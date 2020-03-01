<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

/**
 * Class UserRegistered
 * @package App\Events
 */
class UserRegistered implements ShouldBroadcast
{
    use SerializesModels;

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('users');
    }

    /**
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'user.created';
    }
}
