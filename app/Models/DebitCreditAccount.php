<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\Expense;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Model;

class DebitCreditAccount extends Model
{
    protected $fillable = [
        'customer_id','vendor_id','supplier_id','user_id','expense_id','name'
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }
    public function vendor()
    {
        return $this->belongsTo(Vendor::class,'vendor_id');
    }
    public function supplier()
    {
        return $this->belongsTo(User::class,'supplier_id');
    }
    public function expense()
    {
        return $this->belongsTo(Expense::class,'expense_id');
    }
}
