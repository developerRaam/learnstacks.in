<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ToolsController extends Controller
{
    public function tools(){
        return view('tools.tools');
    }
}
