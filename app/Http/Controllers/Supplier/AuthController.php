<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
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
        $user = Supplier::where('email',$request->email)->first();
        if(!$user)
        {
            toastr()->error('Please Register Yourself!');
            return redirect()->back();
        }
        if(Auth::guard('supplier')->attempt($creds))
        {
            toastr()->success('You Login Successfully');
            return redirect()->intended(route('supplier.dashboard.index'));
        } else {
            toastr()->error('Wrong Password!');
            return redirect()->back();
        }
    }
    
    public function logout()
    {
        Auth::logout();
        toastr()->success('You Logout Successfully');
        return redirect('/');
    }
}
