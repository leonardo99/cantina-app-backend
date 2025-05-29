<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dependent extends Model
{
    use HasFactory;

    protected $fillable = ["responsible_id", "user_id"];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function responsible() {
        return $this->belongsTo(Responsible::class, 'responsible_id', 'id');
    }
}
