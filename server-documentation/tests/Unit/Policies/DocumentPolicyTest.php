<?php

declare(strict_types=1);

use Starter\ServerDocumentation\Policies\DocumentPolicy;

describe('DocumentPolicy structure', function () {
    it('can be instantiated', function () {
        $policy = new DocumentPolicy();

        expect($policy)->toBeInstanceOf(DocumentPolicy::class);
    });

    it('has a before hook for root admin bypass', function () {
        $policy = new DocumentPolicy();

        expect(method_exists($policy, 'before'))->toBeTrue();
    });

    it('has all required CRUD methods', function () {
        $policy = new DocumentPolicy();

        expect(method_exists($policy, 'viewAny'))->toBeTrue();
        expect(method_exists($policy, 'view'))->toBeTrue();
        expect(method_exists($policy, 'create'))->toBeTrue();
        expect(method_exists($policy, 'update'))->toBeTrue();
        expect(method_exists($policy, 'delete'))->toBeTrue();
        expect(method_exists($policy, 'restore'))->toBeTrue();
        expect(method_exists($policy, 'forceDelete'))->toBeTrue();
    });

    it('has viewOnServer method for server panel', function () {
        $policy = new DocumentPolicy();

        expect(method_exists($policy, 'viewOnServer'))->toBeTrue();
    });
});

// Integration tests for actual policy behavior are in Feature/DocumentPolicyTest.php
