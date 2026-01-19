<?php

declare(strict_types=1);

use Starter\ServerDocumentation\Policies\DocumentVersionPolicy;

describe('DocumentVersionPolicy', function () {
    it('can be instantiated', function () {
        $policy = new DocumentVersionPolicy();

        expect($policy)->toBeInstanceOf(DocumentVersionPolicy::class);
    });

    it('has viewAny method', function () {
        $policy = new DocumentVersionPolicy();

        expect(method_exists($policy, 'viewAny'))->toBeTrue();
    });

    it('has view method', function () {
        $policy = new DocumentVersionPolicy();

        expect(method_exists($policy, 'view'))->toBeTrue();
    });

    it('has restore method', function () {
        $policy = new DocumentVersionPolicy();

        expect(method_exists($policy, 'restore'))->toBeTrue();
    });

    it('denies create for manual version creation', function () {
        $policy = new DocumentVersionPolicy();
        $user = Mockery::mock(\App\Models\User::class);

        expect($policy->create($user))->toBeFalse();
    });

    it('denies update for version immutability', function () {
        $policy = new DocumentVersionPolicy();
        $user = Mockery::mock(\App\Models\User::class);
        $version = Mockery::mock(\Starter\ServerDocumentation\Models\DocumentVersion::class);

        expect($policy->update($user, $version))->toBeFalse();
    });

    it('denies individual delete', function () {
        $policy = new DocumentVersionPolicy();
        $user = Mockery::mock(\App\Models\User::class);
        $version = Mockery::mock(\Starter\ServerDocumentation\Models\DocumentVersion::class);

        expect($policy->delete($user, $version))->toBeFalse();
    });
});
