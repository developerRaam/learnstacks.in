<?php

namespace App\Http\Controllers\Frontend\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login(){
        return view('frontend.auth.login');
    }

    
    public function logout(){
        Auth::logout();
        Session::flush();
        return redirect()->route('frontend.login')->with('success', 'Logout Successfully');
    }
}
