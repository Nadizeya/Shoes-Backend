<?php

namespace App\Models;

use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\ProductImage;
use App\Models\ProductVideo;
use App\Models\ProductVariation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
         'short_description',
          'description',
           'category_id',
            'brand_id',
            'image',
            'quantity',
            'original_price',
            'is_discount',
            'discount_percent',
            'discount_price',
            'is_recommend',
            'sell_qty',
            'stock_qty',



    ];
     public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function videos()
    {
        return $this->hasMany(ProductVideo::class);
    }
    public function whitelistedByUsers()
{
    return $this->belongsToMany(User::class, 'user_product_whitelist', 'product_id', 'user_id');

}
}
