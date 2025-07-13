<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 


class Writer extends Model
{
    use HasFactory;
    
    protected $table = 'writer';
    protected $primaryKey = 'idwriter';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'idwriter',
        'name',
        'biography', 
        'photo',
        'iduser',
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'iduser', 'id'); 
    }
    
    // Define the relationship with the Book model
    public function books()
    {
        return $this->hasMany(Book::class, 'idwriter', 'idwriter');
    }
    
}
