<?php

declare(strict_types=1);

namespace Starter\ServerDocumentation\Filament\Admin\Resources\DocumentResource\Pages;

use App\Models\Egg;
use App\Models\Role;
use App\Models\Server;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
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
use Starter\ServerDocumentation\Services\MarkdownConverter;

class ListDocuments extends ListRecords
{
    protected static string $resource = DocumentResource::class;

    protected function getHeaderActions(): array
    {
        $maxFileSize = (int) config('server-documentation.max_import_size', 512);

        return [
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
            CreateAction::make(),
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
}
