<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'title',
        'description',
        'public',
        'reported',
        'num_likes',
        'user_id',
        'reported_by',
        'image_id'
    ];
}
