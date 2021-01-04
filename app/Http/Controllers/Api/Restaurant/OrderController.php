<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Getting the new orders [pending]
     *
     * @return \Illuminate\Http\Response
     * Getting all the Pendings Orders or the new one just made by clients
     */
    public function newOrders(Request $request)
    {
        try {
        $orders = auth()->user()->orders()->where('state', 'pending')->get();
        return jsonResponse('1', 'Here the New Orders', $orders);
        } catch (\Throwable $th) {
            return jsonResponse('0' , 'Failed');
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
                return jsonResponse('0' , 'Failed');
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
            $orders = auth()->user()->orders()->where(function($query){
                $query->where('state' , 'rejected')
                ->orWhere('state' , 'delivered');
            })->get();
            return jsonResponse('1', 'Here the Old Orders', $orders);

            } catch (\Throwable $th) {
                return jsonResponse('0' , 'Failed');
            }
    }

        /**
     * Getting the completed orders [accepted]
     *
     * @return \Illuminate\Http\Response
     */

    public function completedOrders()
    {
        try {
            $orders = auth()->user()->orders()->where('state', 'delivered')->get();
            return jsonResponse('1', 'Here the completed Orders', $orders);
            } catch (\Throwable $th) {
                return jsonResponse('0' , 'Failed');
            }
    }


    /**
     * accepting the new orders , updating the state to'accepted'
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function acceptOrder(Request $request)
    {
        try {
            DB::beginTransaction();
            $order = $request->user()->orders()->find($request->order_id);
            $client = Client::find($order->client_id);
            if($order->state = 'completed' || $order->state = 'delivered' ){
                return jsonResponse('0', 'The order cannot be accepted');
            }
            $order->update([
                'state' => 'accepted',
            ]);
            $client->notification()->create([
                'title' => 'Your order has been accepted',
                'content' => 'Your order has been accepted and Total Price is  ' . $order->total,
                'order_id' => $order->id,
            ]);
                DB::commit();
            return jsonResponse('1', 'Order has been accepted');
        } catch (\Throwable $th) {
            DB::rollBack();
            return jsonResponse('0', 'Failed');
        }

    }

    /**
     * rejecting the new orders , updating the state to'rejected'
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rejectOrder(Request $request)
    {
        try {
            DB::beginTransaction();
            $order = $request->user()->orders()->find($request->order_id);
            $client = Client::find($order->client_id);
            if($order->state = 'completed' || $order->state = 'delivered' ){
                return jsonResponse('0', 'This order cannot be rejected');
            }
            $order->update([
                'state' => 'rejected',
            ]);
            $client->notification()->create([
                'title' => 'Your order has been rejected',
                'content' => 'Your order has been rejected, you can check the customer serivce to know why',
                'order_id' => $order->id,
            ]);
                DB::commit();
            return jsonResponse('1', 'Order has been rejected');
        } catch (\Throwable $th) {
            DB::rollBack();
            return jsonResponse('0', 'Failed');
        }
    }

        /**
     * completing the current orders , updating the state to'delivered'
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function completeOrder(Request $request)
    {
        try {
            DB::beginTransaction();
            $order = $request->user()->orders()->where('state' , 'accepted')->find($request->order_id);
            $client = Client::find($order->client_id);
            $order->update([
                'state' => 'delivered',
            ]);
            $client->notification()->create([
                'title' => 'Your order has been delivered',
                'content' => 'Your order has been delivered, lets us know what you feel about it',
                'order_id' => $order->id,
            ]);
                DB::commit();
            return jsonResponse('1', 'Order has been completed');
        } catch (\Throwable $th) {
            DB::rollBack();
            return jsonResponse('0', 'Failed');
        }
    }
}
