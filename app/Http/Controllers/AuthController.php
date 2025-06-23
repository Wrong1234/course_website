<?php
// Updated AuthController with proper user verification handling
// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Services\OtpService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function showSignupForm()
    {
        return view('auth.signup');
    }

    // public function dashboard()
    // {
    //     // Ensure the user is authenticated
    //     if (!Auth::check()) {
    //         return redirect()->route('login')->with('error', 'Please login first.');
    //     }

    //     // Return the dashboard view
    //     return view('auth.dashboard');
    // }

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Create user but don't verify email yet
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => null,
            'verified' => false, // Explicitly set verified to false
        ]);

        // Generate and send OTP with verification link
        $this->otpService->generateOtp($request->email);

        return redirect()->route('otp.verify.form')
                        ->with('email', $request->email)
                        ->with('success', 'Account created! Please check your email for verification. You can either enter the OTP code or click the verification link.');
    }

    public function showOtpForm()
    {
        if (!session('email')) {
            return redirect()->route('signup')->with('error', 'Please signup first.');
        }
        
        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        if ($this->otpService->verifyOtp($request->email, $request->otp)) {
            return $this->completeEmailVerification($request->email);
        }

        return back()->with('error', 'Invalid or expired OTP. Please try again.');
    }

    // New method to handle verification link
    public function verifyByLink($token)
    {
        $email = $this->otpService->verifyByToken($token);
        
        if (!$email) {
            return redirect()->route('login')
                           ->with('error', 'Invalid or expired verification link.');
        }

        return $this->completeEmailVerification($email);
    }

    // Updated helper method to complete email verification
    private function completeEmailVerification($email)
    {
        // Find user by email
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            return redirect()->route('login')
                           ->with('error', 'User not found.');
        }

        // Check if user is already verified
        if ($user->email_verified_at && $user->verified) {
            return redirect()->route('login')
                           ->with('success', 'Email already verified! You can now login.');
        }

        // Update both email_verified_at and verified columns
        $user->update([
            'email_verified_at' => Carbon::now(),
            'verified' => true
        ]);


        return redirect()->route('login')
                       ->with('success', 'Email verified successfully! You can now login.');
    }

    public function resendOtp(Request $request)
    {
        $email = $request->email ?? session('email');
        
        if (!$email) {
            return back()->with('error', 'Email not found.');
        }

        // Check if user exists and is not already verified
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            return back()->with('error', 'User not found.');
        }

        if ($user->verified && $user->email_verified_at) {
            return redirect()->route('login')
                           ->with('success', 'Email is already verified! You can login now.');
        }

        $this->otpService->generateOtp($email);
        
        return back()->with('success', 'New OTP and verification link sent successfully!');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->with('error', 'Invalid credentials.');
        }

        // Check both email_verified_at and verified columns
        if (!$user->email_verified_at || !$user->verified) {
            // Generate new OTP and verification link
            $this->otpService->generateOtp($user->email);
            return redirect()->route('otp.verify.form')
                           ->with('email', $user->email)
                           ->with('error', 'Please verify your email first. We\'ve sent a new OTP and verification link.');
        }

        if (Auth::attempt($credentials)) {
             $request->session()->regenerate();
            // dd('Login successful, redirecting...', Auth::user());
            return redirect()->route('index') // Adjust this route as needed
                             ->with('success', 'Login successful!');
        }

        return back()->with('error', 'Invalid credentials.');
    }
  

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

}