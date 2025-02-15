<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
// create new manager instance with desired driver
use Intervention\Image\ImageManager;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['heading_title'] = "Post";
        $data['list_title'] = "Post List";

        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => route('admin.dashboard'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Posts',
            'href' => null
        ];

        $query = Post::select('*');

        // Apply filters
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('posts.title', 'like', '%' . $request->search . '%')
                ->orWhere('posts.description', 'like', '%' . $request->search . '%');
            });
        }

        // filter by date
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('posts.created_at', [
                $request->start_date . ' 00:00:00',  
                $request->end_date . ' 23:59:59'     
            ]);
        } elseif ($request->filled('start_date')) {
            $query->whereDate('posts.created_at', '>=', $request->start_date);
        } elseif ($request->filled('end_date')) {
            $query->whereDate('posts.created_at', '<=', $request->end_date);
        }

        $data['posts'] = $query->latest('created_at')->paginate();
        $data['add'] = route('admin.posts.create');

        return view('admin.posts.post-list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['heading_title'] = "Add Post";
        $data['list_title'] = "Add Post";

        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => route('admin.dashboard'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Post',
            'href' => route('admin.posts')
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Add Post',
            'href' => null
        ];

        $data['action'] = route('admin.posts');
        $data['back'] = route('admin.posts');
        $data['categories'] = Category::all();

        return view('admin.posts.post-form', $data);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'user_id' => 'nullable',
            'category_id' => 'nullable',
            'sub_category_id' => 'nullable',
            'status' => 'required',
            'keywords' => 'nullable',
            'robots' => 'required',
            'googlebot' => 'required',
            'tags' => 'nullable',
            'canonical' => 'nullable',
        ]);
       
        $validated['user_id'] = Auth::user()->id;
        
        $validated['slug'] = Str::slug($validated['title']);
        
        if($validated['status'] == 'Published'){
            $validated['published_at'] = Carbon::now();
        }

        // convert images
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('posts', 'public');
            $validated['featured_image'] = $imagePath;

            // convert images
            $imageManager = ImageManager::imagick()->read(Storage::disk('public')->path($imagePath));
            $cacheDir = "cache/posts/";

            $sizes = [600,300];

            foreach ($sizes as $size) {
                // Resize image while maintaining aspect ratio
                $resizedImage = $imageManager->scaleDown(height:$size);
                // Define the filename without extension
                $fileName = pathinfo($imagePath, PATHINFO_FILENAME);
                $outputPath = "{$cacheDir}{$fileName}_{$size}.jpg";
                Storage::disk('public')->put($outputPath, (string) $resizedImage->toJpeg(quality: 80));
            }
        }
        
        Post::create($validated);

        return redirect()->route('admin.posts')->with('success', 'Post added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['heading_title'] = "Edit Post";
        $data['list_title'] = "Edit Post";

        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => route('admin.dashboard'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Post',
            'href' => route('admin.posts')
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Edit Post',
            'href' => null
        ];

        $data['action'] = route('admin.posts') .'/'. $id;
        $data['back'] = route('admin.posts');

        $data['post'] = Post::find($id);
        $data['categories'] = Category::all();  

        return view("admin.posts.post-form", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'user_id' => 'nullable',
            'category_id' => 'nullable',
            'sub_category_id' => 'nullable',
            'status' => 'required',
            'keywords' => 'nullable',
            'robots' => 'required',
            'googlebot' => 'required',
            'tags' => 'nullable',
            'canonical' => 'nullable',
        ]);

        $post = Post::where('id', $id)->where('user_id', Auth::user()->id)->first();
        
        // convert images
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('posts', 'public');
            $cacheDir = "cache/posts/";

            if ($post->featured_image) {
                $file = pathinfo($post->featured_image, PATHINFO_FILENAME);
                Storage::disk('public')->delete($post->featured_image);
                Storage::disk('public')->delete("{$cacheDir}{$file}_300.jpg");
                Storage::disk('public')->delete("{$cacheDir}{$file}_600.jpg");

            }
            $validated['featured_image'] = $imagePath;

            // convert images
            $imageManager = ImageManager::imagick()->read(Storage::disk('public')->path($imagePath));

            $sizes = [600,300];

            foreach ($sizes as $size) {
                // Resize image while maintaining aspect ratio
                $resizedImage = $imageManager->scaleDown(height:$size);
                // Define the filename without extension
                $fileName = pathinfo($imagePath, PATHINFO_FILENAME);
                $outputPath = "{$cacheDir}{$fileName}_{$size}.jpg";
                Storage::disk('public')->put($outputPath, (string) $resizedImage->toJpeg(quality: 80));
            }
        }

        $validated['slug'] = Str::slug($validated['title']);

        if($validated['status'] == 'Published'){
            $validated['published_at'] = Carbon::now();
        }else{
            $validated['published_at'] = null;
        }

        $post->update($validated);

        return redirect()->route('admin.posts')->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);

        if ($post->featured_image) {
            $cacheDir = "cache/posts/";
            $file = pathinfo($post->featured_image, PATHINFO_FILENAME);
            Storage::disk('public')->delete($post->featured_image);
            Storage::disk('public')->delete("{$cacheDir}{$file}_300.jpg");
            Storage::disk('public')->delete("{$cacheDir}{$file}_600.jpg");
        }

        $post->delete();

        return redirect()->route('admin.posts')->with('success','Post deleted successfully');
    }
}
