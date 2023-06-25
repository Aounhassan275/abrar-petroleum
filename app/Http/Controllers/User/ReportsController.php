<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AccountCategory;
use App\Models\DebitCredit;
use App\Models\DebitCreditAccount;
use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        if($request->start_date)
        {
            $start_date = Carbon::parse($request->start_date);
            $end_date = Carbon::parse($request->end_date);
        }else{
            $start_date = Carbon::now()->startOfMonth();
            $end_date = Carbon::today();
        }
        $inital_start_date = DebitCredit::where('user_id',Auth::user()->id)->first()->sale_date;
        $inital_start_date = $inital_start_date?Carbon::parse($inital_start_date):Carbon::today();
        $products = Product::where('user_id',Auth::user()->id)->orWhereNull('user_id')->orderBy('display_order','ASC')->get();
        $test_sales = Sale::where('user_id',Auth::user()->id)
            ->where('total_amount','>',0)
            ->where('type','test')
            ->whereBetween('sale_date', [$start_date,$end_date])->orderBy('sale_date','ASC')->get();
        $active_tab = $request->active_tab?$request->active_tab:'trail_balance';
        $product_account_category_id = AccountCategory::where('name','Products')->first()->id;
        $accounts = DebitCreditAccount::where('user_id',Auth::user()->id)->orWhereNull('user_id')
                        ->orderBy('account_category_id', 'ASC')->get();
        $category_id = AccountCategory::where('name','Expenses & Income')->first()->id;
        $cash_account_id = DebitCreditAccount::where('name','Cash in Hand')->first()->id;
        $lastDayCash = DebitCredit::where('account_id',$cash_account_id)->where('user_id',Auth::user()->id)->whereDate('sale_date',$end_date)->first();
        $working_captial_id = DebitCreditAccount::where('name','Working Capital')->first()->id;
        $workingCaptial = DebitCredit::where('account_id',$working_captial_id)->where('user_id',Auth::user()->id)->orderBy('sale_date','DESC')->first();
        $expenseAccounts = DebitCreditAccount::where('account_category_id',$category_id)->get();
        return view('user.reports.index',compact('active_tab','start_date','end_date','products','accounts','expenseAccounts','lastDayCash','workingCaptial','product_account_category_id','test_sales','inital_start_date'));   
    }
}
