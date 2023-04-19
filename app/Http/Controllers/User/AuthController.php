<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        $creds = [
            'username' => $request->username,
            'password' => $request->password
        ];
        $user = User::where('username',$request->username)->first();
        if(!$user)
        {
            toastr()->error('Please Register Yourself!');
            return redirect()->back();
        }
        if(Auth::guard('user')->attempt($creds))
        {
            toastr()->success('You Login Successfully');
            return redirect()->intended(route('user.dashboard.index'));
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
