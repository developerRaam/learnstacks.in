<?php

namespace App\Http\Controllers\Frontend\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PasswordGenerator extends Controller
{
    public function passwordGenerator(){
        return view('frontend.tools.password-generator');
    }
}
