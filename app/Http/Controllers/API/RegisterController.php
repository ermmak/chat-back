<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\User;
use Illuminate\Http\Request;

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

        return response()->json($user->save());
    }
}
