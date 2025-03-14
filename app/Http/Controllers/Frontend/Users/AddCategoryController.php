<?php

namespace App\Http\Controllers\Frontend\Users;

use Illuminate\Support\Str;
use App\Models\NoteCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AddCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['heading_title'] = "Chapter List";
        $data['list_title'] = "Chapter List";

        $data['breadcrumbs'][] = [
            'text' => 'Dashboard',
            'href' => route('frontend.dashboard'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Chapter List',
            'href' => null
        ];

        $data['action'] = route('frontend.chapter');

        $data['category'] = NoteCategory::where('user_id', Auth::id())->paginate();

        return view('frontend.users.category-list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['heading_title'] = "Add Chapter";
        $data['list_title'] = "Add Chapter";

        $data['breadcrumbs'][] = [
            'text' => 'Dashboard',
            'href' => route('frontend.dashboard'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Add Chapter',
            'href' => route('frontend.chapter'). '/create'
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Add Chapter',
            'href' => null
        ];

        $data['action'] = route('frontend.chapter');

        return view('frontend.users.add-category', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => 'required|max:255',
            "sort_by" => "nullable|numeric"
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['status'] = "Private";
        $validated['user_id'] = Auth::id();

        NoteCategory::create($validated);

        return back()->withSuccess('Chapter Added Successfully');
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
        $data['category'] = NoteCategory::where('user_id', Auth::id())->where('id', $id)->first();

       $data['heading_title'] = "Edit Chapter";
        $data['list_title'] = "Edit Chapter";

        $data['breadcrumbs'][] = [
            'text' => 'Dashboard',
            'href' => route('frontend.dashboard'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Edit Chapter',
            'href' => route('frontend.chapter.edit', $data['category']->id)
        ];
        $data['breadcrumbs'][] = [
            'text' => $data['category']->name,
            'href' => null
        ];

        $data['action'] = route('frontend.chapter.update', $data['category']->id);

        return view('frontend.users.add-category', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            "name" => 'required|max:255',
            "sort_by" => "nullable|numeric"
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['status'] = "Private";

        NoteCategory::where('user_id', Auth::id())->where('id', $id)->update($validated);

        return back()->withSuccess('Chapter Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        NoteCategory::where('user_id', Auth::id())->where('id', $id)->delete();

        return back()->withSuccess('Chapter Deleted Successfully');
    }
}
