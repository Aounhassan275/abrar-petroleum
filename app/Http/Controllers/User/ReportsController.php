<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AccountCategory;
use App\Models\DebitCredit;
use App\Models\DebitCreditAccount;
use App\Models\LossGainTranscation;
use App\Models\MonthProfit;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $inital_debit_credit = DebitCredit::where('user_id',Auth::user()->id)->whereNotNull('sale_date')->orderBy('sale_date','ASC')->first();
        $inital_start_date = $inital_debit_credit?Carbon::parse($inital_debit_credit->sale_date):Carbon::today();     
        if($request->end_date)
        {
            $start_date =  Carbon::parse($request->end_date)->firstOfMonth();  
            $end_date = Carbon::parse($request->end_date);
        }else{
            // $start_date = $inital_start_date;
            $last_debit_credit = DebitCredit::where('user_id',Auth::user()->id)->whereNotNull('sale_date')->orderBy('sale_date','DESC')->first();
            $start_date =  $last_debit_credit?Carbon::parse($last_debit_credit->sale_date)->firstOfMonth():Carbon::today()->firstOfMonth();  
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
        $query = Purchase::query()->where('user_id',Auth::user()->id);
        if($request->product_id)
            $query->where('product_id',$request->product_id);
        else
            $query->where('product_id',1);
        $purchases = $query->get();
        $lastPrice = 0;
        $purchasesRates = [];
        foreach($purchases as $purchase)
        {
            if($lastPrice != $purchase->price)
                $purchasesRates[] = $purchase;
            $lastPrice = $purchase->price;
        }
        $lossGainTranscationQuery = LossGainTranscation::query()
            ->where('user_id',Auth::user()->id)
            ->whereNotNull('date');
        if($request->product_id)
            $lossGainTranscationQuery->where('product_id',$request->product_id);
        else
            $lossGainTranscationQuery->where('product_id',1);
        $loss_gain_transactions = $lossGainTranscationQuery->get();
        $labelsArray = [];
        $expenseAmounts = [];
        foreach($expenseAccounts as $expense)
        {
            if(abs($expense->debitCredits($start_date,$end_date)) > 0)
            {

                array_push($labelsArray, $expense->name);
                array_push($expenseAmounts, abs($expense->debitCredits($start_date,$end_date)));
            }
        }
        $data['labels']      = "'".implode("', '", $labelsArray)."'";
        $data['expense_amounts']      = "'".implode("', '", $expenseAmounts)."'";
        // dd($data);
        // if($request->import_pdf && $active_tab == 'trail_balance')
        // {
        // return $this->trailPdf($products,$start_date,$end_date,$accounts,$expenseAccounts,$lastDayCash,$workingCaptial,$product_account_category_id,$test_sales,$inital_start_date,$whole_sales,$category_id);
        // }
        return view('user.reports.index',compact('data','active_tab','start_date','end_date','products','accounts','expenseAccounts','lastDayCash','workingCaptial','product_account_category_id','test_sales','inital_start_date','whole_sales','category_id','monthlyProfits','purchasesRates','loss_gain_transactions'));   
    }
    public function productAnalysis(Request $request)
    {
        $inital_debit_credit = DebitCredit::where('user_id',Auth::user()->id)->whereNotNull('sale_date')->orderBy('sale_date','ASC')->first();
        $inital_start_date = $inital_debit_credit?Carbon::parse($inital_debit_credit->sale_date):Carbon::today();     
        if($request->end_date)
        {
            $start_date =  Carbon::parse($request->end_date)->firstOfMonth();  
            $end_date = Carbon::parse($request->end_date);
        }else{
            // $start_date = $inital_start_date;
            $last_debit_credit = DebitCredit::where('user_id',Auth::user()->id)->whereNotNull('sale_date')->orderBy('sale_date','DESC')->first();
            $start_date =  $last_debit_credit?Carbon::parse($last_debit_credit->sale_date)->firstOfMonth():Carbon::today()->firstOfMonth();  
            $end_date = $last_debit_credit?Carbon::parse($last_debit_credit->sale_date):Carbon::today();
        } 
        $labelsArray = [];
        $sales = [];
        if($request->product_id)
        {
            $product = Product::find($request->product_id);
        }else{
            $product = Product::find(1);
        }
            
        $label = "Total Sales";
        array_push($labelsArray, $label);
        $total_sale = Sale::query()
                ->where('user_id',Auth::user()->id)
                ->where('product_id',$product->id)
                ->where('type','!=','test')
                ->whereBetween('sale_date',[$start_date,$end_date])
                ->sum('qty');
        $test_sale = Sale::query()
                ->where('user_id',Auth::user()->id)
                ->where('product_id',$product->id)
                ->where('type','test')
                ->whereBetween('sale_date',[$start_date,$end_date])
                ->sum('qty');
        $total_qty  = $total_sale - $test_sale;
        array_push($sales, $total_qty);
        $label = "Retail Sales";
        array_push($labelsArray, $label);
        $retail_sale = SaleDetail::query()
                ->where('user_id',Auth::user()->id)
                ->where('product_id',$product->id)
                ->whereBetween('sale_date',[$start_date,$end_date])
                ->sum('retail_sale');
        array_push($sales, $retail_sale);
        $label = "Supply Sales";
        array_push($labelsArray, $label);
        $supply_sale = SaleDetail::query()
                ->where('user_id',Auth::user()->id)
                ->where('product_id',$product->id)
                ->whereBetween('sale_date',[$start_date,$end_date])
                ->sum('supply_sale');
        array_push($sales, $supply_sale);
        $label = "Whole Sales";
        array_push($labelsArray, $label);
        $whole_sale = Sale::query()
                ->where('user_id',Auth::user()->id)
                ->where('product_id',$product->id)
                ->where('type','whole_sale')
                ->whereBetween('sale_date',[$start_date,$end_date])
                ->sum('qty');
        array_push($sales, $whole_sale);
        $data['labels']      = "'".implode("', '", $labelsArray)."'";
        $data['sales']      = "'".implode("', '", $sales)."'";
        return view('user.reports.product-analysis.index',compact('data','start_date','end_date','product'));   
    }
    public function supply(Request $request)
    {
        $inital_debit_credit = DebitCredit::where('user_id',Auth::user()->id)->whereNotNull('sale_date')->orderBy('sale_date','ASC')->first();
        $inital_start_date = $inital_debit_credit?Carbon::parse($inital_debit_credit->sale_date):Carbon::today();     
        if($request->end_date)
        {
            $start_date =  Carbon::parse($request->end_date)->firstOfMonth();  
            $end_date = Carbon::parse($request->end_date);
        }else{
            // $start_date = $inital_start_date;
            $last_debit_credit = DebitCredit::where('user_id',Auth::user()->id)->whereNotNull('sale_date')->orderBy('sale_date','DESC')->first();
            $start_date =  $last_debit_credit?Carbon::parse($last_debit_credit->sale_date)->firstOfMonth():Carbon::today()->firstOfMonth();  
            $end_date = $last_debit_credit?Carbon::parse($last_debit_credit->sale_date):Carbon::today();
        } 
        $labelsArray = [];
        $sales = [];
        if($request->product_id)
        {
            $product = Product::find($request->product_id);
        }else{
            $product = Product::find(1);
        }
        $supply_sale = SaleDetail::query()
                ->where('user_id',Auth::user()->id)
                ->where('product_id',$product->id)
                ->whereBetween('sale_date',[$start_date,$end_date])
                ->sum('supply_sale');
        $label = "Supply Sales in QTY : ".$supply_sale;
        array_push($labelsArray, $label);
        $retail_sales = Sale::query()
                ->where('user_id',Auth::user()->id)
                ->where('product_id',$product->id)
                ->where('type','retail_sale')
                ->whereBetween('sale_date',[$start_date,$end_date])
                ->sum('qty');
        if($retail_sales > 0)
        {
            $price = round($product->getClosingBalance($end_date) * Auth::user()->getPurchasePrice($end_date,$product));
            $totalAmount = $product->totalDrAmount($start_date,$end_date);
            if($totalAmount > 0)
            {
                $revenue = $price + abs($totalAmount);
            }else{
                $revenue = $price - abs($totalAmount);
            }
            $averageCost = $revenue/$retail_sales;
            $supplyRevenue = round($averageCost*$supply_sale,0);
            array_push($sales, $supplyRevenue);
        }else{
            array_push($sales, 0);
        }
        $whole_sale = Sale::query()
                ->where('user_id',Auth::user()->id)
                ->where('product_id',$product->id)
                ->where('type','whole_sale')
                ->whereBetween('sale_date',[$start_date,$end_date])
                ->sum('qty');
        $label = "Whole Sales in Qty :".$whole_sale;
        array_push($labelsArray, $label);
        $whole_sale_amount = Sale::query()
                ->where('user_id',Auth::user()->id)
                ->where('product_id',$product->id)
                ->where('type','whole_sale')
                ->whereBetween('sale_date',[$start_date,$end_date])
                ->sum('total_amount');
        array_push($sales, $whole_sale_amount);
        if($product->name == "HSD")
        {
            $label = "Expense Less HSD";
            array_push($labelsArray, $label);
            $account_id = DebitCreditAccount::where('name','Expense Less')->first()->id;
        }else{
            $label = "Expense Less PMG";
            array_push($labelsArray, $label);
            $account_id = DebitCreditAccount::where('name','Expense Less PMG')->first()->id;
        }
        $credit = DebitCredit::where('user_id',Auth::user()->id)
            ->where('account_id',$account_id)
            ->whereBetween('sale_date', [$start_date,$end_date])->sum('credit');
        $debit = DebitCredit::where('user_id',Auth::user()->id)
            ->where('account_id',$account_id)
            ->whereBetween('sale_date', [$start_date,$end_date])
            ->sum('debit');
        $totalExpense = $credit - $debit;
        array_push($sales, $totalExpense);
        $data['labels']      = "'".implode("', '", $labelsArray)."'";
        $data['sales']      = "'".implode("', '", $sales)."'";
        return view('user.reports.supply.index',compact('data','start_date','end_date','product'));   
    }
    public function postMonthPorfit($products,$start_date,$end_date)
    {
        $totalRevenue = 0;
        $new_date = $end_date;
        $newDateForMonthProfit = date('Y-m-d', strtotime($new_date . " +1 days"));
        foreach($products as $product)
        {
            $price = round($product->getClosingBalance($end_date) * Auth::user()->getPurchasePrice($end_date,$product));
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
                        ->whereDate('sale_date',$newDateForMonthProfit)->where('is_hide',1)->first();
        if($debit_credit)
        {
            if($totalExpense > 0)
            {
                $debit_credit->update([
                    'credit' => abs($totalExpense),
                    'debit' => 0,
                    'description' => "Profit of ".$end_date->format('F')." Month",
                ]);
            }else{
                $debit_credit->update([
                    'debit' => abs($totalExpense),
                    'credit' => 0,
                    'description' => "Loss of ".$end_date->format('F')." Month",
                ]);
            }
        }else{
            if($totalExpense > 0)
            {
                DebitCredit::create([
                    'account_id' => $month_profit_account_id,
                    'sale_date' => $newDateForMonthProfit,
                    'user_id' => Auth::user()->id,
                    'credit' => abs($totalExpense),
                    'is_hide' => true,
                    'description' => "Profit of ".$end_date->format('F')." Month",
                ]);
            }else{
                DebitCredit::create([
                    'account_id' => $month_profit_account_id,
                    'sale_date' => $newDateForMonthProfit,
                    'user_id' => Auth::user()->id,
                    'debit' => abs($totalExpense),
                    'is_hide' => true,
                    'description' => "Loss of ".$end_date->format('F')." Month",
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
    public function dayNightSale(Request $request)
    {
        $inital_sale_detail = SaleDetail::where('user_id',Auth::user()->id)->whereNotNull('sale_date')->orderBy('sale_date','ASC')->first();
        $inital_start_date = $inital_sale_detail?Carbon::parse($inital_sale_detail->sale_date):Carbon::today();     
        if($request->end_date)
        {
            $start_date =  Carbon::parse($request->end_date)->firstOfMonth();  
            $end_date = Carbon::parse($request->end_date);
        }else{
            // $start_date = $inital_start_date;
            $last_sale_detail = SaleDetail::where('user_id',Auth::user()->id)->whereNotNull('sale_date')->orderBy('sale_date','DESC')->first();
            $start_date =  $last_sale_detail?Carbon::parse($last_sale_detail->sale_date)->firstOfMonth():Carbon::today()->firstOfMonth();  
            $end_date = $last_sale_detail?Carbon::parse($last_sale_detail->sale_date):Carbon::today();
        } 
        $labelsArray = [];
        $sales = [];
        if($request->product_id)
        {
            $product = Product::find($request->product_id);
        }else{
            $product = Product::find(1);
        }
            
        $label = "Day Supply Sales";
        array_push($labelsArray, $label);
        $daySupplySales = SaleDetail::query()
                ->where('user_id',Auth::user()->id)
                ->where('product_id',$product->id)
                ->where('type','Day')
                ->whereBetween('sale_date',[$start_date,$end_date])
                ->sum('supply_sale');
        array_push($sales, $daySupplySales);
        $label = "Day Retail Sales";
        array_push($labelsArray, $label);
        $dayRetailSales = SaleDetail::query()
                ->where('user_id',Auth::user()->id)
                ->where('product_id',$product->id)
                ->where('type','Day')
                ->whereBetween('sale_date',[$start_date,$end_date])
                ->sum('retail_sale');
        array_push($sales, $dayRetailSales);
        $label = "Night Supply Sales";
        array_push($labelsArray, $label);
        $nightSupplySale = SaleDetail::query()
                ->where('user_id',Auth::user()->id)
                ->where('product_id',$product->id)
                ->where('type','Night')
                ->whereBetween('sale_date',[$start_date,$end_date])
                ->sum('supply_sale');
        array_push($sales, $nightSupplySale);
        $label = "Night Retail Sales";
        array_push($labelsArray, $label);
        $nightRetailSales = SaleDetail::query()
                ->where('user_id',Auth::user()->id)
                ->where('product_id',$product->id)
                ->where('type','Night')
                ->whereBetween('sale_date',[$start_date,$end_date])
                ->sum('retail_sale');
        array_push($sales, $nightRetailSales);
        $data['labels']      = "'".implode("', '", $labelsArray)."'";
        $data['sales']      = "'".implode("', '", $sales)."'";
        return view('user.reports.day-night-sale.index',compact('data','start_date','end_date','product'));   
    }
    public function excessAnalysis(Request $request)
    {
        $inital_purchase = Purchase::where('user_id',Auth::user()->id)->whereNotNull('date')->orderBy('date','ASC')->first();
        $inital_start_date = $inital_purchase?Carbon::parse($inital_purchase->date):Carbon::today();     
        if($request->end_date)
        {
            $start_date =  Carbon::parse($request->end_date)->firstOfMonth();  
            $end_date = Carbon::parse($request->end_date);
        }else{
            // $start_date = $inital_start_date;
            $last_purchase = Purchase::where('user_id',Auth::user()->id)->whereNotNull('date')->orderBy('date','DESC')->first();
            $start_date =  $last_purchase?Carbon::parse($last_purchase->date)->firstOfMonth():Carbon::today()->firstOfMonth();  
            $end_date = $last_purchase?Carbon::parse($last_purchase->date):Carbon::today();
        } 
        $labelsArray = [];
        $sales = [];
        if($request->product_id)
        {
            $product = Product::find($request->product_id);
        }else{
            $product = Product::find(1);
        }
            
        $label = "Total Purchases";
        array_push($labelsArray, $label);
        $totalPurchases = Purchase::query()
                ->where('user_id',Auth::user()->id)
                ->where('product_id',$product->id)
                ->whereBetween('date',[$start_date,$end_date])
                ->sum('qty');
        array_push($sales, $totalPurchases);
        $label = "Expected Excess";
        array_push($labelsArray, $label);
        $expectedAccess = $totalPurchases/ 5000 * 50;
        array_push($sales, $expectedAccess);
        $label = "Get Excess";
        array_push($labelsArray, $label);
        $haveAccess = Purchase::query()
                ->where('user_id',Auth::user()->id)
                ->where('product_id',$product->id)
                ->whereBetween('date',[$start_date,$end_date])
                ->sum('access');
        array_push($sales, $haveAccess);
        $data['labels']      = "'".implode("', '", $labelsArray)."'";
        $data['sales']      = "'".implode("', '", $sales)."'";
        return view('user.reports.excess-analysis.index',compact('data','start_date','end_date','product'));   
    }
    public function dipAnalysis(Request $request)
    {
        $inital_purchase = Purchase::where('user_id',Auth::user()->id)->whereNotNull('date')->orderBy('date','ASC')->first();
        $inital_start_date = $inital_purchase?Carbon::parse($inital_purchase->date):Carbon::today();     
        if($request->end_date)
        {
            $start_date =  Carbon::parse($request->end_date)->firstOfMonth();  
            $end_date = Carbon::parse($request->end_date);
        }else{
            // $start_date = $inital_start_date;
            $last_purchase = Purchase::where('user_id',Auth::user()->id)->whereNotNull('date')->orderBy('date','DESC')->first();
            $start_date =  $last_purchase?Carbon::parse($last_purchase->date)->firstOfMonth():Carbon::today()->firstOfMonth();  
            $end_date = $last_purchase?Carbon::parse($last_purchase->date):Carbon::today();
        } 
        $labelsArray = [];
        $sales = [];
        if($request->product_id)
        {
            $product = Product::find($request->product_id);
        }else{
            $product = Product::find(1);
        }
        $totalDips = Purchase::query()
                ->where('user_id',Auth::user()->id)
                ->where('product_id',$product->id)
                ->where('dip','!=',0)
                ->whereBetween('date',[$start_date,$end_date])->get();
        return view('user.reports.dip-analysis.index',compact('totalDips','start_date','end_date','product'));   
    }
    public function supplierAnalysis(Request $request)
    {
        $inital_debit_credit = DebitCredit::where('user_id',Auth::user()->id)->whereNotNull('sale_date')->orderBy('sale_date','ASC')->first();
        $inital_start_date = $inital_debit_credit?Carbon::parse($inital_debit_credit->sale_date):Carbon::today();     
        $last_debit_credit = DebitCredit::where('user_id',Auth::user()->id)->whereNotNull('sale_date')->orderBy('sale_date','DESC')->first();
        $end_date = $last_debit_credit?Carbon::parse($last_debit_credit->sale_date):Carbon::today();
        $products = Product::where('user_id',Auth::user()->id)->orWhereNull('user_id')->orderBy('display_order','ASC')->get();
        $account  = DebitCreditAccount::where('supplier_id',Supplier::first()->id)->first();
        $balance = $account->debitCredits($inital_start_date,$end_date);
        return view('user.reports.supplier-analysis.index',compact('products','balance'));   
    }
}
