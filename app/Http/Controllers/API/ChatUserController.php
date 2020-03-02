<?php

namespace App\Http\Controllers\API;

use App\Chat;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChatUserRequest;

/**
 * Class ChatUserController
 * @package App\Http\Controllers
 */
class ChatUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Chat $chat
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Chat $chat)
    {
        $this->authorize('show', $chat);

        return response()->json($chat->users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Chat $chat
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Chat $chat, int $userId)
    {
        $this->authorize('update', $chat);
        $chat->users()->attach($userId);

        return response()->json(true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Chat $chat
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Chat $chat, int $userId)
    {
        $this->authorize('delete', $chat);
        $chat->users()->detach($userId);

        return response()->json(true);
    }

    /**
     * @param ChatUserRequest $request
     * @param Chat $chat
     * @return \Illuminate\Http\JsonResponse
     */
    public function attach(ChatUserRequest $request, Chat $chat)
    {
        $chat->users()->attach($request->validated());

        return response()->json(true);
    }
}
