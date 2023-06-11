<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LossGainTranscation extends Model
{
    protected $fillable = [
        'product_id','old_price','new_price','user_id','amount','qty','old_selling_price',
        'new_selling_price','date'
    ];
    protected $casts = [
        'date' => 'date',
    ];
    
}
