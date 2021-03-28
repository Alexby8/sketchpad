<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['throttle:create'])->get('/', [App\Http\Controllers\PostController::class, 'create'])->name('index');

Route::get('/{slug}', [App\Http\Controllers\PostController::class, 'show'])->where('slug', '[A-Za-z0-9]+')->name('show');
Route::post('/{slug}', [App\Http\Controllers\PostController::class, 'update'])->where('slug', '[A-Za-z0-9]+')->name('update');