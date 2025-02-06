<?php

namespace App\Http\Controllers\Api;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BannerResource;

class BannerController extends Controller
{
    public function banner(){
        $banner = Banner::latest('created_at')->simplePaginate();

        return response()->json(BannerResource::collection($banner));
    }
}
