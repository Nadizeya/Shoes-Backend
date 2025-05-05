<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderUserAddress extends Model
{
    use HasFactory;

    protected $table = 'order_user_addresses'; // Specify the table name explicitly

    protected $fillable = [
        'username',
        'address',
        'phone',
    ];

    /**
     * Relationship with Orders
     * A user address can be associated with multiple orders.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'order_user_address_id');
    }
}
