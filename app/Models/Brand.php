<?php

namespace App\Models;

use App\Models\Category;
use App\Models\MainCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'main_category_id',
        // 'category_id',
        'image'
    ];
    // public function mainCategory()
    // {
    //     return $this->belongsTo(MainCategory::class);
    // }
    // public function category()
    // {
    //     return $this->belongsTo(Category::class);
    // }

    public function mainCategory()
    {
        return $this->belongsTo(MainCategory::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
