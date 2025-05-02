<?php

namespace App\Models;

use App\Models\User;
use App\Models\OrderItem;
use App\Models\Transactions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'total_price', 'status','order_code','total_product',        'order_user_address_id',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function user()
   {
    return $this->belongsTo(User::class);
  }
    public function userAddress()
    {
        return $this->belongsTo(OrderUserAddress::class, 'order_user_address_id');
    }
  public function transaction()
{
    return $this->hasOne(Transactions::class);
}
}
