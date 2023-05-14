<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dip extends Model
{
    protected $fillable = [
        'product_id','supplier_id','user_id','access','date'
    ];
    
    protected $casts = [
        'date' => 'date',
    ];
}
