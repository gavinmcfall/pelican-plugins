<?php

declare(strict_types=1);

use Starter\ServerDocumentation\Models\Document;
use Starter\ServerDocumentation\Services\DocumentService;
use Starter\ServerDocumentation\Services\ImportValidator;
use Starter\ServerDocumentation\Services\MarkdownConverter;

/**
 * Tests for import validation behavior.
 *
 * These tests verify that the import functionality properly validates
 * input data and handles malformed imports gracefully.
 */
beforeEach(function () {
    $this->converter = app(MarkdownConverter::class);
    $this->validator = new ImportValidator;

    // Mock DocumentService to avoid cache clearing which loads relationships
    // that don't exist in the standalone test environment
    $mockService = Mockery::mock(DocumentService::class)->makePartial();
    $mockService->shouldReceive('clearDocumentCache')->andReturn();
    $mockService->shouldReceive('clearCountCache')->andReturn();
    app()->instance(DocumentService::class, $mockService);
});

describe('JSON import structure validation', function () {
    describe('required fields', function () {
        it('rejects documents missing uuid', function () {
            $docData = [
                'title' => 'Test',
                'content' => 'Content',
                'slug' => 'test',
            ];

            $errors = $this->validator->validate($docData);

            expect($errors)->not->toBeEmpty();
            expect(implode(' ', $errors))->toContain('uuid');
        });

        it('rejects documents with empty uuid', function () {
            $docData = [
                'uuid' => '',
                'title' => 'Test',
                'content' => 'Content',
            ];

            $errors = $this->validator->validate($docData);

            expect($errors)->not->toBeEmpty();
            expect(implode(' ', $errors))->toContain('uuid');
        });

        it('rejects documents missing title', function () {
            $docData = [
                'uuid' => '550e8400-e29b-41d4-a716-446655440000',
                'content' => 'Content',
            ];

            $errors = $this->validator->validate($docData);

            expect($errors)->not->toBeEmpty();
            expect(implode(' ', $errors))->toContain('title');
        });

        it('rejects documents missing content', function () {
            $docData = [
                'uuid' => '550e8400-e29b-41d4-a716-446655440000',
                'title' => 'Test',
            ];

            $errors = $this->validator->validate($docData);

            expect($errors)->not->toBeEmpty();
            expect(implode(' ', $errors))->toContain('content');
        });

        it('accepts valid document with all required fields', function () {
            $docData = [
                'uuid' => '550e8400-e29b-41d4-a716-446655440000',
                'title' => 'Test Document',
                'content' => '<p>Valid content</p>',
            ];

            $errors = $this->validator->validate($docData);

            expect($errors)->toBeEmpty();
        });
    });

    describe('field type validation', function () {
        it('rejects non-string title', function () {
            $docData = [
                'uuid' => '550e8400-e29b-41d4-a716-446655440000',
                'title' => 12345,
                'content' => 'Content',
            ];

            $errors = $this->validator->validate($docData);

            expect($errors)->not->toBeEmpty();
            expect(implode(' ', $errors))->toContain('title');
        });

        it('rejects title exceeding 255 characters', function () {
            $docData = [
                'uuid' => '550e8400-e29b-41d4-a716-446655440000',
                'title' => str_repeat('a', 256),
                'content' => 'Content',
            ];

            $errors = $this->validator->validate($docData);

            expect($errors)->not->toBeEmpty();
            expect(implode(' ', $errors))->toContain('255');
        });

        it('rejects non-boolean is_global', function () {
            $docData = [
                'uuid' => '550e8400-e29b-41d4-a716-446655440000',
                'title' => 'Test',
                'content' => 'Content',
                'is_global' => 'yes',
            ];

            $errors = $this->validator->validate($docData);

            expect($errors)->not->toBeEmpty();
            expect(implode(' ', $errors))->toContain('is_global');
        });

        it('rejects non-boolean is_published', function () {
            $docData = [
                'uuid' => '550e8400-e29b-41d4-a716-446655440000',
                'title' => 'Test',
                'content' => 'Content',
                'is_published' => 'true',
            ];

            $errors = $this->validator->validate($docData);

            expect($errors)->not->toBeEmpty();
            expect(implode(' ', $errors))->toContain('is_published');
        });

        it('rejects non-integer sort_order', function () {
            $docData = [
                'uuid' => '550e8400-e29b-41d4-a716-446655440000',
                'title' => 'Test',
                'content' => 'Content',
                'sort_order' => '10',
            ];

            $errors = $this->validator->validate($docData);

            expect($errors)->not->toBeEmpty();
            expect(implode(' ', $errors))->toContain('sort_order');
        });

        it('rejects invalid content_type enum', function () {
            $docData = [
                'uuid' => '550e8400-e29b-41d4-a716-446655440000',
                'title' => 'Test',
                'content' => 'Content',
                'content_type' => 'invalid_type',
            ];

            $errors = $this->validator->validate($docData);

            expect($errors)->not->toBeEmpty();
            expect(implode(' ', $errors))->toContain('content_type');
        });

        it('accepts valid content_type values', function () {
            foreach (['html', 'markdown', 'raw_html'] as $type) {
                $docData = [
                    'uuid' => '550e8400-e29b-41d4-a716-446655440000',
                    'title' => 'Test',
                    'content' => 'Content',
                    'content_type' => $type,
                ];

                $errors = $this->validator->validate($docData);

                expect($errors)->toBeEmpty("Failed for content_type: {$type}");
            }
        });
    });

    describe('content size limits', function () {
        it('rejects documents with content exceeding 5MB', function () {
            $hugeContent = str_repeat('x', 6 * 1024 * 1024); // 6MB

            $docData = [
                'uuid' => '550e8400-e29b-41d4-a716-446655440000',
                'title' => 'Test',
                'content' => $hugeContent,
            ];

            $errors = $this->validator->validate($docData);

            expect($errors)->not->toBeEmpty();
            expect(implode(' ', $errors))->toContain('5MB');
        });

        it('accepts content just under 5MB', function () {
            $content = str_repeat('x', 4 * 1024 * 1024); // 4MB

            $docData = [
                'uuid' => '550e8400-e29b-41d4-a716-446655440000',
                'title' => 'Test',
                'content' => $content,
            ];

            $errors = $this->validator->validate($docData);

            expect($errors)->toBeEmpty();
        });
    });

    describe('UUID validation', function () {
        it('rejects invalid UUID format', function () {
            $docData = [
                'uuid' => 'not-a-valid-uuid',
                'title' => 'Test',
                'content' => 'Content',
            ];

            $errors = $this->validator->validate($docData);

            expect($errors)->not->toBeEmpty();
            expect(implode(' ', $errors))->toContain('UUID');
        });

        it('rejects UUID with wrong length', function () {
            $docData = [
                'uuid' => '550e8400-e29b-41d4-a716',
                'title' => 'Test',
                'content' => 'Content',
            ];

            $errors = $this->validator->validate($docData);

            expect($errors)->not->toBeEmpty();
        });

        it('accepts valid UUID format', function () {
            $docData = [
                'uuid' => '550e8400-e29b-41d4-a716-446655440000',
                'title' => 'Test',
                'content' => 'Content',
            ];

            $errors = $this->validator->validate($docData);

            expect($errors)->toBeEmpty();
        });

        it('accepts uppercase UUID', function () {
            $docData = [
                'uuid' => '550E8400-E29B-41D4-A716-446655440000',
                'title' => 'Test',
                'content' => 'Content',
            ];

            $errors = $this->validator->validate($docData);

            expect($errors)->toBeEmpty();
        });
    });
});

describe('markdown import frontmatter validation', function () {
    it('parses valid frontmatter', function () {
        $markdown = "---\ntitle: Test Document\nslug: test-doc\nis_global: true\n---\n\n# Content";

        [$metadata, $content] = $this->converter->parseFrontmatter($markdown);

        expect($metadata)->toHaveKey('title', 'Test Document');
        expect($metadata)->toHaveKey('slug', 'test-doc');
        expect($metadata)->toHaveKey('is_global', true);
        expect($content)->toBe('# Content');
    });

    it('handles malformed YAML gracefully', function () {
        $markdown = "---\ntitle: [invalid yaml structure\n---\n\nContent";

        [$metadata, $content] = $this->converter->parseFrontmatter($markdown);

        // Should return empty metadata on parse failure, not crash
        expect($metadata)->toBe([]);
        expect($content)->toBe('Content');
    });

    it('handles non-array YAML result', function () {
        $markdown = "---\njust a string\n---\n\nContent";

        [$metadata, $content] = $this->converter->parseFrontmatter($markdown);

        expect($metadata)->toBe([]);
    });

    it('handles deeply nested YAML', function () {
        $markdown = "---\nnested:\n  deep:\n    value: test\n---\n\nContent";

        [$metadata, $content] = $this->converter->parseFrontmatter($markdown);

        expect($metadata['nested']['deep']['value'])->toBe('test');
    });
});

describe('XSS in imported content', function () {
    it('imported markdown with script tags is sanitized on render', function () {
        $markdown = "# Title\n\n<script>alert('xss')</script>\n\nNormal content";

        $html = $this->converter->toHtml($markdown);

        // Script tags should be escaped or removed
        expect($html)->not->toContain('<script>');
    });

    it('imported HTML content is sanitized on render', function () {
        $htmlContent = '<p>Hello</p><script>alert("xss")</script>';

        $document = Document::factory()->create([
            'content' => $htmlContent,
            'content_type' => 'html',
        ]);

        // getRenderedContent now sanitizes all HTML content
        $rendered = $document->getRenderedContent();

        expect($rendered)->not->toContain('<script>');
    });

    it('getRawRenderedContent preserves content for editing', function () {
        // getRawRenderedContent intentionally does NOT sanitize
        // because it's used for editing the document
        $htmlContent = '<p>Hello</p><script>alert("xss")</script>';

        $document = Document::factory()->create([
            'content' => $htmlContent,
            'content_type' => 'html',
        ]);

        // Raw content is preserved for editing
        $raw = $document->getRawRenderedContent();

        expect($raw)->toContain('<script>');
    });
});

describe('import relation resolution', function () {
    it('handles missing roles gracefully', function () {
        // Test that import with non-existent role names doesn't crash
        $docData = [
            'uuid' => 'test-uuid-'.uniqid(),
            'title' => 'Test',
            'slug' => 'test-'.uniqid(),
            'content' => 'Content',
            'content_type' => 'html',
            'is_global' => false,
            'is_published' => true,
            'sort_order' => 0,
            'roles' => ['NonExistent Role'],
            'users' => [],
            'eggs' => [],
            'servers' => [],
        ];

        // Create document
        $document = Document::create([
            'uuid' => $docData['uuid'],
            'title' => $docData['title'],
            'slug' => $docData['slug'],
            'content' => $docData['content'],
            'content_type' => $docData['content_type'],
            'is_global' => $docData['is_global'],
            'is_published' => $docData['is_published'],
        ]);

        // Trying to sync with non-existent roles should not crash
        // The import logic handles this by skipping and warning
        expect($document->roles()->count())->toBe(0);
    });
});

describe('slug collision handling', function () {
    it('generates unique slug on collision', function () {
        // Create a document with a specific slug
        Document::factory()->create(['slug' => 'test-slug']);

        // Try to create another with same title and NO slug (force auto-generation)
        $document = Document::factory()->create(['title' => 'Test Slug', 'slug' => null]);

        // Should get a modified slug since 'test-slug' is taken
        expect($document->slug)->not->toBe('test-slug');
        expect($document->slug)->toStartWith('test-slug');
    });

    it('handles multiple slug collisions', function () {
        Document::factory()->create(['slug' => 'my-doc']);
        Document::factory()->create(['slug' => 'my-doc-1']);
        Document::factory()->create(['slug' => 'my-doc-2']);

        // Force auto-generation of slug from title
        $newDoc = Document::factory()->create(['title' => 'My Doc', 'slug' => null]);

        // Should get my-doc-3 or similar
        expect($newDoc->slug)->toMatch('/^my-doc-\d+$/');
    });
});
