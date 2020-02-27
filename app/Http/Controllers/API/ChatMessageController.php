<?php

namespace App\Http\Controllers\API;

use App\Chat;
use App\Http\Controllers\Controller;
use App\Message;
use Illuminate\Http\Request;

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
     * @param \Illuminate\Http\Request $request
     * @param Chat $chat
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Chat $chat)
    {
        $this->authorize('store', [Message::class, $chat]);

        return response()->json(!!Message::create([
            'user_id' => $request->user()->id,
            'chat_id' => $chat->id,
            'text' => $request->input('text')
        ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
