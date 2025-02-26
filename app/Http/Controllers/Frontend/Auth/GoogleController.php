<?php

namespace App\Http\Controllers\Frontend\Auth;

use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $userData = Socialite::driver('google')
                ->setHttpClient(new \GuzzleHttp\Client(['verify' => false]))
                ->stateless()
                ->user();

            $user = User::where('email', $userData->email)->first();
            if ($user) {
                // Update Google ID if not set
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $userData->id,
                        'avatar'    => $userData->avatar,
                    ]);
                }

                Auth::login($user);
                
                if ($user->role === 'User') {
                    return redirect()->route('frontend.dashboard')->with('success', 'Login successful.');
                } else {
                    Auth::logout();
                    return redirect()->route('frontend.login')->with('error', 'Access denied.');
                }
            }
            
            $username = $this->generateUniqueUsername($userData->email);

            // Create a new user if not exists
            $newUser = User::create([
                'google_id'          => $userData->id,
                'name'               => $userData->name,
                'email'              => $userData->email,
                'username'           => $username,
                'avatar'             => $userData->avatar,
                'verified_email'     => true,
                'password'           => Hash::make(rand(1000, 9999)),
                'status'             => true,
                'role'               => 'User',
            ]);

            Auth::login($newUser);

            return redirect()->route('frontend.dashboard');

        } catch (Exception $e) {
            return redirect()->route('frontend.login')->with('error', 'Something went wrong. Please try again.');
        }
    }

    function generateUniqueUsername($email)
    {
        // Extract username from email
        $username = Str::slug(explode('@', $email)[0]);

        // Ensure username is at least 3 characters long
        if (strlen($username) < 3) {
            $username .= rand(100, 999);
        }

        // Check if username exists and make it unique
        $originalUsername = $username;
        $count = 1;

        while (User::where('username', $username)->exists()) {
            $username = $originalUsername . $count;
            $count++;
        }

        return $username;
    }
}
