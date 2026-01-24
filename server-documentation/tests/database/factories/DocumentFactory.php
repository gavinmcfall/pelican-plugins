<?php

namespace Starter\ServerDocumentation\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Starter\ServerDocumentation\Models\Document;

class DocumentFactory extends Factory
{
    protected $model = Document::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'slug' => $this->faker->slug(),
            'content' => $this->faker->paragraphs(3, true),
            'content_type' => 'markdown',
            'is_published' => true,
            'is_global' => false,
        ];
    }
}
