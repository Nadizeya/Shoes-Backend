<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariationVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_variation_id',
        'video_path',
    ];

    // Each video belongs to a single variation
    public function variation()
    {
        return $this->belongsTo(ProductVariation::class, 'product_variation_id');
    }
}
