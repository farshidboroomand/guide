<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix'     => 'auth',
    'namespace'  => 'V1\Authentication',
    'limit'      => 50,
    'expires'    => 1
], function () {
    Route::post('register', 'AuthenticationController@register');
    Route::get('verification/{verify_code}', 'AuthenticationController@verfification')
        ->name('account.verification');
});
