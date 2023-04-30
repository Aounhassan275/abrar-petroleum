<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\DebitCredit;
use App\Models\DebitCreditAccount;
use App\Models\Product;
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
        return view('supplier.sale.index');
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
