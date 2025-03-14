<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // check permission
        if (!auth()->user()->can('view_category')) {
            return back()->withError('You don\'t have permission to access this.');
        }

        $data['heading_title'] = "Categories";
        $data['list_title'] = "Category List";

        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => route('admin.dashboard'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Categories',
            'href' => null
        ];

        $query = Category::select('*');

        // Apply filters
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $data['category'] = $query->latest('created_at')->paginate();

        $data['add'] = route('admin.category.create');

        return view("admin.category.category-list", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // check permission
        if (!auth()->user()->can('create_category')) {
            return back()->withError('You don\'t have permission to access this.');
        }

        $data['heading_title'] = "Add Category";
        $data['list_title'] = "Add Category";

        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => route('admin.dashboard'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Categories',
            'href' => route('admin.category'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Add Category',
            'href' => null
        ];

        $data['action'] = route('admin.category');
        $data['back'] = route('admin.category');

        return view("admin.category.category-form", $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // check permission
        if (!auth()->user()->can('store_category')) {
            return back()->withError('You don\'t have permission to access this.');
        }

        $validated = $request->validate([
            "name" => "required|unique:categories,name",
            "description" => "nullable",
            "menu_top" => "nullable",
            "sort_by" => "nullable|numeric",
            'status' => "required|numeric",
        ]);

        $validated['menu_top'] =  isset($validated['menu_top']) ? 1 : 0 ;

        $validated['slug'] = Str::slug($request->name);

        Category::create($validated);

        return redirect()->route('admin.category')->with('success','Category created successfully');
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
        // check permission
        if (!auth()->user()->can('edit_category')) {
            return back()->withError('You don\'t have permission to access this.');
        }

        $data['heading_title'] = "Edit Category";
        $data['list_title'] = "Edit Category";

        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => route('admin.dashboard'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Categories',
            'href' => route('admin.category'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Edit Category',
            'href' => null
        ];
        
        $data['action'] = route('admin.category') .'/'. $id;
        $data['back'] = route('admin.category');

        $data['category'] = Category::find($id);

        return view("admin.category.category-form", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // check permission
        if (!auth()->user()->can('update_category')) {
            return back()->withError('You don\'t have permission to access this.');
        }

        $validated = $request->validate([
            "description" => "nullable",
            "menu_top" => "nullable",
            "sort_by" => "nullable|numeric",
            'status' => "required|numeric",
            "slug" => 'required',
        ]);

        $validated['slug'] = Str::slug($request->slug);

        $validated['menu_top'] =  isset($validated['menu_top']) ? 1 : 0 ;

        Category::findOrFail($id)->update($validated);

        return redirect()->route('admin.category')->with('success','Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // check permission
        if (!auth()->user()->can('delete_category')) {
            return back()->withError('You don\'t have permission to access this.');
        }

        Category::find($id)->delete();
    }
}
