<?php

namespace Starter\ServerDocumentation\Database\Factories;

use App\Models\Egg;
use Illuminate\Database\Eloquent\Factories\Factory;

class EggFactory extends Factory
{
    protected $model = Egg::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            // Add other necessary attributes for Egg model
        ];
    }
}
