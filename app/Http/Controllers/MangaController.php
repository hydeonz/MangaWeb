<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Manga;
use App\Traits\MangaTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MangaController extends Controller
{
    use MangaTrait;

    public function show()
    {
        return view('home', ['mangas' => $this->index()]);
    }
    public function delete($id) {
        Manga::all()
            ->find($id)
            ->update(['is_deleted'=>true]);

        response()->json(['message' => "Манга с id {$id} была успешно удалена"]);
    }

    public function update(Request $request)
    {
        $manga = $request->all();

        $author = Author::query()
            ->where('name', $manga['author_name'])
            ->first();

        if($author) {
            Manga::query()
                ->where('id', '=', $manga['id'])
                ->update([
                    'title' => $manga['title'],
                    'author_id' => $author->id, // Использовать id найденного автора
                    'release_date' => $manga['release_date'],
                    'description' => $manga['description'],
                    'updated_at' => now(),
                ]);
        } else {
            // Обработка ситуации, если автор не найден
            // Например, вы можете выбрать стандартного автора или вывести ошибку
        }
    }
}
