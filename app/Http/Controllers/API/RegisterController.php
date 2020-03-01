<?php

namespace App\Http\Controllers\API;

use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\User;

/**
 * Class RegisterController
 * @package App\Http\Controllers\API
 */
class RegisterController extends Controller
{
    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $user = new User($request->data());

        $saved = $user->save();

        $saved && event(new UserRegistered);

        return response()->json($user->save());
    }
}
