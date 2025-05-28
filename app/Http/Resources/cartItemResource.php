<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class cartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->product_id,
            "cart_item_id" => $this->id,
            "category_id" => $this->product->category_id,
            "cart_id" => $this->cart_id,
            "category" => $this->product->category->name,
            "name" => $this->product->name,
            "amount" => $this->product->getPrice(),
            "brute_amount" => $this->product->amount,
            "quantity" => $this->amount,
        ];
    }
}
