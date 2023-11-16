<?php

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
Route::middleware('auth')->get('/', function () {
    $chats = \App\Models\Chat::withCount('users')->orderBy('id', 'ASC')->get();
    return view('home', compact('chats'));
})->name('home');
Route::middleware('auth')->get('/chats/{chat}', function (\App\Models\Chat $chat) {
    $chat->load('messages', 'users');
    return view('room', compact('chat'));
})->name('room');
Auth::routes();
