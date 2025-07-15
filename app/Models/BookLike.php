<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookLike extends Model
{
    use HasFactory;
    protected $table = 'like_book';
    public $timestamps = false;

    protected $fillable = 
    [
        'idbook', 
        'iduser',
    ];
    
    // Define the relationships
    public function book()
    {
        return $this->belongsTo(Book::class, 'idbook');
    }

    // Define the relationship with the User model
     public function user()
    {
        return $this->belongsTo(User::class, 'iduser', 'id');
    }

}
