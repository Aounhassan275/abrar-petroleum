<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DebitCredit;
use App\Models\DebitCreditAccount;
use App\Models\Product;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DebitCreditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->date)
        {
            $date = Carbon::parse($request->date);
        }else{
            $date = Carbon::today();
        }
        $accounts = DebitCreditAccount::where('user_id',Auth::user()->id)->orWhereNull('user_id')->get();
        $products = Product::where('user_id',Auth::user()->id)->orWhereNull('user_id')->get();
        return view('user.debit_credit.index',compact('date','accounts','products'));
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
        try{
            // $totalDebit = 0;
            // $totalCredit = 0;
            foreach($request->account_id as $key => $account_id)
            {
                if($request->debit[$key] != null || $request->credit[$key] != null && $request->debit[$key] > 0 || $request->credit[$key] > 0)
                {    
                    // $totalDebit = $totalDebit + @$request->debit[$key];
                    // $totalCredit = $totalCredit + @$request->credit[$key];
                    DebitCredit::create([
                        'user_id' => Auth::user()->id,
                        'product_id' => @$request->product_id[$key],
                        'qty' => @$request->qty[$key],
                        'debit' => @$request->debit[$key],
                        'credit' => @$request->credit[$key],
                        'account_id' => $account_id,
                        'description' => @$request->description[$key],
                        'sale_date' => $request->sale_date,
                    ]);
                }
            }
            toastr()->success('Debit Credit Entry is Created Successfully');
            return redirect()->to(route('user.sale.index').'?active_tab=debit_credit&date='.$request->sale_date);
        }catch(Exception $e)
        {
            toastr()->error($e->getMessage());
            return redirect()->to(route('user.sale.index').'?active_tab=debit_credit&date='.$request->sale_date);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DebitCredit  $debitCredit
     * @return \Illuminate\Http\Response
     */
    public function show(DebitCredit $debitCredit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DebitCredit  $debitCredit
     * @return \Illuminate\Http\Response
     */
    public function edit(DebitCredit $debitCredit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DebitCredit  $debitCredit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        try{
            foreach($request->account_id as $key => $account_id)
            {
                if($request->debit_credit_id[$key])
                {
                    $debitCredit = DebitCredit::find($request->debit_credit_id[$key]);       
                    $debitCredit->update([
                        'user_id' => Auth::user()->id,
                        'product_id' => @$request->product_id[$key],
                        'qty' => @$request->qty[$key],
                        'debit' => @$request->debit[$key],
                        'credit' => @$request->credit[$key],
                        'account_id' => $account_id,
                        'description' => @$request->description[$key],
                        'sale_date' => $request->sale_date,
                    ]);
                }
                else
                {              
                    if($request->debit[$key] != null || $request->credit[$key] != null && $request->debit[$key] > 0 || $request->credit[$key] > 0)
                    {
                        DebitCredit::create([
                            'user_id' => Auth::user()->id,
                            'product_id' => @$request->product_id[$key],
                            'qty' => @$request->qty[$key],
                            'debit' => @$request->debit[$key],
                            'credit' => @$request->credit[$key],
                            'account_id' => $account_id,
                            'description' => @$request->description[$key],
                            'sale_date' => $request->sale_date,
                        ]);
                    }      
                }
            }
            toastr()->success('Debit Credit Entry is Created Successfully');
            return redirect()->to(route('user.sale.index').'?active_tab=debit_credit&date='.$request->sale_date);
        }catch(Exception $e)
        {
            toastr()->error($e->getMessage());
            return redirect()->to(route('user.sale.index').'?active_tab=debit_credit&date='.$request->sale_date);
        }
    }
    public function updateForm(Request $request)
    {
        try{
            // $totalDebit = 0;
            // $totalCredit = 0;
            foreach($request->account_id as $key => $account_id)
            {
                if($request->debit_credit_id[$key])
                {
                    $debitCredit = DebitCredit::find($request->debit_credit_id[$key]);       
                    $debitCredit->update([
                        'user_id' => Auth::user()->id,
                        'product_id' => @$request->product_id[$key],
                        'qty' => @$request->qty[$key],
                        'debit' => @$request->debit[$key],
                        'credit' => @$request->credit[$key],
                        'account_id' => $account_id,
                        'description' => @$request->description[$key],
                        'sale_date' => $request->sale_date,
                    ]);
                }
                else
                {              
                    if($request->debit[$key] != null || $request->credit[$key] != null && $request->debit[$key] > 0 || $request->credit[$key] > 0)
                    {
                        DebitCredit::create([
                            'user_id' => Auth::user()->id,
                            'product_id' => @$request->product_id[$key],
                            'qty' => @$request->qty[$key],
                            'debit' => @$request->debit[$key],
                            'credit' => @$request->credit[$key],
                            'account_id' => $account_id,
                            'description' => @$request->description[$key],
                            'sale_date' => $request->sale_date,
                        ]);
                    }      
                }
            }
            toastr()->success('Debit Credit Entry is Created Successfully');
            return redirect()->to(route('user.sale.index').'?active_tab=debit_credit&date='.$request->sale_date);
        }catch(Exception $e)
        {
            toastr()->error($e->getMessage());
            return redirect()->to(route('user.sale.index').'?active_tab=debit_credit&date='.$request->sale_date);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DebitCredit  $debitCredit
     * @return \Illuminate\Http\Response
     */
    public function destroy(DebitCredit $debitCredit)
    {
        //
    }
    public function getCreditFields(Request $request)
    {
        $key = $request->key;
        $accounts =   DebitCreditAccount::select('debit_credit_accounts.*')
                ->join('debit_credits', 'debit_credit_accounts.id', 'debit_credits.account_id')
                ->selectRaw('count(debit_credits.account_id) as accounts')
                ->where('debit_credit_accounts.user_id',Auth::user()->id)
                ->orWhereNull('debit_credit_accounts.user_id')
                ->groupBy('debit_credits.account_id')
                ->orderBy('accounts', 'DESC')->get();
        $products = Product::where('user_id',Auth::user()->id)->orWhereNull('user_id')->get();
        $html = view('user.sale.partials.debit_credit_fields', compact('key','accounts','products'))->render();
        return response([
            'html' => $html,
        ], 200);
    }
    public function getColor(Request $request)
    {
        $account = DebitCreditAccount::find($request->id);
        return response([
            'account_category' => @$account->accountCategory,
            'color' => @$account->accountCategory->color,
        ], 200);
    }
    public function calculateDebitCreditValues(Request $request)
    {
        
        $totalDebit = 0;
        $totalCredit = $request->last_day_cash?$request->last_day_cash:0;
        $cash_account_id = DebitCreditAccount::where('name','Cash in Hand')->first()->id;
        foreach($request->account_id as $key => $account_id)
        {
            if($account_id != $cash_account_id)
            {
                $totalDebit = $totalDebit + @$request->debit[$key];
                $totalCredit = $totalCredit + @$request->credit[$key];
            }
        } 
        $difference = $totalCredit - $totalDebit;
        return response([
            'totalDebit' => $totalDebit,
            'totalCredit' => $totalCredit,
            'difference' => $difference,
        ], 200);
    }
}
