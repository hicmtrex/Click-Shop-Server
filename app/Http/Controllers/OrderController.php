<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Order::all();
    }

    public function user_orders()
    {
        $user = Auth::user();

        $orders = Order::all()->where('user_id', $user->_id);

        return response($orders, 200);
    }


    public function pay_order(Request $request, $id)
    {
        $order =  Order::find($id);

        $order->is_paid = $request->is_paid;
        $order->save();

        return response("Order has been paid with success");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response("user does not exist", 500);
        }
        $order = new Order();

        $order->user_id = $user->id;
        $order->user_name = $user->name;
        $order->cartItems = $request->cartItems;
        $order->shippingAddress = $request->shippingAddress;
        $order->totalPrice = $request->totalPrice;
        $order->is_paid = false;

        $order->save();

        return response($order, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order =  Order::find($id);

        return $order;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function userOrder_destory($id)
    {
        $order = Order::find($id);
        $user = Auth::user();
        if ($order->user_id === $user->_id) {
            Order::destroy($id);
            return response('order has been deleted', 200);
        } else {
            return response("you don't have access!", 400);
        }
    }

    public function destroy($id)
    {
        Order::destroy($id);
        return "order deleted";
    }

    public function user_order(Request $request, $id)
    {
        // $orders = Order::find();
    }
}
