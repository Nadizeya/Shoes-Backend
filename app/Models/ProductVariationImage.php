<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariationImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_variation_id',
        'image_path',
    ];

    // Each image belongs to a single variation
    public function variation()
    {
        return $this->belongsTo(ProductVariation::class, 'product_variation_id');
    }
}
