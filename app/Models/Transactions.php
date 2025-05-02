<?php

namespace App\Models;

use App\Models\Bank;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transactions extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'account_id',
        'payment_screenshot',
        'total_price',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // public function bank()
    // {
    //     return $this->belongsTo(Bank::class);
    // }
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
