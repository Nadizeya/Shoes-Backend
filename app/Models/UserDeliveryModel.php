<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDeliveryModel extends Model
{
    protected $fillable = [
        'phone',
        'address',
    ];
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }


}
