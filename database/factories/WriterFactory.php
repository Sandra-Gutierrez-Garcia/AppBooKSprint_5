<?php

namespace Database\Factories;

use App\Models\Writer;
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
            // 'iduser' se debe asignar explícitamente en los tests para evitar inconsistencias
        ];
    }
   
}
