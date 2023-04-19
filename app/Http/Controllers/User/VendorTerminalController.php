<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\VendorTerminal;
use Exception;
use Illuminate\Http\Request;

class VendorTerminalController extends Controller
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
            VendorTerminal::create($request->all());            
            toastr()->success('Vendor Terminal is Created Successfully');
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
     * @param  \App\Models\VendorTerminal  $vendorTerminal
     * @return \Illuminate\Http\Response
     */
    public function show(VendorTerminal $vendorTerminal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VendorTerminal  $vendorTerminal
     * @return \Illuminate\Http\Response
     */
    public function edit(VendorTerminal $vendorTerminal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VendorTerminal  $vendorTerminal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $vendor_terminal = VendorTerminal::find($id);
            $vendor_terminal->update($request->all());          
            toastr()->success('Vendor Terminal is Updated Successfully');
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
     * @param  \App\Models\VendorTerminal  $vendorTerminal
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $vendor_terminal = VendorTerminal::find($id);
            $vendor_terminal->delete();          
            toastr()->success('Vendor Terminal is Deleted Successfully');
            return redirect()->back();
        }catch(Exception $e)
        {
            toastr()->error($e->getMessage());
            return back();
        }
    }
}
