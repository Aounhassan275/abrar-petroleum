<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerVehicle;
use App\Models\DebitCreditAccount;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.customer.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.customer.create');
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
            $customer = Customer::create($request->all());
            foreach($request->vehicle_name as $key => $name)
            {
                CustomerVehicle::create(
                [
                    'name' => $name,
                    'reg_number' => $request->reg_number[$key],
                    'customer_id' => $customer->id,
                ]);
            }
            DebitCreditAccount::create([
                'name' => $customer->name,
                'customer_id' => $customer->id,
                'user_id' => Auth::user()->id,
            ]);       
            toastr()->success('Customer is Created Successfully');
            return redirect()->to(route('user.customer.index'));
        }catch(Exception $e)
        {
            toastr()->error($e->getMessage());
            return back()->withInput($request->all());

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::find($id);
        return view('user.customer.edit',compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $customer = Customer::find($id);
        $customer->update($request->all());
        toastr()->success('Customer Informations Updated successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        $customer->delete();
        toastr()->success('Customer Deleted successfully');
        return redirect()->back();
    }
    public function getCustomerVehicle(Request $request)
    {
        $vehicles = Customer::find($request->id)->vehicles;
        return response()->json([
            'vehicles' => $vehicles,
        ]);
    }
}
