<?php

namespace Database\Factories;

use App\Models\Writer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class WriterFactory extends Factory
{
    protected $model = Writer::class;

    public function definition()
    {
        return [
            'idwriter' => $this->faker->uuid(),
            'name' => $this->faker->name(),
            'biography' => $this->faker->paragraph(),
            'photo' => null,
        ];
    }
   
}
