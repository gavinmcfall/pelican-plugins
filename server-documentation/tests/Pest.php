<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
)->in('Feature');

uses(
    Tests\TestCase::class,
)->in('Unit');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toContainIgnoreCase', function (string $needle) {
    return $this->and(stripos($this->value, $needle) !== false)->toBeTrue();
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

/**
 * Helper to invoke protected/private methods for testing.
 */
function invokeMethod(object $object, string $method, array $args = []): mixed
{
    $reflection = new ReflectionClass($object);
    $method = $reflection->getMethod($method);
    $method->setAccessible(true);

    return $method->invokeArgs($object, $args);
}

/**
 * Helper to check if cache supports tagging.
 */
function cacheSupportsTagging(): bool
{
    try {
        $store = Illuminate\Support\Facades\Cache::getStore();

        return $store instanceof Illuminate\Cache\TaggableStore;
    } catch (Exception) {
        return false;
    }
}
