<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use NumberFormatter;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ["name", "amount", "category_id"];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getPrice()
    {
        $numberFormatter = new NumberFormatter('pt-BR', NumberFormatter::CURRENCY);
        return $numberFormatter->formatCurrency($this->amount, 'BRL');
    }
}
