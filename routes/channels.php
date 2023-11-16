<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/
Broadcast::channel('test-channel', function () {
    return false;
});
Broadcast::channel('chat-room-{chat}', function (User $user, \App\Models\Chat $chat) {
    return $user->isRoomMember($chat)
        ? ['id' => $user->id, 'name' => $user->name]
        : false;
});
