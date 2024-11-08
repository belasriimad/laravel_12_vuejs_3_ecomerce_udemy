<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display the list of orders
     */
    public function index()
    {
        $orders = Order::with(['products','user','coupon'])->latest()->get();
        return view('admin.orders.index')->with([
            'orders' => $orders
        ]);
    }

    /**
     * Update the orders delivered at date
     */
    public function updateDeliveredAtDate(Order $order)
    {
        $order->update([
            'delivered_at' => Carbon::now()
        ]);

        return redirect()->route('admin.orders.index')->with([
            'success' => 'Order updated successfully'
        ]);
    }

    /**
     * Delete orders
     */
    public function delete(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.orders.index')->with([
            'success' => 'Order deleted successfully'
        ]);
    }
}
