<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use NumberFormatter;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ["user_id", "responsible_id", "dependent_id"];

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
        return $this->hasMany(OrderItems::class);
    }

    public function getTotalValue()
    {
        $numberFormatter = new NumberFormatter('pt-BR', NumberFormatter::CURRENCY);
        return $numberFormatter->formatCurrency($this->items()->sum("price"), 'BRL');
    }

    public function getStatus() 
    {
        switch ($this->status) {
            case 'pending':
                return "pendente";
                break;
            
                case 'preparing':
                return "preparando";
                break;
                
                case 'prepared':
                return "pronto";
                break;

                case 'delivered':
                return "entregue";
                break;
            
            default:
                return "status desconhecido";
                break;
        }
    }
}
