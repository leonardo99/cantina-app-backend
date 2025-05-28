<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsible extends Model
{
    use HasFactory;

    protected $fillable = ["user_id"];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function dependets() {
        return $this->hasMany(Dependent::class);
    }

    public function cart() {
        return $this->hasOne(Cart::class);
    }
}
