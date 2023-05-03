<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AccountCategory;
use App\Models\DebitCreditAccount;
use App\Models\Employee;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
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
        return view('user.employee.create');
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
            $employee = Employee::create($request->all());
            $employeeCategory = AccountCategory::where('name','Employees')->first();
            DebitCreditAccount::create([
                'name' => $employee->name,
                'employee_id' => $employee->id,
                'user_id' => Auth::user()->id,
                'account_category_id' => @$employeeCategory->id,
            ]);       
            toastr()->success('Expense is Created Successfully');
            return redirect()->to(route('user.account_category.index').'?active_tab='.$employeeCategory->id);
        }catch(Exception $e)
        {
            toastr()->error($e->getMessage());
            $account = AccountCategory::where('name','Employees')->first();
            return redirect()->to(route('user.account_category.index').'?active_tab='.$account->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::find($id);
        return view('user.employee.edit',compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $employee = Employee::find($id);
        $employee->update($request->all());
        toastr()->success('Employee Informations Updated successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
        $employee->delete();
        toastr()->success('Employee Deleted successfully');
        $account = AccountCategory::where('name','Employees')->first();
        return redirect()->to(route('user.account_category.index').'?active_tab='.$account->id);
    }
}