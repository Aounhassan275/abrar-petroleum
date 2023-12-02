<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSaleDetail extends Model
{
    protected $fillable = [
        'product_id', 'bulk', 'retail','total_sale','type','date','user_id'
    ];
}
