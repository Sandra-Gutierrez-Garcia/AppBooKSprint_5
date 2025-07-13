<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $table = 'genre';
    protected $primaryKey = 'idgenre';
    public $timestamps = false;

    protected $fillable = [
        'idgenre',
        'namegenre',
    ];

    // Define the relationship with the Book model
    public function books()
    {
        return $this->belongsToMany(Book::class, 'genres_book', 'idgenre', 'idbook');
    }
    
}
