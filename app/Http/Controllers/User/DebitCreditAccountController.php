<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AccountCategory;
use App\Models\DebitCreditAccount;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DebitCreditAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->account_category_id)
        {
            $debitCreditAccounts = Auth::user()->debitCreditAccounts->where('account_category_id',$request->account_category_id);
        }else{
            $debitCreditAccounts = Auth::user()->debitCreditAccounts;
        }
        return view('user.debit_credit_account.index',compact('debitCreditAccounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.debit_credit_account.create');
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
            toastr()->success('Account is Created Successfully');
            return redirect()->to(route('user.debit_credit_account.index').'?account_category_id='.$account->account_category_id);
   
        }catch(Exception $e)
        {
            toastr()->error($e->getMessage());
            return redirect()->back();
            // $category = AccountCategory::find($account->account_category_id); 
            // return redirect()->to(route('user.account_category.index').'?active_tab='.$category->id);
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
        return view('user.debit_credit_account.edit',compact('account'));
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
        return redirect()->to(route('user.debit_credit_account.index').'?account_category_id='.$account->account_category_id);
        // $category = AccountCategory::find($account->account_category_id); 
        // return redirect()->to(route('user.account_category.index').'?active_tab='.$category->id);
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
        return redirect()->back();
        // $category = AccountCategory::find($account->account_category_id); 
        // return redirect()->to(route('user.account_category.index').'?active_tab='.$category->id);
    }
}
