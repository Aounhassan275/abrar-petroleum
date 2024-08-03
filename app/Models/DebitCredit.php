<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DebitCredit extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'account_id','product_id','qty','user_id','description','debit','credit','sale_date',
        'is_hide','customer_vehicle_id','purchase_id','display_order','site_id','supplier_id',
        'debit_credit_id','supplier_purchase_id','supplier_validation','site_validation'
    ];
    protected $casts = [
        'sale_date' => 'date',
    ];
    public function account()
    {
        return $this->belongsTo(DebitCreditAccount::class,'account_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function site()
    {
        return $this->belongsTo(User::class,'site_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
