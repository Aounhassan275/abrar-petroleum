<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AccountCategory;
use App\Models\DebitCreditAccount;
use App\Models\Expense;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.expense.index');
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
            $expense = Expense::create($request->all());
            toastr()->success('Expense is Created Successfully');
            $account = AccountCategory::where('name','Expenses & Income')->first();
            return redirect()->to(route('user.account_category.index').'?active_tab='.$account->id);
        }catch(Exception $e)
        {
            toastr()->error($e->getMessage());
            $account = AccountCategory::where('name','Expenses & Income')->first();
            return redirect()->to(route('user.account_category.index').'?active_tab='.$account->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $expense = Expense::find($id);
        $expense->update($request->all());
        toastr()->success('Expense Informations Updated successfully');
        $account = AccountCategory::where('name','Expenses & Income')->first();
        return redirect()->to(route('user.account_category.index').'?active_tab='.$account->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense = Expense::find($id);
        $expense->delete();
        toastr()->success('Expense Deleted successfully');
        $account = AccountCategory::where('name','Expenses & Income')->first();
        return redirect()->to(route('user.account_category.index').'?active_tab='.$account->id);
    }
}
