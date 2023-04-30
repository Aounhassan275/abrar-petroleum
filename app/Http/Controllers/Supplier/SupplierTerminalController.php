<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\SupplierTerminal;
use Exception;
use Illuminate\Http\Request;

class SupplierTerminalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('supplier.terminal.index');
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
            SupplierTerminal::create($request->all());            
            toastr()->success('Supplier Terminal is Created Successfully');
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
     * @param  \App\Models\SupplierTerminal  $supplierTerminal
     * @return \Illuminate\Http\Response
     */
    public function show(SupplierTerminal $supplierTerminal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SupplierTerminal  $supplierTerminal
     * @return \Illuminate\Http\Response
     */
    public function edit(SupplierTerminal $supplierTerminal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SupplierTerminal  $supplierTerminal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $supplierTerminal = SupplierTerminal::find($id);
        $supplierTerminal->update($request->all());
        toastr()->success('Supplier Terminal Informations Updated successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SupplierTerminal  $supplierTerminal
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplierTerminal = SupplierTerminal::find($id);
        $supplierTerminal->delete();
        toastr()->success('SupplierTerminal Deleted successfully');
        return redirect()->back();
    }
}