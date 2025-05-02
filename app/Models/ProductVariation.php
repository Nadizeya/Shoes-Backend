<?php
namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    protected $fillable = [
        'product_id',
        'size',
        'color',
        'quantity',
        'price',
        'stock_qty',
        'sell_qty'
        // 'variation_name', // if you want an extra name field
    ];

    // A variation belongs to one product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // A variation can have multiple images
    public function images()
    {
        return $this->hasMany(ProductVariationImage::class, 'product_variation_id');
    }

    // A variation can have multiple videos
    public function videos()
    {
        return $this->hasMany(ProductVariationVideo::class, 'product_variation_id');
    }
      public function whitelistedByUsers()
{
    return $this->belongsToMany(User::class, 'wishlist', 'product_variation_id', 'user_id');

}
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_variation_id');
    }

}
