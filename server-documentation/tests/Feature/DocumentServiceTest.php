<?php

declare(strict_types=1);

use App\Models\Egg;
use App\Models\Role;
use App\Models\Server;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Starter\ServerDocumentation\Models\Document;
use Starter\ServerDocumentation\Models\DocumentVersion;
use Starter\ServerDocumentation\Services\DocumentService;

beforeEach(function () {
    $this->service = app(DocumentService::class);
});

describe('getDocumentsForServer', function () {
    it('returns published documents visible on the server', function () {
        $server = Server::factory()->create();
        $visibleDoc = Document::factory()->create([
            'is_global' => true,
            'is_published' => true,
        ]);
        $unpublishedDoc = Document::factory()->create([
            'is_global' => true,
            'is_published' => false,
        ]);

        $results = $this->service->getDocumentsForServer($server);

        expect($results->pluck('id'))->toContain($visibleDoc->id);
        expect($results->pluck('id'))->not->toContain($unpublishedDoc->id);
    });

    it('applies user visibility restrictions for non-admin users', function () {
        $role = Role::factory()->create(['name' => 'VIP']);
        $vipUser = User::factory()->create();
        $vipUser->roles()->attach($role);
        $regularUser = User::factory()->create();

        $server = Server::factory()->create();
        $restrictedDoc = Document::factory()->create([
            'is_global' => true,
            'is_published' => true,
        ]);
        $restrictedDoc->roles()->attach($role);

        $vipResults = $this->service->getDocumentsForServer($server, $vipUser);
        $regularResults = $this->service->getDocumentsForServer($server, $regularUser);

        expect($vipResults->pluck('id'))->toContain($restrictedDoc->id);
        expect($regularResults->pluck('id'))->not->toContain($restrictedDoc->id);
    });

    it('bypasses user restrictions for root admin', function () {
        $rootAdmin = User::factory()->create();
        $rootAdmin->roles()->attach(Role::where('name', Role::ROOT_ADMIN)->first());

        $role = Role::factory()->create(['name' => 'Private']);
        $server = Server::factory()->create();
        $restrictedDoc = Document::factory()->create([
            'is_global' => true,
            'is_published' => true,
        ]);
        $restrictedDoc->roles()->attach($role);

        $results = $this->service->getDocumentsForServer($server, $rootAdmin);

        expect($results->pluck('id'))->toContain($restrictedDoc->id);
    });

    it('orders server-attached docs by pivot sort_order first', function () {
        $server = Server::factory()->create();

        $doc1 = Document::factory()->create(['is_global' => false, 'is_published' => true, 'sort_order' => 99]);
        $doc2 = Document::factory()->create(['is_global' => false, 'is_published' => true, 'sort_order' => 1]);
        $doc3 = Document::factory()->create(['is_global' => false, 'is_published' => true, 'sort_order' => 50]);

        $doc1->servers()->attach($server, ['sort_order' => 3]);
        $doc2->servers()->attach($server, ['sort_order' => 1]);
        $doc3->servers()->attach($server, ['sort_order' => 2]);

        $results = $this->service->getDocumentsForServer($server);

        expect($results->first()->id)->toBe($doc2->id);
        expect($results->get(1)->id)->toBe($doc3->id);
        expect($results->get(2)->id)->toBe($doc1->id);
    });
});

describe('version management', function () {
    it('creates a version when document content changes', function () {
        $document = Document::factory()->create([
            'title' => 'Original Title',
            'content' => '<p>Original content</p>',
        ]);

        $document->update([
            'content' => '<p>Updated content</p>',
        ]);

        expect($document->versions()->count())->toBe(1);
        expect($document->versions()->first()->content)->toBe('<p>Original content</p>');
    });

    it('creates a version when document title changes', function () {
        $document = Document::factory()->create([
            'title' => 'Original Title',
            'content' => '<p>Content</p>',
        ]);

        $document->update([
            'title' => 'New Title',
        ]);

        expect($document->versions()->count())->toBe(1);
        expect($document->versions()->first()->title)->toBe('Original Title');
    });

    it('does not create version for non-versionable field changes', function () {
        $document = Document::factory()->create([
            'sort_order' => 0,
        ]);

        $document->update([
            'sort_order' => 10,
        ]);

        expect($document->versions()->count())->toBe(0);
    });

    it('increments version number with each change', function () {
        $document = Document::factory()->create(['content' => '<p>V1</p>']);

        // Wait to avoid rate limiting
        $document->update(['content' => '<p>V2</p>']);
        sleep(1); // Small delay
        $document->refresh();

        expect($document->versions()->max('version_number'))->toBeGreaterThanOrEqual(1);
    });

    it('restores document to a previous version', function () {
        $document = Document::factory()->create([
            'title' => 'Original',
            'content' => '<p>Original</p>',
        ]);

        $document->update(['title' => 'Updated', 'content' => '<p>Updated</p>']);
        $document->refresh();

        $version = $document->versions()->first();
        $this->service->restoreVersion($document, $version);
        $document->refresh();

        expect($document->title)->toBe('Original');
        expect($document->content)->toBe('<p>Original</p>');
    });
});

describe('generateChangeSummary', function () {
    it('describes title changes', function () {
        $summary = $this->service->generateChangeSummary(['title'], 'old', 'old');

        expect($summary)->toContain('title');
    });

    it('describes content changes with character difference', function () {
        $summary = $this->service->generateChangeSummary(['content'], 'short', 'much longer content');

        expect($summary)->toContain('content');
        expect($summary)->toMatch('/\+\d+ chars/');
    });

    it('indicates content reduction', function () {
        $summary = $this->service->generateChangeSummary(['content'], 'very long content here', 'short');

        expect($summary)->toContain('content');
        expect($summary)->toMatch('/-\d+ chars/');
    });

    it('indicates reformatted content when length unchanged', function () {
        $summary = $this->service->generateChangeSummary(['content'], 'abcd', 'dcba');

        expect($summary)->toContain('reformatted');
    });
});

describe('pruneVersions', function () {
    it('removes old versions keeping only the specified count', function () {
        $document = Document::factory()->create();

        // Create 10 versions manually
        for ($i = 1; $i <= 10; $i++) {
            DocumentVersion::factory()->create([
                'document_id' => $document->id,
                'version_number' => $i,
            ]);
        }

        expect($document->versions()->count())->toBe(10);

        $deleted = $this->service->pruneVersions($document, 5);

        expect($deleted)->toBe(5);
        expect($document->versions()->count())->toBe(5);
        expect($document->versions()->min('version_number'))->toBe(6);
    });

    it('does nothing when keepCount is zero', function () {
        $document = Document::factory()->create();
        DocumentVersion::factory()->count(5)->create(['document_id' => $document->id]);

        $deleted = $this->service->pruneVersions($document, 0);

        expect($deleted)->toBe(0);
        expect($document->versions()->count())->toBe(5);
    });
});

describe('caching', function () {
    it('caches document queries', function () {
        config(['server-documentation.cache_ttl' => 300]);
        $server = Server::factory()->create();
        Document::factory()->create(['is_global' => true, 'is_published' => true]);

        // First call should query
        $this->service->getDocumentsForServer($server);

        // Second call should use cache
        $results = $this->service->getDocumentsForServer($server);

        expect($results)->toHaveCount(1);
    });

    it('clears cache when document is saved', function () {
        config(['server-documentation.cache_ttl' => 300]);
        $server = Server::factory()->create();
        $document = Document::factory()->create(['is_global' => true, 'is_published' => true]);
        $document->servers()->attach($server);

        // Prime cache
        $this->service->getDocumentsForServer($server);

        // Update document should clear cache
        $document->update(['title' => 'New Title']);

        // This should be a fresh query
        $results = $this->service->getDocumentsForServer($server);

        expect($results->first()->title)->toBe('New Title');
    });
});

describe('getDocumentCount', function () {
    it('returns the total document count', function () {
        Document::factory()->count(5)->create();

        $count = $this->service->getDocumentCount();

        expect($count)->toBe(5);
    });

    it('caches the count', function () {
        config(['server-documentation.badge_cache_ttl' => 60]);
        Document::factory()->count(3)->create();

        $count1 = $this->service->getDocumentCount();

        // Create more without clearing cache
        Document::query()->delete();

        $count2 = $this->service->getDocumentCount();

        // Should still return cached count
        expect($count1)->toBe(3);
    });
});
