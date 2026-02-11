<?php

declare(strict_types=1);

namespace Starter\ServerDocumentation\Filament\Admin\Resources\DocumentResource\Pages;

use App\Models\Egg;
use App\Models\Role;
use App\Models\Server;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Arr;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Starter\ServerDocumentation\Filament\Admin\Resources\DocumentResource;
use Starter\ServerDocumentation\Models\Document;
use Illuminate\Support\Facades\DB;
use Starter\ServerDocumentation\Services\ImportValidator;
use Starter\ServerDocumentation\Services\MarkdownConverter;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ListDocuments extends ListRecords
{
    protected static string $resource = DocumentResource::class;

    protected function getHeaderActions(): array
    {
        $maxFileSize = (int) config('server-documentation.max_import_size', 512);

        $actionGroup = ActionGroup::make([
            Action::make('exclude_createRichText')
                ->label(trans('server-documentation::strings.form.rich_text'))
                ->icon('tabler-file-text')
                ->url(fn () => DocumentResource::getUrl('create', ['type' => 'html'])),
            Action::make('exclude_createMarkdown')
                ->label(trans('server-documentation::strings.form.markdown'))
                ->icon('tabler-markdown')
                ->url(fn () => DocumentResource::getUrl('create', ['type' => 'markdown'])),
            Action::make('exclude_createRawHtml')
                ->label(trans('server-documentation::strings.form.raw_html'))
                ->icon('tabler-code')
                ->url(fn () => DocumentResource::getUrl('create', ['type' => 'raw_html'])),
        ])
            ->label(trans('server-documentation::strings.actions.new_document'))
            ->icon('tabler-plus');

        if ($this->getButtonStyle() === 1) {
            $actionGroup = $actionGroup->iconButton();
        } else {
            $actionGroup = $actionGroup->button();
        }

        return [
            Action::make('exportJson')
                ->label(trans('server-documentation::strings.actions.export_json'))
                ->icon('tabler-download')
                ->color('gray')
                ->requiresConfirmation()
                ->modalHeading(trans('server-documentation::strings.export.modal_heading'))
                ->modalDescription(trans('server-documentation::strings.export.modal_description'))
                ->modalSubmitActionLabel(trans('server-documentation::strings.actions.export_json_button'))
                ->action(fn () => $this->exportAllDocumentsAsJson()),
            Action::make('importJson')
                ->label(trans('server-documentation::strings.actions.import_json'))
                ->icon('tabler-file-import')
                ->color('gray')
                ->form([
                    FileUpload::make('json_file')
                        ->label(trans('server-documentation::strings.import.json_file_label'))
                        ->helperText(trans('server-documentation::strings.import.json_file_helper'))
                        ->acceptedFileTypes(['application/json', '.json'])
                        ->maxSize(5120) // 5MB for JSON backups
                        ->required()
                        ->storeFiles(false),
                    Toggle::make('overwrite_existing')
                        ->label(trans('server-documentation::strings.import.overwrite_existing'))
                        ->helperText(trans('server-documentation::strings.import.overwrite_existing_helper'))
                        ->default(false),
                ])
                ->action(function (array $data): void {
                    $this->importDocumentsFromJson($data);
                }),
            Action::make('import')
                ->label(trans('server-documentation::strings.actions.import'))
                ->icon('tabler-upload')
                ->color('gray')
                ->form([
                    FileUpload::make('markdown_file')
                        ->label(trans('server-documentation::strings.import.file_label'))
                        ->helperText(trans('server-documentation::strings.import.file_helper') . " (max {$maxFileSize}KB)")
                        ->acceptedFileTypes(['text/markdown', 'text/plain', '.md'])
                        ->maxSize($maxFileSize)
                        ->required()
                        ->storeFiles(false),
                    Toggle::make('use_frontmatter')
                        ->label(trans('server-documentation::strings.import.use_frontmatter'))
                        ->helperText(trans('server-documentation::strings.import.use_frontmatter_helper'))
                        ->default(true),
                ])
                ->action(function (array $data): void {
                    $this->importMarkdownFile($data);
                }),
            Action::make('help')
                ->label(trans('server-documentation::strings.permission_guide.title'))
                ->icon('tabler-help')
                ->color('gray')
                ->modalHeading(trans('server-documentation::strings.permission_guide.modal_heading'))
                ->modalDescription(new HtmlString(
                    view('server-documentation::filament.partials.permission-guide', ['showExamples' => true])->render() // @phpstan-ignore argument.type
                ))
                ->modalSubmitAction(false)
                ->modalCancelActionLabel(trans('server-documentation::strings.actions.close')),
            $actionGroup,
        ];
    }

    /**
     * Import a Markdown file and create a new document.
     *
     * @phpstan-param array<string, mixed> $data
     */
    protected function importMarkdownFile(array $data): void
    {
        $converter = app(MarkdownConverter::class);

        /** @var TemporaryUploadedFile $file */
        $file = $data['markdown_file'];

        $maxSize = (int) config('server-documentation.max_import_size', 512) * 1024;
        if ($file->getSize() > $maxSize) {
            Notification::make()
                ->title(trans('server-documentation::strings.import.error'))
                ->body(trans('server-documentation::strings.import.file_too_large'))
                ->danger()
                ->send();

            return;
        }

        $content = file_get_contents($file->getRealPath());
        if ($content === false) {
            Notification::make()
                ->title(trans('server-documentation::strings.import.error'))
                ->body(trans('server-documentation::strings.import.file_read_error'))
                ->danger()
                ->send();

            return;
        }

        $useFrontmatter = $data['use_frontmatter'] ?? true;
        $metadata = [];
        $markdownContent = $content;

        if ($useFrontmatter) {
            [$metadata, $markdownContent] = $converter->parseFrontmatter($content);
        }

        $htmlContent = $converter->toHtml($markdownContent);

        $title = $metadata['title']
            ?? $this->extractTitleFromMarkdown($markdownContent)
            ?? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        $slug = $metadata['slug'] ?? Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;
        while (Document::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        $document = Document::create([
            'title' => $title,
            'slug' => $slug,
            'content' => $htmlContent,
            'is_global' => filter_var($metadata['is_global'] ?? false, FILTER_VALIDATE_BOOLEAN),
            'is_published' => filter_var($metadata['is_published'] ?? true, FILTER_VALIDATE_BOOLEAN),
            'sort_order' => (int) ($metadata['sort_order'] ?? 0),
            'author_id' => auth()->id(),
            'last_edited_by' => auth()->id(),
        ]);

        // Resolve and attach roles, users, and eggs from frontmatter
        $warnings = $this->attachVisibilityFromFrontmatter($document, $metadata);

        $notification = Notification::make()
            ->title(trans('server-documentation::strings.import.success'))
            ->body(trans('server-documentation::strings.import.success_body', ['title' => $document->title]));

        if (!empty($warnings)) {
            $notification->warning();
            foreach ($warnings as $warning) {
                $notification->body($warning);
            }
        } else {
            $notification->success();
        }

        $notification->send();

        $this->redirect(DocumentResource::getUrl('edit', ['record' => $document]));
    }

    /**
     * Extract title from first H1 heading in markdown.
     */
    protected function extractTitleFromMarkdown(string $markdown): ?string
    {
        if (preg_match('/^#\s+(.+)$/m', $markdown, $matches)) {
            return trim($matches[1]);
        }

        return null;
    }

    /**
     * Attach visibility settings from frontmatter (roles, users, eggs).
     *
     * @phpstan-param array<string, mixed> $metadata
     * @return array<string> Warning messages for unresolved names
     */
    protected function attachVisibilityFromFrontmatter(Document $document, array $metadata): array
    {
        $warnings = [];

        // Resolve roles by name
        $roleNames = Arr::wrap($metadata['roles'] ?? []);
        if (!empty($roleNames)) {
            $roles = Role::whereIn('name', $roleNames)->get();
            $document->roles()->attach($roles->pluck('id'));

            $unresolvedRoles = array_diff($roleNames, $roles->pluck('name')->toArray());
            if (!empty($unresolvedRoles)) {
                $warnings[] = trans('server-documentation::strings.import.unresolved_roles', [
                    'roles' => implode(', ', $unresolvedRoles),
                ]);
            }
        }

        // Resolve users by username
        $usernames = Arr::wrap($metadata['users'] ?? []);
        if (!empty($usernames)) {
            $users = User::whereIn('username', $usernames)->get();
            $document->users()->attach($users->pluck('id'));

            $unresolvedUsers = array_diff($usernames, $users->pluck('username')->toArray());
            if (!empty($unresolvedUsers)) {
                $warnings[] = trans('server-documentation::strings.import.unresolved_users', [
                    'users' => implode(', ', $unresolvedUsers),
                ]);
            }
        }

        // Resolve eggs by name
        $eggNames = Arr::wrap($metadata['eggs'] ?? []);
        if (!empty($eggNames)) {
            $eggs = Egg::whereIn('name', $eggNames)->get();
            $document->eggs()->attach($eggs->pluck('id'));

            $unresolvedEggs = array_diff($eggNames, $eggs->pluck('name')->toArray());
            if (!empty($unresolvedEggs)) {
                $warnings[] = trans('server-documentation::strings.import.unresolved_eggs', [
                    'eggs' => implode(', ', $unresolvedEggs),
                ]);
            }
        }

        // Resolve servers by UUID (used for portability)
        $serverUuids = Arr::wrap($metadata['servers'] ?? []);
        if (!empty($serverUuids)) {
            $servers = Server::whereIn('uuid', $serverUuids)->get();
            $document->servers()->attach($servers->pluck('id'));

            $unresolvedServers = array_diff($serverUuids, $servers->pluck('uuid')->toArray());
            if (!empty($unresolvedServers)) {
                $warnings[] = trans('server-documentation::strings.import.unresolved_servers', [
                    'servers' => implode(', ', $unresolvedServers),
                ]);
            }
        }

        return $warnings;
    }

    /**
     * Export all documents as a JSON backup file.
     */
    protected function exportAllDocumentsAsJson(): StreamedResponse
    {
        $documents = Document::with(['servers', 'eggs', 'roles', 'users', 'versions'])->get();

        $exportData = [
            'plugin' => 'server-documentation',
            'version' => '1.1.0',
            'exported_at' => now()->toIso8601String(),
            'exported_by' => auth()->user()?->username ?? 'unknown',
            'documents' => $documents->map(function (Document $doc) {
                return [
                    'uuid' => $doc->uuid,
                    'title' => $doc->title,
                    'slug' => $doc->slug,
                    'content' => $doc->content,
                    'content_type' => $doc->content_type ?? 'html',
                    'is_global' => $doc->is_global,
                    'is_published' => $doc->is_published,
                    'sort_order' => $doc->sort_order,
                    'created_at' => $doc->created_at?->toIso8601String(),
                    'updated_at' => $doc->updated_at?->toIso8601String(),
                    // Relations by portable identifiers
                    'servers' => $doc->servers->pluck('uuid')->toArray(),
                    'eggs' => $doc->eggs->pluck('name')->toArray(),
                    'roles' => $doc->roles->pluck('name')->toArray(),
                    'users' => $doc->users->pluck('username')->toArray(),
                    // Version history
                    'versions' => $doc->versions->map(fn ($v) => [
                        'version_number' => $v->version_number,
                        'title' => $v->title,
                        'content' => $v->content,
                        'change_summary' => $v->change_summary,
                        'created_at' => $v->created_at?->toIso8601String(),
                    ])->toArray(),
                ];
            })->toArray(),
        ];

        $filename = 'server-documentation-backup-' . now()->format('Y-m-d-His') . '.json';

        return response()->streamDownload(function () use ($exportData) {
            echo json_encode($exportData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }, $filename, [
            'Content-Type' => 'application/json',
        ]);
    }

    /**
     * Import documents from a JSON backup file.
     *
     * @phpstan-param array<string, mixed> $data
     */
    protected function importDocumentsFromJson(array $data): void
    {
        /** @var TemporaryUploadedFile $file */
        $file = $data['json_file'];
        $overwrite = $data['overwrite_existing'] ?? false;
        $markdownConverter = app(MarkdownConverter::class);

        $content = file_get_contents($file->getRealPath());
        if ($content === false) {
            Notification::make()
                ->title(trans('server-documentation::strings.import.error'))
                ->body(trans('server-documentation::strings.import.file_read_error'))
                ->danger()
                ->send();

            return;
        }

        $importData = json_decode($content, true);
        if ($importData === null || !isset($importData['documents'])) {
            Notification::make()
                ->title(trans('server-documentation::strings.import.error'))
                ->body(trans('server-documentation::strings.import.invalid_json'))
                ->danger()
                ->send();

            return;
        }

        if (!is_array($importData['documents'])) {
            Notification::make()
                ->title(trans('server-documentation::strings.import.error'))
                ->body('Invalid JSON structure: documents must be an array')
                ->danger()
                ->send();

            return;
        }

        $imported = 0;
        $updated = 0;
        $skipped = 0;
        $validationErrors = 0;
        $warnings = [];

        $validator = app(ImportValidator::class);

        DB::transaction(function () use ($importData, $overwrite, $markdownConverter, $validator, &$imported, &$updated, &$skipped, &$validationErrors, &$warnings) {
            foreach ($importData['documents'] as $index => $docData) {
                // Validate document data
                $errors = $validator->validate($docData);
                if (!empty($errors)) {
                    $docId = $docData['uuid'] ?? $docData['title'] ?? "index {$index}";
                    $warnings[] = "Skipped document ({$docId}): " . implode('; ', $errors);
                    $validationErrors++;
                    continue;
                }
                // Check for existing document (active only)
                $existing = Document::where('uuid', $docData['uuid'])->first();
                // Also check for soft-deleted with same UUID
                $trashed = Document::onlyTrashed()->where('uuid', $docData['uuid'])->first();

                if ($existing && !$overwrite) {
                    $skipped++;
                    continue;
                }

                if ($trashed) {
                    // Restore and update the soft-deleted document
                    $trashed->restore();
                    $existing = $trashed;
                }

                $sanitizedContent = $markdownConverter->sanitizeHtml($docData['content']);

                if ($existing) {
                    // Update existing document
                    $existing->update([
                        'title' => $docData['title'],
                        'slug' => $docData['slug'],
                        'content' => $sanitizedContent,
                        'content_type' => $docData['content_type'] ?? 'html',
                        'is_global' => $docData['is_global'],
                        'is_published' => $docData['is_published'],
                        'sort_order' => $docData['sort_order'],
                        'last_edited_by' => auth()->id(),
                    ]);
                    // Force timestamp update even if no data changed
                    $existing->touch();
                    $document = $existing;
                    $updated++;
                } else {
                    // Check for slug conflict
                    $slug = $docData['slug'];
                    $originalSlug = $slug;
                    $counter = 1;
                    while (Document::where('slug', $slug)->exists()) {
                        $slug = $originalSlug . '-' . $counter++;
                    }

                    // Create new document
                    $document = Document::create([
                        'uuid' => $docData['uuid'],
                        'title' => $docData['title'],
                        'slug' => $slug,
                        'content' => $sanitizedContent,
                        'content_type' => $docData['content_type'] ?? 'html',
                        'is_global' => $docData['is_global'],
                        'is_published' => $docData['is_published'],
                        'sort_order' => $docData['sort_order'],
                        'author_id' => auth()->id(),
                        'last_edited_by' => auth()->id(),
                    ]);
                    $imported++;
                }

                // Sync relationships
                $docWarnings = $this->syncRelationsFromJson($document, $docData);
                $warnings = array_merge($warnings, $docWarnings);
            }
        });

        $message = trans('server-documentation::strings.import.json_success', [
            'imported' => $imported,
            'updated' => $updated,
            'skipped' => $skipped,
        ]);

        if ($validationErrors > 0) {
            $message .= " ({$validationErrors} failed validation)";
        }

        $notification = Notification::make()
            ->title(trans('server-documentation::strings.import.success'))
            ->body($message);

        if (!empty($warnings)) {
            $notification->warning();
            // Log detailed warnings for admin review
            foreach ($warnings as $warning) {
                \Illuminate\Support\Facades\Log::warning('[ServerDocs Import] ' . $warning);
            }
        } else {
            $notification->success();
        }

        $notification->send();
    }

    /**
     * Sync document relations from JSON data.
     *
     * @phpstan-param array<string, mixed> $docData
     * @return array<string> Warning messages
     */
    protected function syncRelationsFromJson(Document $document, array $docData): array
    {
        $warnings = [];

        // Sync servers by UUID
        $serverUuids = $docData['servers'] ?? [];
        if (!empty($serverUuids)) {
            $servers = Server::whereIn('uuid', $serverUuids)->get();
            $document->servers()->sync($servers->pluck('id'));

            $unresolvedServers = array_diff($serverUuids, $servers->pluck('uuid')->toArray());
            if (!empty($unresolvedServers)) {
                $warnings[] = trans('server-documentation::strings.import.unresolved_servers', [
                    'servers' => implode(', ', $unresolvedServers),
                ]);
            }
        } else {
            $document->servers()->detach();
        }

        // Sync eggs by name
        $eggNames = $docData['eggs'] ?? [];
        if (!empty($eggNames)) {
            $eggs = Egg::whereIn('name', $eggNames)->get();
            $document->eggs()->sync($eggs->pluck('id'));

            $unresolvedEggs = array_diff($eggNames, $eggs->pluck('name')->toArray());
            if (!empty($unresolvedEggs)) {
                $warnings[] = trans('server-documentation::strings.import.unresolved_eggs', [
                    'eggs' => implode(', ', $unresolvedEggs),
                ]);
            }
        } else {
            $document->eggs()->detach();
        }

        // Sync roles by name
        $roleNames = $docData['roles'] ?? [];
        if (!empty($roleNames)) {
            $roles = Role::whereIn('name', $roleNames)->get();
            $document->roles()->sync($roles->pluck('id'));

            $unresolvedRoles = array_diff($roleNames, $roles->pluck('name')->toArray());
            if (!empty($unresolvedRoles)) {
                $warnings[] = trans('server-documentation::strings.import.unresolved_roles', [
                    'roles' => implode(', ', $unresolvedRoles),
                ]);
            }
        } else {
            $document->roles()->detach();
        }

        // Sync users by username
        $usernames = $docData['users'] ?? [];
        if (!empty($usernames)) {
            $users = User::whereIn('username', $usernames)->get();
            $document->users()->sync($users->pluck('id'));

            $unresolvedUsers = array_diff($usernames, $users->pluck('username')->toArray());
            if (!empty($unresolvedUsers)) {
                $warnings[] = trans('server-documentation::strings.import.unresolved_users', [
                    'users' => implode(', ', $unresolvedUsers),
                ]);
            }
        } else {
            $document->users()->detach();
        }

        return $warnings;
    }

    /**
     * Get user's button style preference.
     * Returns 0 for regular buttons, 1 for icon buttons.
     * Compatible with both beta31 (no preference) and beta32 (with ButtonStyle enum).
     */
    private function getButtonStyle(): int
    {
        return (int) (user()->getCustomization()['button_style'] ?? 0);
    }
}
