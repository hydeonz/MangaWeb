<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Manga;
use App\Traits\MangaTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MangaController extends Controller
{
    use MangaTrait;

    public function show()
    {
        return view('home', ['mangas' => $this->index()]);
    }
    public function delete(Request $request) {
        Manga::all()
            ->find($request->get('id'))
            ->update(['is_deleted'=>true]);

        response()->json(['message' => "Манга с id {$request->get('id')} была успешно удалена"]);
    }

    public function update(Request $request)
    {
        $manga = $request->all();
        $oldManga = Manga::all()->find($manga['id'])->first();
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $filename = Str::random(40) . '.jpg';

            $path = $file->storeAs('public/images', $filename);

            $imagePath = Storage::url($path);;
            Manga::query()
                ->where('id', '=', $manga['id'])
                ->update([
                    'title' => $manga['title'],
                    'author_id' => $manga['author_id'],
                    'release_date' => $manga['release_date'],
                    'genre_id' => $manga['genre_id'],
                    'description' => $manga['description'],
                    'image_path' =>  $imagePath,
                    'updated_at' => now(),
                ]);
        } else {
            Manga::query()
                ->where('id', '=', $manga['id'])
                ->update([
                    'title' => $manga['title'],
                    'author_id' => $manga['author_id'],
                    'release_date' => $manga['release_date'],
                    'genre_id' => $manga['genre_id'],
                    'description' => $manga['description'],
                    'updated_at' => now(),
                ]);
        }
        $newManga = Manga::query()->where('id', '=', $manga['id'])->get();

        return response()->json([
            'oldManga' => $oldManga,
            'manga' => $newManga,
            'authors' => Author::query()->get(),
        ]);
    }

}
