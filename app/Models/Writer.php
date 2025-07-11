<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Writer extends Model
{
    protected $table = 'writer';
    protected $primaryKey = 'idwriter';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'photo',
        'iduser',
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'iduser', 'iduser');
    }
    
    // Define the relationship with the Book model
    public function books()
    {
        return $this->hasMany(Book::class, 'idwriter', 'idwriter');
    }
}
