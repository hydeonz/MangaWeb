<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Genre;
use App\Traits\MangaTrait;


class AdminController extends Controller
{
    use MangaTrait;

    public function show()
    {
        $authors = Author::all();
        $genres = Genre::query()
            ->where([
                'is_deleted' => false,
            ])
            ->get();
        $mangas = $this->index();
        return view('admin',[
            'authors' => $authors,
            'genres' => $genres,
            'mangas' => $mangas,
        ]);
    }

    public function showAddManga()
    {

    }

    public function showAddAuthor()
    {

    }

    public function showAddGenre()
    {

    }
}
