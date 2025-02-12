<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function getComment($post_id){
        $comments = Comment::where('post_id', $post_id)->latest('created_at')->simplePaginate();

        // dd($comments);

        return response()->json([
            "success" => true,
            "comments" => $comments
        ]);
    }

    public function comment(Request $request){
        $validated = $request->validate([
            'post_id' => 'required|numeric',
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250',
            'comment' => 'required' 
        ]);

        Comment::create($validated);

        return redirect()->back()->with('success', 'Comment post successfully!');
    }
}
