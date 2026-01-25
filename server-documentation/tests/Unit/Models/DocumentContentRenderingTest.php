<?php

declare(strict_types=1);

use Starter\ServerDocumentation\Models\Document;
use Starter\ServerDocumentation\Services\MarkdownConverter;
use Starter\ServerDocumentation\Services\VariableProcessor;

/**
 * Tests for Document content rendering security.
 *
 * These tests verify that getRenderedContent() properly handles
 * different content types and sanitization requirements.
 */

beforeEach(function () {
    // Mock the services
    $this->markdownConverter = Mockery::mock(MarkdownConverter::class);
    $this->variableProcessor = Mockery::mock(VariableProcessor::class);

    app()->instance(MarkdownConverter::class, $this->markdownConverter);
    app()->instance(VariableProcessor::class, $this->variableProcessor);
});

afterEach(function () {
    Mockery::close();
});

describe('getRenderedContent content type handling', function () {
    describe('markdown content type', function () {
        it('converts markdown to HTML via MarkdownConverter', function () {
            $document = new Document([
                'content' => '# Hello World',
                'content_type' => 'markdown',
            ]);

            $this->variableProcessor->shouldReceive('hasVariables')
                ->with('# Hello World')
                ->andReturn(false);

            $this->markdownConverter->shouldReceive('toHtml')
                ->with('# Hello World')
                ->andReturn('<h1>Hello World</h1>');

            $result = $document->getRenderedContent();

            expect($result)->toBe('<h1>Hello World</h1>');
        });

        it('processes variables before markdown conversion', function () {
            $document = new Document([
                'content' => 'Hello {{user.name}}',
                'content_type' => 'markdown',
            ]);

            $this->variableProcessor->shouldReceive('hasVariables')
                ->with('Hello {{user.name}}')
                ->andReturn(true);

            $this->variableProcessor->shouldReceive('process')
                ->with('Hello {{user.name}}', null, null)
                ->andReturn('Hello John');

            $this->markdownConverter->shouldReceive('toHtml')
                ->with('Hello John')
                ->andReturn('<p>Hello John</p>');

            $result = $document->getRenderedContent();

            expect($result)->toBe('<p>Hello John</p>');
        });

        it('sanitizes output via MarkdownConverter toHtml', function () {
            $document = new Document([
                'content' => '<script>alert("xss")</script>',
                'content_type' => 'markdown',
            ]);

            $this->variableProcessor->shouldReceive('hasVariables')->andReturn(false);

            // MarkdownConverter should sanitize the content
            $this->markdownConverter->shouldReceive('toHtml')
                ->andReturn('<p>&lt;script&gt;alert("xss")&lt;/script&gt;</p>');

            $result = $document->getRenderedContent();

            expect($result)->not->toContain('<script>');
        });
    });

    describe('html content type (rich editor)', function () {
        it('returns sanitized HTML content', function () {
            $document = new Document([
                'content' => '<p>Hello <strong>World</strong></p>',
                'content_type' => 'html',
            ]);

            $this->variableProcessor->shouldReceive('hasVariables')->andReturn(false);
            $this->markdownConverter->shouldReceive('sanitizeHtml')
                ->with('<p>Hello <strong>World</strong></p>')
                ->andReturn('<p>Hello <strong>World</strong></p>');

            $result = $document->getRenderedContent();

            expect($result)->toBe('<p>Hello <strong>World</strong></p>');
        });

        it('processes variables in HTML content then sanitizes', function () {
            $document = new Document([
                'content' => '<p>Hello {{user.name}}</p>',
                'content_type' => 'html',
            ]);

            $this->variableProcessor->shouldReceive('hasVariables')
                ->andReturn(true);
            $this->variableProcessor->shouldReceive('process')
                ->andReturn('<p>Hello John</p>');
            $this->markdownConverter->shouldReceive('sanitizeHtml')
                ->with('<p>Hello John</p>')
                ->andReturn('<p>Hello John</p>');

            $result = $document->getRenderedContent();

            expect($result)->toBe('<p>Hello John</p>');
        });

        it('sanitizes malicious HTML in html content type', function () {
            $document = new Document([
                'content' => '<p>Hello</p><script>alert("xss")</script>',
                'content_type' => 'html',
            ]);

            $this->variableProcessor->shouldReceive('hasVariables')->andReturn(false);
            $this->markdownConverter->shouldReceive('sanitizeHtml')
                ->with('<p>Hello</p><script>alert("xss")</script>')
                ->andReturn('<p>Hello</p>');

            $result = $document->getRenderedContent();

            expect($result)->not->toContain('<script>');
        });
    });

    describe('raw_html content type', function () {
        it('returns sanitized raw HTML content', function () {
            $document = new Document([
                'content' => '<div class="custom">Content</div>',
                'content_type' => 'raw_html',
            ]);

            $this->variableProcessor->shouldReceive('hasVariables')->andReturn(false);
            $this->markdownConverter->shouldReceive('sanitizeHtml')
                ->with('<div class="custom">Content</div>')
                ->andReturn('<div class="custom">Content</div>');

            $result = $document->getRenderedContent();

            expect($result)->toBe('<div class="custom">Content</div>');
        });

        it('processes variables in raw HTML then sanitizes', function () {
            $document = new Document([
                'content' => '<div>{{user.name}}</div>',
                'content_type' => 'raw_html',
            ]);

            $this->variableProcessor->shouldReceive('hasVariables')->andReturn(true);
            $this->variableProcessor->shouldReceive('process')
                ->andReturn('<div>John</div>');
            $this->markdownConverter->shouldReceive('sanitizeHtml')
                ->with('<div>John</div>')
                ->andReturn('<div>John</div>');

            $result = $document->getRenderedContent();

            expect($result)->toBe('<div>John</div>');
        });

        it('sanitizes malicious raw_html content', function () {
            $document = new Document([
                'content' => '<script>alert("xss")</script>',
                'content_type' => 'raw_html',
            ]);

            $this->variableProcessor->shouldReceive('hasVariables')->andReturn(false);
            $this->markdownConverter->shouldReceive('sanitizeHtml')
                ->with('<script>alert("xss")</script>')
                ->andReturn('');

            $result = $document->getRenderedContent();

            expect($result)->not->toContain('<script>');
        });
    });

    describe('default/null content type', function () {
        it('treats null content_type as html and sanitizes', function () {
            $document = new Document([
                'content' => '<p>Hello</p>',
                'content_type' => null,
            ]);

            $this->variableProcessor->shouldReceive('hasVariables')->andReturn(false);
            $this->markdownConverter->shouldReceive('sanitizeHtml')
                ->with('<p>Hello</p>')
                ->andReturn('<p>Hello</p>');

            $result = $document->getRenderedContent();

            expect($result)->toBe('<p>Hello</p>');
        });

        it('treats missing content_type as html and sanitizes', function () {
            $document = new Document([
                'content' => '<p>Hello</p>',
            ]);

            $this->variableProcessor->shouldReceive('hasVariables')->andReturn(false);
            $this->markdownConverter->shouldReceive('sanitizeHtml')
                ->with('<p>Hello</p>')
                ->andReturn('<p>Hello</p>');

            $result = $document->getRenderedContent();

            expect($result)->toBe('<p>Hello</p>');
        });
    });
});

describe('getUnsanitizedContentForEditing (and deprecated getRawRenderedContent)', function () {
    it('converts markdown without variable processing or sanitization', function () {
        $document = new Document([
            'content' => '# Hello {{user.name}}',
            'content_type' => 'markdown',
        ]);

        // The method now explicitly passes sanitize=false
        $this->markdownConverter->shouldReceive('toHtml')
            ->with('# Hello {{user.name}}', false)
            ->andReturn('<h1>Hello {{user.name}}</h1>');

        $result = $document->getUnsanitizedContentForEditing();

        // Variables should NOT be processed
        expect($result)->toContain('{{user.name}}');
    });

    it('deprecated getRawRenderedContent calls getUnsanitizedContentForEditing', function () {
        $document = new Document([
            'content' => '# Test',
            'content_type' => 'markdown',
        ]);

        $this->markdownConverter->shouldReceive('toHtml')
            ->with('# Test', false)
            ->andReturn('<h1>Test</h1>');

        // Deprecated method should still work
        $result = $document->getRawRenderedContent();

        expect($result)->toBe('<h1>Test</h1>');
    });

    it('returns html content as-is', function () {
        $document = new Document([
            'content' => '<p>Hello {{user.name}}</p>',
            'content_type' => 'html',
        ]);

        $result = $document->getUnsanitizedContentForEditing();

        expect($result)->toBe('<p>Hello {{user.name}}</p>');
    });

    it('returns raw_html content as-is', function () {
        $document = new Document([
            'content' => '<div>Custom HTML</div>',
            'content_type' => 'raw_html',
        ]);

        $result = $document->getUnsanitizedContentForEditing();

        expect($result)->toBe('<div>Custom HTML</div>');
    });
});

describe('content type helper methods', function () {
    it('isMarkdown returns true for markdown content', function () {
        $document = new Document(['content_type' => 'markdown']);
        expect($document->isMarkdown())->toBeTrue();
    });

    it('isMarkdown returns false for html content', function () {
        $document = new Document(['content_type' => 'html']);
        expect($document->isMarkdown())->toBeFalse();
    });

    it('isMarkdown returns false for null content_type', function () {
        $document = new Document(['content_type' => null]);
        expect($document->isMarkdown())->toBeFalse();
    });

    it('isRawHtml returns true for raw_html content', function () {
        $document = new Document(['content_type' => 'raw_html']);
        expect($document->isRawHtml())->toBeTrue();
    });

    it('isRawHtml returns false for html content', function () {
        $document = new Document(['content_type' => 'html']);
        expect($document->isRawHtml())->toBeFalse();
    });
});
