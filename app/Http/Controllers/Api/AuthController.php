<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->headers->set('Access-Control-Allow-Origin', '*'); // prvent cors error

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->where('role', 'User')->first();

        if($user) {
            if ($user->status == 0) {
                return response()->json([
                    'status' => false,
                    'message' => 'Your account is blocked. Please contact admin.'
                ]);
            }

            if (Hash::check($request->password, $user->password)) {
                $user->tokens()?->delete();

                if ($request->fcm) {
                    $user->update(['fcm' => $request->fcm]);
                }

                return response()->json([
                    'status' => true,
                    'token' => $user->createToken($request->email)->plainTextToken,
                    'user' =>  $user->refresh()
                ], Response::HTTP_CREATED);
            }
        }

        return response()->json([
            'status' => false,
            'message' => 'Email and password does not match.'
        ]);
    }

    public function signup(Request $request)
    {
        $request->headers->set('Access-Control-Allow-Origin', '*'); // prvent cors error

        $validated =  $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:4|max:20',
        ]);

        
        $custom = [
            "country" => $request->location['country'] ?? "",
            "countryCode" => $request->location['countryCode'] ?? "",
            "region" => $request->location['region'] ?? "",
            "city" => $request->location['city'] ?? "",
            "zip" => $request->location['zip'] ?? "",
            "lat" => $request->location['lat'] ?? "",
            "lon" => $request->location['lon'] ?? "",
            "timezone" => $request->location['timezone'] ?? "",
            "isp" => $request->location['isp'] ?? "",
            "ip" => $request->location['query'] ?? "",
        ];
        
        $validated['custom'] = json_encode($custom);
        $validated['status'] = true;
        $validated['role'] = 'User';
        
        $user = User::create($validated);

        $user->tokens()?->delete();

        if ($request->fcm) {
            $user->update(['fcm' => $request->fcm]);
        }

        return response()->json([
            'msg' => true,
            'token' => $user->createToken($request->email)->plainTextToken,
            'user' =>  $user->refresh()
        ], Response::HTTP_CREATED);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'msg' => 'User logged Out Successfully',
        ], Response::HTTP_OK);
    }
}
