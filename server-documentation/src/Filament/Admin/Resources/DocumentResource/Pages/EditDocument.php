<?php

declare(strict_types=1);

namespace Starter\ServerDocumentation\Filament\Admin\Resources\DocumentResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\IconSize;
use Starter\ServerDocumentation\Filament\Admin\Resources\DocumentResource;
use Starter\ServerDocumentation\Models\Document;
use Starter\ServerDocumentation\Services\MarkdownConverter;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EditDocument extends EditRecord
{
    protected static string $resource = DocumentResource::class;

    public function getRecord(): Document
    {
        /** @var Document */
        return $this->record;
    }

    /** @return array<Action|ActionGroup> */
    protected function getHeaderActions(): array
    {
        return [
            Action::make('export')
                ->label(trans('server-documentation::strings.actions.export'))
                ->icon('tabler-download')
                ->iconButton()
                ->iconSize(IconSize::ExtraLarge)
                ->color('gray')
                ->authorize('view')
                ->action(fn () => $this->exportAsMarkdown()),
            Action::make('versions')
                ->label(trans('server-documentation::strings.versions.title'))
                ->icon('tabler-history')
                ->iconButton()
                ->iconSize(IconSize::ExtraLarge)
                ->url(fn () => DocumentResource::getUrl('versions', ['record' => $this->getRecord()]))
                ->badge(fn () => $this->getRecord()->versions()->count() ?: null),
            DeleteAction::make()
                ->iconButton()
                ->iconSize(IconSize::ExtraLarge),
        ];
    }

    /**
     * Export the current document as a Markdown file.
     */
    public function exportAsMarkdown(): StreamedResponse
    {
        $converter = new MarkdownConverter();
        $document = $this->getRecord();

        // Load relationships for export
        $document->load(['roles', 'users', 'eggs', 'servers']);

        $frontmatter = [
            'title' => $document->title,
            'slug' => $document->slug,
            'is_global' => $document->is_global,
            'is_published' => $document->is_published,
            'sort_order' => $document->sort_order,
        ];

        // Add roles if any
        if ($document->roles->isNotEmpty()) {
            $frontmatter['roles'] = $document->roles->pluck('name')->toArray();
        }

        // Add users if any
        if ($document->users->isNotEmpty()) {
            $frontmatter['users'] = $document->users->pluck('username')->toArray();
        }

        // Add eggs if any
        if ($document->eggs->isNotEmpty()) {
            $frontmatter['eggs'] = $document->eggs->pluck('name')->toArray();
        }

        // Add servers if any (using uuids for portability)
        if ($document->servers->isNotEmpty()) {
            $frontmatter['servers'] = $document->servers->pluck('uuid')->toArray();
        }

        $markdown = $converter->toMarkdown($document->content);
        $markdown = $converter->addFrontmatter($markdown, $frontmatter);

        $filename = $converter->generateFilename($document->title, $document->slug);

        return response()->streamDownload(function () use ($markdown) {
            echo $markdown;
        }, $filename, [
            'Content-Type' => 'text/markdown',
        ]);
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction(),
            $this->getCancelFormAction(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    /**
     * Mutate form data before filling to map content to the appropriate field.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $contentType = $data['content_type'] ?? 'html';
        $content = $data['content'] ?? '';

        // Map content to the appropriate field based on type
        match ($contentType) {
            'markdown' => $data['content_markdown'] = $content,
            'raw_html' => $data['content_raw_html'] = $content,
            default => $data['content_html'] = $content,
        };

        return $data;
    }

    /**
     * Mutate form data before saving to map content fields back.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $contentType = $data['content_type'] ?? 'html';

        // Map the appropriate content field to 'content'
        $data['content'] = match ($contentType) {
            'markdown' => $data['content_markdown'] ?? '',
            'raw_html' => $data['content_raw_html'] ?? '',
            default => $data['content_html'] ?? '',
        };

        // Remove the individual content fields (not in database)
        unset($data['content_html'], $data['content_markdown'], $data['content_raw_html']);

        return $data;
    }
}
