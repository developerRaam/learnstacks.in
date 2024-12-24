<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
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

        $query = User::where('role', 'User');

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

        if ($request->filled('plan')) {
            $query->where('users.plan_id', $request->plan);
        }

        $data['users'] = $query->latest('users.created_at')->paginate();

        return view("admin.user.user", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::where('users.id', $id)->where('role', 'User')->firstOrFail();

        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        

        return redirect()->route('admin.user')->with('error',"Invalid action");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
