<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DebitCreditAccount;
use Illuminate\Http\Request;

class DebitCreditAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.debit_credit_account.index');
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
        
        DebitCreditAccount::create($request->all());
        toastr()->success('Debit Credit Account is Created Successfully');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DebitCreditAccount  $debitCreditAccount
     * @return \Illuminate\Http\Response
     */
    public function show(DebitCreditAccount $debitCreditAccount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DebitCreditAccount  $debitCreditAccount
     * @return \Illuminate\Http\Response
     */
    public function edit(DebitCreditAccount $debitCreditAccount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DebitCreditAccount  $debitCreditAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $debitCreditAccount = DebitCreditAccount::find($id);
        $debitCreditAccount->update($request->all());
        toastr()->success('Debit Credit Account Informations Updated successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DebitCreditAccount  $debitCreditAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $debitCreditAccount = DebitCreditAccount::find($id);
        $debitCreditAccount->delete();
        toastr()->success('Debit Credit Account Deleted Successfully');
        return redirect()->back();
    }
}
