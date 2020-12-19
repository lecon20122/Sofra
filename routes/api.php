<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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



Route::get('settings','App\Http\Controllers\Api\MainController@settings');

Route::group(['prefix' => 'auth', ], function () {
    Route::post('register','App\Http\Controllers\Api\Auth\RestaurantController@register');
    Route::post('login','App\Http\Controllers\Api\Auth\RestaurantController@login');

    // Route::group(['middleware' => 'auth:restaurant'], function () {

    // });
    
});

