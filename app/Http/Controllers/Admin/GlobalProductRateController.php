<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GlobalProductRate;
use Exception;
use Illuminate\Http\Request;

class GlobalProductRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
    public function store(Request $request)
    {
        try{
			$this->validate($request, [
				'user_id' => 'required',
				'product_id' => 'required',
				'selling_price' => 'required|numeric',
			],[
				'selling_price.numeric'=>'Selling Price Must be Numeric',
			]
			);
            GlobalProductRate::create($request->all());
            toastr()->success('Global Product Rate is Created Successfully');
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
     * @param  \App\Models\GlobalProductRate  $globalProductRate
     * @return \Illuminate\Http\Response
     */
    public function show(GlobalProductRate $globalProductRate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GlobalProductRate  $globalProductRate
     * @return \Illuminate\Http\Response
     */
    public function edit(GlobalProductRate $globalProductRate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GlobalProductRate  $globalProductRate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GlobalProductRate $globalProductRate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GlobalProductRate  $globalProductRate
     * @return \Illuminate\Http\Response
     */
    public function destroy(GlobalProductRate $globalProductRate)
    {
        //
    }
}
