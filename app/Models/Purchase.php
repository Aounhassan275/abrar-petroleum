<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'price', 'qty','total_amount','status','product_id','vendor_id','supplier_id',
        'user_id','vendor_terminal_id','access','date','access_total_amount','dip'
    ];
    protected $casts = [
        'date' => 'date',
    ];
    public function payments()
    {
        return $this->hasMany('App\Models\PurchasePayment','purchase_id');
    }
    public function site()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier','supplier_id');
    }
    public function product()
    {
        return $this->belongsTo('App\Models\Product','product_id');
    }
    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor','vendor_id');
    }
    public function terminal()
    {
        return $this->belongsTo('App\Models\VendorTerminal','vendor_terminal_id');
    }
}
