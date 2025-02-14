<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function page($slug){
        $data['page'] = Page::where('slug', $slug)->first();

        if(!$data['page']){
            abort(404, 'Page Not Found');
        }
        return view('frontend.pages.page', $data);
    }
}
