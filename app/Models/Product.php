<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'sku',
        'category_id',
        'price',
        'discount_price',
        'vat_percentage',
        'stock_quantity',
        'status',
    ];
}
