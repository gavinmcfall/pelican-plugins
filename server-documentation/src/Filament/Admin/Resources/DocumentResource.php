<?php

declare(strict_types=1);

namespace Starter\ServerDocumentation\Filament\Admin\Resources;

use App\Models\Egg;
use App\Models\Server;
use App\Models\User;
use App\Traits\Filament\CanCustomizePages;
use App\Traits\Filament\CanCustomizeRelations;
use App\Traits\Filament\CanModifyForm;
use App\Traits\Filament\CanModifyTable;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\CheckboxList;
use Filament\Schemas\Components\Fieldset;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
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

                Section::make(trans('server-documentation::strings.document.content'))->schema([
                    RichEditor::make('content')
                        ->label('')
                        ->required()
                        ->extraAttributes(['style' => 'min-height: 400px;'])
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

                                Select::make('filter_egg')
                                    ->label(trans('server-documentation::strings.form.filter_by_egg'))
                                    ->options(fn () => Egg::pluck('name', 'id'))
                                    ->placeholder(trans('server-documentation::strings.form.all_eggs'))
                                    ->live()
                                    ->afterStateUpdated(fn ($set) => $set('servers', []))
                                    ->hidden(fn (Get $get) => $get('is_global')),

                                CheckboxList::make('servers')
                                    ->label(trans('server-documentation::strings.form.assign_to_servers'))
                                    ->relationship('servers', 'name')
                                    ->options(function ($get) {
                                        $query = Server::query()->orderBy('name');

                                        if ($eggId = $get('filter_egg')) {
                                            $query->where('egg_id', $eggId);
                                        }

                                        return $query->pluck('name', 'id');
                                    })
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
                                    ->getSearchResultsUsing(fn (string $search) => User::where('username', 'like', "%{$search}%")
                                        ->orWhere('email', 'like', "%{$search}%")
                                        ->limit(50)
                                        ->pluck('username', 'id'))
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
