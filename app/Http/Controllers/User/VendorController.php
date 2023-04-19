<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DebitCreditAccount;
use App\Models\Vendor;
use App\Models\VendorAccount;
use App\Models\VendorTerminal;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.vendor.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.vendor.create');
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
            $vendor = Vendor::create($request->all());
            foreach($request->names as $name)
            {
                VendorTerminal::create(
                [
                    'name' => $name,
                    'vendor_id' => $vendor->id,
                ]);
            }
            foreach($request->title as $index => $title)
            {
                VendorAccount::create([
                    'title' => $title,
                    'bank_id' => $request->bank_id[$index] ?? 1,
                    'number' => $request->number[$index],
                    'location' => $request->location[$index],
                    'vendor_id' => $vendor->id,
                ]);
            }
            DebitCreditAccount::create([
                'name' => $vendor->name,
                'vendor_id' => $vendor->id,
                'user_id' => Auth::user()->id,
            ]);
            toastr()->success('Vendor is Created Successfully');
            return redirect()->to(route('user.vendor.index'));
        }catch(Exception $e)
        {
            toastr()->error($e->getMessage());
            return back()->withInput($request->all());

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vendor = Vendor::find($id);
        return view('user.vendor.edit',compact('vendor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $vendor = Vendor::find($id);
        $vendor->update($request->all());
        toastr()->success('Vendor Informations Updated successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vendor = Vendor::find($id);
        $vendor->delete();
        toastr()->success('Vendor Deleted successfully');
        return redirect()->back();
    }
    
    public function getVendorTerminal(Request $request)
    {
        $vendor_terminals = Vendor::find($request->id)->terminals;
        $vendor_accounts = Vendor::find($request->id)->accounts;
        return response()->json([
            'vendor_terminals' => $vendor_terminals,
            'vendor_accounts' => $vendor_accounts
        ]);
    }
}
