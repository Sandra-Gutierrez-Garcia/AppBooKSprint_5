<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenrsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          $genres = [
            'Fiction',
            'Horror',
            'Adventure',
            'Science Fiction',
            'Romance',
            'Drama',
            'Historical',
            'Biography'
        ];

        foreach ($genres as $genreName) {
            Genre::create(['namegenre' => $genreName]);
        }
    }
}
