<?php

namespace App\Http\Controllers\Admin;

use App\Mail\Email;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index(){
        $data['action'] = route('admin.login');
        $data['route_forgot'] = route('admin.forgot-password');
        return view("admin.login", $data);
    }


    public function login(Request $request){
        // Validate the input fields
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log in the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $user = Auth::user();

            if ($user->role === 'superadmin' || $user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Login successful.');
            } else {
                Auth::logout();
                return redirect()->route('admin.login')->with('error', 'Access denied.');
            }
        }

        return redirect()->route('admin.login')->with('error', 'Invalid email or password.');
    }


    public function logout(){
        Auth::logout();
        Session::flush();
        return redirect()->route('admin.login')->with('success', 'Logout');
    }

    
    public function showForgotPassword(){
        $data['action'] = route('admin.forgot-password');
        return view('admin.forgot-password', $data);
    }

    
    public function forgotPassword(Request $request){

        $validator = $request->validate([
            'email' => 'required|string|max:50',
        ]);

        // verify email
        $getEmail = User::where('email', $validator['email'])->first();

        if($getEmail){
            $subject = 'Reset Password via OTP';
            $text = "Your OTP is: ";

            // send mail
            self::sendMail($validator['email'], $subject, $text);

            Session::put('otp_page_token', Str::random(60));
            Session::put('user_email', $validator['email']);

            return redirect()->route('admin.verify-otp')->with('success', "Email sent successfully! Please check email and reset password.");
        }
        return redirect()->route('admin.forgot-password')->with('email_not_match', 'Email does not exists.');
    }

    
    public function showVerifyOtp(){ 
        $otp_page_token = session('otp_page_token');
        
        if(!$otp_page_token){
            return redirect()->route('admin.login')->with('error', 'Invalid Page');
        }

        $data['action'] = route('admin.verify-otp');
        return view('admin.verify-otp', $data);
    }

    
    public function verifyOtp(Request $request){
        $request->validate([
            'otp'=> 'required|numeric',
        ]);

        $getSessionOtp = Session::get('email_otp');
        $getOtp = $request->request->get('otp');

        if($getOtp != $getSessionOtp){
            return redirect()->route('admin.verify-otp')->with('error', 'The OTP you entered is incorrect. Please check your email and try again.');
        }

        session()->forget('otp_page_token');
        Session::put('password_page_token', Str::random(60));

        return redirect()->route('admin.change-password')->with('success','OTP verified now you can change your password');
    }

    
    public function showChangePassword(){
        $password_page_token = session('password_page_token');
        
        if(!$password_page_token){
            return redirect()->route('admin.login')->with('error', 'Invalid Page');
        }

        $data['action'] = route('admin.change-password');
        return view('admin.change-password', $data);
    }

    
    public function changePassword(Request $request){
        $validator = $request->validate( [
            'password' => 'required|string|min:4|max:20',
            'confirm_password' => 'required|string|min:4|max:20',
        ],[
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 4 characters.',
            'confirm_password.required' => 'The confirm password field is required.',
            'confirm_password.min' => 'The confirm password must be at least 4 characters.',
        ]);

        // checking password
        if($validator['password'] != $validator['confirm_password']){
            return redirect()->route('admin.change-password')->with('password_not_match', 'The password does not match.');
        }

        User::where('email', session('user_email'))->update([
            "password" => Hash::make($validator['password'])
        ]);

        session()->forget('password_page_token');
        session()->forget('user_email');

        return redirect()->route('admin.login')->with('success', "Password updated successfully!");

    }

    
    public function sendMail($email, $subject, $text){
        $otp = rand(100000, 999999);
        $emailData = [
            "subject" => $subject,
            "text" => $text,
            "email_otp" => $otp
        ];
        Session::put('email_otp', $otp);
        Mail::to($email)->send(new Email($emailData));
    }

}
