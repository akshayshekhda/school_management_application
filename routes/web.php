<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Admin\ParentController as AdminParentController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\TeacherLoginController;
use App\Http\Controllers\Teacher\StudentController;
use App\Http\Controllers\Teacher\ParentController;
use App\Http\Controllers\Teacher\AnnouncementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Root route - Check auth status and redirect accordingly
Route::get('/', function () {
    if (auth()->guard('admin')->check()) {
        return redirect()->route('admin.dashboard');
    }
    if (auth()->guard('teacher')->check()) {
        return redirect()->route('teacher.dashboard');
    }
    return redirect()->route('admin.login');
});

// Guest Routes (only accessible when not logged in)
Route::middleware('guest:admin,teacher')->group(function () {
    // Admin Auth Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login'])->name('login.submit');
    });

    // Teacher Auth Routes
    Route::prefix('teacher')->name('teacher.')->group(function () {
        Route::get('/login', [TeacherLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [TeacherLoginController::class, 'login'])->name('login.submit');
    });
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

    // Teacher Management
    Route::resource('teachers', TeacherController::class);

    // Student Management
    Route::resource('students', AdminStudentController::class);

    // Parent Management
    Route::resource('parents', AdminParentController::class);

    // Announcement Management
    Route::resource('announcements', AdminAnnouncementController::class);
});

// Teacher Routes
Route::prefix('teacher')->name('teacher.')->middleware('auth:teacher')->group(function () {
    Route::get('/dashboard', function () {
        return view('teacher.dashboard');
    })->name('dashboard');
    Route::post('/logout', [TeacherLoginController::class, 'logout'])->name('logout');

    // Student Management
    Route::resource('students', StudentController::class);

    // Parent Management
    Route::resource('parents', ParentController::class);

    // Announcement Management
    Route::resource('announcements', AnnouncementController::class);
});