<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image_path',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
