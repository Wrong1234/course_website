<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;

Route::get('/', function () {
    return redirect()->route('courses.index');
});

Route::resource('courses', CourseController::class);

// Additional routes if needed
Route::get('/courses/{course}/modules', [CourseController::class, 'modules'])->name('courses.modules');
Route::post('/courses/{course}/duplicate', [CourseController::class, 'duplicate'])->name('courses.duplicate');