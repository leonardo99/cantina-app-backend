<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;

class OrderAdminController extends Controller
{
    public function index(Request $request) 
    {
        $order = Order::with('items')->when($request->status === "pending", function($order) {
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

        return OrderResource::collection($order);
    }

    public function update(OrderRequest $request, Order $order)
    {
        try {
            $order->status = $request->status;
            $order->save();
            return new OrderResource($order);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } 
    }
}
