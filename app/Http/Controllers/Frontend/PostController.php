<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function post($category_slug){
        $category = Category::where('slug', $category_slug)->first();
        
        if(!$category){
            abort(404, "Post not found");
        }

        $data['posts'] = Post::where('status', 'Published')
            ->where('category_id', $category->id)
            ->latest('created_at')->simplePaginate();

        $data['category'] = $category;
        
        return view('frontend.posts.posts', $data);
    }

    public function postShow(Request $request, $slug){

        $data['post'] = Post::with('category')->where('status', 'Published')->where('slug', $slug)->first();
        
        if(!$data['post']){
            abort(404, "Post not found");
        }

        $data['action'] = route('frontend.comment');

        $data['posts'] = Post::where('status', 'Published')->latest('created_at')->limit(10)->get();

        return view('frontend.posts.post-detail', $data);
    }
}
