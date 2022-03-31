<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StripeController extends Controller
{

    public function get_session($id)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_API_KEY'));
        $order =  Order::find($id);
        $price = $order->totalPrice;
        $price = $price * 100;
        $checkout = $stripe->checkout->sessions->create([
            'success_url' => "http://localhost:8000/api/pay/" . $order->_id,
            'cancel_url' => "http://localhost:3000",
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'unit_amount' => $price,
                        'product_data' => [
                            'name' => $order->user_name
                        ]
                    ],
                    'quantity' => 1,
                ]
            ],
            'mode' => 'payment',
        ]);
        return $checkout;
    }

    public function pay($id)
    {

        $order = Order::find($id);
        
        if ($order) {
            $order->is_paid = true;
            $order->save();
            return  redirect('http://localhost:3000/auth/profile');
        }
    }

    public function webhook(Request $request)
    {

        Log::info("webhook");

        if ($request->type == 'checkout.session.completed') {

            return response('gg');
        }

        return response()->json(['status' => "success"]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
