<?php

namespace Database\Factories;

use App\Models\Writer;
use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition()
    {
        return [
           'title' => $this->faker->name(),
           'description' => $this->faker->paragraph(),
           'publish_date' => $this->faker->date(),
           'photo' => null,
           'content' => $this->faker->text(),
           'status' => 'pending',

        ];
    }
   
}
