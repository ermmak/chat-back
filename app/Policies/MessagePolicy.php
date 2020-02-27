<?php

namespace App\Policies;

use App\Chat;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class MessagePolicy
 * @package App\Policies
 */
class MessagePolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Chat $chat
     * @return bool
     */
    public function store(User $user, Chat $chat)
    {
        return $user->chats()->where('id', $chat->id)->exists();
    }
}
