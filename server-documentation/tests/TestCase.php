<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as Orchestra;
use Starter\ServerDocumentation\Providers\ServerDocumentationServiceProvider;

class TestCase extends Orchestra
{
    use RefreshDatabase;

    protected function getPackageProviders($app)
    {
        return [
            ServerDocumentationServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function defineDatabaseMigrations()
    {
        // Load mock migrations first to ensure base tables like 'roles' exist
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        // Then load the plugin's actual migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    /**
     * Get package factories. Laravel 8+ uses a new factory discovery mechanism.
     *
     * @return array<int, string>
     */
    protected function getFactories(): array
    {
        return [
            // Path to your package's factories
            __DIR__.'/database/factories',
            // Path to app's mock factories
            __DIR__.'/app/Models',
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();
    }
}
