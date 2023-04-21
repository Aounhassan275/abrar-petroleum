<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountCategory;
use Illuminate\Http\Request;

class AccountCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.account_category.index');
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
        AccountCategory::create($request->all());
        toastr()->success('Account Category is Created Successfully');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AccountCategory  $accountCategory
     * @return \Illuminate\Http\Response
     */
    public function show(AccountCategory $accountCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AccountCategory  $accountCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(AccountCategory $accountCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AccountCategory  $accountCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $accountCategory = AccountCategory::find($id);
        $accountCategory->update($request->all());
        toastr()->success('Account Category Informations Updated successfully');
        return redirect()->back();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AccountCategory  $accountCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $accountCategory = AccountCategory::find($id);
        $accountCategory->delete();
        toastr()->success('Account Category Deleted Successfully');
        return redirect()->back();
    }
}
