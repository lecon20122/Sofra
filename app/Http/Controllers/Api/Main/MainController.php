<?php

namespace App\Http\Controllers\Api\Main;

use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResourse;
use App\Models\Category;
use App\Models\City;
use App\Models\ContactUs;
use App\Models\District;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\Setting;
use Illuminate\Http\Request;
use function GuzzleHttp\Promise\all;

class MainController extends Controller
{
    // Cities
    public function cities()
    {
        try {
            $record = City::all();
            return jsonResponse('1' , 'Success' , $record);
        }catch (\Exception $exception){
            return jsonResponse('0' , 'Failed' , 'Nothing');
        }
    }//end Cities


    // Districts
    public function districts()
    {
        try {
            $record = District::all();
            return jsonResponse('1' , 'Success' , $record);
        }catch (\Exception $exception){
            return jsonResponse('0' , 'Failed' , 'Nothing');
        }

        }//end Districts

        // Categories
    public function categories()
    {
        try {
            $record = Category::all(['name','parent_id']);
            return jsonResponse('1' , 'Success' , $record);
        }catch (\Exception $exception){
            return jsonResponse('0' , 'Failed' , 'Nothing');
        }
    }//end Categories

        //offers
        public function offers()
    {
        try {
            $record = Offer::all();
            return jsonResponse('1' , 'Success' , $record);
        }catch (\Exception $exception){
            return jsonResponse('0' , 'Failed' , 'Nothing');
        }
    }//end Offers


    //settings
    public function settings()
    {
        try {
            $record = Setting::all(['id','key','value']);
            return jsonResponse('1' , 'Success' , $record);
        }catch (\Exception $exception){
            return jsonResponse('0' , 'Failed');
        }
    }//end Settings

    // Restaurants
    public function restaurants()
    {
        try {
            $record = Restaurant::all();
            return jsonResponse('1' , 'Success' , $record);
        }catch (\Exception $exception){
            return jsonResponse('0' , 'Failed' , 'Nothing');
        }
    }//end Restaurants




    //Contact_us [ adding messege from users or restaurant]
    public function contactUs(Request $request)
    {
        try {
            $record = ContactUs::create($request->all());
            return jsonResponse('1' , 'Success' , $record);
        }catch (\Exception $exception){
            return jsonResponse('0' , 'Failed' , 'Nothing');
        }
    }//end contactUs

}//end Controller

