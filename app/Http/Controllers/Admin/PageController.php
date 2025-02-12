<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['heading_title'] = "Page";
        $data['list_title'] = "Page List";

        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => route('admin.dashboard'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Pages',
            'href' => null
        ];

        $data['pages'] = Page::all();
        $data['add'] = route('admin.pages.create');

        return view('admin.pages.page-list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['heading_title'] = "Add Page";
        $data['list_title'] = "Add Page";

        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => route('admin.dashboard'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Page',
            'href' => route('admin.pages')
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Add Page',
            'href' => null
        ];

        $data['action'] = route('admin.pages');
        $data['back'] = route('admin.pages');

        return view('admin.pages.page-form', $data);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'keywords' => 'nullable',
            'robots' => 'nullable',
            'googlebot' => 'nullable',
            'tags' => 'nullable',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Page::create($validated);

        return redirect()->route('admin.pages')->with('success', 'Page added successfully');
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
        $data['heading_title'] = "Edit Page";
        $data['list_title'] = "Edit Page";

        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => route('admin.dashboard'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Page',
            'href' => route('admin.pages')
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Edit Page',
            'href' => null
        ];

        $data['action'] = route('admin.pages') .'/'. $id;
        $data['back'] = route('admin.pages');

        $data['page'] = Page::find($id); 

        return view("admin.pages.page-form", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'keywords' => 'nullable',
            'robots' => 'nullable',
            'googlebot' => 'nullable',
            'tags' => 'nullable',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Page::where('id', $id)->update($validated);

        return redirect()->route('admin.pages')->with('success', 'Page updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Page::find($id)->delete();

        return redirect()->route('admin.pages')->with('success','Page deleted successfully');
    }
}
