<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\SupplierPurchase;
use Exception;
use Illuminate\Http\Request;

class SupplierPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('supplier.purchase.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('supplier.purchase.create');
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
            SupplierPurchase::create($request->all());
            toastr()->success('Supplier Purchase is Created Successfully');
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
     * @param  \App\Models\SupplierPurchase  $supplierPurchase
     * @return \Illuminate\Http\Response
     */
    public function show(SupplierPurchase $supplierPurchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SupplierPurchase  $supplierPurchase
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchase = SupplierPurchase::find($id);
        return view('supplier.purchase.edit',compact('purchase'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SupplierPurchase  $supplierPurchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $purchase = SupplierPurchase::find($id);
        $purchase->update($request->all());
        toastr()->success('Purchase Informations Updated successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SupplierPurchase  $supplierPurchase
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $purchase = SupplierPurchase::find($id);
        $purchase->delete();
        toastr()->success('Purchase Deleted successfully');
        return redirect()->back();
    }
}
