<?php

namespace App\Policies;

use App\Chat;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class ChatPolicy
 * @package App\Policies
 */
class ChatPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the chat.
     *
     * @param  \App\User  $user
     * @param  \App\Chat  $chat
     * @return mixed
     */
    public function show(User $user, Chat $chat)
    {
        return $user->chats()->where('id', $chat->id)->exists();
    }

    /**
     * Determine whether the user can update the chat.
     *
     * @param  \App\User  $user
     * @param  \App\Chat  $chat
     * @return mixed
     */
    public function update(User $user, Chat $chat)
    {
        return $this->ownsChat($user, $chat);
    }

    /**
     * Determine whether the user can delete the chat.
     *
     * @param  \App\User  $user
     * @param  \App\Chat  $chat
     * @return mixed
     */
    public function delete(User $user, Chat $chat)
    {
        return $this->ownsChat($user, $chat);
    }

    /**
     * @param User $user
     * @param Chat $chat
     * @return bool
     */
    public function ownsChat(User $user, Chat $chat): bool
    {
        return $user->chats()
            ->where('id', '=', $chat->id)
            ->wherePivot('is_admin', true)
            ->exists();
    }
}
