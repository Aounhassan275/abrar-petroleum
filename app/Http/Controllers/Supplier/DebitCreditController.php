<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Http\Requests\DebitCreditStoreRequest;
use App\Models\CustomerVehicle;
use App\Models\DebitCredit;
use App\Models\DebitCreditAccount;
use App\Models\Product;
use App\Models\Purchase;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DebitCreditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
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
    public function store(DebitCreditStoreRequest $request)
    {
        try{
            // $totalDebit = 0;
            // $totalCredit = 0;
            $totalEmptyAccount = 0;
            $missingText = '';
            foreach($request->account_id as $key => $account_id)
            {
                if($account_id && $account_id != null && $account_id != 0){
                    if($account_id == 42)
                    {
                        if(DebitCredit::where('supplier_id',Auth::user()->id)->where('account_id',$account_id)->whereDate('sale_date',$request->sale_date)->count() == 0)
                        {
                            $debitCreditAccount = DebitCreditAccount::find($account_id);
                            DebitCredit::create([
                                'supplier_id' => Auth::user()->id,
                                'site_id' => $debitCreditAccount->site_id,
                                'product_id' => @$request->product_id[$key],
                                'qty' => @$request->qty[$key],
                                'debit' => @$request->debit[$key],
                                'credit' => @$request->credit[$key],
                                'account_id' => $account_id,
                                'description' => @$request->description[$key],
                                'sale_date' => $request->sale_date,
                                'display_order' => $key + 1,
                            ]);
                        }
                    }else{
                        if(DebitCredit::where('supplier_id',Auth::user()->id)->where('account_id',$account_id)->whereDate('sale_date',$request->sale_date)->count() == 0)
                        {
                            $debitCreditAccount = DebitCreditAccount::find($account_id);
                            if($request->debit[$key] != null || $request->credit[$key] != null && $request->debit[$key] > 0 || $request->credit[$key] > 0)
                            {    
                                // $totalDebit = $totalDebit + @$request->debit[$key];
                                // $totalCredit = $totalCredit + @$request->credit[$key];
                                if(@$request->vehicle_id[$key] && is_numeric($request->vehicle_id[$key]))
                                {
                                    $vehicle_id = $request->vehicle_id[$key];
                                } else{
                                    $vehicle_id = null;
                                }
                                DebitCredit::create([
                                    'supplier_id' => Auth::user()->id,
                                    'site_id' => $debitCreditAccount->site_id,
                                    'product_id' => @$request->product_id[$key],
                                    'qty' => @$request->qty[$key],
                                    'customer_vehicle_id' => $vehicle_id,
                                    'debit' => @$request->debit[$key],
                                    'credit' => @$request->credit[$key],
                                    'account_id' => $account_id,
                                    'description' => @$request->description[$key],
                                    'sale_date' => $request->sale_date,
                                    'display_order' => $key + 1,
                                ]);
                            }else{
                                $totalEmptyAccount += 1;
                                $account = DebitCreditAccount::find($account_id);
                                $missingText .= "<p>Missing Entry For Account named ".$account->name." as No Debit / Credit Value entered.</p>";
                            }
                        }
                    }
                }
                else{
                    $totalEmptyAccount += 1;
                    $missingText .= "<p>Missing Entry For Account For Data where Debit / Credit Value is ".$request->debit[$key] > 0 ? $request->debit[$key] : $request->credit[$key].".</p>";
                }
            }
            if($totalEmptyAccount > 0)
            {
                $url = route('supplier.sale.index').'?active_tab=debit_credit&date='.$request->sale_date;
                return response([
                    'success' => false,
                    'totalEmptyAccount' => $totalEmptyAccount,
                    'missingText' => $missingText,
                    'url' => $url,
                ], 200);
            }
            $next_date = Carbon::parse($request->sale_date);
            $next_date->addDay(); 
            $url = route('supplier.sale.index').'?active_tab=diesel&date='.$next_date->format('Y-m-d');
            toastr()->success('Debit Credit Added Successfully');
            return response([
                'success' => true,
                'totalEmptyAccount' => $totalEmptyAccount,
                'missingText' => $missingText,
                'message' => "Debit Credit Added Successfully",
                'url' => $url,
            ], 200);
        }catch(Exception $e)
        {
            return response([
                'success' => false,
                'message' => $e->getMessage(),
                'totalEmptyAccount' => 0,
            ], 422);
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
            $totalEmptyAccount = 0;
            foreach($request->account_id as $key => $account_id)
            {
                if($account_id && $account_id != null && $account_id != 0)
                {
                    if($request->debit_credit_id[$key])
                    {
                        $debitCredit = DebitCredit::find($request->debit_credit_id[$key]); 
                        if(@$request->vehicle_id[$key] && is_numeric($request->vehicle_id[$key]))
                        {
                            $vehicle_id = $request->vehicle_id[$key];
                        } else{
                            $vehicle_id = null;
                        }      
                        $debitCreditAccount = DebitCreditAccount::find($account_id);
                        $debitCredit->update([
                            'supplier_id' => Auth::user()->id,
                            'site_id' => $debitCreditAccount->site_id,
                            'product_id' => @$request->product_id[$key],
                            'qty' => @$request->qty[$key],
                            'customer_vehicle_id' => $vehicle_id,
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
                            if(@$request->vehicle_id[$key] && is_numeric($request->vehicle_id[$key]))
                            {
                                $vehicle_id = $request->vehicle_id[$key];
                            } else{
                                $vehicle_id = null;
                            }
                            $debitCreditAccount = DebitCreditAccount::find($account_id);
                            DebitCredit::create([
                                'supplier_id' => Auth::user()->id,
                                'site_id' => $debitCreditAccount->site_id,
                                'product_id' => @$request->product_id[$key],
                                'qty' => @$request->qty[$key],
                                'customer_vehicle_id' => $vehicle_id,
                                'debit' => @$request->debit[$key],
                                'credit' => @$request->credit[$key],
                                'account_id' => $account_id,
                                'description' => @$request->description[$key],
                                'sale_date' => $request->sale_date,
                                'display_order' => $key + 1,
                            ]);
                        }      
                    }

                }
                else{
                    $totalEmptyAccount += 1;
                }
            }
            
            if($totalEmptyAccount > 0)
            {
                
                toastr()->warning('You add '.$totalEmptyAccount.' Debit Credit Entry with no account.');
                return redirect()->to(route('supplier.sale.index').'?active_tab=debit_credit&date='.$request->sale_date);       
            }
            $next_date = Carbon::parse($request->sale_date);
            $next_date->addDay();    
            toastr()->success('Debit Credit Updated Successfully');
            return redirect()->to(route('supplier.sale.index').'?active_tab=diesel&date='.$next_date->format('Y-m-d'));
        }catch(Exception $e)
        {
            toastr()->error($e->getMessage());
            return redirect()->to(route('supplier.sale.index').'?active_tab=debit_credit&date='.$request->sale_date);
        }
    }
    public function updateForm(DebitCreditStoreRequest $request)
    {
        try{
            // $totalDebit = 0;
            // $totalCredit = 0;
            $totalEmptyAccount = 0;
            $missingText = '';
            foreach($request->account_id as $key => $account_id)
            {
                if($account_id && $account_id != null && $account_id != 0)
                {
                    if($request->debit_credit_id[$key])
                    {
                        $debitCredit = DebitCredit::find($request->debit_credit_id[$key]); 
                        if(@$request->vehicle_id[$key] && is_numeric($request->vehicle_id[$key]))
                        {
                            $vehicle_id = $request->vehicle_id[$key];
                        } else{
                            $vehicle_id = null;
                        }
                        $debitCreditAccount = DebitCreditAccount::find($account_id);

                        $debitCredit->update([
                            'supplier_id' => Auth::user()->id,
                            'site_id' => $debitCreditAccount->site_id,
                            'product_id' => @$request->product_id[$key],
                            'qty' => @$request->qty[$key],
                            'customer_vehicle_id' => $vehicle_id,
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
                            if(@$request->vehicle_id[$key] && is_numeric($request->vehicle_id[$key]))
                            {
                                $vehicle_id = $request->vehicle_id[$key];
                            } else{
                                $vehicle_id = null;
                            }
                            $debitCreditAccount = DebitCreditAccount::find($account_id);
                            DebitCredit::create([
                                'supplier_id' => Auth::user()->id,
                                'site_id' => $debitCreditAccount->site_id,
                                'product_id' => @$request->product_id[$key],
                                'qty' => @$request->qty[$key],
                                'customer_vehicle_id' => @$vehicle_id,
                                'debit' => @$request->debit[$key],
                                'credit' => @$request->credit[$key],
                                'account_id' => $account_id,
                                'description' => @$request->description[$key],
                                'sale_date' => $request->sale_date,
                                'display_order' => $key + 1,
                            ]);
                        }      
                    }

                }
                else{
                    $totalEmptyAccount += 1;
                    $missingText .= "<p>Missing Entry For Account For Data where Debit / Credit Value is ".$request->debit[$key] > 0 ? $request->debit[$key] : $request->credit[$key].".</p>";
                }
            }
            if($totalEmptyAccount > 0)
            {
                $url = route('supplier.sale.index').'?active_tab=debit_credit&date='.$request->sale_date;
                return response([
                    'success' => false,
                    'totalEmptyAccount' => $totalEmptyAccount,
                    'missingText' => $missingText,
                    'url' => $url,
                ], 200);
            }
            $next_date = Carbon::parse($request->sale_date);
            $next_date->addDay();    
            toastr()->success('Debit Credit Updated Successfully');
            $url = route('supplier.sale.index').'?active_tab=diesel&date='.$next_date->format('Y-m-d');
            return response([
                'success' => true,
                'totalEmptyAccount' => $totalEmptyAccount,
                'missingText' => $missingText,
                'message' => "Debit Credit Added Successfully",
                'url' => $url,
            ], 200);
        }catch(Exception $e)
        {
            return response([
                'success' => false,
                'message' => $e->getMessage(),
                'totalEmptyAccount' => 0,
            ], 422);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DebitCredit  $debitCredit
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $debitCredit = DebitCredit::find($id);
        $sale_date = $debitCredit->sale_date;
        if($debitCredit->purchase_id)
            Purchase::where('id',$debitCredit->purchase_id)->delete();
        $debitCredit->delete();
        toastr()->success('Debit Credit Deleted successfully');
        return redirect()->to(route('supplier.sale.index').'?active_tab=debit_credit_missing');
    }
    public function delete(Request $request)
    {
        $debitCredit = DebitCredit::find($request->id);
        $sale_date = $debitCredit->sale_date;
        if($debitCredit->purchase_id)
            Purchase::where('id',$debitCredit->purchase_id)->delete();
        $debitCredit->delete();
        toastr()->success('Debit Credit Deleted successfully');
        return redirect()->to(route('supplier.sale.index').'?active_tab=debit_credit&date='.$sale_date->format('m/d/Y'));
    }
    public function getCreditFields(Request $request)
    {
        $key = $request->key;
        $accounts = DebitCreditAccount::leftJoin('debit_credits', 'debit_credit_accounts.id', '=', 'debit_credits.account_id')
                ->select('debit_credit_accounts.*', DB::raw('COUNT(debit_credits.account_id) as accounts'))
                ->where('debit_credit_accounts.supplier_id', Auth::user()->id)
                ->orWhereNull('debit_credit_accounts.user_id')
                ->groupBy('debit_credit_accounts.id')
                ->orderBy('accounts', 'DESC')
                ->get();
        $products = Product::where('supplier_id',Auth::user()->id)->orWhereNull('user_id')->get();
        $html = view('supplier.sale.partials.debit_credit_fields', compact('key','accounts','products'))->render();
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
            if($account_id && $account_id != null && $account_id != 0)
            {
                if($account_id != $cash_account_id)
                {
                    $totalDebit = $totalDebit + @$request->debit[$key];
                    $totalCredit = $totalCredit + @$request->credit[$key];
                }
            }
        } 
        $difference = $totalCredit - $totalDebit;
        return response([
            'totalDebit' => $totalDebit,
            'totalCredit' => $totalCredit,
            'difference' => $difference,
        ], 200);
    }
    public function get_customer_vehicle(Request $request)
    {
        $vehicles = CustomerVehicle::where('debit_credit_account_id',$request->account_id)->get();
        return response([
            'vehicles' => $vehicles
        ], 200);
    }
    public function deletedValues()
    {
        $debit_credits = DebitCredit::withTrashed()->whereNotNull('deleted_at')->get();
        return view('supplier.debit_credit.deleted',compact('debit_credits'));
    }
    public function forceDelete($id)
    {
        $debitCredit = DebitCredit::withTrashed()->find($id);
        $debitCredit->forceDelete();
        toastr()->success('Debit Credit Deleted successfully');
        return redirect()->back();
    }
    public function verify($id)
    {
        $debitCredit = DebitCredit::find($id);
        $debitCredit->update([
            'supplier_validation' => 1
        ]);
        toastr()->success('Debit Credit Verified successfully');
        return redirect()->back();
    }
}
