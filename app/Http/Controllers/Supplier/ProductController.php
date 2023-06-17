<?php

namespace App\Http\Controllers\Supplier;

use App\Helpers\LossGainHelper;
use App\Http\Controllers\Controller;
use App\Models\AccountCategory;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('supplier.product.index');
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
			$this->validate($request, [
				'name' => 'required',
				'purchasing_price' => 'required|numeric',
				'selling_price' => 'required|numeric',
				'supplier_purchasing_price' => 'required|numeric',
			],[
				'purchasing_price.numeric'=>'Own Selling Price Must be Numeric',
				'selling_price.numeric'=>'Selling Price Must be Numeric',
				'supplier_purchasing_price.numeric'=>'Puchasing Price Must be Numeric',
			]
			);
            Product::create($request->all());
            toastr()->success('Product is Created Successfully');
            return back();
        }catch(Exception $e)
        {
            toastr()->error($e->getMessage());       
            return back();
      
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $product = Product::find($id);
        $old_amount = 0;
        $old_selling_amount = 0;
        if($request->purchasing_price != $product->purchasing_price)
        {
            $old_amount = $product->purchasing_price;
            $old_selling_amount = $product->selling_price;
        }
        $product->update($request->all());
        if($old_amount > 0)
        {
            LossGainHelper::procceed($old_amount,$product,$old_selling_amount,$request->date);
        }
        toastr()->success('Product Informations Updated successfully');
        return back();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        toastr()->success('Product Deleted Successfully');
        return back();
    }
    public function getPrice(Request $request)
    {
        $product = Product::find($request->id);
        $purchasing_price = $product?$product->purchasing_price:0;
        $selling_price = $product?$product->selling_amount:0;
        $supplier_purchasing_price = $product?$product->supplier_purchasing_price:0;
        $stocks = $product?$product->supplierAvailableStock():0;
        return response()->json([
            'supplier_purchasing_price' => $supplier_purchasing_price,
            'purchasing_price' => $purchasing_price,
            'selling_price' => $selling_price,
            'stocks' => $stocks
        ]);
    }
}
