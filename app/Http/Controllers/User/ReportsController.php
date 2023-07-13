<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AccountCategory;
use App\Models\DebitCredit;
use App\Models\DebitCreditAccount;
use App\Models\MonthProfit;
use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $inital_debit_credit = DebitCredit::where('user_id',Auth::user()->id)->whereNotNull('sale_date')->orderBy('sale_date','ASC')->first();
        $inital_start_date = $inital_debit_credit?Carbon::parse($inital_debit_credit->sale_date):Carbon::today();     
        if($request->start_date)
        {
            $start_date = Carbon::parse($request->start_date);
            $end_date = Carbon::parse($request->end_date);
        }else{
            $start_date = $inital_start_date;
            $last_debit_credit = DebitCredit::where('user_id',Auth::user()->id)->whereNotNull('sale_date')->orderBy('sale_date','DESC')->first();
            $end_date = $last_debit_credit?Carbon::parse($last_debit_credit->sale_date):Carbon::today();
        } 
        $products = Product::where('user_id',Auth::user()->id)->orWhereNull('user_id')->orderBy('display_order','ASC')->get();
        if($request->testing_product)
        {
            $testing_product = Product::where('name',$request->testing_product)->first();
            $test_sales = Sale::where('user_id',Auth::user()->id)
                ->where('total_amount','>',0)
                ->where('type','test')
                ->where('product_id',$testing_product->id)
                ->whereBetween('sale_date', [$start_date,$end_date])->orderBy('sale_date','ASC')->get();
            $whole_sales = Sale::where('user_id',Auth::user()->id)
                    ->where('total_amount','>',0)
                    ->where('type','whole_sale')
                    ->where('product_id',$testing_product->id)
                    ->whereBetween('sale_date', [$start_date,$end_date])->orderBy('sale_date','ASC')->get();
        }else{
            $test_sales = Sale::where('user_id',Auth::user()->id)
                        ->where('total_amount','>',0)
                        ->where('type','test')
                        ->whereBetween('sale_date', [$start_date,$end_date])->orderBy('sale_date','ASC')->get();
       
            $whole_sales = Sale::where('user_id',Auth::user()->id)
                        ->where('total_amount','>',0)
                        ->where('type','whole_sale')
                        ->whereBetween('sale_date', [$start_date,$end_date])->orderBy('sale_date','ASC')->get();
        }
        
        $monthlyProfits = MonthProfit::whereBetween('end_date', [$start_date,$end_date])
                    ->where('user_id',Auth::user()->id)->get();
        if($request->post_month_profit)
        {
            $this->postMonthPorfit($products,$start_date,$end_date);
        }
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
        // if($request->import_pdf && $active_tab == 'trail_balance')
        // {
        // return $this->trailPdf($products,$start_date,$end_date,$accounts,$expenseAccounts,$lastDayCash,$workingCaptial,$product_account_category_id,$test_sales,$inital_start_date,$whole_sales,$category_id);
        // }
        return view('user.reports.index',compact('active_tab','start_date','end_date','products','accounts','expenseAccounts','lastDayCash','workingCaptial','product_account_category_id','test_sales','inital_start_date','whole_sales','category_id','monthlyProfits'));   
    }
    public function postMonthPorfit($products,$start_date,$end_date)
    {
        $totalRevenue = 0;
        foreach($products as $product)
        {
            $price = round($product->getClosingBalance($end_date) * $product->purchasing_price);
            $totalAmount = $product->totalDrAmount($start_date,$end_date);
            if($totalAmount > 0)
            {
                $revenue = $price + abs($totalAmount);
            }else{
                $revenue = $price - abs($totalAmount);
            }
            $totalRevenue += abs($revenue);
            $month_profit = MonthProfit::where('product_id',$product->id)->whereDate('end_date',$end_date)
                                ->where('user_id',Auth::user()->id)->first();
            if($month_profit)
            {
                $month_profit->update([
                    'amount' => $revenue,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                ]);
            }else{
                MonthProfit::create([
                    'user_id' => Auth::user()->id,
                    'product_id' => $product->id,
                    'amount' => $revenue,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'type' => 'Product Revenue',
                ]);
            }
        }
        $expense_amount = abs(Auth::user()->totalExpense($start_date,$end_date));
        $totalExpense = $totalRevenue - $expense_amount;
        
        $month_profit_account_id = DebitCreditAccount::where('name','Month Profit')->first()->id;
        $debit_credit = DebitCredit::where('user_id',Auth::user()->id)->where('account_id',$month_profit_account_id)
                        ->whereDate('sale_date',$end_date)->where('is_hide',1)->first();
        if($debit_credit)
        {
            if($totalExpense > 0)
            {
                $debit_credit->update([
                    'credit' => $totalExpense
                ]);
            }else{
                $debit_credit->update([
                    'debit' => $totalExpense
                ]);
            }
        }else{
            if($totalExpense > 0)
            {
                DebitCredit::create([
                    'account_id' => $month_profit_account_id,
                    'sale_date' => $end_date,
                    'user_id' => Auth::user()->id,
                    'credit' => $totalExpense,
                    'is_hide' => true,
                ]);
            }else{
                DebitCredit::create([
                    'account_id' => $month_profit_account_id,
                    'sale_date' => $end_date,
                    'user_id' => Auth::user()->id,
                    'debit' => $totalExpense,
                    'is_hide' => true,
                ]);
            }
        }
        $month_profit = MonthProfit::where('type','Expense')->whereDate('end_date',$end_date)
                            ->where('user_id',Auth::user()->id)->first();
        if($month_profit)
        {
            $month_profit->update([
                'amount' => $expense_amount,
                'start_date' => $start_date,
                'end_date' => $end_date,
            ]);
        }else{
            if($expense_amount > 0)
            {
                MonthProfit::create([
                    'user_id' => Auth::user()->id,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'type' => 'Expense',
                    'amount' => $expense_amount,
                ]);
                
            }
        }
    }
    public function trailPdf($products,$start_date,$end_date,$accounts,$expenseAccounts,$lastDayCash,$workingCaptial,$product_account_category_id,$test_sales,$inital_start_date,$whole_sales,$category_id)
    {
        // $pdf = PDF::loadView('user.pdf.trail_balance', [
        //     'products' => $products,
        //     'start_date' =>$start_date,
        //     'end_date' =>$end_date,
        //     'accounts' =>$accounts,
        //     'expenseAccounts' =>$expenseAccounts,
        //     'lastDayCash' =>$lastDayCash,
        //     'workingCaptial' =>$workingCaptial,
        //     'product_account_category_id' =>$product_account_category_id,
        //     'test_sales' =>$test_sales,
        //     'inital_start_date' =>$inital_start_date,
        //     'whole_sales' =>$whole_sales,
        //     'category_id' =>$category_id,
        // ]);
        // // dd($pdf);
        // return $pdf->download('sample.pdf');
    }
}
