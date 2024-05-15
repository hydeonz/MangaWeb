<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manga extends Model
{
    protected $fillable = [
        'id',
        'author_id',
        'title',
        'description',
        'release_data',
        'image_path',
        'is_deleted',
    ];
}
