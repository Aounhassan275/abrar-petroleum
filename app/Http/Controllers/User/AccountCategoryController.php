<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AccountCategory;
use App\Models\DebitCreditAccount;
use App\Models\Product;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class AccountCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->end_date)
        {
            $end_date = Carbon::parse($request->end_date);
            $start_date = Carbon::parse($request->end_date)->startOfMonth();
        }else{
            $start_date = Carbon::now()->startOfMonth();
            $end_date = Carbon::today();
        }
        $dateRange = CarbonPeriod::create($start_date, $end_date);
        $dates = array_map(fn ($date) => $date->format('Y-m-d'), iterator_to_array($dateRange));
        $petrol = Product::where('name','PMG')->first();
        $active_tab = $request->active_tab?$request->active_tab:1;
        $sub_account = $request->sub_account?$request->sub_account:'';
        $url = url('user/account_category/pdf?sub_account='.$sub_account.'&type='.$request->type.'&account_category_id='.$active_tab.'&start_date='.$start_date->format('Y-m-d').'&end_date='.$end_date->format('Y-m-d'));
        return view('user.account_category.index',compact('active_tab','start_date','end_date','sub_account','dates','petrol','url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AccountCategory  $accountCategory
     * @return \Illuminate\Http\Response
     */
    public function show(AccountCategory $accountCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AccountCategory  $accountCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(AccountCategory $accountCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AccountCategory  $accountCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AccountCategory $accountCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AccountCategory  $accountCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccountCategory $accountCategory)
    {
        //
    }
    
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
        return view('user.pdf.account-category',compact('start_date','end_date','account_category','sub_account','sub_account_id'));
   
    }
}
