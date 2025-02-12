<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Subscriber;

class HomeController extends Controller
{
    public function home(){
        $data['posts'] = Post::where('status', 'Published')->latest('created_at')->limit(10)->get();
        $data['banners'] = Banner::where('status', 1)->get();

        return view('frontend.home', $data);
    }

    public function subscribe(Request $request){
        $request->validate([
            "email" => 'required|email'
        ]);

        // Check if the email already exists
        if (Subscriber::where('email', $request->email)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'You are already subscribed!'
            ], 409); // 409 Conflict
        }

        $subscribe = Subscriber::create([
            "email" => $request->email
        ]);

        if($subscribe){
            return response()->json([
                "success" => true,
                "message" => "Email subscribed successfully!"
            ], 200);
        }

        return response()->json([
            "success" => false,
            "message" => "Oops something went wrong"
        ]);
    }
}