<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\AccountCategory;
use App\Models\DebitCreditAccount;
use Exception;
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
        return view('supplier.debit_credit_account.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('supplier.debit_credit_account.create');
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
            $account = DebitCreditAccount::create($request->all());
            // $category = AccountCategory::find($request->account_category_id); 
            toastr()->success('Account is Created Successfully');
            return redirect()->to(route('supplier.debit_credit_account.index'));
        }catch(Exception $e)
        {
            toastr()->error($e->getMessage());
            // $category = AccountCategory::find($request->account_category_id); 
            return redirect()->to(route('supplier.debit_credit_account.index'));
        }
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
    public function edit($id)
    {
        
        $account = DebitCreditAccount::find($id);
        return view('supplier.debit_credit_account.edit',compact('account'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DebitCreditAccount  $debitCreditAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $account = DebitCreditAccount::find($id);
        $account->update($request->all());
        toastr()->success('Account Informations Updated successfully');
        // $category = AccountCategory::find($account->account_category_id); 
        return redirect()->to(route('supplier.debit_credit_account.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DebitCreditAccount  $debitCreditAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $account = DebitCreditAccount::find($id);
        $account->delete();
        toastr()->success('Debit Credit Account Deleted successfully');
        // $category = AccountCategory::find($account->account_category_id); 
        return redirect()->to(route('supplier.debit_credit_account.index'));
    }
}
