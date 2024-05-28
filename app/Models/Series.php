<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'movieId',
        'isAdult',
        'full_name',
        'originalTitleText',
        'imageUrl',
        'backdrop_path',
        'country',
        'language',
        'plotText',
        'releaseDate',
        'releaseYear',
        'aggregateRating',
        'titleType',
        'runtime',
        'genres',
        'trailer',
        'status',
        'created_at',
    ];
}
