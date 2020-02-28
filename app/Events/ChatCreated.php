<?php

namespace App\Events;

use App\Chat;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

/**
 * Class ChatCreated
 * @package App\Events
 */
class ChatCreated implements ShouldBroadcast
{
    use SerializesModels;

    /**
     * @var Chat
     */
    public Chat $chat;

    /**
     * ChatCreated constructor.
     * @param Chat $chat
     */
    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chats');
    }

    /**
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'chat.created';
    }
}
