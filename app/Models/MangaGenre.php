<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MangaGenre extends Model
{
    protected $fillable = [
        'manga_id',
        'genre_id',
    ];
}
