<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthProfit extends Model
{
    protected $fillable = [
        'product_id', 'start_date','end_date','amount','user_id','type'
    ];
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
    public function product()
    {
        return $this->belongsTo('App\Models\Product','product_id');
    }
}
