<?php

namespace Starter\ServerDocumentation\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Server;

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
