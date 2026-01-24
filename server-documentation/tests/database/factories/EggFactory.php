<?php

namespace Starter\ServerDocumentation\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Egg;

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
