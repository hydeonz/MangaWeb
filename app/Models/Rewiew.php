<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rewiew extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'manga_id',
        'rating',
        'review',
    ];
}
