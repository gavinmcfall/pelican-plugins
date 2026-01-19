<?php

declare(strict_types=1);

namespace Starter\ServerDocumentation\Filament\Admin\Resources\DocumentResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
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
                ->action(fn () => $this->exportAsMarkdown()),
            Action::make('versions')
                ->label(trans('server-documentation::strings.versions.title'))
                ->icon('tabler-history')
                ->iconButton()
                ->iconSize(IconSize::ExtraLarge)
                ->url(fn () => DocumentResource::getUrl('versions', ['record' => $this->getRecord()]))
                ->badge(fn () => $this->getRecord()->versions()->count() ?: null),
            $this->getSaveFormAction()
                ->formId('form')
                ->iconButton()
                ->iconSize(IconSize::ExtraLarge)
                ->icon('tabler-device-floppy'),
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
        return [];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
