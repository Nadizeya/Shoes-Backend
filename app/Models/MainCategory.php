<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MainCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function brands()
    {
        return $this->hasMany(Brand::class);
    }
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
