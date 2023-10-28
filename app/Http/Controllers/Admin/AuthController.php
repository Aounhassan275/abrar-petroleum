<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DebitCredit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        $creds = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if(Auth::guard('admin')->attempt($creds))
        {
            toastr()->success('You Login Successfully');
            return redirect()->intended(route('admin.dashboard.index'));
        } else {
            return redirect()->back();
        }
    }
    
    public function logout()
    {
        Auth::logout();
        toastr()->success('You Logout Successfully');
        return redirect('/');
    }
    public function removeDebitEntriesWithoutDates()
    {
        DebitCredit::whereNull('sale_date')->delete();
        toastr()->success('You Remove Debit Entries Without Dates Successfully!');
        return redirect()->back();
    }
}
