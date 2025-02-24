<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use ErrorException;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class OrderController extends Controller
{
    /***
     * Store user orders
     */
    public function storeUserOrders(Request $request) 
    {
        foreach($request->cartItems as $item) {
            $order = Order::create([
                'qty' => $item['qty'],
                'user_id' => $request->user()->id,
                'coupon_id' => $item['coupon_id'],
                'total' => $this->calculateEachOrderTotal($item['qty'],$item['price'],$item['coupon_id']),
            ]);
            $order->products()->attach($item['product_id']);
        }
        return response()->json([
            'user' => UserResource::make($request->user())
        ]);
    }

    /**
     * Calculate each order total
     */
    public function calculateEachOrderTotal($qty,$price,$coupon_id)
    {
        $discount = 0;
        $total = $price * $qty;
        $coupon = Coupon::find($coupon_id);

        if($coupon && $coupon->checkIfValid()) {
            $discount = $total * $coupon->discount / 100;
        }

        return $total - $discount;
    }

    /***
     * Pay orders
     */
    public function payOrdersByStripe(Request $request)
    {
        Stripe::setApiKey("YOUR STRIPE SECRET KEY HERE");

        try {
            $checkout_session = Session::create([
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Vue T-shirt Store'
                        ],
                        'unit_amount' => $this->calculateTotalToPay($request->cartItems)
                    ],
                    'quantity' => 1
                ]],
                'mode' => 'payment',
                'success_url' => $request->success_url
            ]);
            //return the link to the stripe checkout form
            return response()->json([
                'url' => $checkout_session->url
            ]);
        } catch (ErrorException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Calculate the total to pay
     */
    public function calculateTotalToPay($items)
    {
        $total = 0;
        foreach ($items as $item) {
            $total += $this->calculateEachOrderTotal($item['qty'],$item['price'],$item['coupon_id']);
        }
        return $total * 100;
    }
}
