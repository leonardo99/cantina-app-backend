<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request) 
    {
        $cart = Order::when($request->status === "peding", function($order) {
            return $order->where("status", "pending");
        })
        ->when($request->status === "preparing", function($order) {
            return $order->where("status", "preparing");
        })
        ->when($request->status === "prepared", function($order) {
            return $order->where("status", "prepared");
        })
        ->when($request->status === "delivered", function($order) {
            return $order->where("status", "delivered");
        })
        ->paginate();
        return OrderResource::collection($cart);
    }
}
