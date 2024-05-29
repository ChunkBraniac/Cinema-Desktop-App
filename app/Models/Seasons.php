<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seasons extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'movieId',
        'full_name',
        'movieName',
        'movieType',
        'season_number',
        'episode_number',
        'air_date',
        'imageUrl',
        'created_at',
    ];
}
