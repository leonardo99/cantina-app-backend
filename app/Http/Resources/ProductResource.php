<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Ramsey\Uuid\Type\Decimal;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
           "id" => $this->id,
            "category_id" => $this->category_id,
            "category" => $this->category->name,
            "name" => $this->name,
            "amount" => $this->getPrice(),
            "brute_amount" => $this->amount,
            "quantity" => 1,
        ];
    }
}
