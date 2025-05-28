<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ["user_id", "responsible_id". "dependent_id"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function responsible()
    {
        return $this->belongsTo(Responsible::class);
    }

    public function dependent()
    {
        return $this->belongsTo(Dependent::class);
    }

    public function items()
    {
        return $this->hasMany(CartItems::class);
    }
}
