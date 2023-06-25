<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\DebitCredit;
use App\Models\DebitCreditAccount;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchasePayment;
use App\Models\Supplier;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sale_date = Purchase::all()->last()->date;
        if($request->date)
        {
            $sale_date->addDay();    
            if(Carbon::parse($request->date)->gt($sale_date))
            {
                toastr()->error('Not Allowed');
                $date =  $sale_date;
                $day_before = Purchase::all()->last()->sale_date;
            }else{
                $date =  Carbon::parse($request->date);
                $day_before =  Carbon::parse($request->date)->subDay();
            }
        }else{
            $date =  $sale_date->addDay();
            $day_before = Purchase::all()->last()->sale_date;
        }
        $active_tab = $request->active_tab?$request->active_tab:'purchase';
        $accounts = DebitCreditAccount::query()
                ->select('debit_credit_accounts.*')
                ->where('debit_credit_accounts.user_id', Auth::user()->id)
                ->orWhereNull('debit_credit_accounts.user_id')
                ->orderBy('debit_credit_accounts.account_category_id', 'ASC')
                ->get();
        $cash_account_id = DebitCreditAccount::where('name','Cash in Hand')->first()->id;
        $lastDayCash = DebitCredit::where('account_id',$cash_account_id)->whereDate('sale_date',$day_before)->where('user_id',Auth::user()->id)->first();
        $missing_debit_credits = DebitCredit::whereNull('account_id')->where('user_id',Auth::user()->id)->get();
        $products = Product::where('user_id',Auth::user()->id)->orWhereNull('user_id')->get();
        return view('supplier.sale.index',compact('date','active_tab','accounts','products','cash_account_id','lastDayCash','missing_debit_credits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('supplier.sale.create');
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
            $product = Product::find($request->product_id);
            if($product->supplierAvailableStock() > $request->qty)
            {
                $purchase = Purchase::create($request->all());
                
                if($purchase->access > 0)
                {
                    $account_id  = DebitCreditAccount::where('name','Product Excess')->first()->id;
                    $creditAmount = $purchase->access * $purchase->price;
                    // DebitCredit::create([
                    //     'user_id' => Auth::user()->id,
                    //     'product_id' => @$purchase->product_id,
                    //     'qty' => @$purchase->access,
                    //     'credit' => @$creditAmount,
                    //     'account_id' => $account_id,
                    //     'sale_date' => date('Y-m-d'),
                    // ]);
                }
                toastr()->success('Sale is Created Successfully');
                return redirect()->back();
            }else{
                toastr()->error('Stock is limited');
                return back()->withInput($request->all());
            }

        }catch(Exception $e)
        {
            toastr()->error($e->getMessage());
            return back()->withInput($request->all());

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sale = Purchase::find($id);
        return view('supplier.sale.edit',compact('sale'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $purchase = Purchase::find($id);
        $purchase->update($request->all());
        toastr()->success('Sale Informations Updated successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $purchase = Purchase::find($id);
        $purchase->delete();
        toastr()->success('Sale Deleted successfully');
        return redirect()->back();
    }
}
