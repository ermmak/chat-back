<?php

namespace App\Http\Controllers\API;

use App\Chat;
use App\Events\MessageCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;
use App\Message;

/**
 * Class ChatMessageController
 * @package App\Http\Controllers\API
 */
class ChatMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Chat $chat
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Chat $chat)
    {
        return response()->json($chat->messages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MessageRequest $request
     * @param Chat $chat
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MessageRequest $request, Chat $chat)
    {
        $message = new Message([
            'user_id' => $request->user()->id,
            'chat_id' => $chat->id,
            'text' => $request->input('text')
        ]);

        $created = $message->save();

        if ($created) {
            collect($message->chat->users)->each(
                fn($user) => event(new MessageCreated($message, $user->id, $chat->id))
            );
        }

        return response()->json($created);
    }
}
