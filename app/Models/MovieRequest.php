<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'movie_title',
        'comment'
    ];
}
