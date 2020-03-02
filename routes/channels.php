<?php

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

use App\User;

Broadcast::channel('chats.{userId}', function (User $user, int $userId) {
    return $user->id === $userId;
});

Broadcast::channel('users', function ($user) {
    return true;
});

Broadcast::channel('chat.updated.{chatId}', function (User $user, int $chatId) {
    return $user->chats()->where('id', $chatId)->exists();
});
