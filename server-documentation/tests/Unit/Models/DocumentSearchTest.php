<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Builder;
use Starter\ServerDocumentation\Models\Document;

/**
 * Tests for Document search functionality.
 *
 * These tests verify that the scopeSearch method properly handles
 * user input including SQL wildcard characters.
 */

describe('scopeSearch', function () {
    it('returns unmodified query for empty search term', function () {
        $query = Mockery::mock(Builder::class);
        $document = new Document();

        // Empty string should return query unchanged
        $result = $document->scopeSearch($query, '');

        expect($result)->toBe($query);
    });

    it('returns unmodified query for whitespace-only search term', function () {
        $query = Mockery::mock(Builder::class);
        $document = new Document();

        $result = $document->scopeSearch($query, '   ');

        expect($result)->toBe($query);
    });

    it('trims whitespace from search term', function () {
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')
            ->once()
            ->with(Mockery::type('Closure'))
            ->andReturnSelf();

        $document = new Document();
        $document->scopeSearch($query, '  test  ');

        // The where should be called (term was trimmed but not empty)
        $query->shouldHaveReceived('where');
    });

    it('searches in title, slug, and content fields', function () {
        // This is an integration test that checks the query structure
        $document = new Document();

        // Get the actual query
        $query = Document::query();
        $searchQuery = $document->scopeSearch($query, 'test');

        // Convert to SQL to verify structure
        $sql = $searchQuery->toSql();

        expect($sql)->toContain('title');
        expect($sql)->toContain('slug');
        expect($sql)->toContain('content');
        // whereRaw produces uppercase LIKE
        expect(strtolower($sql))->toContain('like');
        // Verify explicit ESCAPE clause for cross-DB compatibility
        expect(strtoupper($sql))->toContain('ESCAPE');
    });

    describe('SQL wildcard handling', function () {
        it('escapes percent signs in search term', function () {
            $document = new Document();
            $query = Document::query();

            // User searching for literal "100%"
            $searchQuery = $document->scopeSearch($query, '100%');

            $bindings = $searchQuery->getBindings();

            // The % is escaped so it's treated literally
            expect($bindings[0] ?? '')->toBe('%100\\%%');
        });

        it('escapes underscores in search term', function () {
            $document = new Document();
            $query = Document::query();

            // User searching for "test_file"
            $searchQuery = $document->scopeSearch($query, 'test_file');

            $bindings = $searchQuery->getBindings();

            // The _ is escaped so it's treated literally
            expect($bindings[0] ?? '')->toBe('%test\\_file%');
        });

        it('escapes backslashes in search term', function () {
            $document = new Document();
            $query = Document::query();

            // User searching for a path with backslash
            $searchQuery = $document->scopeSearch($query, 'C:\\path');

            $bindings = $searchQuery->getBindings();

            // Backslashes are escaped
            expect($bindings[0] ?? '')->toBe('%C:\\\\path%');
        });

        it('prevents wildcard injection with %', function () {
            $document = new Document();
            $query = Document::query();

            // User searching for just "%" should NOT match everything
            $searchQuery = $document->scopeSearch($query, '%');

            $bindings = $searchQuery->getBindings();

            // Produces %\%% which matches only literal %
            expect($bindings[0] ?? '')->toBe('%\\%%');
        });

        it('prevents single character wildcard with underscore', function () {
            $document = new Document();
            $query = Document::query();

            // Searching for "t_st" should match only literal "t_st", not "test"
            $searchQuery = $document->scopeSearch($query, 't_st');

            $bindings = $searchQuery->getBindings();

            expect($bindings[0] ?? '')->toBe('%t\\_st%');
        });
    });

    describe('case sensitivity', function () {
        it('performs case-insensitive search with LIKE', function () {
            $document = new Document();
            $query = Document::query();

            $searchQuery = $document->scopeSearch($query, 'TEST');

            $sql = $searchQuery->toSql();

            // MySQL LIKE is case-insensitive by default (depending on collation)
            // This test just verifies the query uses LIKE (whereRaw produces uppercase)
            expect(strtolower($sql))->toContain('like');
        });
    });

    describe('special characters', function () {
        it('handles quotes in search term', function () {
            $document = new Document();
            $query = Document::query();

            // Should handle quotes via parameter binding
            $searchQuery = $document->scopeSearch($query, "O'Brien");

            $bindings = $searchQuery->getBindings();

            expect($bindings[0] ?? '')->toContain("O'Brien");
        });

        it('escapes backslashes in search term for LIKE', function () {
            $document = new Document();
            $query = Document::query();

            // Backslashes are escaped by the wildcard escaping function
            $searchQuery = $document->scopeSearch($query, 'path\\file');

            $bindings = $searchQuery->getBindings();

            // Backslashes are doubled for LIKE escaping
            expect($bindings[0] ?? '')->toBe('%path\\\\file%');
        });
    });
});
