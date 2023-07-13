<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DebitCredit extends Model
{
    protected $fillable = [
        'account_id','product_id','qty','user_id','description','debit','credit','sale_date',
        'is_hide'
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
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
