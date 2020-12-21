<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function myMenu()
    {
        try {
            $record = auth()->user()->products;
            return jsonResponse('1' , 'Success' , $record);
        }catch (\Exception $exception){
            return jsonResponse('0' , 'Failed' , 'Nothing');
        }
    }//end myRestaurant

    public function addProduct(Request $request)
    {
        // try {
            $record = auth()->user()->products()->create($request->all());
            $record->image = addImage($request->image); //this function in the helper
            $record->save();
            return jsonResponse('1' , 'Success' , $record);
        // } catch (\Exception $th) {
        //     return jsonResponse('0' , 'Failed' , 'Nothing');

        // }
    }
}
