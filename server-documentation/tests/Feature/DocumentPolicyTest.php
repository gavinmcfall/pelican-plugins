<?php

declare(strict_types=1);

use App\Models\Role;
use App\Models\Server;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Starter\ServerDocumentation\Models\Document;
use Starter\ServerDocumentation\Policies\DocumentPolicy;

beforeEach(function () {
    $this->policy = new DocumentPolicy();
});

describe('before hook', function () {
    it('grants root admin full access to admin operations', function () {
        $rootAdmin = User::factory()->create();
        $rootAdmin->roles()->attach(Role::where('name', Role::ROOT_ADMIN)->first());

        expect($this->policy->before($rootAdmin, 'viewAny'))->toBeTrue();
        expect($this->policy->before($rootAdmin, 'create'))->toBeTrue();
        expect($this->policy->before($rootAdmin, 'update'))->toBeTrue();
        expect($this->policy->before($rootAdmin, 'delete'))->toBeTrue();
    });

    it('defers viewOnServer to the specific method even for root admin', function () {
        $rootAdmin = User::factory()->create();
        $rootAdmin->roles()->attach(Role::where('name', Role::ROOT_ADMIN)->first());

        // before() returns null for viewOnServer, deferring to the actual method
        expect($this->policy->before($rootAdmin, 'viewOnServer'))->toBeNull();
    });

    it('returns null for non-admin users to defer to specific methods', function () {
        $user = User::factory()->create();

        expect($this->policy->before($user, 'viewAny'))->toBeNull();
        expect($this->policy->before($user, 'create'))->toBeNull();
    });
});

describe('viewOnServer', function () {
    it('allows viewing global documents on any server', function () {
        $user = User::factory()->create();
        $server = Server::factory()->create();
        $document = Document::factory()->create([
            'is_global' => true,
            'is_published' => true,
        ]);

        expect($this->policy->viewOnServer($user, $document, $server))->toBeTrue();
    });

    it('allows viewing documents attached to the server', function () {
        $user = User::factory()->create();
        $server = Server::factory()->create();
        $document = Document::factory()->create([
            'is_global' => false,
            'is_published' => true,
        ]);
        $document->servers()->attach($server);

        expect($this->policy->viewOnServer($user, $document, $server))->toBeTrue();
    });

    it('allows viewing documents attached to the server egg', function () {
        $user = User::factory()->create();
        $server = Server::factory()->create();
        $document = Document::factory()->create([
            'is_global' => false,
            'is_published' => true,
        ]);
        $document->eggs()->attach($server->egg_id);

        expect($this->policy->viewOnServer($user, $document, $server))->toBeTrue();
    });

    it('denies viewing documents not visible on the server', function () {
        $user = User::factory()->create();
        $server = Server::factory()->create();
        $otherServer = Server::factory()->create();
        $document = Document::factory()->create([
            'is_global' => false,
            'is_published' => true,
        ]);
        $document->servers()->attach($otherServer);

        expect($this->policy->viewOnServer($user, $document, $server))->toBeFalse();
    });

    it('denies viewing unpublished documents for non-admins', function () {
        $user = User::factory()->create();
        $server = Server::factory()->create();
        $document = Document::factory()->create([
            'is_global' => true,
            'is_published' => false,
        ]);

        expect($this->policy->viewOnServer($user, $document, $server))->toBeFalse();
    });

    it('allows root admin to view unpublished documents', function () {
        $rootAdmin = User::factory()->create();
        $rootAdmin->roles()->attach(Role::where('name', Role::ROOT_ADMIN)->first());
        $server = Server::factory()->create();
        $document = Document::factory()->create([
            'is_global' => true,
            'is_published' => false,
        ]);

        expect($this->policy->viewOnServer($rootAdmin, $document, $server))->toBeTrue();
    });

    it('respects role-based visibility restrictions', function () {
        $role = Role::factory()->create(['name' => 'Test Role']);
        $userWithRole = User::factory()->create();
        $userWithRole->roles()->attach($role);
        $userWithoutRole = User::factory()->create();

        $server = Server::factory()->create();
        $document = Document::factory()->create([
            'is_global' => true,
            'is_published' => true,
        ]);
        $document->roles()->attach($role);

        expect($this->policy->viewOnServer($userWithRole, $document, $server))->toBeTrue();
        expect($this->policy->viewOnServer($userWithoutRole, $document, $server))->toBeFalse();
    });

    it('respects user-based visibility restrictions', function () {
        $allowedUser = User::factory()->create();
        $deniedUser = User::factory()->create();
        $server = Server::factory()->create();
        $document = Document::factory()->create([
            'is_global' => true,
            'is_published' => true,
        ]);
        $document->users()->attach($allowedUser);

        expect($this->policy->viewOnServer($allowedUser, $document, $server))->toBeTrue();
        expect($this->policy->viewOnServer($deniedUser, $document, $server))->toBeFalse();
    });

    it('allows access when no visibility restrictions are set', function () {
        $user = User::factory()->create();
        $server = Server::factory()->create();
        $document = Document::factory()->create([
            'is_global' => true,
            'is_published' => true,
        ]);
        // No roles or users attached = visible to everyone

        expect($this->policy->viewOnServer($user, $document, $server))->toBeTrue();
    });
});

describe('admin permission gates', function () {
    it('allows users with server permissions to manage documents by default', function () {
        $user = User::factory()->create();
        // Simulate user having 'update server' permission
        Gate::define('update server', fn () => true);

        expect($user->can('viewList document'))->toBeTrue();
        expect($user->can('create document'))->toBeTrue();
        expect($user->can('update document'))->toBeTrue();
    });

    it('denies users without server permissions when explicit_permissions is false', function () {
        $user = User::factory()->create();
        Gate::define('update server', fn () => false);
        Gate::define('create server', fn () => false);

        expect($user->can('viewList document'))->toBeFalse();
    });
});
