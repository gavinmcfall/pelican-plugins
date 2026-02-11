<?php

namespace Starter\ServerDocumentation\Database\Factories;

use App\Models\Server;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServerFactory extends Factory
{
    protected $model = Server::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'uuid' => $this->faker->uuid(),
            'description' => $this->faker->sentence(),
        ];
    }
}
