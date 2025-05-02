<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
     protected $fillable = ['order_id', 'product_variation_id', 'quantity', 'price'];

    public function variation()
    {
        return $this->belongsTo(ProductVariation::class, 'product_variation_id');
    }
}
