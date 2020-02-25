<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class AuthController
 * @package App\Http\Controllers\API
 */
class AuthController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->validationData())) {
            return response()->json([
                'token' => Auth::user()->createToken('chat_client')->accessToken
            ]);
        }

        abort(401, 'incorrect_credentials');
    }

    /**
     * @param Request $request
     */
    public function logout(Request $request)
    {
        $request->user()->token()->delete();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user(Request $request)
    {
        return response()->json(['user' => $request->user()]);
    }
}
