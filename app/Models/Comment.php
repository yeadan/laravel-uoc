<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'content',
        'reported',
        'user_id',
        'reported_by',
        'post_id'
    ];
}
