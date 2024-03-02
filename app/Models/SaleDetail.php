<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    protected $fillable = [
        'supply_sale', 
        'retail_sale',
        'total_sale',
        'product_id',
        'supplier_id',
        'user_id',
        'sale_date'
    ];
}
