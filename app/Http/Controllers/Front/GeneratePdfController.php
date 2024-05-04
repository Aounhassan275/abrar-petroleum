<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\AccountCategory;
use App\Models\DebitCreditAccount;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class GeneratePdfController extends Controller
{
    
    public function generatePDF(Request $request)
    {
        $account_category = AccountCategory::find($request->account_category_id); 
        $sub_account_id = $request->sub_account ? $request->sub_account : '';
        $sub_account = DebitCreditAccount::find($request->sub_account); 
        if($request->start_date)
        {
            $start_date = Carbon::parse($request->start_date);
            $end_date = Carbon::parse($request->end_date);
        }else{
            $start_date = Carbon::now()->startOfMonth();
            $end_date = Carbon::today();
        }
        $user = User::find($request->user_id);
        return view('user.pdf.account-category',compact('start_date','user','end_date','account_category','sub_account','sub_account_id'));
   
    }
    public function generatePDFForProduct(Request $request)
    {
        $product = Product::find($request->product_id); 
        if($request->start_date)
        {
            $start_date = Carbon::parse($request->start_date);
            $end_date = Carbon::parse($request->end_date);
        }else{
            $start_date = Carbon::now()->startOfMonth();
            $end_date = Carbon::today();
        }
        $dateRange = CarbonPeriod::create($start_date, $end_date);
        $user = User::find($request->user_id);
        $dates = array_map(fn ($date) => $date->format('Y-m-d'), iterator_to_array($dateRange));
        $url = url('product/pdf?product_id='.$product->id.'&start_date='.$start_date->format('Y-m-d').'&end_date='.$end_date->format('Y-m-d').'&user_id='.$user->id);
        return view('user.pdf.product-ledger',compact('url','product','dates','start_date','end_date','user'));   
   
    }
}
