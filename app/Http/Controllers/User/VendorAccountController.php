<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\VendorAccount;
use Exception;
use Illuminate\Http\Request;

class VendorAccountController extends Controller
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
            VendorAccount::create($request->all());            
            toastr()->success('Vendor Account is Created Successfully');
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
     * @param  \App\Models\VendorAccount  $vendorAccount
     * @return \Illuminate\Http\Response
     */
    public function show(VendorAccount $vendorAccount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VendorAccount  $vendorAccount
     * @return \Illuminate\Http\Response
     */
    public function edit(VendorAccount $vendorAccount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VendorAccount  $vendorAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        try{
            $vendor_account = VendorAccount::find($id);
            $vendor_account->update($request->all());          
            toastr()->success('Vendor Account is Updated Successfully');
            return redirect()->back();
        }catch(Exception $e)
        {
            toastr()->error($e->getMessage());
            return back()->withInput($request->all());

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VendorAccount  $vendorAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $vendorAccount = VendorAccount::find($id);
            $vendorAccount->delete();          
            toastr()->success('Vendor Account is Deleted Successfully');
            return redirect()->back();
        }catch(Exception $e)
        {
            toastr()->error($e->getMessage());
            return back();
        }
    }
}
