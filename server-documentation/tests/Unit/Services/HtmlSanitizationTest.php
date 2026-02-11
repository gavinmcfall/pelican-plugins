<?php

declare(strict_types=1);

use Starter\ServerDocumentation\Services\MarkdownConverter;

/**
 * Tests for HTML sanitization security.
 *
 * These tests verify that XSS vectors are properly neutralized
 * in both the markdown-to-HTML conversion and the sanitization fallback.
 */
beforeEach(function () {
    $this->converter = new MarkdownConverter();
});

describe('sanitizeHtml XSS prevention', function () {
    describe('script tag removal', function () {
        it('removes basic script tags', function () {
            $html = '<p>Hello</p><script>alert("xss")</script><p>World</p>';
            $result = $this->converter->sanitizeHtml($html);

            expect($result)->not->toContain('<script');
            expect($result)->not->toContain('alert');
            expect($result)->toContain('<p>Hello</p>');
            expect($result)->toContain('<p>World</p>');
        });

        it('removes script tags with attributes', function () {
            $html = '<script type="text/javascript" src="evil.js"></script>';
            $result = $this->converter->sanitizeHtml($html);

            expect($result)->not->toContain('<script');
            expect($result)->not->toContain('evil.js');
        });

        it('removes script tags with newlines', function () {
            $html = "<script>\nalert('xss')\n</script>";
            $result = $this->converter->sanitizeHtml($html);

            expect($result)->not->toContain('<script');
            expect($result)->not->toContain('alert');
        });

        it('removes script tags case insensitively', function () {
            $html = '<SCRIPT>alert("xss")</SCRIPT>';
            $result = $this->converter->sanitizeHtml($html);

            expect($result)->not->toContain('<script', ignoreCase: true);
        });

        it('removes nested script tags', function () {
            $html = '<script><script>alert("xss")</script></script>';
            $result = $this->converter->sanitizeHtml($html);

            expect($result)->not->toContain('<script');
        });
    });

    describe('event handler removal', function () {
        it('removes onclick handlers', function () {
            $html = '<button onclick="alert(\'xss\')">Click</button>';
            $result = $this->converter->sanitizeHtml($html);

            expect($result)->not->toContain('onclick');
            expect($result)->not->toContain('alert');
        });

        it('removes onerror handlers', function () {
            $html = '<img src="x" onerror="alert(\'xss\')">';
            $result = $this->converter->sanitizeHtml($html);

            expect($result)->not->toContain('onerror');
        });

        it('removes onload handlers', function () {
            $html = '<body onload="alert(\'xss\')">';
            $result = $this->converter->sanitizeHtml($html);

            expect($result)->not->toContain('onload');
        });

        it('removes onmouseover handlers', function () {
            $html = '<div onmouseover="alert(\'xss\')">Hover me</div>';
            $result = $this->converter->sanitizeHtml($html);

            expect($result)->not->toContain('onmouseover');
        });

        it('removes onfocus handlers', function () {
            $html = '<input onfocus="alert(\'xss\')">';
            $result = $this->converter->sanitizeHtml($html);

            expect($result)->not->toContain('onfocus');
        });

        it('removes event handlers with double quotes', function () {
            $html = '<div onclick="alert(1)">test</div>';
            $result = $this->converter->sanitizeHtml($html);

            expect($result)->not->toContain('onclick');
        });

        it('removes event handlers with single quotes', function () {
            $html = "<div onclick='alert(1)'>test</div>";
            $result = $this->converter->sanitizeHtml($html);

            expect($result)->not->toContain('onclick');
        });
    });

    describe('javascript: URL removal', function () {
        it('removes javascript: in href', function () {
            $html = '<a href="javascript:alert(\'xss\')">Click</a>';
            $result = $this->converter->sanitizeHtml($html);

            expect($result)->not->toContain('javascript:');
        });

        it('removes javascript: case insensitively', function () {
            $html = '<a href="JAVASCRIPT:alert(\'xss\')">Click</a>';
            $result = $this->converter->sanitizeHtml($html);

            expect($result)->not->toContain('javascript:', ignoreCase: true);
        });

        it('removes javascript: in src attribute', function () {
            $html = '<iframe src="javascript:alert(\'xss\')"></iframe>';
            $result = $this->converter->sanitizeHtml($html);

            expect($result)->not->toContain('javascript:');
        });
    });

    describe('SVG XSS prevention', function () {
        it('removes SVG onload handlers', function () {
            $html = '<svg onload="alert(\'xss\')"><circle r="50"/></svg>';
            $result = $this->converter->sanitizeHtml($html);

            expect($result)->not->toContain('onload');
        });
    });

    describe('dangerous URL schemes', function () {
        it('removes data:text/html URLs', function () {
            $html = '<a href="data:text/html,<script>alert(1)</script>">Click</a>';
            $result = $this->converter->sanitizeHtml($html);

            expect($result)->not->toContain('data:text/html');
        });

        it('removes data:application URLs', function () {
            $html = '<object data="data:application/x-shockwave-flash,evil">test</object>';
            $result = $this->converter->sanitizeHtml($html);

            expect($result)->not->toContain('data:application');
        });

        it('removes vbscript: URLs', function () {
            $html = '<a href="vbscript:msgbox(1)">Click</a>';
            $result = $this->converter->sanitizeHtml($html);

            expect($result)->not->toContain('vbscript:');
        });
    });

    describe('dangerous tags removal', function () {
        it('removes iframe tags', function () {
            $html = '<iframe src="evil.com"></iframe>';
            $result = $this->converter->sanitizeHtml($html);

            expect($result)->not->toContain('<iframe');
        });

        it('removes object tags', function () {
            $html = '<object data="evil.swf"></object>';
            $result = $this->converter->sanitizeHtml($html);

            expect($result)->not->toContain('<object');
        });

        it('removes embed tags', function () {
            $html = '<embed src="evil.swf">';
            $result = $this->converter->sanitizeHtml($html);

            expect($result)->not->toContain('<embed');
        });

        it('removes form tags', function () {
            $html = '<form action="evil.com"><input type="submit"></form>';
            $result = $this->converter->sanitizeHtml($html);

            expect($result)->not->toContain('<form');
        });

        it('removes meta refresh redirects', function () {
            $html = '<meta http-equiv="refresh" content="0;url=evil.com">';
            $result = $this->converter->sanitizeHtml($html);

            expect($result)->not->toContain('<meta');
        });

        it('removes base tag', function () {
            $html = '<base href="https://evil.com/">';
            $result = $this->converter->sanitizeHtml($html);

            expect($result)->not->toContain('<base');
        });
    });

    describe('event handler edge cases', function () {
        it('handles event handlers without quotes', function () {
            $html = '<div onclick=alert(1)>test</div>';
            $result = $this->converter->sanitizeHtml($html);

            expect($result)->not->toContain('onclick');
        });

        it('handles event handlers with spaces around equals', function () {
            $html = '<div onclick = "alert(1)">test</div>';
            $result = $this->converter->sanitizeHtml($html);

            expect($result)->not->toContain('onclick');
        });
    });

    // These are edge cases that may still bypass the regex-based sanitizer
    describe('known remaining gaps', function () {
        it('may not catch style-based expression XSS', function () {
            // CSS expression() is IE-only and mostly obsolete
            $html = '<div style="width:expression(alert(1))">test</div>';
            $result = $this->converter->sanitizeHtml($html);

            // This edge case may still pass through
            expect($result)->toContain('test');
        })->skip('Edge case: CSS expression() is IE-only, low priority');
    });
});

describe('toHtml sanitization integration', function () {
    it('sanitizes HTML embedded in markdown by default', function () {
        // When allow_html_import is false (default), HTML is escaped
        $markdown = 'Hello <script>alert("xss")</script> world';
        $html = $this->converter->toHtml($markdown);

        // With html_input = 'escape', the script tag should be escaped
        expect($html)->not->toContain('<script>');
    });

    it('applies sanitization when sanitize parameter is true', function () {
        $markdown = '# Heading';
        $html = $this->converter->toHtml($markdown, sanitize: true);

        // Basic conversion should still work
        expect($html)->toContain('<h1>');
    });

    it('skips sanitization when sanitize parameter is false', function () {
        $markdown = '# Heading';
        $html = $this->converter->toHtml($markdown, sanitize: false);

        expect($html)->toContain('<h1>');
    });
});

describe('cleanHtml preprocessing', function () {
    it('removes style tags before conversion', function () {
        $html = '<style>.malicious { display: none; }</style><p>Content</p>';
        $markdown = $this->converter->toMarkdown($html);

        expect($markdown)->not->toContain('style');
        expect($markdown)->not->toContain('.malicious');
        expect($markdown)->toContain('Content');
    });

    it('removes script tags before conversion', function () {
        $html = '<script>alert("xss")</script><p>Content</p>';
        $markdown = $this->converter->toMarkdown($html);

        expect($markdown)->not->toContain('script');
        expect($markdown)->not->toContain('alert');
        expect($markdown)->toContain('Content');
    });

    it('removes HTML comments', function () {
        $html = '<!-- secret comment --><p>Content</p>';
        $markdown = $this->converter->toMarkdown($html);

        expect($markdown)->not->toContain('secret comment');
        expect($markdown)->toContain('Content');
    });
});
