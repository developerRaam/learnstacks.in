<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // check permission
        if (!auth()->user()->can('view_user')) {
            return back()->withError('You don\'t have permission to access this.');
        }

        $data['heading_title'] = "Users";
        $data['list_title'] = "User List";

        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => route('admin.dashboard'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Users',
            'href' => null
        ];

        $query = User::where('role', 'user')->orWhere('role', 'admin');

        // Apply filters
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('users.name', 'like', '%' . $request->search . '%')
                ->orWhere('users.email', 'like', '%' . $request->search . '%')
                ->orWhere('users.phone', 'like', '%' . $request->search . '%');
            });
        }

        // filter by date
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('users.created_at', [
                $request->start_date . ' 00:00:00',  
                $request->end_date . ' 23:59:59'     
            ]);
        } elseif ($request->filled('start_date')) {
            $query->whereDate('users.created_at', '>=', $request->start_date);
        } elseif ($request->filled('end_date')) {
            $query->whereDate('users.created_at', '<=', $request->end_date);
        }

        $data['users'] = $query->latest('users.created_at')->paginate();

        $data['add'] = route('admin.user.create');

        return view("admin.user.user", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['heading_title'] = "Add User";
        $data['list_title'] = "Add User";

        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => route('admin.dashboard'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Users',
            'href' => route('admin.user'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Add User',
            'href' => null
        ];

        $data['action'] = route('admin.user');

        return view("admin.user.user-form", $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string",
            "username" => "required|unique:users,username",
            "email" => "required|email|unique:users,email",
            "role" => "required",
            'new_password' => 'required|string|min:4|max:255',
            'confirm_password' => 'required|string|min:4|max:255',
        ]);

        if($validated['new_password'] != $validated['confirm_password']){
            return back()->withError('Password not changed successfully');
        }

        User::create([
            "name" => $validated['name'],
            "username" => $validated['username'],
            "email" => $validated['email'],
            "role" => $validated['role'],
            "password" => Hash::make($validated['new_password']),
            "status" => true,
        ]);

        return redirect()->route('admin.user')->with('success','User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // check permission
        // if (!auth()->user()->can('show_user')) {
        //     return response()->json([
        //         "success" => false,
        //         "message" => 'You don\'t have permission to access this.'
        //     ]);
        // }

        $user = User::where('users.id', $id)->firstOrFail();

        return response()->json([
            "success" => true,
            "user" => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['heading_title'] = "Edit user";
        $data['list_title'] = "Edit user";

        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => route('admin.dashboard'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Users',
            'href' => route('admin.user'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Edit User',
            'href' => null
        ];

        $data['action'] = route('admin.user') .'/'. $id;
        $data['back'] = route('admin.user');

        $data['user'] = User::find($id);

        return view("admin.user.user-form", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request data
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|string|email|max:255|unique:users,email,$id",
            "role" => "required|string",
            'new_password' => 'nullable|string|min:4|max:255',
            'confirm_password' => 'nullable|string|min:4|max:255',
        ]);

        $user = User::findOrFail($id);

        if ($request->filled('new_password') || $request->filled('confirm_password')) {
            if ($validated['new_password'] !== $validated['confirm_password']) {
                return back()->withErrors(['password' => 'Passwords do not match.'])->withInput();
            }
            $validated['password'] = Hash::make($validated['new_password']);
        }

        $updateData = [
            "name" => $validated['name'],
            "email" => $validated['email'],
            "role" => $validated['role'],
        ];

        if (isset($validated['password'])) {
            $updateData['password'] = $validated['password'];
        }

        $user->update($updateData);
        
        return redirect()->route('admin.user')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
