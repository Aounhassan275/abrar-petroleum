<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerVehicle extends Model
{
    protected $fillable = [
        'name','reg_number','customer_id','debit_credit_account_id','user_id'
    ];
    public function debit_credit_account()
    {
        return $this->belongsTo(DebitCreditAccount::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
