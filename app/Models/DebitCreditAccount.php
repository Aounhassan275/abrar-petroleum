<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\Expense;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DebitCreditAccount extends Model
{
    protected $fillable = [
        'customer_id','vendor_id','supplier_id','user_id','expense_id','name','account_category_id'
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
        return $this->belongsTo(Supplier::class,'supplier_id');
    }
    public function expense()
    {
        return $this->belongsTo(Expense::class,'expense_id');
    }
    public function accountCategory()
    {
        return $this->belongsTo(AccountCategory::class,'account_category_id');
    }
    
    public function debitCredits($start_date,$end_date)
    {
        $credit = DebitCredit::select('debit_credits.*','debit_credit_accounts.account_category_id as account_category_id')
            ->join('debit_credit_accounts', 'debit_credits.account_id', 'debit_credit_accounts.id')
            ->where('debit_credits.user_id',Auth::user()->id)
            ->where('debit_credit_accounts.id',$this->id)
            ->whereBetween('debit_credits.sale_date', [$start_date,$end_date])->sum('credit');
        $debit = DebitCredit::select('debit_credits.*','debit_credit_accounts.account_category_id as account_category_id')
            ->join('debit_credit_accounts', 'debit_credits.account_id', 'debit_credit_accounts.id')
            ->where('debit_credits.user_id',Auth::user()->id)
            ->where('debit_credit_accounts.id',$this->id)
            ->whereBetween('debit_credits.sale_date', [$start_date,$end_date])
            ->sum('debit');
        return $credit - $debit;
    }
}
