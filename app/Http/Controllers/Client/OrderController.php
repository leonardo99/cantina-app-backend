<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index() 
    {
        $cart = Order::where('user_id', auth()->id())->get();
        return OrderResource::collection($cart);
    }

    public function store(Request $request)
    {
        try {
            /** @var \App\Models\User $user */
            $user = auth()->user();
            DB::transaction(function() use($request, $user) {
                $saveOrder = $user->orders()->create(['status' => 'pending']); 
                $saveOrder->items()->createMany($request->all());
                $user->cart->delete();
                return new OrderResource($saveOrder->with('items'));
            });
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
