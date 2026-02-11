<?php

declare(strict_types=1);

namespace Starter\ServerDocumentation\Filament\Admin\Resources;

use App\Models\Server;
use App\Models\User;
use App\Traits\Filament\CanCustomizePages;
use App\Traits\Filament\CanCustomizeRelations;
use App\Traits\Filament\CanModifyForm;
use App\Traits\Filament\CanModifyTable;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Starter\ServerDocumentation\Filament\Admin\Resources\DocumentResource\Pages;
use Starter\ServerDocumentation\Filament\Admin\Resources\DocumentResource\RelationManagers;
use Starter\ServerDocumentation\Filament\Concerns\HasDocumentTableColumns;
use Starter\ServerDocumentation\Models\Document;
use Starter\ServerDocumentation\Services\DocumentService;
use Starter\ServerDocumentation\Services\MarkdownConverter;

class DocumentResource extends Resource
{
    use CanCustomizePages;
    use CanCustomizeRelations;
    use CanModifyForm;
    use CanModifyTable;
    use HasDocumentTableColumns;

    protected static ?string $model = Document::class;

    protected static string|\BackedEnum|null $navigationIcon = 'tabler-file-text';

    protected static ?int $navigationSort = 10;

    protected static ?string $recordTitleAttribute = 'title';

    /**
     * Check if the user can access the document resource.
     */
    public static function canAccess(): bool
    {
        return auth()->check() && auth()->user()->can('viewList document');
    }

    public static function getNavigationLabel(): string
    {
        return trans('server-documentation::strings.navigation.documents');
    }

    public static function getModelLabel(): string
    {
        $key = 'server-documentation::strings.document.singular';

        return Lang::has($key) ? trans($key) : 'Document';
    }

    public static function getPluralModelLabel(): string
    {
        $key = 'server-documentation::strings.document.plural';

        return Lang::has($key) ? trans($key) : 'Documents';
    }

    public static function getNavigationGroup(): ?string
    {
        $key = 'server-documentation::strings.navigation.group';

        return Lang::has($key) ? trans($key) : 'Content';
    }

    public static function getNavigationBadge(): ?string
    {
        $count = app(DocumentService::class)->getDocumentCount();

        return $count > 0 ? (string) $count : null;
    }

    public static function defaultForm(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make(trans('server-documentation::strings.form.details_section'))->schema([
                    TextInput::make('title')
                        ->label(trans('server-documentation::strings.document.title'))
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, $set, ?Document $record) => $record === null ? $set('slug', Str::slug($state)) : null
                        ),

                    TextInput::make('slug')
                        ->label(trans('server-documentation::strings.document.slug'))
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->rules(['alpha_dash']),

                    Toggle::make('is_published')
                        ->label(trans('server-documentation::strings.document.is_published'))
                        ->default(true)
                        ->helperText(trans('server-documentation::strings.labels.published_helper')),

                    TextInput::make('sort_order')
                        ->label(trans('server-documentation::strings.document.sort_order'))
                        ->numeric()
                        ->default(0)
                        ->helperText(trans('server-documentation::strings.labels.sort_order_helper')),
                ])->columns(2)->columnSpanFull(),

                Section::make(function (Get $get) {
                    $type = $get('content_type') ?? request()->query('type', 'html');

                    return match ($type) {
                        'markdown' => 'Markdown Content',
                        'raw_html' => 'Raw HTML Content',
                        default => 'Rich Text Content',
                    };
                })->schema([
                    // Hidden field to store content_type
                    // Dynamic default reads from URL on create, database value takes precedence on edit
                    \Filament\Forms\Components\Hidden::make('content_type')
                        ->default(function () {
                            $type = request()->query('type', 'html');

                            return in_array($type, ['html', 'markdown', 'raw_html']) ? $type : 'html';
                        }),

                    // Document type badge (read-only display)
                    Placeholder::make('content_type_display')
                        ->label(trans('server-documentation::strings.form.content_type'))
                        ->content(function (Get $get) {
                            $type = $get('content_type') ?? request()->query('type', 'html');

                            return new HtmlString(match ($type) {
                                'markdown' => '<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">' . e(trans('server-documentation::strings.form.markdown')) . '</span>',
                                'raw_html' => '<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">' . e(trans('server-documentation::strings.form.raw_html')) . '</span>',
                                default => '<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">' . e(trans('server-documentation::strings.form.rich_text')) . '</span>',
                            });
                        })
                        ->columnSpanFull(),

                    Placeholder::make('variables_reference')
                        ->label('')
                        ->content(function () {
                            $variables = \Starter\ServerDocumentation\Services\VariableProcessor::getAvailableVariables();

                            $html = '<details class="text-sm">';
                            $html .= '<summary class="cursor-pointer text-primary-600 dark:text-primary-400 hover:underline font-medium">';
                            $html .= trans('server-documentation::strings.variables.show_available');
                            $html .= '</summary>';
                            $html .= '<div class="mt-3 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">';
                            $html .= '<div class="grid grid-cols-1 md:grid-cols-2 gap-2">';

                            foreach ($variables as $var => $description) {
                                $html .= '<div class="flex items-start gap-2">';
                                $html .= '<code class="text-xs bg-gray-200 dark:bg-gray-700 px-1.5 py-0.5 rounded whitespace-nowrap">' . e($var) . '</code>';
                                $html .= '<span class="text-xs text-gray-600 dark:text-gray-400">' . e($description) . '</span>';
                                $html .= '</div>';
                            }

                            $html .= '</div>';
                            $html .= '<p class="mt-3 text-xs text-gray-500 dark:text-gray-400">';
                            $html .= trans('server-documentation::strings.variables.escape_hint');
                            $html .= '</p>';
                            $html .= '</div></details>';

                            return new HtmlString($html);
                        })
                        ->columnSpanFull(),

                    // Rich Text Editor (for html type) - WYSIWYG, no preview needed
                    RichEditor::make('content_html')
                        ->label(trans('server-documentation::strings.document.content'))
                        ->required(function (Get $get) {
                            $type = $get('content_type') ?? request()->query('type', 'html');

                            return $type === 'html';
                        })
                        ->extraAttributes(['style' => 'min-height: 400px;'])
                        ->visible(function (Get $get) {
                            $type = $get('content_type') ?? request()->query('type', 'html');

                            return $type === 'html';
                        })
                        ->toolbarButtons([
                            'bold', 'italic', 'underline', 'strike',
                            'h2', 'h3',
                            'bulletList', 'orderedList',
                            'link',
                            'blockquote', 'codeBlock',
                            'undo', 'redo',
                        ])
                        ->helperText(trans('server-documentation::strings.form.rich_text_help'))
                        ->columnSpanFull(),

                    // Markdown Editor (for markdown type)
                    MarkdownEditor::make('content_markdown')
                        ->label(trans('server-documentation::strings.document.content'))
                        ->required(function (Get $get) {
                            $type = $get('content_type') ?? request()->query('type', 'html');

                            return $type === 'markdown';
                        })
                        ->extraAttributes(['style' => 'min-height: 400px;'])
                        ->visible(function (Get $get) {
                            $type = $get('content_type') ?? request()->query('type', 'html');

                            return $type === 'markdown';
                        })
                        ->live(debounce: 500)
                        ->helperText(trans('server-documentation::strings.form.markdown_help'))
                        ->columnSpanFull(),

                    // Raw HTML Textarea (for raw_html type)
                    Textarea::make('content_raw_html')
                        ->label(trans('server-documentation::strings.document.content'))
                        ->required(function (Get $get) {
                            $type = $get('content_type') ?? request()->query('type', 'html');

                            return $type === 'raw_html';
                        })
                        ->rows(20)
                        ->extraAttributes(['style' => 'font-family: monospace; min-height: 400px;'])
                        ->visible(function (Get $get) {
                            $type = $get('content_type') ?? request()->query('type', 'html');

                            return $type === 'raw_html';
                        })
                        ->live(debounce: 500)
                        ->helperText(trans('server-documentation::strings.form.raw_html_help'))
                        ->columnSpanFull(),

                    // Preview section - only for Markdown and Raw HTML (Rich Text is WYSIWYG)
                    Section::make(trans('server-documentation::strings.versions.preview'))
                        ->description(trans('server-documentation::strings.form.content_preview_description'))
                        ->collapsed(false)
                        ->visible(function (Get $get) {
                            $type = $get('content_type') ?? request()->query('type', 'html');

                            return in_array($type, ['markdown', 'raw_html']);
                        })
                        ->schema([
                            Placeholder::make('content_preview')
                                ->label(trans('server-documentation::strings.form.content_preview'))
                                ->content(function (Get $get) {
                                    $contentType = $get('content_type') ?? request()->query('type', 'html');
                                    // Get content from the appropriate field
                                    $content = match ($contentType) {
                                        'markdown' => $get('content_markdown'),
                                        'raw_html' => $get('content_raw_html'),
                                        default => $get('content_html'),
                                    };

                                    if (empty($content)) {
                                        return new HtmlString('<p class="text-gray-500 italic">' . e(trans('server-documentation::strings.form.content_preview_empty')) . '</p>');
                                    }

                                    $processor = app(\Starter\ServerDocumentation\Services\VariableProcessor::class);
                                    $converter = app(MarkdownConverter::class);

                                    // Process based on content type
                                    if ($contentType === 'markdown') {
                                        if ($processor->hasVariables($content)) {
                                            $content = $processor->process($content, auth()->user(), null);
                                        }
                                        // Convert markdown to HTML with sanitization enabled
                                        $html = $converter->toHtml($content, true);
                                    } else {
                                        // Raw HTML - process variables then sanitize
                                        $html = $content;
                                        if ($processor->hasVariables($html)) {
                                            $html = $processor->process($html, auth()->user(), null);
                                        }
                                        // Always sanitize HTML content to prevent XSS
                                        $html = $converter->sanitizeHtml($html);
                                    }

                                    // Use a Blade view to ensure proper HTML rendering
                                    return new HtmlString(
                                        view('server-documentation::filament.partials.content-preview', ['html' => $html])->render()
                                    );
                                })
                                ->columnSpanFull(),
                        ])
                        ->columnSpanFull(),
                ])->columnSpanFull(),

                Section::make(trans('server-documentation::strings.visibility.title'))
                    ->description(trans('server-documentation::strings.visibility.description'))
                    ->schema([
                        // Server Visibility
                        Fieldset::make(trans('server-documentation::strings.visibility.server'))
                            ->schema([
                                Toggle::make('is_global')
                                    ->label(trans('server-documentation::strings.labels.all_servers'))
                                    ->helperText(trans('server-documentation::strings.labels.all_servers_helper'))
                                    ->live()
                                    ->columnSpanFull(),

                                Select::make('eggs')
                                    ->label(trans('server-documentation::strings.labels.eggs'))
                                    ->relationship('eggs', 'name')
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->helperText(trans('server-documentation::strings.hints.eggs_hint'))
                                    ->hidden(fn (Get $get) => $get('is_global'))
                                    ->columnSpanFull(),

                                CheckboxList::make('servers')
                                    ->label(trans('server-documentation::strings.form.assign_to_servers'))
                                    ->relationship('servers', 'name', fn ($query) => $query->orderBy('name'))
                                    ->searchable()
                                    ->bulkToggleable()
                                    ->columns(2)
                                    ->helperText(trans('server-documentation::strings.form.assign_servers_helper'))
                                    ->hidden(fn (Get $get) => $get('is_global'))
                                    ->columnSpanFull(),
                            ])->columns(2),

                        // Person Visibility
                        Fieldset::make(trans('server-documentation::strings.visibility.person'))
                            ->schema([
                                Select::make('roles')
                                    ->label(trans('server-documentation::strings.labels.roles'))
                                    ->relationship('roles', 'name')
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->helperText(trans('server-documentation::strings.hints.roles_empty'))
                                    ->columnSpanFull(),

                                Select::make('users')
                                    ->label(trans('server-documentation::strings.labels.users'))
                                    ->relationship('users', 'username')
                                    ->multiple()
                                    ->searchable()
                                    ->getSearchResultsUsing(function (string $search) {
                                        // Escape SQL LIKE wildcards to prevent injection
                                        $escaped = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $search);
                                        $pattern = "%{$escaped}%";

                                        // Use explicit ESCAPE clause for cross-database compatibility
                                        return User::whereRaw('username LIKE ? ESCAPE ?', [$pattern, '\\'])
                                            ->orWhereRaw('email LIKE ? ESCAPE ?', [$pattern, '\\'])
                                            ->limit(50)
                                            ->pluck('username', 'id');
                                    })
                                    ->getOptionLabelUsing(fn ($value): ?string => User::find($value)?->username)
                                    ->helperText(trans('server-documentation::strings.hints.users_optional'))
                                    ->columnSpanFull(),
                            ])->columns(1),
                    ])->columnSpanFull(),

                Section::make(trans('server-documentation::strings.permission_guide.title'))
                    ->description(trans('server-documentation::strings.permission_guide.description'))
                    ->collapsed()
                    ->schema([
                        Placeholder::make('help')
                            ->label('')
                            ->content(new HtmlString(
                                view('server-documentation::filament.partials.permission-guide')->render() // @phpstan-ignore argument.type
                            )),
                    ])->columnSpanFull(),
            ]);
    }

    public static function defaultTable(Table $table): Table
    {
        return $table
            ->columns([
                static::getDocumentTitleColumn(),
                static::getDocumentTypeColumn(),
                static::getDocumentRolesColumn(),
                static::getDocumentGlobalColumn(),
                static::getDocumentPublishedColumn(),

                TextColumn::make('servers_count')
                    ->counts('servers')
                    ->label(trans('server-documentation::strings.table.servers'))
                    ->badge(),

                TextColumn::make('eggs_count')
                    ->counts('eggs')
                    ->label(trans('server-documentation::strings.labels.eggs'))
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('author.username')
                    ->label(trans('server-documentation::strings.document.author'))
                    ->toggleable(isToggledHiddenByDefault: true),

                static::getDocumentUpdatedAtColumn(),
            ])
            ->filters([
                static::getDocumentRolesFilter(),
                static::getDocumentGlobalFilter(),
                static::getDocumentPublishedFilter(),
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make(),
            ])
            ->defaultSort('sort_order')
            ->emptyStateIcon('tabler-file-off')
            ->emptyStateHeading(trans('server-documentation::strings.table.empty_heading'))
            ->emptyStateDescription(trans('server-documentation::strings.table.empty_description'));
    }

    /** @return class-string[] */
    public static function getRelations(): array
    {
        return [
            RelationManagers\ServersRelationManager::class,
        ];
    }

    /** @return array<string, PageRegistration> */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
            'versions' => Pages\ViewDocumentVersions::route('/{record}/versions'),
        ];
    }
}
