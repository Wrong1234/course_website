<?php
// use App\Models\Course;
// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\CourseController;
// use App\Http\Controllers\AuthController;
// use App\Services\WhatsAppService;

// //course routes
// // Route::get('/', [CourseController::class, 'index'])->name('index');
// Route::resource('courses', CourseController::class);
// Route::get('/courses/{course}/modules', [CourseController::class, 'modules'])->name('courses.modules');
// Route::post('/courses/{course}/duplicate', [CourseController::class, 'duplicate'])->name('courses.duplicate');

// // Authentication routes
// // Route::get('/', [AuthController::class, 'dashboard'])->name('dashboard');
// Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
// Route::post('/signup', [AuthController::class, 'signup']);
// Route::get('/verify-otp', [AuthController::class, 'showOtpForm'])->name('otp.verify.form');
// Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('otp.verify');
// Route::get('/verify-email/{token}', [AuthController::class, 'verifyByLink'])->name('email.verify.link'); 
// Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('otp.resend');
// Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [AuthController::class, 'login']);
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// // Home route with WhatsApp integration
// Route::get('/', function () {
//     try {
//         $whatsAppService = new WhatsAppService();
//         $whatsAppData = $whatsAppService->getWhatsAppData(
//             'Hello! I visited your homepage and would like to know more!',
//             'Get Started on WhatsApp',
//             'btn btn-success btn-lg'
//         );

//         return view('courses.index', $whatsAppData, [
//            'courses' => $courses = Course::withCount('modules')->latest()->paginate(3),
//         ])->name('index');

//     } catch (\Exception $e) {
//         // Log::error('Homepage WhatsApp integration failed', ['error' => $e->getMessage()]);

//         return view('courses.index', [
//             'whatsAppUrl' => null,
//             'isAvailable' => false,
//             'errors' => ['WhatsApp service temporarily unavailable'],
//             'courses' => []
//         ]);
//     }
// });

// // Test route for debugging
// Route::get('/test-whatsapp', function () {
//     $service = new WhatsAppService();
    
//     return response()->json([
//         'is_available' => $service->isAvailable(),
//         'errors' => $service->getErrors(),
//         'sample_url' => $service->generateChatUrl('Test message'),
//         'sample_data' => $service->getWhatsAppData('Test message', 'Test Button', 'btn btn-test')
//     ]);
// });

use App\Models\Course;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Services\WhatsAppService;

// Public routes
Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup']);
Route::get('/verify-otp', [AuthController::class, 'showOtpForm'])->name('otp.verify.form');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('otp.verify');
Route::get('/verify-email/{token}', [AuthController::class, 'verifyByLink'])->name('email.verify.link');
Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('otp.resend');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Home/Index route - accessible to all users
Route::get('/', [HomeController::class, 'index'])->name('index');

// Protected routes - require authentication
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard route
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    
    // Course routes
    Route::resource('courses', CourseController::class);
    Route::get('/courses/{course}/modules', [CourseController::class, 'modules'])->name('courses.modules');
    Route::post('/courses/{course}/duplicate', [CourseController::class, 'duplicate'])->name('courses.duplicate');
    
    // Contact route
    Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
    
    // Logout route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Test route for debugging WhatsApp (remove in production)
Route::get('/test-whatsapp', function () {
    try {
        $service = new WhatsAppService();
        
        return response()->json([
            'is_available' => $service->isAvailable(),
            'errors' => $service->getErrors(),
            'sample_url' => $service->generateChatUrl('Test message'),
            'sample_data' => $service->getWhatsAppData('Test message', 'Test Button', 'btn btn-test')
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'WhatsApp service failed',
            'message' => $e->getMessage()
        ], 500);
    }
});