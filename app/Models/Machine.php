<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    protected $fillable = [
        'meter_reading','boot_number','product_id','user_id'
    ];
    public function site()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
    public function getSale($date)
    {
        $sale = Sale::where('machine_id',$this->id)->whereDate('sale_date',$date)->first();
        return $sale;
    }
}
