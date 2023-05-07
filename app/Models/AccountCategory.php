<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AccountCategory extends Model
{
    protected $fillable = [
        'name','color'
    ];
    public function debitCreditAccount()
    {
        return $this->hasMany(DebitCreditAccount::class);
    }
    public function debitCredits($start_date,$end_date,$sub_account)
    {
        if($sub_account)
        {
            return DebitCredit::select('debit_credits.*','debit_credit_accounts.account_category_id as account_category_id')
                ->join('debit_credit_accounts', 'debit_credits.account_id', 'debit_credit_accounts.id')
                ->where('debit_credits.user_id',Auth::user()->id)
                ->where('debit_credit_accounts.id',$sub_account)
                ->where('debit_credit_accounts.account_category_id',$this->id)
                ->whereBetween('debit_credits.sale_date', [$start_date,$end_date])
                ->orderBy('debit_credits.sale_date', 'asc')->get();
        }else{
            return DebitCredit::select('debit_credits.*','debit_credit_accounts.account_category_id as account_category_id')
                ->join('debit_credit_accounts', 'debit_credits.account_id', 'debit_credit_accounts.id')
                ->where('debit_credit_accounts.account_category_id',$this->id)
                ->where('debit_credits.user_id',Auth::user()->id)
                ->whereBetween('debit_credits.sale_date', [$start_date,$end_date])
                ->orderBy('debit_credits.sale_date', 'asc')->get();
        }
    }
}
