<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\BookLike;
use App\Models\Book;
use App\Models\User;


class BookLikeFactory extends Factory
{
    protected $model = BookLike::class;

    public function definition(): array
    {
        return [
            'idbook' => Book::factory(),
            'iduser' => User::factory(),
        ];
    }
}
