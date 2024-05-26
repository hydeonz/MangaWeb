<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Manga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class GenreController extends Controller
{
    public function store(Request $request)
    {
        $genre = $request->get('name');

        Genre::query()->insert(['name' => $genre]);
        return response()->json(['message' => 'Добавление прошло успешно']);
    }

    public function delete(Request $request)
    {
        $genre = Genre::query()->where('id', '=', $request->get('id'))->first('name');

        if (!$genre) {
            return response()->json(['message' => "Жанр с id {$request->input('id')} не найден"], 404);
        }
        DB::table('mangas')
            ->where('genre_id','=', $request->get('id'))
            ->update(['genre_id' => 1]);
        DB::table('genres')
            ->where('id','=', $request->get('id'))
            ->delete();
        return response()->json([
            'genres' => Genre::all(),
            'deletedGenreId' => $request->get('id'),
            'mangas' => Manga::all(),
            'genre' => $genre,
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
