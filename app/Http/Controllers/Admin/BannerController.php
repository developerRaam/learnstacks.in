<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use App\Enums\BannerType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // check permission
        if (!auth()->user()->can('view_page')) {
            return back()->withError('You don\'t have permission to access this.');
        }

        $data['heading_title'] = "Banner";
        $data['list_title'] = "Banner List";

        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => route('admin.dashboard'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Banners',
            'href' => null
        ];

        $data['add'] = route('admin.banner') . '/create';

        $data['banners'] = Banner::latest('created_at')->get();

        return view("admin.banner.banner", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // check permission
        if (!auth()->user()->can('create_page')) {
            return back()->withError('You don\'t have permission to access this.');
        }

        $data['heading_title'] = "Add Banner";
        $data['list_title'] = "Add Banner";

        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => route('admin.dashboard'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Banner',
            'href' => route('admin.banner')
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Add Banner',
            'href' => null
        ];

        $data['action'] = route('admin.banner');
        $data['back'] = route('admin.banner');

        return view("admin.banner.banner-form", $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // check permission
        if (!auth()->user()->can('store_page')) {
            return back()->withError('You don\'t have permission to access this.');
        }

        $validated = $request->validate([
            'title' => 'nullable',
            'status' => 'nullable',
            'image' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable',
            'button_text' => 'nullable',
            'button_url' => 'nullable',
            'sort_by' => 'nullable',
            'button_background' => 'nullable',
            'button_color' => 'nullable',
            'border_color' => 'nullable',
        ]);

        $validated['status'] = $validated['status'] ? true : false;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('banner', 'public');
            $validated['image'] = $imagePath;
        }

        Banner::create($validated);

        return redirect()->route('admin.banner')->with('success','Added banner successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // check permission
        if (!auth()->user()->can('show_page')) {
            return back()->withError('You don\'t have permission to access this.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // check permission
        if (!auth()->user()->can('edit_page')) {
            return back()->withError('You don\'t have permission to access this.');
        }

        $data['heading_title'] = "Edit Banner";
        $data['list_title'] = "Edit Banner";

        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => route('admin.dashboard'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Banner',
            'href' => route('admin.banner')
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Edit Banner',
            'href' => null
        ];

        $data['action'] = route('admin.banner') .'/'. $id;
        $data['back'] = route('admin.banner');

        $data['banner'] = Banner::find($id);

        return view("admin.banner.banner-form", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // check permission
        if (!auth()->user()->can('update_page')) {
            return back()->withError('You don\'t have permission to access this.');
        }

        $validated = $request->validate([
            'title' => 'nullable',
            'status' => 'nullable',
            'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable',
            'button_text' => 'nullable',
            'button_url' => 'nullable',
            'sort_by' => 'nullable',
            'button_background' => 'nullable',
            'button_color' => 'nullable',
            'border_color' => 'nullable',
        ]);

        $validated['status'] = $validated['status'] ? true : false; 

        $banner = Banner::find($id);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('banner', 'public');
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }
            $validated['image'] = $imagePath;
        }

        Banner::where('id', $id)->update($validated);

        return redirect()->route('admin.banner')->with('success','Added banner successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // check permission
        if (!auth()->user()->can('delete_page')) {
            return back()->withError('You don\'t have permission to access this.');
        }

        $banner = Banner::find($id);

        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        return redirect()->route('admin.banner')->with('success','Banner deleted successfully');

    }
}
