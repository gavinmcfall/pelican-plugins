<?php

declare(strict_types=1);

use Starter\ServerDocumentation\Services\MarkdownConverter;

beforeEach(function () {
    $this->converter = new MarkdownConverter();
});

describe('toHtml', function () {
    it('converts basic markdown to HTML', function () {
        $markdown = "# Hello World\n\nThis is a paragraph.";
        $html = $this->converter->toHtml($markdown);

        expect($html)->toContain('<h1>Hello World</h1>');
        expect($html)->toContain('<p>This is a paragraph.</p>');
    });

    it('converts bold and italic', function () {
        $markdown = '**bold** and *italic*';
        $html = $this->converter->toHtml($markdown);

        expect($html)->toContain('<strong>bold</strong>');
        expect($html)->toContain('<em>italic</em>');
    });

    it('converts links', function () {
        $markdown = '[Link text](https://example.com)';
        $html = $this->converter->toHtml($markdown);

        expect($html)->toContain('href="https://example.com"');
        expect($html)->toContain('Link text</a>');
    });

    it('converts code blocks', function () {
        $markdown = "```php\necho 'hello';\n```";
        $html = $this->converter->toHtml($markdown);

        expect($html)->toContain('<code');
        expect($html)->toContain('echo');
    });
});

describe('toMarkdown', function () {
    it('converts HTML headings to markdown', function () {
        $html = '<h1>Title</h1><h2>Subtitle</h2>';
        $markdown = $this->converter->toMarkdown($html);

        expect($markdown)->toContain('# Title');
        expect($markdown)->toContain('## Subtitle');
    });

    it('converts bold and italic HTML to markdown', function () {
        $html = '<strong>bold</strong> and <em>italic</em>';
        $markdown = $this->converter->toMarkdown($html);

        expect($markdown)->toContain('**bold**');
        expect($markdown)->toContain('*italic*');
    });

    it('converts links to markdown format', function () {
        $html = '<a href="https://example.com">Link</a>';
        $markdown = $this->converter->toMarkdown($html);

        expect($markdown)->toContain('[Link](https://example.com)');
    });

    it('converts unordered lists', function () {
        $html = '<ul><li>Item 1</li><li>Item 2</li></ul>';
        $markdown = $this->converter->toMarkdown($html);

        expect($markdown)->toContain('- Item 1');
        expect($markdown)->toContain('- Item 2');
    });

    it('converts ordered lists', function () {
        $html = '<ol><li>First</li><li>Second</li></ol>';
        $markdown = $this->converter->toMarkdown($html);

        expect($markdown)->toContain('1. First');
        expect($markdown)->toContain('2. Second');
    });
});

describe('addFrontmatter', function () {
    it('adds simple key-value frontmatter', function () {
        $markdown = '# Content';
        $metadata = ['title' => 'My Title', 'slug' => 'my-title'];
        $result = $this->converter->addFrontmatter($markdown, $metadata);

        expect($result)->toStartWith("---\n");
        expect($result)->toContain("title: 'My Title'");
        expect($result)->toContain('slug: my-title');
        expect($result)->toContain("---\n\n# Content");
    });

    it('converts boolean values correctly', function () {
        $markdown = 'Content';
        $metadata = ['is_published' => true, 'is_global' => false];
        $result = $this->converter->addFrontmatter($markdown, $metadata);

        expect($result)->toContain('is_published: true');
        expect($result)->toContain('is_global: false');
    });

    it('formats arrays as YAML block sequences', function () {
        $markdown = 'Content';
        $metadata = ['roles' => ['Root Admin', 'Support']];
        $result = $this->converter->addFrontmatter($markdown, $metadata);

        expect($result)->toContain("roles:\n");
        expect($result)->toMatch('/  - [\'"]?Root Admin[\'"]?/');
        expect($result)->toMatch('/  - [\'"]?Support[\'"]?/');
    });

    it('skips empty arrays', function () {
        $markdown = 'Content';
        $metadata = ['title' => 'Test', 'roles' => []];
        $result = $this->converter->addFrontmatter($markdown, $metadata);

        expect($result)->not->toContain('roles:');
    });

    it('quotes values with special characters', function () {
        $markdown = 'Content';
        $metadata = ['title' => 'Title: With Colon'];
        $result = $this->converter->addFrontmatter($markdown, $metadata);

        // Symfony YAML quotes values with colons using single quotes
        expect($result)->toContain("title: 'Title: With Colon'");
    });
});

describe('parseFrontmatter', function () {
    it('extracts frontmatter and content', function () {
        $markdown = "---\ntitle: My Title\nslug: my-slug\n---\n\n# Content here";
        [$metadata, $content] = $this->converter->parseFrontmatter($markdown);

        expect($metadata)->toHaveKey('title', 'My Title');
        expect($metadata)->toHaveKey('slug', 'my-slug');
        expect($content)->toBe('# Content here');
    });

    it('handles missing frontmatter', function () {
        $markdown = '# Just Content';
        [$metadata, $content] = $this->converter->parseFrontmatter($markdown);

        expect($metadata)->toBe([]);
        expect($content)->toBe('# Just Content');
    });

    it('parses boolean values', function () {
        $markdown = "---\nis_published: true\nis_global: false\n---\n\nContent";
        [$metadata, $content] = $this->converter->parseFrontmatter($markdown);

        expect($metadata['is_published'])->toBeTrue();
        expect($metadata['is_global'])->toBeFalse();
    });

    it('parses YAML block sequences as arrays', function () {
        $markdown = "---\nroles:\n  - Root Admin\n  - Support\n---\n\nContent";
        [$metadata, $content] = $this->converter->parseFrontmatter($markdown);

        expect($metadata['roles'])->toBe(['Root Admin', 'Support']);
    });

    it('parses comma-separated values as string (use YAML arrays for lists)', function () {
        // Note: Symfony YAML treats comma-separated values as a single string
        // Use proper YAML array syntax for lists: "roles:\n  - Root Admin\n  - Support"
        $markdown = "---\nroles: Root Admin, Support\n---\n\nContent";
        [$metadata, $content] = $this->converter->parseFrontmatter($markdown);

        expect($metadata['roles'])->toBe('Root Admin, Support');
    });

    it('unquotes quoted values', function () {
        $markdown = "---\ntitle: \"Quoted: Value\"\n---\n\nContent";
        [$metadata, $content] = $this->converter->parseFrontmatter($markdown);

        expect($metadata['title'])->toBe('Quoted: Value');
    });
});

describe('generateFilename', function () {
    it('uses slug when provided', function () {
        $filename = $this->converter->generateFilename('My Title', 'custom-slug');

        expect($filename)->toBe('custom-slug.md');
    });

    it('sanitizes title when no slug', function () {
        $filename = $this->converter->generateFilename('My Title!', '');

        expect($filename)->toBe('my-title.md');
    });
});

describe('sanitizeFilename', function () {
    it('converts to lowercase', function () {
        expect($this->converter->sanitizeFilename('UPPER'))->toBe('upper');
    });

    it('replaces spaces with hyphens', function () {
        expect($this->converter->sanitizeFilename('hello world'))->toBe('hello-world');
    });

    it('removes special characters', function () {
        expect($this->converter->sanitizeFilename('test@#$%file'))->toBe('testfile');
    });

    it('collapses multiple hyphens', function () {
        expect($this->converter->sanitizeFilename('test---file'))->toBe('test-file');
    });

    it('returns document for empty input', function () {
        expect($this->converter->sanitizeFilename(''))->toBe('document');
    });
});
