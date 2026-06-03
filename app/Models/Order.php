<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
     protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'country',
        'city',
        'address',
        'billing_address',
        'shipping_method',
        'payment_method',
        'total',
        'status'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
