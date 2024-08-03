<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierPurchase extends Model
{
    protected $fillable = [
        'price', 'qty','total_amount','status','product_id','supplier_id','supplier_vehicle_id',
        'supplier_terminal_id','access','date','debit_credit_account_id','access_total_amount',
        'shortage','shortage_total_amount'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function supplier()
    {
        return $this->belongsTo('App\Models\Suppliers','supplier_id');
    }
    public function product()
    {
        return $this->belongsTo('App\Models\Product','product_id');
    }
    public function terminal()
    {
        return $this->belongsTo('App\Models\SupplierTerminal','supplier_terminal_id');
    }
    public function vehicle()
    {
        return $this->belongsTo('App\Models\SupplierVehicle','supplier_vehicle_id');
    }
    public function debit_credit_account()
    {
        return $this->belongsTo('App\Models\DebitCreditAccount','debit_credit_account_id');
    }
}
