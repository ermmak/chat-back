<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->namespace('API')->group(function () {
    Route::post('register', 'RegisterController@register');

    // Auth
    Route::prefix('auth')->group(function () {
        Route::post('login', 'AuthController@login');
        Route::get('user', 'AuthController@user')->middleware('auth:api');
        Route::post('logout', 'AuthController@logout')->middleware('auth:api');
    });

    Route::middleware('auth:api')->group(function () {
        Route::apiResource('chats', 'ChatController');
    });
});
