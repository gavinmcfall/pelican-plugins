<?php

declare(strict_types=1);

namespace Starter\ServerDocumentation\Filament\Admin\Resources\DocumentResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use Starter\ServerDocumentation\Filament\Admin\Resources\DocumentResource;

class CreateDocument extends CreateRecord
{
    protected static string $resource = DocumentResource::class;

    protected static bool $canCreateAnother = false;

    public ?string $contentType = null;

    public function mount(): void
    {
        // Get content type from URL parameter
        $this->contentType = request()->query('type', 'html');

        // Validate content type
        if (!in_array($this->contentType, ['html', 'markdown', 'raw_html'])) {
            $this->contentType = 'html';
        }

        parent::mount();
    }

    protected function getDefaultFormData(): array
    {
        return [
            'content_type' => $this->contentType,
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return match ($this->contentType) {
            'markdown' => 'Create Markdown Document',
            'raw_html' => 'Create Raw HTML Document',
            default => 'Create Rich Text Document',
        };
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(),
            $this->getCancelFormAction(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    /**
     * Mutate form data before creating to map content fields.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ensure content_type is set
        $contentType = $data['content_type'] ?? $this->contentType ?? 'html';
        $data['content_type'] = $contentType;

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
