<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;

class Order extends EloquentModel
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'orders';

    protected $casts = [
        'cartItems' => 'array',
        'shippingAddress' => 'array',
    ];

    protected $fillable = [
        "user_id",
        "user_name",
        "cartItems",
        "totalPrice",
        "shippingAddress",
        "is_paid"
    ];
}
