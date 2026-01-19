<?php

declare(strict_types=1);

use Starter\ServerDocumentation\Policies\DocumentPolicy;

describe('DocumentPolicy', function () {
    it('can be instantiated', function () {
        $policy = new DocumentPolicy();

        expect($policy)->toBeInstanceOf(DocumentPolicy::class);
    });

    it('has viewAny method', function () {
        $policy = new DocumentPolicy();

        expect(method_exists($policy, 'viewAny'))->toBeTrue();
    });

    it('has view method', function () {
        $policy = new DocumentPolicy();

        expect(method_exists($policy, 'view'))->toBeTrue();
    });

    it('has create method', function () {
        $policy = new DocumentPolicy();

        expect(method_exists($policy, 'create'))->toBeTrue();
    });

    it('has update method', function () {
        $policy = new DocumentPolicy();

        expect(method_exists($policy, 'update'))->toBeTrue();
    });

    it('has delete method', function () {
        $policy = new DocumentPolicy();

        expect(method_exists($policy, 'delete'))->toBeTrue();
    });

    it('has restore method', function () {
        $policy = new DocumentPolicy();

        expect(method_exists($policy, 'restore'))->toBeTrue();
    });

    it('has forceDelete method', function () {
        $policy = new DocumentPolicy();

        expect(method_exists($policy, 'forceDelete'))->toBeTrue();
    });

    it('has viewOnServer method', function () {
        $policy = new DocumentPolicy();

        expect(method_exists($policy, 'viewOnServer'))->toBeTrue();
    });
});
