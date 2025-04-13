<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PasswordGenerator extends Controller
{
    public function passwordGenerator(){
        return view('tools.password-generator');
    }
}
