<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;

class OrderController extends Controller
{
    public function index() 
    {
        $cart = Order::paginate();
        return OrderResource::collection($cart);
    }
}
