<?php

use App\Http\Controllers\MangaController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/register',[RegisterController::class,'register']);
Route::get('/admin/manga/delete/{id}',[MangaController::class,'delete']);
Route::post('/admin/manga/update/',[MangaController::class,'update']);
