<?php

namespace Database\Factories;

use App\Models\Writer;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GenreFactory extends Factory
{
    protected $model = Genre::class;

    public function definition()
    {
        return [
           'namegenre' => $this->faker->word(),
        ];
    }
   
}
