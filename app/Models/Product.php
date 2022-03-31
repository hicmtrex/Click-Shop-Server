<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Product extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'products';

    protected $casts = [
        'images' => 'array',
        'sizes' => 'array',
        'color' => 'array',
    ];


    protected $fillable = [
        'name',
        'image',
        'images',
        'sizes',
        'color',
        'price',
        'rating',
        "description",
        "gender",
        "cateogry"

    ];
}
