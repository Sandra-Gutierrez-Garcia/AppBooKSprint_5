<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GenreBook extends Model
{
    protected $table = 'genre_book';
    public $timestamps = false;

    // Define the fillable attributes if needed
    protected $fillable = [
        'idbook',
        'idgenre',
    ];

    // Define the relationship with the Book model
      public function book()
    {
        return $this->belongsTo(Book::class, 'idbook');
    }
    
    // Define the relationship with the Genre model
    public function genre()
    {
        return $this->belongsTo(Genre::class, 'idgenre');
    }
}
