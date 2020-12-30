<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class RestaurantController extends Controller
{
    // showing the products of the authenticated Restaurant
    public function myMenu()
    {
        try {
            DB::beginTransaction();
            $record = auth()->user()->products;
            return jsonResponse('1', 'Success', $record);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return jsonResponse('0', 'Failed', 'Nothing');
        }
    } //end myMenu

    //adding product to restaurant
    public function addProduct(Request $request)
    {
        try {
            DB::beginTransaction();
            $record = auth()->user()->products()->create($request->all());
            $record->image = addImage($request); //this function in the helper
            $record->save();
            DB::commit();
            return jsonResponse('1', 'Success', $record);
        } catch (\Exception $th) {
            DB::rollBack();
            return jsonResponse('0', 'Failed', 'Nothing');
        }
    }
    //edit product to restaurant
    public function editProduct(Request $request)
    {
        try {
            DB::beginTransaction();
            $record = auth()->user()->products()->findOrFail($request->id);
            $record->update($request->all());
            if ($request->hasFile('image')) {
                deleteImage($record->image);
                $record->delete($record->image);
                $record->image = addImage($request); //this function in the helper
                $record->save();
            }
            DB::commit();
            return jsonResponse('1', 'Success', $record);
        } catch (\Exception $th) {
            DB::rollBack();
            return jsonResponse('0', 'Failed', 'Nothing');
        }
    }

    public function deleteProduct(Request $request)
    {
        try {
            DB::beginTransaction();
            $record = Product::findOrFail($request->id);
            $img = $record->image;
            deleteImage($img);
            $record->delete();
            DB::commit();
            return jsonResponse('1', 'Success', $record);
        } catch (\Exception $th) {
            DB::rollBack();
            return jsonResponse('0', 'Failed', 'Nothing');
        }
    }

    public function reviews()
    {
        try {
            $record = auth()->user()->reviews;
            return jsonResponse('1', 'Success', $record);
        } catch (\Throwable $th) {
            return jsonResponse('0', 'Failed', 'Nothing');
        }
    }
}
