<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Client Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Restaurant Auth
Route::group(['prefix' => 'cl-auth', 'namespace' => 'App\Http\Controllers\Api\Client'], function () {
    // not requiring -> auth
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('reset-password', 'AuthController@resetPassword');
    Route::post('new-password', 'AuthController@newPassword');
    //require -> auth
    Route::group(['middleware' => 'auth:client'], function () {
        Route::post('logout', 'AuthController@logout');
        Route::post('profile', 'AuthController@editProfile');
    });
});
