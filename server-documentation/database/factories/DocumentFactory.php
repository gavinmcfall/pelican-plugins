<?php

declare(strict_types=1);

namespace Starter\ServerDocumentation\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Starter\ServerDocumentation\Models\Document;

/**
 * @extends Factory<Document>
 */
class DocumentFactory extends Factory
{
    protected $model = Document::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid(),
            'title' => fake()->sentence(4),
            'slug' => fake()->unique()->slug(3),
            'content' => '<p>' . fake()->paragraphs(3, true) . '</p>',
            'is_global' => fake()->boolean(20),
            'is_published' => fake()->boolean(80),
            'sort_order' => fake()->numberBetween(0, 100),
        ];
    }

    /**
     * Published document.
     */
    public function published(): static
    {
        return $this->state(['is_published' => true]);
    }

    /**
     * Unpublished/draft document.
     */
    public function unpublished(): static
    {
        return $this->state(['is_published' => false]);
    }

    /**
     * Global document (visible on all servers).
     */
    public function global(): static
    {
        return $this->state(['is_global' => true]);
    }

    /**
     * Non-global document (must be attached to servers).
     */
    public function notGlobal(): static
    {
        return $this->state(['is_global' => false]);
    }

    /**
     * Attach roles to the document after creation.
     *
     * @param array<int> $roleIds
     */
    public function withRoles(array $roleIds): static
    {
        return $this->afterCreating(fn (Document $doc) => $doc->roles()->attach($roleIds));
    }

    /**
     * Attach users to the document after creation.
     *
     * @param array<int> $userIds
     */
    public function withUsers(array $userIds): static
    {
        return $this->afterCreating(fn (Document $doc) => $doc->users()->attach($userIds));
    }

    /**
     * Attach eggs to the document after creation.
     *
     * @param array<int> $eggIds
     */
    public function withEggs(array $eggIds): static
    {
        return $this->afterCreating(fn (Document $doc) => $doc->eggs()->attach($eggIds));
    }

    /**
     * Attach servers to the document after creation.
     *
     * @param array<int> $serverIds
     */
    public function withServers(array $serverIds): static
    {
        return $this->afterCreating(fn (Document $doc) => $doc->servers()->attach($serverIds));
    }
}
