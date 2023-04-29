<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LossGainHelper;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.product.index');
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
			],[
				'purchasing_price.numeric'=>'Purchasing Price Must be Numeric',
				'selling_price.numeric'=>'Selling Price Must be Numeric',
			]
			);
            Product::create($request->all());
            toastr()->success('Product is Created Successfully');
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
        if($request->purchasing_price != $product->purchasing_price)
        {
            $old_amount = $product->purchasing_price;
        }
        $product->update($request->all());
        if($old_amount > 0)
        {
            LossGainHelper::procceed($old_amount,$product);
        }
        toastr()->success('Product Informations Updated successfully');
        return redirect()->back();
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
        return redirect()->back();
    }
}
