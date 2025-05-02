<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\MainCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'main_category_id'
    ];

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }
    // public function mainCategory()
    // {
    //     return $this->belongsTo(MainCategory::class);
    // }

    public function mainCategory()
    {
        return $this->belongsTo(MainCategory::class);
    }

    public function brands()
    {
        return $this->hasMany(Brand::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
