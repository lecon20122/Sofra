<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    //works fine
    public function newOrder(Request $request)
    {

        try {
            DB::beginTransaction();
            $restaurant = Restaurant::find($request->restaurant_id);

            //check if the restaurant is open
            if ($restaurant->is_active = false) {
                return jsonResponse(0, "Restaurant Closed at the time , come back later");
            }
            // dd($request);
            $order = $request->user()->orders()->create([
                'restaurant_id' => $request->restaurant_id,
                'notes' => $request->notes,
                'state' => 'pending',
                'address' => $request->address,
                'payment_type_id' => $request->payment_type_id,
            ]);

            $cost = 0;
            $delivery_cost = $restaurant->delivery_fees;

            foreach ($request->items as $item) {

                $product = Product::find($item['product_id']);

                $readyProduct = [
                    $item['product_id'] => [
                        'qty' => $item['qty'],
                        'price' => $product->price,
                        'notes' => (isset($item['notes'])) ? $item['notes'] : '',
                    ],
                ]; //end ready products

                //attaching the order info to pivot table
                $order->products()->attach($readyProduct);
                //calculating the cost
                $cost += ($product->price * $item['qty']);
            }

            //minimum charge
            if ($cost >= $restaurant->min_order) {
                $total = $cost + $delivery_cost;
                $commission = settings('commission')->value * $cost;
                $net = $total - $commission;
                // updating the rest of the calculations
                $update = $order->update([
                    'total' => $total,
                    'cost' => $cost,
                    'delivery_fees' => $delivery_cost,
                    'commission' => $commission,
                    'net' => $net,
                ]);
            }
            $restaurant->notifications()->create([
                'title' => 'You Have a New Order',
                'content' => 'you have new order from '  . $request->user()->name . ' and Total Price is  ' . $total,
                'order_id' => $order->id,
            ]);
            DB::commit();
            return jsonResponse('1', 'Success', 'Order Placed Successfuly');
        } catch (\Exception $th) {
            return jsonResponse('0', 'Failed', 'Something wrong with thr Order');
        }
    }

    /**
     * Getting the current orders [accepted]
     *
     * @return \Illuminate\Http\Response
     */
    public function currentOrders()
    {
        try {
            $orders = auth()->user()->orders()->where('state', 'accepted')->get();
            return jsonResponse('1', 'Here the New Orders', $orders);
        } catch (\Throwable $th) {
            return jsonResponse('0', 'Failed');
        }
    }


    /**
     * Getting the Old orders [rejected and delivered]
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function oldOrders(Request $request)
    {
        try {
            $orders = auth()->user()->orders()->where(function ($query) {
                $query->where('state', 'rejected')
                    ->orWhere('state', 'delivered');
            })->get();
            return jsonResponse('1', 'Here the Old Orders', $orders);
        } catch (\Throwable $th) {
            return jsonResponse('0', 'Failed');
        }
    }

    /**
     * accepting the  orders by the client , updating the state to'acceptedByClient'
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function acceptOrder(Request $request){
        try {
            DB::beginTransaction();
            $order = $request->user()->orders()->where('state', 'accepted')->find($request->order_id);
            $restaurant = Restaurant::find($order->restaurant_id);
            $order->update([
                'state' => 'acceptedByClient',
            ]);
            $restaurant->notifications()->create([
                'title' => 'Your order has been accepted by the Client',
                'content' => 'Your order has been accepted by   ' . $order->client->name,
                'order_id' => $order->id,
            ]);
            DB::commit();
            return jsonResponse('1', 'Order has been accepted by the client');
        } catch (\Throwable $th) {
            DB::rollBack();
            return jsonResponse('0', 'this Order cannot be accepted');
        }
    }


    /**
     * rejecting the  orders by client , updating the state to'rejectedByClient'
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rejectOrder(Request $request){
        try {
            DB::beginTransaction();
            $order = $request->user()->orders()->where('state', 'accepted')->find($request->order_id);
            $restaurant = Restaurant::find($order->restaurant_id);
            $order->update([
                'state' => 'rejectedByClient',
            ]);
            $restaurant->notifications()->create([
                'title' => 'Your order has been rejected by the Client',
                'content' => 'Your order has been rejected  by ' . $order->client->name,
                'order_id' => $order->id,
            ]);
            DB::commit();
            return jsonResponse('1', 'Order has been accepted by the client');
        } catch (\Throwable $th) {
            DB::rollBack();
            return jsonResponse('0', 'this Order cannot be accepted');
        }
    }
}
