<?php

namespace App\Http\Controllers;

use App\Traits\MangaTrait;
class MangaController extends Controller
{
    use MangaTrait;

    public function show()
    {
        return view('home', ['mangas' => $this->index()]);
    }
}
