<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function page($slug){
        $data['page'] = Page::where('slug', $slug)->first();
        return view('frontend.pages.page', $data);
    }
}
