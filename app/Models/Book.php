<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'book';
    protected $primaryKey = 'idbook';
    public $timestamps = false;

    protected $fillable = [
        'idbook',
        'title',
        'idwriter',
        'description',
        'publication_date',
        'photo',
        'content',
        
    ];
    // Define the relationship with the Writer model
     public function writer()
    {
    return $this->belongsTo(Writer::class, 'idwriter', 'idwriter');
    }

    // Define the relationship with the Genre model
    public function genre_Book()
    {
        return $this->belongsToMany(Genre::class, 'genres_book', 'idbook', 'idgenre');
    }

    // Define the relationship with the User model for likes
    public function likesBook()
    {
        return $this->belongsToMany(User::class, 'like_book', 'idbook', 'iduser');
    }
    
}
