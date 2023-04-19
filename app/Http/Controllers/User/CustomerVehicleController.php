<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CustomerVehicle;
use Exception;
use Illuminate\Http\Request;

class CustomerVehicleController extends Controller
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
            CustomerVehicle::create($request->all());            
            toastr()->success('Customer Vehicle is Created Successfully');
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
     * @param  \App\Models\CustomerVehicle  $customerVehicle
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerVehicle $customerVehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomerVehicle  $customerVehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerVehicle $customerVehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomerVehicle  $customerVehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $customerVehicle = CustomerVehicle::find($id);
        $customerVehicle->update($request->all());
        toastr()->success('Customer Vehicle Informations Updated successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomerVehicle  $customerVehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customerVehicle = CustomerVehicle::find($id);
        $customerVehicle->delete();
        toastr()->success('Customer Vehicle Deleted successfully');
        return redirect()->back();
    }
}
