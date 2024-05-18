<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

trait MangaTrait
{
    function index()
    {
        return DB::table('mangas as m')
            ->join('authors as a', 'm.author_id', '=', 'a.id')
            ->leftJoin('genres as g', 'm.genre_id', '=', 'g.id')
            ->where('m.is_deleted', '=', false)
            ->where(function ($query) {
                $query->where('g.is_deleted', '=', false)
                    ->orWhereNull('g.is_deleted');
            })
            ->groupBy('m.id')
            ->select(
                'm.id as id',
                'a.id as author_id',
                'm.title as title',
                'g.name as genre_names',
                'm.genre_id as genre_id',
                'm.description as description',
                'm.release_date as release_date',
                'image_path as image_path',
                'a.name as author_name',
            )
            ->get();
    }
}
