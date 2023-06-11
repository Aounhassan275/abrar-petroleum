<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DebitCredit;
use App\Models\DebitCreditAccount;
use App\Models\Purchase;
use App\Models\PurchasePayment;
use App\Models\Supplier;
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
    public function index()
    {
        return view('user.purchase.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.purchase.create');
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
            if(!$request->vendor_id)
            {
                $request->merge([
                    'supplier_id' => Supplier::first()->id
                ]);
            }
            if($request->access_total_amount)
            {
                $request->merge([
                    'total_amount' => $request->access_total_amount
                ]);
            }
            $purchase = Purchase::create($request->all());
            if($request->amount)
            {
                PurchasePayment::create(
                [
                    'amount' => $request->amount,
                    'vendor_account_id' => $request->vendor_account_id,
                    'date' => $request->date?$request->date:date('Y-m-d'),
                    'purchase_id' => $purchase->id,
                    'image' => @$request->image,
                ]);
            }
            if($purchase->access > 0)
            {
                $account_id  = DebitCreditAccount::where('name','Product Excess')->first()->id;
                DebitCredit::create([
                    'user_id' => Auth::user()->id,
                    'product_id' => @$purchase->product_id,
                    'qty' => @$purchase->access,
                    'credit' => @$purchase->access_total_amount,
                    'account_id' => $account_id,
                    'sale_date' => $purchase->date,
                    'description' => $purchase->access.' litres '.$purchase->product->name,
                ]);
                $account_id  = DebitCreditAccount::where('product_id',$request->product_id)->first()->id;
                DebitCredit::create([
                    'user_id' => Auth::user()->id,
                    'debit' => @$purchase->access_total_amount,
                    'account_id' => $account_id,
                    'sale_date' => $purchase->date,
                    'description' => $purchase->access.' litres '.$purchase->product->name,
                ]);
            }
            else if($request->total_amount > 0)
            {
                $account_id  = DebitCreditAccount::where('product_id',$request->product_id)->first()->id;
                DebitCredit::create([
                    'user_id' => Auth::user()->id,
                    'debit' => @$purchase->total_amount,
                    'account_id' => $account_id,
                    'sale_date' => $purchase->date,
                ]);
                if($request->supplier_id)
                {
                    $supplier_account_id  = DebitCreditAccount::where('supplier_id',$request->supplier_id)->first()->id;
                    DebitCredit::create([
                        'user_id' => Auth::user()->id,
                        'credit' => @$purchase->total_amount,
                        'account_id' => $supplier_account_id,
                        'sale_date' => $purchase->date,
                        'description' => $purchase->qty.' litres '.$purchase->product->name,
                    ]);
                }

            }
            if($request->product_id == 2)
            {
                return redirect()->to(route('user.sale.index').'?active_tab=petrol&date='.$request->date);
            }else{
                return redirect()->to(route('user.sale.index').'?active_tab=diesel&date='.$request->date);
            }
            toastr()->success('Purchase is Created Successfully');
            return redirect()->back();

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
        $purchase = Purchase::find($id);
        return view('user.purchase.edit',compact('purchase'));
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
        toastr()->success('Purchase Informations Updated successfully');
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
        toastr()->success('Purchase Deleted successfully');
        return redirect()->back();
    }
}
