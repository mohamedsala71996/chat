<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\GlobalChatController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//private chat
Route::get('/chat/{user_id}', [ChatController::class, 'index'])->name('chat.index')->middleware('auth');
Route::post('/chat/{user_id}', [ChatController::class, 'store'])->middleware('auth');

//global chat
Route::get('/globalChat', [GlobalChatController::class, 'index'])->name('globalChat.index')->middleware('auth');
Route::post('/globalChat', [GlobalChatController::class, 'store'])->middleware('auth');

require __DIR__.'/auth.php';
