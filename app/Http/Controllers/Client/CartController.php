<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\cartItemResource;
use App\Http\Resources\CartResource;
use App\Http\Resources\ProductResource;
use App\Models\Cart;
use App\Models\CartItems;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index() 
    {
        $user = auth()->id();
        $cart = Cart::with('items')->where('user_id', $user)->get()->first();

        if($cart && $cart->items) {
            return cartItemResource::collection($cart->items);
        }
        return response()->json(["data" => []], 200);
    }

    public function store(Request $request)
    {
        try {
            $user = auth()->id();
            $cart = Cart::firstOrCreate(['user_id' => $user]);
            $product = Product::find($request->id);

            if($cart && $product) {
                $saveProduct = $cart->items()->updateOrCreate(
                    ["product_id" => $product->id],
                    [
                    "price" => $product->amount,
                    "amount" => $request->quantity,
                    ]
                );
                if(!$saveProduct) {
                    return response()->json(['error' => 'Ocorreu um erro ao tentar adicionar o item ao carrinho'], 500);
                }

                return new cartItemResource($saveProduct);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } 
    }

    public function show(CartItems $cartItem)
    {
        try {
            return new cartItemResource($cartItem);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } 
    }

    public function destroy(Cart $cart, CartItems $item)
    {
        try {
            if($cart->items->count() === 0) {
                $cart->delete();
                return response()->json([], 204);
            }

            $userCart = $cart->where('user_id', auth()->id())->get()->first();

            if($userCart->items->where("id", $item->id)->count()) {
                $deleteItem = $item->delete();
            }

            if(!$deleteItem) {
                    return response()->json(['error' => 'Ocorreu um erro ao tentar remover o item do carrinho'], 500);
            }

            return response()->json(["data" => "Item removido"], 200);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } 
    }
}
