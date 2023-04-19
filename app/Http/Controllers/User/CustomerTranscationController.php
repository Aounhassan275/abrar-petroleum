<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerTranscation;
use Exception;
use Illuminate\Http\Request;

class CustomerTranscationController extends Controller
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
            $transcation = CustomerTranscation::create($request->all());    
            $customer = Customer::find($transcation->customer_id);   
            $customer->update([
                'balance' =>  $customer->balance + $transcation->amount
            ]);     
            toastr()->success('Customer Transcation is Created Successfully');
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
     * @param  \App\Models\CustomerTranscation  $customerTranscation
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerTranscation $customerTranscation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomerTranscation  $customerTranscation
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerTranscation $customerTranscation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomerTranscation  $customerTranscation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $customerTranscation = CustomerTranscation::find($id);
        $customerTranscation->update($request->all());
        toastr()->success('Customer Transcation Informations Updated successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomerTranscation  $customerTranscation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customerTranscation = CustomerTranscation::find($id);
        $customerTranscation->delete();
        toastr()->success('Customer Transcation Deleted successfully');
        return redirect()->back();
    }
}
