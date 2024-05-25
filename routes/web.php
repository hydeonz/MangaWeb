<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MangaController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [MangaController::class, 'show'])->name('home');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['isadmin','auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'show'])->name('admin');
    Route::get('/admin/manga/add', [AdminController::class, 'showAddManga'])->name('add_manga');
    Route::get('/admin/author/add', [AdminController::class, 'showAddAuthor'])->name('add_author');
    Route::get('/admin/genre/add', [AdminController::class, 'showAddGenre'])->name('add_genre');
});
Route::middleware(['authcheck'])->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/login', [LoginController::class, 'attempt']);
});

Route::post('/manga/add',[MangaController::class,'store']);
Route::post('/manga/delete',[MangaController::class,'delete']);
Route::post('/manga/update',[MangaController::class,'update']);

Route::post('/genre/delete',[GenreController::class,'delete']);
Route::post('/genre/update',[GenreController::class,'update']);

Route::post('/author/add',[AuthorController::class,'store']);
Route::post('/author/delete',[AuthorController::class,'delete']);
Route::post('/author/update',[AuthorController::class,'update']);



