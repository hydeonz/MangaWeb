<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Manga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class GenreController extends Controller
{

    public function delete(Request $request)
    {
        $genre = Genre::all()
            ->find($request->get('id'));

        if (!$genre) {
            return response()->json(['message' => "Жанр с id {$request->input('id')} не найден"], 404);
        }
        DB::table('mangas')
            ->where('genre_id','=', $genre->id)
            ->update(['genre_id' => 1]);
        DB::table('genres')
            ->where('id','=', $request->get('id'))
            ->delete();
        return response()->json([
            'genres' => Genre::all(),
            'deletedGenreId' => $request->get('id'),
            'mangas' => Manga::all(),
        ]);
    }

    public function update(Request $request)
    {
        $genre = $request->all();

        $oldGenre = Genre::query()
            ->where('id','=',$genre['id'])
            ->get();

        Genre::query()
            ->where('id', '=', $genre['id'])
            ->update([
                'name' => $genre['name']
            ]);
        $newGenre = Genre::query()
            ->where('id','=',$genre['id'])
            ->get();

        return response()->json([
            'genre' => $newGenre,
            'old_genre' => $oldGenre,
            'mangas' => Manga::all(),
            'updated_genre_id' => $genre['id'],
        ]);
    }

}
