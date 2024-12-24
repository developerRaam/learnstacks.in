<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['heading_title'] = "Profiles";
        $data['list_title'] = "Profile List";

        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => route('admin.dashboard'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Profiles',
            'href' => null
        ];

        $data['profiles'] = User::where('role', 'Admin')->get();

        return view("admin.profile.profile", $data);

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['heading_title'] = "Edit Profile";
        $data['list_title'] = "Edit Profile";

        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => route('admin.dashboard'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Profiles',
            'href' => route('admin.profile'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Edit Profile',
            'href' => null
        ];

        $data['action'] = route('admin.profile') .'/'. $id;
        $data['back'] = route('admin.profile');

        $data['profile'] = User::where('id', $id)->where('role', 'Admin')->first();

        return view("admin.profile.profile-form", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            "name" => "required|string",
            "email" => "required|string|email",
            "logo" => "nullable|file|mimes:jpg,jpeg,png|max:2048",
        ]);

        $profile = User::find(session('isUser'));

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('users', 'public');
            if ($profile->avatar) {
                Storage::disk('public')->delete($profile->avatar);
            }
            $validated['avatar'] = $avatarPath;
        }

        $profile->update($validated);

        return redirect()->route('admin.profile')->with('success','Profile updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function changePassword(){
        $data['heading_title'] = "Change Password";
        $data['list_title'] = "Change Password";

        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => route('admin.dashboard'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Profiles',
            'href' => route('admin.profile'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Change Password',
            'href' => null
        ];

        $data['action'] = Route('admin.savePassword');
        $data['back'] = route('admin.dashboard');
        
        return view('admin.profile.change-password', $data);
    }

    public function savePassword(Request $request){
        $validated = $request->validate([
            'new_password' => 'required|string|min:4|max:255',
            'confirm_password' => 'required|string|min:4|max:255',
        ]);
        
        if($validated['new_password'] === $validated['confirm_password']){

            User::where('id', session('isUser'))->update([
                'password'=> Hash::make($validated['new_password'])
            ]);
    
            return redirect()->route('admin.changePassword')->with('success', 'Password changed successfully');

        }else{
            return redirect()->route('admin.changePassword')->with('error', 'Password does not match.');
        }

    }
}
