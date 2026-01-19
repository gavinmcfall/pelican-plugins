<?php

declare(strict_types=1);

namespace Starter\ServerDocumentation\Services;

use App\Models\Egg;
use App\Models\Server;
use App\Models\User;
use Illuminate\Cache\TaggableStore;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Starter\ServerDocumentation\Models\Document;
use Starter\ServerDocumentation\Models\DocumentVersion;

class DocumentService
{
    /**
     * Default cache TTL in seconds (5 minutes).
     */
    private const DEFAULT_CACHE_TTL_SECONDS = 300;

    /**
     * Default badge cache TTL in seconds (1 minute).
     */
    private const DEFAULT_BADGE_CACHE_TTL_SECONDS = 60;

    /**
     * Minimum seconds between version creations (rate limiting).
     */
    private const VERSION_DEBOUNCE_SECONDS = 30;

    /**
     * Cache tag for server documents.
     */
    private const CACHE_TAG_SERVER_DOCUMENTS = 'server-documents';

    /**
     * Cache TTL for document queries in seconds.
     */
    protected int $cacheTtl;

    public function __construct()
    {
        $this->cacheTtl = (int) config('server-documentation.cache_ttl', self::DEFAULT_CACHE_TTL_SECONDS);
    }

    /**
     * Get documents visible to a user for a specific server.
     *
     * @return Collection<int, Document>
     */
    public function getDocumentsForServer(Server $server, ?User $user = null): Collection
    {
        $cacheKey = $this->getServerDocumentsCacheKey($server, $user);

        if ($this->cacheTtl > 0 && $this->cacheSupportsTagging()) {
            return Cache::tags([self::CACHE_TAG_SERVER_DOCUMENTS, "server-{$server->id}"])
                ->remember($cacheKey, $this->cacheTtl, fn () => $this->queryDocumentsForServer($server, $user));
        }

        if ($this->cacheTtl > 0) {
            return Cache::remember($cacheKey, $this->cacheTtl, fn () => $this->queryDocumentsForServer($server, $user));
        }

        return $this->queryDocumentsForServer($server, $user);
    }

    /**
     * Query documents for a server without caching.
     *
     * @return Collection<int, Document>
     */
    protected function queryDocumentsForServer(Server $server, ?User $user): Collection
    {
        $query = Document::query()
            ->where('is_published', true)
            ->visibleOnServer($server);

        // Apply user visibility restrictions (unless root admin)
        if ($user !== null && !$user->isRootAdmin()) {
            $query->visibleToUser($user);
        }

        // Eager load all relationships to avoid N+1 queries
        $eagerLoad = ['roles', 'users', 'eggs', 'servers'];

        // Get server-attached docs first (ordered by pivot)
        $attachedDocs = (clone $query)
            ->whereHas('servers', fn ($q) => $q->where('servers.id', $server->id))
            ->with($eagerLoad)
            ->get()
            ->sortBy(fn (Document $doc) => $doc->servers->find($server->id)?->pivot->sort_order ?? 0)
            ->values();

        // Then global/egg-based docs
        $otherDocs = (clone $query)
            ->where(fn ($q) => $q->where('is_global', true)
                ->orWhereHas('eggs', fn ($eq) => $eq->where('eggs.id', $server->egg_id)))
            ->whereNotIn('id', $attachedDocs->pluck('id'))
            ->with($eagerLoad)
            ->orderBy('sort_order')
            ->get();

        return $attachedDocs->concat($otherDocs);
    }

    /**
     * Generate a change summary for version history.
     *
     * @param array<string> $dirtyFields
     */
    public function generateChangeSummary(array $dirtyFields, string $oldContent, string $newContent): string
    {
        $parts = [];

        if (in_array('title', $dirtyFields, true)) {
            $parts[] = 'title';
        }

        if (in_array('content', $dirtyFields, true)) {
            $oldLen = strlen(strip_tags($oldContent));
            $newLen = strlen(strip_tags($newContent));
            $diff = $newLen - $oldLen;

            $parts[] = match (true) {
                $diff > 0 => "content (+{$diff} chars)",
                $diff < 0 => "content ({$diff} chars)",
                default => 'content (reformatted)',
            };
        }

        return empty($parts) ? 'Updated' : 'Updated ' . implode(', ', $parts);
    }

    /**
     * Create a version from pre-stored original values (called from model 'updated' event).
     * Includes rate limiting to prevent spam.
     */
    public function createVersionFromOriginal(
        Document $document,
        ?string $originalTitle,
        ?string $originalContent,
        ?string $changeSummary = null,
        ?int $userId = null
    ): DocumentVersion {
        /** @var DocumentVersion */
        return DB::transaction(function () use ($document, $originalTitle, $originalContent, $changeSummary, $userId): DocumentVersion {
            /** @var DocumentVersion|null $latestVersion */
            $latestVersion = $document->versions()
                ->lockForUpdate()
                ->latest()
                ->first();

            $latestVersionNumber = $latestVersion !== null ? $latestVersion->version_number : 0;

            if ($latestVersion !== null && $latestVersion->created_at->diffInSeconds(now()) < self::VERSION_DEBOUNCE_SECONDS) {
                $latestVersion->update([
                    'title' => $originalTitle ?? $document->title,
                    'content' => $originalContent ?? $document->content,
                    'change_summary' => $changeSummary,
                    'edited_by' => $userId ?? auth()->id(),
                ]);

                $this->logAudit('version_updated', $document, [
                    'version_number' => $latestVersion->version_number,
                    'reason' => 'rate_limited',
                ]);

                return $latestVersion;
            }

            /** @var DocumentVersion $version */
            $version = $document->versions()->create([
                'title' => $originalTitle ?? $document->title,
                'content' => $originalContent ?? $document->content,
                'version_number' => $latestVersionNumber + 1,
                'edited_by' => $userId ?? auth()->id(),
                'change_summary' => $changeSummary,
            ]);

            $this->logAudit('version_created', $document, [
                'version_number' => $version->version_number,
            ]);

            return $version;
        });
    }

    /**
     * Create a new version of a document within a transaction.
     *
     * @deprecated Use createVersionFromOriginal for model events
     */
    public function createVersion(Document $document, ?string $changeSummary = null, ?int $userId = null): DocumentVersion
    {
        /** @var DocumentVersion */
        return DB::transaction(function () use ($document, $changeSummary, $userId): DocumentVersion {
            $latestVersion = $document->versions()
                ->lockForUpdate()
                ->max('version_number') ?? 0;

            /** @var DocumentVersion */
            return $document->versions()->create([
                'title' => $document->getOriginal('title') ?? $document->title,
                'content' => $document->getOriginal('content') ?? $document->content,
                'version_number' => ((int) $latestVersion) + 1,
                'edited_by' => $userId ?? auth()->id(),
                'change_summary' => $changeSummary,
            ]);
        });
    }

    /**
     * Restore a document to a previous version within a transaction.
     */
    public function restoreVersion(Document $document, DocumentVersion $version, ?int $userId = null): void
    {
        $this->logAudit('version_restore_started', $document, [
            'restoring_version' => $version->version_number,
            'current_title' => $document->title,
        ]);

        DB::transaction(function () use ($document, $version, $userId) {
            $document->updateQuietly([
                'title' => $version->title,
                'content' => $version->content,
                'last_edited_by' => $userId ?? auth()->id(),
            ]);

            $this->createVersionFromOriginal(
                $document,
                $document->title,
                $document->content,
                'Restored from version ' . $version->version_number,
                $userId
            );
        });

        $this->logAudit('version_restored', $document, [
            'restored_version' => $version->version_number,
        ]);

        $this->clearDocumentCache($document);
    }

    /**
     * Clear cache for a specific document.
     * Handles explicit server attachments, global docs, and egg-based visibility.
     */
    public function clearDocumentCache(Document $document): void
    {
        // Load relationships if not already loaded
        if (!$document->relationLoaded('servers')) {
            $document->load('servers');
        }
        if (!$document->relationLoaded('eggs')) {
            $document->load('eggs');
        }

        // Clear cache for explicitly attached servers
        foreach ($document->servers as $server) {
            $this->clearServerDocumentsCache($server);
        }

        // Clear cache for servers matching attached eggs
        // Use chunking to avoid loading all servers into memory for large installations
        if ($document->eggs->isNotEmpty()) {
            $eggIds = $document->eggs->pluck('id')->toArray();

            Server::whereIn('egg_id', $eggIds)
                ->select(['id']) // Only need ID for cache clearing
                ->chunkById(100, function ($servers) {
                    foreach ($servers as $server) {
                        $this->clearServerDocumentsCache($server);
                    }
                });
        }

        // Global documents affect all servers
        if ($document->is_global && $this->cacheSupportsTagging()) {
            Cache::tags([self::CACHE_TAG_SERVER_DOCUMENTS])->flush();
        }
    }

    /**
     * Clear document cache for a specific server.
     */
    public function clearServerDocumentsCache(Server $server): void
    {
        if ($this->cacheSupportsTagging()) {
            Cache::tags(["server-{$server->id}"])->flush();

            return;
        }

        // Without tagging, we can't efficiently clear all user-specific caches
        // Just clear the anonymous user cache key as a best-effort approach
        Cache::forget($this->getServerDocumentsCacheKey($server, null));
    }

    /**
     * Check if the cache driver supports tagging.
     * Only redis and memcached reliably support cache tags.
     */
    protected function cacheSupportsTagging(): bool
    {
        try {
            $store = Cache::getStore();

            return $store instanceof TaggableStore;
        } catch (\Exception) {
            // Fallback to driver check if store inspection fails
            $driver = (string) config('cache.default');

            return in_array($driver, ['redis', 'memcached'], true);
        }
    }

    /**
     * Generate cache key for server documents.
     */
    protected function getServerDocumentsCacheKey(Server $server, ?User $user): string
    {
        $userKey = $user !== null ? (string) $user->id : 'anon';

        return "server-docs.{$server->id}.{$userKey}";
    }

    /**
     * Get document count (cached for navigation badge).
     */
    public function getDocumentCount(): int
    {
        $cacheTtl = (int) config('server-documentation.badge_cache_ttl', self::DEFAULT_BADGE_CACHE_TTL_SECONDS);

        if ($cacheTtl > 0) {
            return (int) Cache::remember('server-docs.count', $cacheTtl, fn () => Document::count());
        }

        return (int) Document::count();
    }

    /**
     * Clear the document count cache.
     */
    public function clearCountCache(): void
    {
        Cache::forget('server-docs.count');
    }

    /**
     * Prune old versions keeping only the specified number of recent versions.
     */
    public function pruneVersions(Document $document, ?int $keepCount = null): int
    {
        $keepCount ??= (int) config('server-documentation.versions_to_keep', 50);

        if ($keepCount <= 0) {
            return 0;
        }

        $versionsToKeep = $document->versions()
            ->orderByDesc('version_number')
            ->limit($keepCount)
            ->pluck('id');

        $deleted = $document->versions()
            ->whereNotIn('id', $versionsToKeep)
            ->delete();

        if ($deleted > 0) {
            $this->logAudit('versions_pruned', $document, [
                'deleted_count' => $deleted,
                'kept_count' => $keepCount,
            ]);
        }

        return $deleted;
    }

    /**
     * Log an audit event for document operations.
     *
     * @param array<string, mixed> $context
     */
    protected function logAudit(string $action, Document $document, array $context = []): void
    {
        $context = array_merge([
            'document_id' => $document->id,
            'document_uuid' => $document->uuid,
            'document_title' => $document->title,
            'user_id' => auth()->id(),
            'user' => auth()->user()?->username,
            'is_global' => $document->is_global,
            'servers' => $document->relationLoaded('servers') ? $document->servers->pluck('id')->toArray() : [],
            'eggs' => $document->relationLoaded('eggs') ? $document->eggs->pluck('id')->toArray() : [],
            'roles' => $document->relationLoaded('roles') ? $document->roles->pluck('name')->toArray() : [],
        ], $context);

        Log::channel((string) config('server-documentation.audit_log_channel', 'single'))
            ->info("[ServerDocs] {$action}", $context);
    }
}
