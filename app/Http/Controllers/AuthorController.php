<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Manga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthorController extends Controller
{
    public function store(Request $request)
    {
        $author = $request->get('name');

        Author::query()->insert(['name' => $author]);
        return response()->json(['message' => 'Добавление прошло успешно']);
    }
    public function delete(Request $request)
    {
        $author = Author::query()->where('id', '=', $request->get('id'))->first('name');

        if (!$author) {
            return response()->json(['message' => "Автор с id {$request->input('id')} не найден"], 404);
        }
        DB::table('mangas')
            ->where('author_id','=', $request->get('id'))
            ->update(['author_id' => 1]);
        DB::table('authors')
            ->where('id','=', $request->get('id'))
            ->delete();
        return response()->json([
            'authors' => Author::all(),
            'deletedAuthorId' => $request->get('id'),
            'mangas' => Manga::all(),
            'author' => $author,
        ]);
    }

    public function update(Request $request)
    {
        $author = $request->all();

        $oldAuthor = Author::query()
            ->where('id','=',$author['id'])
            ->get();

        Author::query()
            ->where('id', '=', $author['id'])
            ->update([
                'name' => $author['name']
            ]);
        $newAuthor = Author::query()
            ->where('id','=',$author['id'])
            ->get();

        return response()->json([
            'author' => $newAuthor,
            'old_author' => $oldAuthor,
            'mangas' => Manga::all(),
            'updated_author_id' => $author['id'],
        ]);
    }
}
