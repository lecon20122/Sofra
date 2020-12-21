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


// Main Controllers //
Route::group(['namespace' => 'App\Http\Controllers\Api\Main'], function () {
    Route::get('settings', 'MainController@settings');
    Route::get('categories', 'MainController@categories');
    Route::get('districts', 'MainController@districts');
    Route::get('cities', 'MainController@districts');
    Route::get('restaurants', 'MainController@restaurants');
    Route::get('offers', 'MainController@offers');
    Route::post('contact-us', 'MainController@contactUs');
});
