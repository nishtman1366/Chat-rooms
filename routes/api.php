<?php

use App\Events\TestWebsocketEvent;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('test-websockets', function () {
    TestWebsocketEvent::dispatch();
    return response()->json();
});
Route::middleware('auth:sanctum')->post('/chats/{chat}/messages/send', function (\App\Models\Chat $chat, Request $request) {
    $user = \Illuminate\Support\Facades\Auth::user();
    $message = \App\Models\ChatsMessage::create([
        'chat_id' => $chat->id,
        'sender_id' => $user->id,
        'message' => $request->get('message')
    ]);
    TestWebsocketEvent::dispatch();
    \App\Events\ReceiveMessages::dispatch($chat, $message);
    return response()->json();
});
Route::middleware('auth:sanctum')->post('/chats/{chat}/join', function (\App\Models\Chat $chat) {
    $user = \Illuminate\Support\Facades\Auth::user();
    \App\Models\ChatsUser::firstOrCreate([
        'chat_id' => $chat->id,
        'user_id' => $user->id,
    ]);

    return response()->json();
});
Route::middleware('auth:sanctum')->get('/chats/{chat}/leave', function (\App\Models\Chat $chat) {
    $user = \Illuminate\Support\Facades\Auth::user();
    \App\Models\ChatsUser::where('chat_id', $chat->id)->where('user_id', $user->id)->delete();

    return response()->json();
});
