<?php

declare(strict_types=1);

use App\Models\Egg;
use App\Models\Role;
use App\Models\Server;
use App\Models\User;
use Starter\ServerDocumentation\Models\Document;

describe('scopeVisibleOnServer', function () {
    it('includes global documents', function () {
        $server = Server::factory()->create();
        $globalDoc = Document::factory()->create(['is_global' => true]);
        $nonGlobalDoc = Document::factory()->create(['is_global' => false]);

        $results = Document::visibleOnServer($server)->get();

        expect($results->pluck('id'))->toContain($globalDoc->id);
        expect($results->pluck('id'))->not->toContain($nonGlobalDoc->id);
    });

    it('includes documents attached to the server', function () {
        $server = Server::factory()->create();
        $attachedDoc = Document::factory()->create(['is_global' => false]);
        $attachedDoc->servers()->attach($server);

        $unattachedDoc = Document::factory()->create(['is_global' => false]);

        $results = Document::visibleOnServer($server)->get();

        expect($results->pluck('id'))->toContain($attachedDoc->id);
        expect($results->pluck('id'))->not->toContain($unattachedDoc->id);
    });

    it('includes documents attached to the server egg', function () {
        $egg = Egg::factory()->create();
        $server = Server::factory()->create(['egg_id' => $egg->id]);
        $eggDoc = Document::factory()->create(['is_global' => false]);
        $eggDoc->eggs()->attach($egg);

        $otherDoc = Document::factory()->create(['is_global' => false]);

        $results = Document::visibleOnServer($server)->get();

        expect($results->pluck('id'))->toContain($eggDoc->id);
        expect($results->pluck('id'))->not->toContain($otherDoc->id);
    });

    it('combines global, server-attached, and egg-attached documents', function () {
        $egg = Egg::factory()->create();
        $server = Server::factory()->create(['egg_id' => $egg->id]);

        $globalDoc = Document::factory()->create(['is_global' => true]);
        $serverDoc = Document::factory()->create(['is_global' => false]);
        $serverDoc->servers()->attach($server);
        $eggDoc = Document::factory()->create(['is_global' => false]);
        $eggDoc->eggs()->attach($egg);
        $hiddenDoc = Document::factory()->create(['is_global' => false]);

        $results = Document::visibleOnServer($server)->get();

        expect($results)->toHaveCount(3);
        expect($results->pluck('id'))
            ->toContain($globalDoc->id)
            ->toContain($serverDoc->id)
            ->toContain($eggDoc->id)
            ->not->toContain($hiddenDoc->id);
    });
});

describe('scopeVisibleToUser', function () {
    it('includes documents with no restrictions', function () {
        $user = User::factory()->create();
        $openDoc = Document::factory()->create();
        // No roles or users attached

        $results = Document::visibleToUser($user)->get();

        expect($results->pluck('id'))->toContain($openDoc->id);
    });

    it('includes documents when user is explicitly listed', function () {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $restrictedDoc = Document::factory()->create();
        $restrictedDoc->users()->attach($user);

        $resultsForUser = Document::visibleToUser($user)->get();
        $resultsForOther = Document::visibleToUser($otherUser)->get();

        expect($resultsForUser->pluck('id'))->toContain($restrictedDoc->id);
        expect($resultsForOther->pluck('id'))->not->toContain($restrictedDoc->id);
    });

    it('includes documents when user has a required role', function () {
        $role = Role::factory()->create(['name' => 'Support']);
        $userWithRole = User::factory()->create();
        $userWithRole->roles()->attach($role);
        $userWithoutRole = User::factory()->create();

        $roleDoc = Document::factory()->create();
        $roleDoc->roles()->attach($role);

        $resultsWithRole = Document::visibleToUser($userWithRole)->get();
        $resultsWithoutRole = Document::visibleToUser($userWithoutRole)->get();

        expect($resultsWithRole->pluck('id'))->toContain($roleDoc->id);
        expect($resultsWithoutRole->pluck('id'))->not->toContain($roleDoc->id);
    });

    it('allows access via either user or role', function () {
        $role = Role::factory()->create(['name' => 'Admin']);
        $userWithRole = User::factory()->create();
        $userWithRole->roles()->attach($role);
        $explicitUser = User::factory()->create();
        $excludedUser = User::factory()->create();

        $doc = Document::factory()->create();
        $doc->roles()->attach($role);
        $doc->users()->attach($explicitUser);

        expect(Document::visibleToUser($userWithRole)->get()->pluck('id'))->toContain($doc->id);
        expect(Document::visibleToUser($explicitUser)->get()->pluck('id'))->toContain($doc->id);
        expect(Document::visibleToUser($excludedUser)->get()->pluck('id'))->not->toContain($doc->id);
    });
});

describe('scopePublished', function () {
    it('only includes published documents', function () {
        $published = Document::factory()->create(['is_published' => true]);
        $unpublished = Document::factory()->create(['is_published' => false]);

        $results = Document::published()->get();

        expect($results->pluck('id'))->toContain($published->id);
        expect($results->pluck('id'))->not->toContain($unpublished->id);
    });
});

describe('scopeGlobal', function () {
    it('only includes global documents', function () {
        $global = Document::factory()->create(['is_global' => true]);
        $nonGlobal = Document::factory()->create(['is_global' => false]);

        $results = Document::global()->get();

        expect($results->pluck('id'))->toContain($global->id);
        expect($results->pluck('id'))->not->toContain($nonGlobal->id);
    });
});

describe('scopeSearch', function () {
    it('searches by title', function () {
        $matchingDoc = Document::factory()->create(['title' => 'Getting Started Guide']);
        $nonMatchingDoc = Document::factory()->create(['title' => 'Other Document']);

        $results = Document::search('Started')->get();

        expect($results->pluck('id'))->toContain($matchingDoc->id);
        expect($results->pluck('id'))->not->toContain($nonMatchingDoc->id);
    });

    it('searches by slug', function () {
        $matchingDoc = Document::factory()->create(['slug' => 'installation-guide']);
        $nonMatchingDoc = Document::factory()->create(['slug' => 'other-doc']);

        $results = Document::search('installation')->get();

        expect($results->pluck('id'))->toContain($matchingDoc->id);
    });

    it('searches by content', function () {
        $matchingDoc = Document::factory()->create(['content' => '<p>Configure your database settings</p>']);
        $nonMatchingDoc = Document::factory()->create(['content' => '<p>Other content here</p>']);

        $results = Document::search('database')->get();

        expect($results->pluck('id'))->toContain($matchingDoc->id);
        expect($results->pluck('id'))->not->toContain($nonMatchingDoc->id);
    });

    it('returns all documents for empty search term', function () {
        Document::factory()->count(3)->create();

        $results = Document::search('')->get();

        expect($results)->toHaveCount(3);
    });
});
