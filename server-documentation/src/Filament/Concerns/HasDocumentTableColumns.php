<?php

declare(strict_types=1);

namespace Starter\ServerDocumentation\Filament\Concerns;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Support\Str;
use Starter\ServerDocumentation\Models\Document;

/**
 * Shared table column definitions for Document resources and relation managers.
 */
trait HasDocumentTableColumns
{
    protected static function getDocumentTitleColumn(int $descriptionLimit = 50): TextColumn
    {
        return TextColumn::make('title')
            ->label(trans('server-documentation::strings.document.title'))
            ->searchable()
            ->sortable()
            ->description(fn (Document $record) => Str::limit(strip_tags($record->content), $descriptionLimit));
    }

    protected static function getDocumentTypeColumn(): TextColumn
    {
        return TextColumn::make('content_type')
            ->label('Type')
            ->badge()
            ->formatStateUsing(fn (?string $state) => match ($state) {
                'markdown' => 'Markdown',
                'raw_html' => 'Raw HTML',
                default => 'Rich Text',
            })
            ->color(fn (?string $state) => match ($state) {
                'markdown' => 'info',
                'raw_html' => 'warning',
                default => 'success',
            })
            ->icon(fn (?string $state) => match ($state) {
                'markdown' => 'tabler-markdown',
                'raw_html' => 'tabler-code',
                default => 'tabler-file-text',
            });
    }

    protected static function getDocumentRolesColumn(): TextColumn
    {
        return TextColumn::make('roles.name')
            ->label(trans('server-documentation::strings.labels.roles'))
            ->badge()
            ->placeholder(trans('server-documentation::strings.visibility.everyone'))
            ->color('primary');
    }

    protected static function getDocumentGlobalColumn(): IconColumn
    {
        return IconColumn::make('is_global')
            ->boolean()
            ->label(trans('server-documentation::strings.document.is_global'))
            ->trueIcon('tabler-world')
            ->falseIcon('tabler-world-off');
    }

    protected static function getDocumentPublishedColumn(): IconColumn
    {
        return IconColumn::make('is_published')
            ->boolean()
            ->label(trans('server-documentation::strings.document.is_published'));
    }

    protected static function getDocumentUpdatedAtColumn(): TextColumn
    {
        return TextColumn::make('updated_at')
            ->label(trans('server-documentation::strings.table.updated_at'))
            ->dateTime()
            ->sortable()
            ->toggleable();
    }

    protected static function getDocumentRolesFilter(): SelectFilter
    {
        return SelectFilter::make('roles')
            ->label(trans('server-documentation::strings.labels.roles'))
            ->relationship('roles', 'name')
            ->multiple()
            ->preload();
    }

    protected static function getDocumentGlobalFilter(): TernaryFilter
    {
        return TernaryFilter::make('is_global')
            ->label(trans('server-documentation::strings.document.is_global'));
    }

    protected static function getDocumentPublishedFilter(): TernaryFilter
    {
        return TernaryFilter::make('is_published')
            ->label(trans('server-documentation::strings.document.is_published'));
    }
}
