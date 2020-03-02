<?php

namespace App\Events;

use App\Message;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

/**
 * Class MessageCreated
 * @package App\Events
 */
class MessageCreated implements ShouldBroadcast
{
    use SerializesModels;

    /**
     * @var Message
     */
    public Message $message;

    /**
     * @var int
     */
    protected int $userId;

    /**
     * @var int
     */
    public int $chatId;

    /**
     * Create a new event instance.
     *
     * @param Message $message
     * @param int $userId
     * @param int $chatId
     */
    public function __construct(Message $message, int $userId, int $chatId)
    {
        $this->message = $message;
        $this->userId = $userId;
        $this->chatId = $chatId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chats.' . $this->userId);
    }

    /**
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'message.created';
    }
}
