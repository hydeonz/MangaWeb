<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Genre;
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

    public function store(Request $request)
    {
        $manga = $request->all();
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $filename = Str::random(40) . '.jpg';

            $path = $file->storeAs('public/images', $filename);

            $imagePath = Storage::url($path);
                Manga::query()
                    ->insert([
                        'title' => $manga['title'],
                        'author_id' => $manga['author_id'],
                        'release_date' => $manga['release_date'],
                        'genre_id' => $manga['genre_id'],
                        'description' => $manga['description'],
                        'image_path' =>  $imagePath,
                        'updated_at' => now(),
                    ]);
        }
        return response()->json(['message' => 'Добавление манги с названием ' . $manga['title'] . ' прошло успешно']);
    }

    public function delete(Request $request) {
        $manga = Manga::query()->where('id', '=', $request->get('id'))->first('title');
        Manga::all()
            ->find($request->get('id'))
            ->update(['is_deleted'=>true]);

        return response()->json([
            'message' => 'Манга с id '. $request->get('id') . 'была успешно удалена', 'manga' => $manga]);
    }

    public function update(Request $request)
    {
        $manga = $request->all();

        $oldManga = Manga::query()
            ->where('id','=', $manga['id'])
            ->get();

        $oldMangaAuthor = Author::query()->where('id', '=', $oldManga[0]['author_id'])->first('name');
        $oldMangaGenre = Genre::query()->where('id', '=', $oldManga[0]['genre_id'])->first('name');

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $filename = Str::random(40) . '.jpg';

            $path = $file->storeAs('public/images', $filename);

            $imagePath = Storage::url($path);
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

        $mangaAuthor = Author::query()->where('id', '=', $newManga[0]['author_id'])->first('name');
        $mangaGenre = Genre::query()->where('id', '=', $newManga[0]['genre_id'])->first('name');

        return response()->json([
            'oldManga' => $oldManga,
            'manga' => $newManga,
            'authors' => Author::query()->get(),
            'oldMangaAuthor' => $oldMangaAuthor,
            'oldMangaGenre' => $oldMangaGenre,
            'mangaAuthor' => $mangaAuthor,
            'mangaGenre' => $mangaGenre,
        ]);
    }

}
