<?php

namespace App\Http\Controllers\Frontend\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $data['heading_title'] = "Dashboard";
        $data['list_title'] = "Dashboard";

        $data['breadcrumbs'][] = [
            'text' => 'Dashboard',
            'href' => null
        ];

        return view('frontend.users.dashboard', $data);
    }
}
