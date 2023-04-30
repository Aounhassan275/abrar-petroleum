<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\SupplierVehicle;
use Exception;
use Illuminate\Http\Request;

class SupplierVehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('supplier.vehicle.index');
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
            SupplierVehicle::create($request->all());            
            toastr()->success('Supplier Vehicle is Created Successfully');
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
     * @param  \App\Models\SupplierVehicle  $supplierVehicle
     * @return \Illuminate\Http\Response
     */
    public function show(SupplierVehicle $supplierVehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SupplierVehicle  $supplierVehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(SupplierVehicle $supplierVehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SupplierVehicle  $supplierVehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $supplierVehicle = SupplierVehicle::find($id);
        $supplierVehicle->update($request->all());
        toastr()->success('Supplier Vehicle Informations Updated successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SupplierVehicle  $supplierVehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplierVehicle = SupplierVehicle::find($id);
        $supplierVehicle->delete();
        toastr()->success('Supplier Vehicle Deleted successfully');
        return redirect()->back();
    }
}
