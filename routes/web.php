<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('courses.index');
});

Route::resource('courses', CourseController::class);

// Additional routes if needed
Route::get('/courses/{course}/modules', [CourseController::class, 'modules'])->name('courses.modules');
Route::post('/courses/{course}/duplicate', [CourseController::class, 'duplicate'])->name('courses.duplicate');



// Authentication routes
Route::get('/', [AuthController::class, 'dashboard'])->name('dashboard');
Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup']);
Route::get('/verify-otp', [AuthController::class, 'showOtpForm'])->name('otp.verify.form');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('otp.verify');
Route::get('/verify-email/{token}', [AuthController::class, 'verifyByLink'])->name('email.verify.link'); // New route
Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('otp.resend');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');