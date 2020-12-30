<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\Setting;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function newOrder(Request $request)
    {
        $restaurant = Restaurant::find($request->restaurant_id);

        //check if the restaurant is open
        if ($restaurant->is_active = false) {
            return jsonResponse(0,"Restaurant Closed at the time , come back later");
        }

        $order = $request->user()->orders()->create([
            'restaurant_id' => $request->restaurant_id,
            'notes' => $request->notes,
            'state' => 'pending',
            'address' => $request->address,
            'type' => $request->restaurant_id,
        ]);

        $cost = 0;
        $delivery_cost = $restaurant->delivery_fees; 

        foreach ($request->products as $product) {
            $product = Product::find($product['product_id']);
            $readyProduct = [
                $product['product_id'] => [
                    'qty' => $product['qty'],
                    'price' => $product->price,
                    'notes' => (isset($product['notes'])) ? $product['notes'] : '' ,
                ],
            ];//end ready products

            //attaching the order info to pivot table
            $order->products()->attach($readyProduct);
            //calculating the cost
            $cost += ($restaurant->price * $product['qty']);
        }

        //minimum charge
        if ($cost >= $restaurant->min_order) {
            $total = $cost + $delivery_cost;
            $commission = settings()->commission * $cost ;
            $net = $total - settings()->commission;
            // updating the rest of the calculations
            $update = $order->update([
                'totoal' => $total,
                'cost' => $cost,
                'delivery_fees' => $delivery_cost,
                'commission' =>$commission,
                'net' => $net,
            ]);
        }
    }

    // public function pendings(Request $request)
    // {
    //     $pendings = $request->user()->orders()->where()
    // }
}
