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
        'customer_id','vendor_id','supplier_id','user_id','expense_id','name','account_category_id',
        'employee_id','phone','address','designation','product_id','is_hide'
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
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
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
        return round($credit - $debit);
    }
    public function getExpenseDebitCredits($start_date,$end_date)
    {
        $month_profit = MonthProfit::where('type','Expense')->whereDate('end_date',$end_date)
                            ->where('user_id',Auth::user()->id)->sum('amount');
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
        if($month_profit > 0)
        {
            $total_amount = $credit - $debit;
            return round(abs($total_amount) - $month_profit);
        }else{
            return round($credit - $debit);
        }
    }
    public function getProductBalance($start_date,$end_date)
    {
        $product = Product::find($this->product_id);
        // $amountBalance = -(Auth::user()->getPurchasePrice($end_date,$product) * Auth::user()->getOpeningBalance($end_date,$product));
        // $amountBalance = $amountBalance + Auth::user()->getTodaySaleTotalAmount($end_date,$product);
        // $amountBalance = $amountBalance - Auth::user()->getTodayPurchaseTotalAmount($end_date,$product);
        // return round($amountBalance);

        $purchase = Purchase::where('user_id',Auth::user()->id)
            ->where('product_id',$this->product_id)
            ->whereBetween('date', [$start_date,$end_date])->sum('total_amount');
        $total_sale = Sale::where('user_id',Auth::user()->id)
            ->where('product_id',$this->product_id)
            ->where('type','!=','test')
            ->whereBetween('sale_date', [$start_date,$end_date])->sum('total_amount');
        $testSale = Sale::where('user_id',Auth::user()->id)
            ->where('product_id',$this->product_id)
            ->where('type','test')
            ->whereBetween('sale_date', [$start_date,$end_date])->sum('total_amount');
        $sale = $total_sale - $testSale;
        $amount = -(Auth::user()->getPurchasePrice($start_date,$product) * Auth::user()->getOpeningBalance($start_date,$product));
        // $month_profit = MonthProfit::where('product_id',$product->id)->whereDate('end_date',$end_date)
        //                     ->where('user_id',Auth::user()->id)->sum('amount');
        return round($amount + $sale - $purchase);
    }
}
