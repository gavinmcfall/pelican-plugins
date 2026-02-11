<?php

declare(strict_types=1);

namespace Starter\ServerDocumentation\Providers;

use App\Filament\Admin\Resources\Servers\ServerResource;
use App\Models\Server;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Starter\ServerDocumentation\Filament\Admin\RelationManagers\DocumentsRelationManager;
use Starter\ServerDocumentation\Models\Document;
use Starter\ServerDocumentation\Models\DocumentVersion;
use Starter\ServerDocumentation\Policies\DocumentPolicy;
use Starter\ServerDocumentation\Policies\DocumentVersionPolicy;
use Starter\ServerDocumentation\Services\DocumentService;
use Starter\ServerDocumentation\Services\MarkdownConverter;
use Starter\ServerDocumentation\Services\VariableProcessor;

class ServerDocumentationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/server-documentation.php', 'server-documentation');

        $this->app->singleton(DocumentService::class, function ($app) {
            return new DocumentService;
        });

        $this->app->singleton(MarkdownConverter::class, function ($app) {
            return new MarkdownConverter;
        });

        $this->app->singleton(VariableProcessor::class, function ($app) {
            return new VariableProcessor;
        });
    }

    public function boot(): void
    {
        Gate::policy(Document::class, DocumentPolicy::class);
        Gate::policy(DocumentVersion::class, DocumentVersionPolicy::class);

        $this->registerDocumentPermissions();

        if (! $this->app->runningInConsole()) {
            $this->registerLivewireComponents();
        }

        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'server-documentation');
        $this->loadTranslationsFrom(__DIR__.'/../../lang', 'server-documentation');

        $this->publishes([
            __DIR__.'/../../config/server-documentation.php' => config_path('server-documentation.php'),
        ], 'server-documentation-config');

        $this->publishes([
            __DIR__.'/../../resources/css' => public_path('plugins/server-documentation/css'),
            __DIR__.'/../../resources/js' => public_path('plugins/server-documentation/js'),
        ], 'server-documentation-assets');

        // Auto-publish CSS assets if they don't exist
        $this->autoPublishAssets();

        Server::resolveRelationUsing('documents', function (Server $server) {
            return $server->belongsToMany(
                Document::class,
                'document_server',
                'server_id',
                'document_id'
            )->withPivot('sort_order')->withTimestamps()->orderByPivot('sort_order');
        });

        ServerResource::registerCustomRelations(DocumentsRelationManager::class);
    }

    /**
     * Register Livewire components from the plugin.
     * This is needed because Livewire autodiscovery doesn't scan plugin directories.
     */
    protected function registerLivewireComponents(): void
    {
        // Register RelationManagers
        Livewire::component(
            'starter.server-documentation.filament.admin.relation-managers.documents-relation-manager',
            DocumentsRelationManager::class
        );

        Livewire::component(
            'starter.server-documentation.filament.admin.resources.document-resource.relation-managers.servers-relation-manager',
            \Starter\ServerDocumentation\Filament\Admin\Resources\DocumentResource\RelationManagers\ServersRelationManager::class
        );

        // Register Server Panel Pages
        Livewire::component(
            'starter.server-documentation.filament.server.pages.documents',
            \Starter\ServerDocumentation\Filament\Server\Pages\Documents::class
        );

        // Register Admin Resource Pages
        Livewire::component(
            'starter.server-documentation.filament.admin.resources.document-resource.pages.view-document-versions',
            \Starter\ServerDocumentation\Filament\Admin\Resources\DocumentResource\Pages\ViewDocumentVersions::class
        );
    }

    /**
     * Auto-publish CSS and JS assets, updating if source is newer than published version.
     */
    protected function autoPublishAssets(): void
    {
        $assets = [
            // CSS assets
            'css/document-content.css',
            // JS assets (highlight.js for syntax highlighting fallback)
            'js/highlight.min.js',
            'js/highlight-github-dark.min.css',
        ];

        foreach ($assets as $asset) {
            $sourcePath = __DIR__.'/../../resources/'.$asset;
            $publicPath = public_path('plugins/server-documentation/'.$asset);

            if (! file_exists($sourcePath)) {
                continue;
            }

            $publicDir = dirname($publicPath);
            if (! is_dir($publicDir)) {
                mkdir($publicDir, 0755, true);
            }

            // Always copy if public doesn't exist, or if source is newer
            if (! file_exists($publicPath) || filemtime($sourcePath) > filemtime($publicPath)) {
                copy($sourcePath, $publicPath);
            }
        }
    }

    /**
     * Register document-related Gates for admin panel permissions.
     *
     * These gates control who can manage documents in the admin panel.
     * Access is granted to:
     * - Root Admins (full access)
     * - Server Admins (users with server update/create permissions)
     *
     * Set config('server-documentation.explicit_permissions', true) to require
     * explicit document permissions instead of inheriting from server permissions.
     */
    protected function registerDocumentPermissions(): void
    {
        $permissions = [
            'viewList document',
            'view document',
            'create document',
            'update document',
            'delete document',
        ];

        foreach ($permissions as $permission) {
            Gate::define($permission, function (User $user) {
                if ($user->isRootAdmin()) {
                    return true;
                }

                if (config('server-documentation.explicit_permissions', false)) {
                    return false;
                }

                return $user->can('update server') || $user->can('create server');
            });
        }
    }
}
