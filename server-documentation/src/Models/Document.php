<?php

declare(strict_types=1);

namespace Starter\ServerDocumentation\Models;

use App\Models\Egg;
use App\Models\Role;
use App\Models\Server;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Starter\ServerDocumentation\Database\Factories\DocumentFactory;
use Starter\ServerDocumentation\Services\DocumentService;
use Starter\ServerDocumentation\Services\MarkdownConverter;
use Starter\ServerDocumentation\Services\VariableProcessor;

/**
 * @property int $id
 * @property string $uuid
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property string $content_type
 * @property bool $is_global
 * @property bool $is_published
 * @property int|null $author_id
 * @property int|null $last_edited_by
 * @property int $sort_order
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read User|null $author
 * @property-read User|null $lastEditor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Server> $servers
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Role> $roles
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $users
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Egg> $eggs
 * @property-read \Illuminate\Database\Eloquent\Collection<int, DocumentVersion> $versions
 *
 * @method static Builder|Document published()
 * @method static Builder|Document global()
 * @method static Builder|Document search(string $term)
 * @method static Builder|Document visibleOnServer(Server $server)
 * @method static Builder|Document visibleToUser(User $user)
 */
class Document extends Model
{
    /** @use HasFactory<DocumentFactory> */
    use HasFactory;

    use SoftDeletes;

    /**
     * Resource name for API/permission references.
     */
    public const RESOURCE_NAME = 'document';

    /**
     * Fields that trigger versioning when changed.
     */
    private const VERSIONABLE_FIELDS = ['title', 'content'];

    /**
     * Temporary storage for original values before update (for versioning).
     *
     * @var array{title?: string, content?: string, dirty_fields?: array<string>}
     */
    protected array $originalValuesForVersion = [];

    protected $table = 'documents';

    protected $fillable = [
        'uuid',
        'title',
        'slug',
        'content',
        'content_type',
        'is_global',
        'is_published',
        'author_id',
        'last_edited_by',
        'sort_order',
    ];

    /**
     * Validation rules for the model.
     *
     * @var array<string, array<string>>
     */
    public static array $validationRules = [
        'title' => ['required', 'string', 'max:255'],
        'slug' => ['required', 'string', 'max:255', 'alpha_dash'],
        'content' => ['required', 'string'],
        'is_global' => ['boolean'],
        'is_published' => ['boolean'],
        'sort_order' => ['integer'],
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_global' => 'boolean',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    protected static function newFactory(): DocumentFactory
    {
        return DocumentFactory::new();
    }

    protected static function booted(): void
    {
        static::creating(function (Document $document) {
            $document->uuid ??= Str::uuid()->toString();
            if (empty($document->slug)) {
                $document->slug = static::generateUniqueSlug($document->title);
            }
            if ($document->author_id === null && auth()->check()) {
                $document->author_id = auth()->id();
            }
        });

        static::updating(function (Document $document) {
            if ($document->isDirty(self::VERSIONABLE_FIELDS)) {
                $document->originalValuesForVersion = [
                    'title' => $document->getOriginal('title'),
                    'content' => $document->getOriginal('content'),
                    'dirty_fields' => array_keys($document->getDirty()),
                ];

                if (auth()->check()) {
                    $document->last_edited_by = auth()->id();
                }
            }
        });

        static::updated(function (Document $document) {
            if (!empty($document->originalValuesForVersion)) {
                $changeSummary = app(DocumentService::class)->generateChangeSummary(
                    $document->originalValuesForVersion['dirty_fields'] ?? [],
                    $document->originalValuesForVersion['content'] ?? '',
                    $document->content
                );

                app(DocumentService::class)->createVersionFromOriginal(
                    $document,
                    $document->originalValuesForVersion['title'],
                    $document->originalValuesForVersion['content'],
                    $changeSummary
                );

                $document->originalValuesForVersion = [];
            }
        });

        static::saved(function (Document $document) {
            app(DocumentService::class)->clearDocumentCache($document);
            app(DocumentService::class)->clearCountCache();

            if ((bool) config('server-documentation.auto_prune_versions', false)) {
                app(DocumentService::class)->pruneVersions($document);
            }
        });

        static::deleted(function (Document $document) {
            app(DocumentService::class)->clearCountCache();
        });
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function lastEditor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_edited_by');
    }

    public function servers(): BelongsToMany
    {
        return $this->belongsToMany(Server::class, 'document_server')
            ->withPivot('sort_order')
            ->withTimestamps()
            ->orderByPivot('sort_order');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'document_role')
            ->withTimestamps();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'document_user')
            ->withTimestamps();
    }

    public function eggs(): BelongsToMany
    {
        return $this->belongsToMany(Egg::class, 'document_egg')
            ->withTimestamps();
    }

    public function versions(): HasMany
    {
        return $this->hasMany(DocumentVersion::class)
            ->orderByDesc('version_number');
    }

    public function createVersion(?string $changeSummary = null): DocumentVersion
    {
        return app(DocumentService::class)->createVersion($this, $changeSummary);
    }

    public function restoreVersion(DocumentVersion $version): void
    {
        app(DocumentService::class)->restoreVersion($this, $version);
    }

    public function getCurrentVersionNumber(): int
    {
        return (int) ($this->versions()->max('version_number') ?? 1);
    }

    public function scopeGlobal(Builder $query): Builder
    {
        return $query->where('is_global', true);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope to documents visible on a specific server.
     * A document is visible if:
     * - It's global, OR
     * - It's attached to this server, OR
     * - It's attached to this server's egg
     */
    public function scopeVisibleOnServer(Builder $query, Server $server): Builder
    {
        return $query->where(function (Builder $q) use ($server) {
            $q->where('is_global', true)
                ->orWhereHas('servers', fn (Builder $sq) => $sq->where('servers.id', $server->id))
                ->orWhereHas('eggs', fn (Builder $eq) => $eq->where('eggs.id', $server->egg_id));
        });
    }

    /**
     * Scope to documents visible to a specific user.
     * A document is visible to a user if:
     * - It has no role or user restrictions (empty = everyone), OR
     * - The user is explicitly listed, OR
     * - The user has one of the required roles
     */
    public function scopeVisibleToUser(Builder $query, User $user): Builder
    {
        $userRoleIds = $user->roles->pluck('id')->toArray();

        return $query->where(function (Builder $q) use ($user, $userRoleIds) {
            // No restrictions = everyone
            $q->where(function (Builder $sub) {
                $sub->doesntHave('roles')->doesntHave('users');
            })
            // Or user explicitly listed
            ->orWhereHas('users', fn (Builder $uq) => $uq->where('users.id', $user->id))
            // Or user has a required role
            ->orWhereHas('roles', fn (Builder $rq) => $rq->whereIn('roles.id', $userRoleIds));
        });
    }

    /**
     * Search documents by title, slug, or content.
     */
    public function scopeSearch(Builder $query, string $term): Builder
    {
        $term = trim($term);
        if ($term === '') {
            return $query;
        }

        return $query->where(function (Builder $q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
                ->orWhere('slug', 'like', "%{$term}%")
                ->orWhere('content', 'like', "%{$term}%");
        });
    }

    /**
     * Check if this document is visible on a specific server.
     * Used by DocumentPolicy to avoid duplicating query logic.
     */
    public function isVisibleOnServer(Server $server): bool
    {
        if ($this->is_global) {
            return true;
        }

        if ($this->servers()->where('servers.id', $server->id)->exists()) {
            return true;
        }

        if ($this->eggs()->where('eggs.id', $server->egg_id)->exists()) {
            return true;
        }

        return false;
    }

    /**
     * Check if this document is visible to a specific user.
     * Used by DocumentPolicy to avoid duplicating query logic.
     */
    public function isVisibleToUser(User $user): bool
    {
        // No restrictions = everyone can see
        if (!$this->hasVisibilityRestrictions()) {
            return true;
        }

        // User explicitly listed
        if ($this->users()->where('users.id', $user->id)->exists()) {
            return true;
        }

        // User has a required role
        $userRoleIds = $user->roles->pluck('id')->toArray();
        if (!empty($userRoleIds) && $this->roles()->whereIn('roles.id', $userRoleIds)->exists()) {
            return true;
        }

        return false;
    }

    /**
     * Check if this document has any visibility restrictions.
     * Returns true if the document is restricted to specific roles or users.
     */
    public function hasVisibilityRestrictions(): bool
    {
        return $this->roles()->exists() || $this->users()->exists();
    }

    /**
     * Check if this document is visible to everyone (no restrictions).
     */
    public function isVisibleToEveryone(): bool
    {
        return !$this->hasVisibilityRestrictions();
    }

    /**
     * Get the rendered HTML content.
     * Converts markdown to HTML if content_type is 'markdown'.
     * Processes template variables if present.
     *
     * @param Server|null $server Optional server context for variable replacement
     * @param User|null $user Optional user context for variable replacement
     */
    public function getRenderedContent(?Server $server = null, ?User $user = null): string
    {
        $content = $this->content;
        $processor = app(VariableProcessor::class);

        // For markdown: process variables BEFORE conversion (because markdown escapes backslashes)
        // For other types: process variables AFTER (normal flow)
        if (($this->content_type ?? 'html') === 'markdown') {
            // Process variables on raw markdown first
            if ($processor->hasVariables($content)) {
                $content = $processor->process($content, $user, $server);
            }
            // Then convert to HTML and sanitize
            return $markdownConverter->sanitizeHtml($markdownConverter->toHtml($content));
        }

        // Convert to HTML based on content type
        $html = match ($this->content_type ?? 'html') {
            'raw_html' => $content, // Raw HTML is passed through as-is
            default => $content, // 'html' from Rich Editor
        };

        // Process template variables
        if ($processor->hasVariables($html)) {
            $html = $processor->process($html, $user, $server);
        }

        // Sanitize all non-markdown HTML content
        return $markdownConverter->sanitizeHtml($html);
    }

    /**
     * Get the raw content without variable processing.
     * Useful for editing.
     */
    public function getRawRenderedContent(): string
    {
        return match ($this->content_type ?? 'html') {
            'markdown' => app(MarkdownConverter::class)->toHtml($this->content),
            'raw_html' => $this->content,
            default => $this->content,
        };
    }

    /**
     * Check if this document uses markdown content.
     */
    public function isMarkdown(): bool
    {
        return ($this->content_type ?? 'html') === 'markdown';
    }

    /**
     * Check if this document uses raw HTML content.
     */
    public function isRawHtml(): bool
    {
        return ($this->content_type ?? 'html') === 'raw_html';
    }

    /**
     * Generate a unique slug from a title.
     * Only checks non-deleted documents to allow slug reuse after soft delete.
     * Uses database constraint as final authority on uniqueness.
     */
    public static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);

        if ($slug === '') {
            $slug = 'document';
        }

        $originalSlug = $slug;
        $counter = 0;
        $maxAttempts = 100;

        while ($counter < $maxAttempts) {
            $candidate = $counter === 0 ? $slug : "{$originalSlug}-{$counter}";

            $query = static::where('slug', $candidate);
            if ($ignoreId !== null) {
                $query->where('id', '!=', $ignoreId);
            }

            if (!$query->exists()) {
                return $candidate;
            }

            $counter++;
        }

        // Fallback: append UUID fragment for guaranteed uniqueness
        return $originalSlug . '-' . substr(Str::uuid()->toString(), 0, 8);
    }

    /**
     * Attempt to save with slug uniqueness retry on constraint violation.
     *
     * @param array<string, mixed> $options
     */
    public function saveWithSlugRetry(array $options = []): bool
    {
        $maxAttempts = 5;
        $attempt = 0;

        while ($attempt < $maxAttempts) {
            try {
                return $this->save($options);
            } catch (QueryException $e) {
                // Check if it's a unique constraint violation
                if ($e->getCode() === '23000' && str_contains($e->getMessage(), 'slug')) {
                    $this->slug = static::generateUniqueSlug($this->title, $this->id);
                    $attempt++;
                } else {
                    throw $e;
                }
            }
        }

        return false;
    }
}
