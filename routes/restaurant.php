<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Restaurant Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Restaurant Auth
Route::group(['prefix' => 'rs-auth', 'namespace' => 'App\Http\Controllers\Api\Restaurant'], function () {
    // not requiring -> auth
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('reset-password', 'AuthController@resetPassword');
    Route::post('new-password', 'AuthController@newPassword');
    //require -> auth
    Route::group(['middleware' => 'auth:restaurant'], function () {
        Route::post('logout', 'AuthController@logout');
        Route::post('profile', 'AuthController@editProfile');
    });
});

Route::group(['namespace' => 'App\Http\Controllers\Api\Restaurant' , 'middleware' => 'auth:restaurant'], function () {
    Route::get('my-items','RestaurantController@myRestaurant');
    Route::post('add-products','RestaurantController@addProduct');
    Route::post('edit-products','RestaurantController@editProduct');
    Route::post('delete-products','RestaurantController@deleteProduct');

    Route::post('add-offer','OfferController@addOffer');
    Route::get('my-offers','OfferController@myOffers');
    Route::post('delete-offer','OfferController@deleteOffer');
    Route::post('edit-offer','OfferController@editOffer');


});
