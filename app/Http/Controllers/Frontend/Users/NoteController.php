<?php

namespace App\Http\Controllers\Frontend\Users;

use App\Models\Note;
use Illuminate\Support\Str;
use App\Models\NoteCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['heading_title'] = "Note List";
        $data['list_title'] = "Note List";

        $data['breadcrumbs'][] = [
            'text' => 'Dashboard',
            'href' => route('frontend.dashboard'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Note List',
            'href' => null
        ];

        $data['action'] = route('frontend.note');

        $data['notes'] = Note::with('noteCategory')->where('id', Auth::id())->paginate();

        return view('frontend.users.note-list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['heading_title'] = "Add Note";
        $data['list_title'] = "Add Note";

        $data['breadcrumbs'][] = [
            'text' => 'Dashboard',
            'href' => route('frontend.dashboard'),
        ];

        $data['breadcrumbs'][] = [
            'text' => 'Add Note',
            'href' => null
        ];

        $data['action'] = route('frontend.note');

        $data['category'] = NoteCategory::where('user_id', Auth::id())->get();

        return view('frontend.users.add-note', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => 'required|max:255',
            "description" => "required",
            "category_id" => "nullable|numeric",
            "sort_by" => "nullable||numeric"
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['status'] = "Private";
        $validated['user_id'] = Auth::id();

        Note::create($validated);

        return back()->withSuccess('Note Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['note'] = Note::where('user_id', Auth::id())->where('id', $id)->first();

        $data['heading_title'] = "Note";
        $data['list_title'] = "Note";

        $data['breadcrumbs'][] = [
            'text' => 'Dashboard',
            'href' => route('frontend.dashboard'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Note',
            'href' => route('frontend.note.show', $data['note']->id)
        ];

        return view('frontend.users.show-note', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['note'] = Note::where('user_id', Auth::id())->where('id', $id)->first();
        
        $data['heading_title'] = "Edit Note";
        $data['list_title'] = "Edit Note";

        $data['breadcrumbs'][] = [
            'text' => 'Dashboard',
            'href' => route('frontend.dashboard'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Edit Note',
            'href' => route('frontend.note.edit', $data['note']->id)
        ];
        $data['breadcrumbs'][] = [
            'text' => $data['note']->name,
            'href' => null
        ];

        $data['action'] = route('frontend.note.update', $data['note']->id);

        $data['category'] = NoteCategory::where('user_id', Auth::id())->get();

        return view('frontend.users.add-note', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            "name" => 'required|max:255',
            "description" => "required",
            "category_id" => "nullable|numeric",
            "sort_by" => "nullable|numeric"
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['status'] = "Private";

        Note::where('user_id', Auth::id())->where('id', $id)->update($validated);

        return back()->withSuccess('Note Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Note::where('user_id', Auth::id())->where('id', $id)->delete();

        return back()->withSuccess('Note Deleted Successfully');
    }
}
