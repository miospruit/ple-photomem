<?php

use Illuminate\Support\Facades\Route;
use App\Models\Memory;
use App\Models\Tag;
use App\Http\Controllers\MemoryController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::resource('memory', MemoryController::class)->middleware(['auth']);

Route::get('/memory/{memory}/tag/{tag}/disconnect', function (Memory $memory, Tag $tag) {
    $memory->tags()->detach($tag);
    return redirect()->route('memory.edit', $memory);
})->middleware(['auth'])->name('delete-tag');

require __DIR__.'/auth.php';
