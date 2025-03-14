<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function viewPermission(){

        $user = Auth::user();
        if (!$user->can('view_permission')) {
            return back()->withError('You don\'t have permission to access this.');
        }

        $data['heading_title'] = "Permission";
        $data['list_title'] = "Permission";

        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => route('admin.dashboard'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Permissions',
            'href' => null
        ];

        $data['action'] = route('admin.givePermission');

        $data['users'] = User::where('role', 'admin')->select('id', 'name', 'email')->get();

        $data['permissions'] = Permission::all();

        return view('admin.setting.permission', $data);
    }

    public function givePermission(Request $request){

        $request->validate([
            "user_id" => 'required',
            "permissions" => 'required|array'
        ]);
        
        $user = User::findOrFail($request->user_id);

        // Get valid permissions from the database
        $validPermissions = Permission::whereIn('name', $request->permissions)->pluck('name')->toArray();

        // Sync user permissions (add new, remove missing)
        $user->syncPermissions($validPermissions);

        return back()->withSuccess('Permission Changed Successfully');
    }

    public function getPermission($user_id = null){
        $user = User::where('id', $user_id)->first();

        return response()->json([
            'data' => $user->getAllPermissions()
        ]);
    }
}
