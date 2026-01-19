<?php

declare(strict_types=1);

use Starter\ServerDocumentation\Models\Document;

describe('generateUniqueSlug', function () {
    it('generates slug from title', function () {
        $slug = Document::generateUniqueSlug('My Test Document');

        expect($slug)->toBe('my-test-document');
    });

    it('handles empty title', function () {
        $slug = Document::generateUniqueSlug('');

        expect($slug)->toBe('document');
    });

    it('handles special characters', function () {
        $slug = Document::generateUniqueSlug('Test!@#$%^&*()Document');

        expect($slug)->toBe('testdocument');
    });
});

describe('validation rules', function () {
    it('has required title rule', function () {
        expect(Document::$validationRules['title'])->toContain('required');
    });

    it('has required content rule', function () {
        expect(Document::$validationRules['content'])->toContain('required');
    });

    it('has alpha_dash slug rule', function () {
        expect(Document::$validationRules['slug'])->toContain('alpha_dash');
    });
});

describe('casts', function () {
    it('casts is_global to boolean', function () {
        $document = new Document(['is_global' => '1']);

        expect($document->is_global)->toBeBool();
    });

    it('casts is_published to boolean', function () {
        $document = new Document(['is_published' => '0']);

        expect($document->is_published)->toBeBool();
    });

    it('casts sort_order to integer', function () {
        $document = new Document(['sort_order' => '5']);

        expect($document->sort_order)->toBeInt();
    });
});

describe('RESOURCE_NAME constant', function () {
    it('has correct resource name', function () {
        expect(Document::RESOURCE_NAME)->toBe('document');
    });
});
