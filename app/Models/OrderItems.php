<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    use HasFactory;

    protected $fillable = ["order_id", "product_id", "price", "amount"];

    public function items()
    {
        return $this->belongsTo(Product::class, "product_id", "id");
    }
}
