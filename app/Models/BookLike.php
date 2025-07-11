<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookLike extends Model
{
    protected $table = 'like_book';
    protected $primaryKey = 'idbook';
    public $timestamps = false;

    protected $fillable = 
    [
        'idbook', 
        'iduser'
    ];
    
    // Define the relationships
    public function book()
    {
        return $this->belongsTo(Book::class, 'idbook');
    }

    // Define the relationship with the User model
     public function user()
    {
        return $this->belongsTo(User::class, 'iduser');
    }
}
