<?php

namespace App\Http\Controllers\API;

use App\Chat;
use App\Events\ChatCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChatRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class ChatController
 * @package App\Http\Controllers\API
 */
class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json($request->user()->chats);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ChatRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ChatRequest $request)
    {
        return response()->json(DB::transaction(function () use ($request) {
            $data = $request->validated();
            $chat = $request->user()->chats()->create($data, ['is_admin' => true]);

            if (!!$chat) {
                event(new ChatCreated($chat, $request->user()->id));
                $users = $data['users'] ?? [];

                if (!empty($users)) {
                    $chat->users()->attach($users);
                    collect($users)->each(
                        fn(int $userId) => event(new ChatCreated($chat, $userId))
                    );
                }
            }

            return response()->json(!!$chat);
        }));
    }

    /**
     * Display the specified resource.
     *
     * @param Chat $chat
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Chat $chat)
    {
        $this->authorize('show', $chat);

        return response()->json($chat);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ChatRequest $request
     * @param Chat $chat
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ChatRequest $request, Chat $chat)
    {
        return response()->json($chat->update($request->validated()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Chat $chat
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Chat $chat)
    {
        $this->authorize('delete', $chat);

        return response()->json(DB::transaction(function () use ($chat) {
            $chat->users()->detach();

            return $chat->delete();
        }));
    }
}
