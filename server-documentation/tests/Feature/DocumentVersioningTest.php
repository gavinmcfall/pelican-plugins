<?php

declare(strict_types=1);

use Carbon\Carbon;
use Starter\ServerDocumentation\Models\Document;
use Starter\ServerDocumentation\Services\DocumentService;

/**
 * Tests for Document versioning behavior.
 *
 * These tests verify version creation, debouncing, and history preservation.
 */
beforeEach(function () {
    // Create a partial mock to avoid cache clearing which loads relationships
    // that don't exist in the standalone test environment
    $this->service = Mockery::mock(DocumentService::class)->makePartial();
    $this->service->shouldReceive('clearDocumentCache')->andReturn();
    $this->service->shouldReceive('clearCountCache')->andReturn();
    app()->instance(DocumentService::class, $this->service);
});

describe('version creation on document update', function () {
    it('creates a version when title changes', function () {
        $document = Document::factory()->create([
            'title' => 'Original Title',
            'content' => 'Content',
        ]);

        expect($document->versions()->count())->toBe(0);

        $document->update(['title' => 'New Title']);

        expect($document->versions()->count())->toBe(1);

        $version = $document->versions()->first();
        expect($version->title)->toBe('Original Title');
    });

    it('creates a version when content changes', function () {
        $document = Document::factory()->create([
            'title' => 'Title',
            'content' => 'Original content',
        ]);

        $document->update(['content' => 'New content']);

        expect($document->versions()->count())->toBe(1);

        $version = $document->versions()->first();
        expect($version->content)->toBe('Original content');
    });

    it('does not create version for non-versionable field changes', function () {
        $document = Document::factory()->create([
            'is_published' => false,
            'sort_order' => 0,
        ]);

        $document->update([
            'is_published' => true,
            'sort_order' => 10,
        ]);

        expect($document->versions()->count())->toBe(0);
    });

    it('increments version number correctly', function () {
        $document = Document::factory()->create();

        $document->update(['content' => 'Version 1 trigger']);
        $document->refresh();

        // Need to wait past debounce window
        Carbon::setTestNow(now()->addSeconds(35));

        $document->update(['content' => 'Version 2 trigger']);
        $document->refresh();

        Carbon::setTestNow(now()->addSeconds(35));

        $document->update(['content' => 'Version 3 trigger']);
        $document->refresh();

        Carbon::setTestNow(); // Reset

        // Use reorder() to clear the default orderByDesc from the relationship
        $versions = $document->versions()->reorder('version_number', 'asc')->get();

        expect($versions)->toHaveCount(3);
        expect($versions[0]->version_number)->toBe(1);
        expect($versions[1]->version_number)->toBe(2);
        expect($versions[2]->version_number)->toBe(3);
    });
});

describe('version debounce behavior', function () {
    it('updates existing version within debounce window', function () {
        $document = Document::factory()->create([
            'title' => 'Original',
            'content' => 'Original content',
        ]);

        // First update - creates version
        $document->update(['content' => 'First edit']);
        expect($document->versions()->count())->toBe(1);

        $firstVersion = $document->versions()->first();
        $firstVersionId = $firstVersion->id;

        // Second update within 30 seconds - should update existing version
        $document->update(['content' => 'Second edit']);

        // Still only 1 version
        expect($document->versions()->count())->toBe(1);

        // But the version was updated (same ID)
        $updatedVersion = $document->versions()->first();
        expect($updatedVersion->id)->toBe($firstVersionId);
    });

    it('creates new version after debounce window passes', function () {
        $document = Document::factory()->create([
            'content' => 'Original',
        ]);

        // First update
        $document->update(['content' => 'First edit']);
        expect($document->versions()->count())->toBe(1);

        // Travel past debounce window (30 seconds)
        Carbon::setTestNow(now()->addSeconds(35));

        // Second update - should create new version
        $document->update(['content' => 'Second edit']);
        expect($document->versions()->count())->toBe(2);

        Carbon::setTestNow(); // Reset
    });

    // This test documents the data loss issue with debouncing
    it('loses intermediate content when debounce updates in place', function () {
        $document = Document::factory()->create([
            'content' => 'Original content',
        ]);

        // First edit - version stores "Original content"
        $document->update(['content' => 'First edit - important info']);

        $version = $document->versions()->first();
        expect($version->content)->toBe('Original content');

        // Second edit within debounce - version is UPDATED
        // This means "First edit - important info" is LOST from history
        $document->update(['content' => 'Second edit']);

        $document->refresh();
        $version = $document->versions()->first();

        // The version now stores the first edit, not original
        // But if we look at what's recoverable:
        // - Current document: "Second edit"
        // - Version 1: "First edit - important info" (was "Original content")
        // - "Original content" is LOST

        // This test documents that the ORIGINAL content is lost
        // when debounce kicks in
        expect($version->content)->toBe('First edit - important info');

        // There's no way to recover "Original content" anymore
        expect($document->versions()->where('content', 'Original content')->exists())->toBeFalse();
    })->group('documents-known-issues');
});

describe('version restore', function () {
    it('restores document to previous version', function () {
        $document = Document::factory()->create([
            'title' => 'Original Title',
            'content' => 'Original content',
        ]);

        // Create some history
        $document->update(['content' => 'Edit 1']);
        Carbon::setTestNow(now()->addSeconds(35));
        $document->update(['content' => 'Edit 2']);
        Carbon::setTestNow(now()->addSeconds(35));

        // Get version 1
        $version1 = $document->versions()->where('version_number', 1)->first();

        // Restore
        $this->service->restoreVersion($document, $version1);
        $document->refresh();

        expect($document->content)->toBe($version1->content);

        Carbon::setTestNow();
    });

    it('creates new version recording the restore', function () {
        $document = Document::factory()->create([
            'content' => 'Original',
        ]);

        $document->update(['content' => 'Edit 1']);
        Carbon::setTestNow(now()->addSeconds(35));

        $version1 = $document->versions()->first();
        $initialVersionCount = $document->versions()->count();

        Carbon::setTestNow(now()->addSeconds(35));
        $this->service->restoreVersion($document, $version1);

        // Should have one more version
        expect($document->versions()->count())->toBe($initialVersionCount + 1);

        // Latest version should mention restore
        $latestVersion = $document->versions()->orderByDesc('version_number')->first();
        expect($latestVersion->change_summary)->toContain('Restored from version');

        Carbon::setTestNow();
    });
});

describe('version pruning', function () {
    it('keeps only specified number of versions', function () {
        $document = Document::factory()->create();

        // Create 10 versions
        for ($i = 1; $i <= 10; $i++) {
            Carbon::setTestNow(now()->addSeconds(35 * $i));
            $document->update(['content' => "Content v{$i}"]);
        }

        expect($document->versions()->count())->toBe(10);

        // Prune to keep only 5
        $deleted = $this->service->pruneVersions($document, 5);

        expect($deleted)->toBe(5);
        expect($document->versions()->count())->toBe(5);

        // Should keep the 5 most recent (highest version numbers)
        $keptVersions = $document->versions()->pluck('version_number')->sort()->values();
        expect($keptVersions->toArray())->toBe([6, 7, 8, 9, 10]);

        Carbon::setTestNow();
    });

    it('does nothing when version count is below threshold', function () {
        $document = Document::factory()->create();

        $document->update(['content' => 'Edit 1']);
        Carbon::setTestNow(now()->addSeconds(35));
        $document->update(['content' => 'Edit 2']);

        expect($document->versions()->count())->toBe(2);

        $deleted = $this->service->pruneVersions($document, 10);

        expect($deleted)->toBe(0);
        expect($document->versions()->count())->toBe(2);

        Carbon::setTestNow();
    });

    it('respects zero keep count by doing nothing', function () {
        $document = Document::factory()->create();
        $document->update(['content' => 'Edit']);

        $deleted = $this->service->pruneVersions($document, 0);

        expect($deleted)->toBe(0);
    });
});

describe('change summary generation', function () {
    it('summarizes title changes', function () {
        $summary = $this->service->generateChangeSummary(
            ['title'],
            'old content',
            'old content'
        );

        expect($summary)->toContain('title');
    });

    it('summarizes content additions', function () {
        $summary = $this->service->generateChangeSummary(
            ['content'],
            'short',
            'short with more text added'
        );

        expect($summary)->toContain('content');
        expect($summary)->toContain('+');
    });

    it('summarizes content removals', function () {
        $summary = $this->service->generateChangeSummary(
            ['content'],
            'this is longer content here',
            'shorter'
        );

        expect($summary)->toContain('content');
        expect($summary)->toMatch('/-\d+ chars/');
    });

    it('summarizes reformatting with no size change', function () {
        $summary = $this->service->generateChangeSummary(
            ['content'],
            'same length',
            'equal size!'
        );

        expect($summary)->toContain('reformatted');
    });

    it('combines title and content changes', function () {
        $summary = $this->service->generateChangeSummary(
            ['title', 'content'],
            'old',
            'new!'
        );

        expect($summary)->toContain('title');
        expect($summary)->toContain('content');
    });
});
