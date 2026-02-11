<?php

declare(strict_types=1);

use App\Models\Role;
use App\Models\Server;
use App\Models\User;
use Starter\ServerDocumentation\Services\VariableProcessor;

beforeEach(function () {
    $this->processor = new VariableProcessor;
});

describe('hasVariables', function () {
    it('detects presence of variables', function () {
        expect($this->processor->hasVariables('Hello {{user.name}}'))->toBeTrue();
        expect($this->processor->hasVariables('No variables here'))->toBeFalse();
    });
});

describe('extractVariables', function () {
    it('extracts all unique variables', function () {
        $content = '{{user.name}} and {{server.name}} and {{user.name}}';
        $variables = $this->processor->extractVariables($content);

        expect($variables)->toHaveCount(2);
        expect($variables)->toContain('{{user.name}}');
        expect($variables)->toContain('{{server.name}}');
    });
});

describe('process', function () {
    it('replaces date variables', function () {
        $now = now();
        $content = 'Today is {{date}}';
        $result = $this->processor->process($content);

        expect($result)->toBe('Today is '.$now->format('Y-m-d'));
    });

    it('replaces user variables', function () {
        $user = Mockery::mock(User::class);
        $user->shouldReceive('offsetExists')->andReturn(true)->byDefault();
        $user->shouldReceive('getAttribute')->with('name')->andReturn('John Doe');
        $user->shouldReceive('getAttribute')->with('username')->andReturn('johndoe');
        $user->shouldReceive('getAttribute')->with('email')->andReturn('john@example.com');
        $user->shouldReceive('getAttribute')->with('id')->andReturn(123);
        $user->shouldReceive('getAttribute')->with('roles')->andReturn(collect([new Role(['name' => 'Admin'])]));

        $content = 'Hello {{user.name}} ({{user.username}}), your ID is {{user.id}} and email is {{user.email}}';
        $result = $this->processor->process($content, $user);

        expect($result)->toBe('Hello John Doe (johndoe), your ID is 123 and email is john@example.com');
    });

    it('replaces server variables', function () {
        $server = Mockery::mock(Server::class);
        $server->shouldReceive('offsetExists')->andReturn(true)->byDefault();
        $server->shouldReceive('getAttribute')->with('name')->andReturn('Test Server');
        $server->shouldReceive('getAttribute')->with('uuid')->andReturn('uuid-123');
        $server->shouldReceive('getAttribute')->with('id')->andReturn(1);
        $server->shouldReceive('getAttribute')->with('memory')->andReturn(1024);
        $server->shouldReceive('getAttribute')->with('disk')->andReturn(5120);
        $server->shouldReceive('getAttribute')->with('cpu')->andReturn(100);
        $server->shouldReceive('getAttribute')->with('allocation')->andReturn(null);
        $server->shouldReceive('getAttribute')->with('egg')->andReturn((object) ['name' => 'Minecraft']);
        $server->shouldReceive('getAttribute')->with('node')->andReturn((object) ['name' => 'Node 1']);

        $content = 'Server {{server.name}} ({{server.uuid}}) has {{server.memory}}MB RAM';
        $result = $this->processor->process($content, null, $server);

        expect($result)->toBe('Server Test Server (uuid-123) has 1024MB RAM');
    });

    it('handles escaped variables', function () {
        $content = 'Show literal \{{user.name}} instead of value';
        $result = $this->processor->process($content);

        expect($result)->toBe('Show literal {{user.name}} instead of value');
    });

    it('fixes mangled variables from rich text editor', function () {
        $content = 'Fix {{<a href="http://user.name">user.name</a>}}';
        $user = Mockery::mock(User::class);
        $user->shouldReceive('offsetExists')->andReturn(true)->byDefault();
        $user->shouldReceive('getAttribute')->with('name')->andReturn('John Doe');
        $user->shouldReceive('getAttribute')->with('username')->andReturn('johndoe');
        $user->shouldReceive('getAttribute')->with('email')->andReturn('john@example.com');
        $user->shouldReceive('getAttribute')->with('id')->andReturn(123);
        $user->shouldReceive('getAttribute')->with('roles')->andReturn(collect([]));

        $result = $this->processor->process($content, $user);

        expect($result)->toBe('Fix John Doe');
    });
});
