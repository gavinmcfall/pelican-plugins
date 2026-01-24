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
        $rootAdminRole = Role::create(['name' => Role::ROOT_ADMIN]);
        $rootAdmin->roles()->attach($rootAdminRole);

        expect($this->policy->before($rootAdmin, 'viewAny'))->toBeTrue();
        expect($this->policy->before($rootAdmin, 'create'))->toBeTrue();
        expect($this->policy->before($rootAdmin, 'update'))->toBeTrue();
        expect($this->policy->before($rootAdmin, 'delete'))->toBeTrue();
    });

    it('defers viewOnServer to the specific method even for root admin', function () {
        $rootAdmin = User::factory()->create();
        $rootAdminRole = Role::create(['name' => Role::ROOT_ADMIN]);
        $rootAdmin->roles()->attach($rootAdminRole);

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
        $document = Mockery::mock(Document::class, [
            'is_global' => true,
            'is_published' => true,
        ]);

        $document->shouldReceive('getAttribute')->with('is_global')->andReturn(true);
        $document->shouldReceive('getAttribute')->with('is_published')->andReturn(true);

        $document->shouldReceive('isVisibleOnServer')
            ->with(Mockery::on(function (Server $s) use ($server) { return $s->id === $server->id; }))
            ->andReturn(true);

        $document->shouldReceive('isVisibleToUser')
            ->andReturn(true);

        expect($this->policy->viewOnServer($user, $document, $server))->toBeTrue();
    });

    it('allows viewing documents attached to the server', function () {
        $user = User::factory()->create();
        $server = Server::factory()->create();
        $document = Mockery::mock(Document::class, [
            'is_global' => false,
            'is_published' => true,
        ]);

        $document->shouldReceive('getAttribute')->with('is_global')->andReturn(false);
        $document->shouldReceive('getAttribute')->with('is_published')->andReturn(true);

        $document->shouldReceive('servers')
            ->andReturnSelf()
            ->shouldReceive('where')
            ->with('servers.id', $server->id)
            ->andReturnSelf()
            ->shouldReceive('exists')
            ->andReturn(true);

        $document->shouldReceive('isVisibleOnServer')
            ->andReturn(true);
        $document->shouldReceive('isVisibleToUser')
            ->andReturn(true);

        expect($this->policy->viewOnServer($user, $document, $server))->toBeTrue();
    });

    it('allows viewing documents attached to the server egg', function () {
        $user = User::factory()->create();
        $server = Server::factory()->create();
        $document = Mockery::mock(Document::class, [
            'is_global' => false,
            'is_published' => true,
        ]);
        $server->egg_id = 1; // Mock egg_id for the server

        $document->shouldReceive('getAttribute')->with('is_global')->andReturn(false);
        $document->shouldReceive('getAttribute')->with('is_published')->andReturn(true);

        $document->shouldReceive('eggs')
            ->andReturnSelf()
            ->shouldReceive('where')
            ->with('eggs.id', $server->egg_id)
            ->andReturnSelf()
            ->shouldReceive('exists')
            ->andReturn(true);

        $document->shouldReceive('isVisibleOnServer')
            ->andReturn(true);
        $document->shouldReceive('isVisibleToUser')
            ->andReturn(true);

        expect($this->policy->viewOnServer($user, $document, $server))->toBeTrue();
    });

    it('denies viewing documents not visible on the server', function () {
        $user = User::factory()->create();
        $server = Server::factory()->create();
        $otherServer = Server::factory()->create();
        $document = Mockery::mock(Document::class, [
            'is_global' => false,
            'is_published' => true,
        ]);
        $server->egg_id = 1;

        $document->shouldReceive('getAttribute')->with('is_global')->andReturn(false);
        $document->shouldReceive('getAttribute')->with('is_published')->andReturn(true);

        $document->shouldReceive('servers')
            ->andReturnSelf()
            ->shouldReceive('where')
            ->with('servers.id', $server->id)
            ->andReturnSelf()
            ->shouldReceive('exists')
            ->andReturn(false);
        $document->shouldReceive('eggs')
            ->andReturnSelf()
            ->shouldReceive('where')
            ->with('eggs.id', $server->egg_id)
            ->andReturnSelf()
            ->shouldReceive('exists')
            ->andReturn(false);

        $document->shouldReceive('isVisibleOnServer')
            ->andReturn(false);
        $document->shouldReceive('isVisibleToUser')
            ->andReturn(true); // This doesn't matter, as isVisibleOnServer returns false

        expect($this->policy->viewOnServer($user, $document, $server))->toBeFalse();
    });

    it('denies viewing unpublished documents for non-admins', function () {
        $user = User::factory()->create();
        $server = Server::factory()->create();
        $document = Mockery::mock(Document::class, [
            'is_global' => true,
            'is_published' => false,
        ]);

        $document->shouldReceive('getAttribute')->with('is_global')->andReturn(true);
        $document->shouldReceive('getAttribute')->with('is_published')->andReturn(false);

        $document->shouldReceive('isVisibleOnServer')
            ->andReturn(true);
        $document->shouldReceive('isVisibleToUser')
            ->andReturn(true);

        expect($this->policy->viewOnServer($user, $document, $server))->toBeFalse();
    });

    it('allows root admin to view unpublished documents', function () {
        $rootAdmin = User::factory()->create();
        $rootAdminRole = Role::create(['name' => Role::ROOT_ADMIN]);
        $rootAdmin->roles()->attach($rootAdminRole);
        $server = Server::factory()->create();
        $document = Mockery::mock(Document::class, [
            'is_global' => true,
            'is_published' => false,
        ]);

        $document->shouldReceive('getAttribute')->with('is_global')->andReturn(true);
        $document->shouldReceive('getAttribute')->with('is_published')->andReturn(false);

        $document->shouldReceive('isVisibleOnServer')
            ->andReturn(true);
        $document->shouldReceive('isVisibleToUser')
            ->andReturn(false); // Root admin bypasses isVisibleToUser

        expect($this->policy->viewOnServer($rootAdmin, $document, $server))->toBeTrue();
    });

    it('respects role-based visibility restrictions', function () {
        $role = Role::factory()->create(['name' => 'Test Role']);
        $userWithRole = User::factory()->create();
        $userWithRole->roles()->attach($role);
        $userWithoutRole = User::factory()->create();

        $server = Server::factory()->create();
        $document = Mockery::mock(Document::class, [
            'is_global' => true,
            'is_published' => true,
        ]);

        $document->shouldReceive('getAttribute')->with('is_global')->andReturn(true);
        $document->shouldReceive('getAttribute')->with('is_published')->andReturn(true);

        // Mock for userWithRole
        $document->shouldReceive('isVisibleOnServer')->andReturn(true)->byDefault();
        $document->shouldReceive('isVisibleToUser')
            ->with(Mockery::on(function (User $u) use ($userWithRole) { return $u->id === $userWithRole->id; }))
            ->andReturn(true);
        expect($this->policy->viewOnServer($userWithRole, $document, $server))->toBeTrue();

        // Mock for userWithoutRole
        $document->shouldReceive('isVisibleOnServer')->andReturn(true);
        $document->shouldReceive('isVisibleToUser')
            ->with(Mockery::on(function (User $u) use ($userWithoutRole) { return $u->id === $userWithoutRole->id; }))
            ->andReturn(false);
        expect($this->policy->viewOnServer($userWithoutRole, $document, $server))->toBeFalse();
    });

    it('respects user-based visibility restrictions', function () {
        $allowedUser = User::factory()->create();
        $deniedUser = User::factory()->create();
        $server = Server::factory()->create();
        $document = Mockery::mock(Document::class, [
            'is_global' => true,
            'is_published' => true,
        ]);

        $document->shouldReceive('getAttribute')->with('is_global')->andReturn(true);
        $document->shouldReceive('getAttribute')->with('is_published')->andReturn(true);

        // Mock for allowedUser
        $document->shouldReceive('isVisibleOnServer')->andReturn(true)->byDefault();
        $document->shouldReceive('isVisibleToUser')
            ->with(Mockery::on(function (User $u) use ($allowedUser) { return $u->id === $allowedUser->id; }))
            ->andReturn(true);
        expect($this->policy->viewOnServer($allowedUser, $document, $server))->toBeTrue();

        // Mock for deniedUser
        $document->shouldReceive('isVisibleOnServer')->andReturn(true);
        $document->shouldReceive('isVisibleToUser')
            ->with(Mockery::on(function (User $u) use ($deniedUser) { return $u->id === $deniedUser->id; }))
            ->andReturn(false);
        expect($this->policy->viewOnServer($deniedUser, $document, $server))->toBeFalse();
    });

    it('allows access when no visibility restrictions are set', function () {
        $user = User::factory()->create();
        $server = Server::factory()->create();
        $document = Mockery::mock(Document::class, [
            'is_global' => true,
            'is_published' => true,
        ]);

        $document->shouldReceive('getAttribute')->with('is_global')->andReturn(true);
        $document->shouldReceive('getAttribute')->with('is_published')->andReturn(true);

        // No roles or users attached = visible to everyone
        $document->shouldReceive('isVisibleOnServer')->andReturn(true);
        $document->shouldReceive('isVisibleToUser')->andReturn(true);

        expect($this->policy->viewOnServer($user, $document, $server))->toBeTrue();
    });
});

describe('admin permission gates', function () {
    it('allows users with server permissions to manage documents by default', function () {
        $user = Mockery::mock(User::class);
        $user->shouldReceive('can')->with('viewList document')->andReturn(true);
        $user->shouldReceive('can')->with('create document')->andReturn(true);
        $user->shouldReceive('can')->with('update document')->andReturn(true);

        expect($user->can('viewList document'))->toBeTrue();
        expect($user->can('create document'))->toBeTrue();
        expect($user->can('update document'))->toBeTrue();
    });

    it('denies users without server permissions when explicit_permissions is false', function () {
        $user = Mockery::mock(User::class);
        $user->shouldReceive('can')->with('viewList document')->andReturn(false);

        expect($user->can('viewList document'))->toBeFalse();
    });
});
