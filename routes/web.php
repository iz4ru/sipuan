<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\Auth\AdminLoginController;

# Landing Page
Route::get('/', [HomeController::class, 'index']);

# Search Staff
Route::get('staff', [SearchController::class, 'index'])->name('search.staff');

# Rate Staff
Route::get('rate/{uuid}', [RatingController::class, 'index'])->name('rate');
Route::post('rate/{uuid}', [RatingController::class, 'store'])->name('rate.store');

# Password Reset
Route::get('/forgot-password', [ResetPasswordController::class, 'index'])->middleware('guest')->name('password.request');
Route::post('/forgot-password', [ResetPasswordController::class, 'sendResetLink'])->middleware('guest')->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'resetForm'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->middleware('guest')->name('password.update');

# Admin Authentication
Route::middleware('guest') -> group(function (){
    Route::get('auth', [AdminLoginController::class, 'index'])->name('admin.login');
    Route::post('auth', [AdminLoginController::class, 'loginAction'])->name('admin.login.action');
    Route::get('auth/register', [AdminLoginController::class, 'registerFirstAdmin'])->name('admin.register');
    Route::post('auth/register', [AdminLoginController::class, 'storeFirstAdmin'])->name('admin.register.store');
});

Route::middleware('auth') -> group(function (){

    # Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    # Profile
    Route::get('admin/profile', [ProfileController::class, 'index'])->name('admin.profile');
    Route::put('admin/profile/update/{uuid}', [ProfileController::class, 'update'])->name('admin.profile.update');

    # Admin Management
    Route::get('admin-mgmt', [AdminController::class, 'index'])->name('admin.mgmt');
    Route::get('admin-mgmt/create', [AdminController::class, 'create'])->name('admin.mgmt.create');
    Route::post('admin-mgmt/store', [AdminController::class, 'store'])->name('admin.mgmt.store');
    Route::get('admin-mgmt/edit/{uuid}', [AdminController::class, 'show'])->name('admin.mgmt.edit');
    Route::put('admin-mgmt/update/{uuid}', [AdminController::class, 'update'])->name('admin.mgmt.update');
    Route::delete('admin-mgmt/delete/{uuid}', [AdminController::class, 'destroy'])->name('admin.mgmt.delete');
    Route::get('admin-mgmt/edit_password/{uuid}', [AdminController::class, 'editPassword'])->name('admin.mgmt.edit_password');
    Route::put('admin-mgmt/update_password/{uuid}', [AdminController::class, 'updatePassword'])->name('admin.mgmt.update_password');

    # Staff Management
    Route::get('staff-mgmt', [StaffController::class, 'index'])->name('staff.mgmt');
    Route::get('staff-mgmt/create', [StaffController::class, 'create'])->name('staff.mgmt.create');
    Route::post('staff-mgmt/store', [StaffController::class, 'store'])->name('staff.mgmt.store');
    Route::get('staff-mgmt/edit/{uuid}', [StaffController::class, 'show'])->name('staff.mgmt.edit');
    Route::put('staff-mgmt/update/{uuid}', [StaffController::class, 'update'])->name('staff.mgmt.update');
    Route::delete('staff-mgmt/delete/{uuid}', [StaffController::class, 'destroy'])->name('staff.mgmt.delete');
    Route::get('staff-mgmt/details/{uuid}', [StaffController::class, 'preview'])->name('staff.mgmt.details');

    # Load Comments
    Route::get('staff-mgmt/details/{uuid}/comments', [StaffController::class, 'loadComments'])->name('staff.mgmt.load_comments');

    # Position Management
    Route::get('position', [PositionController::class, 'index'])->name('position');
    Route::get('position/create', [PositionController::class, 'create'])->name('position.create');
    Route::post('position/store', [PositionController::class, 'store'])->name('position.store');
    Route::get('position/edit/{id}', [PositionController::class, 'show'])->name('position.edit');
    Route::put('position/update/{id}', [PositionController::class, 'update'])->name('position.update');
    Route::delete('position/delete/{id}', [PositionController::class, 'destroy'])->name('position.delete');

    # Tag Management
    Route::get('tag', [TagController::class, 'index'])->name('tag');
    Route::get('tag/create', [TagController::class, 'create'])->name('tag.create');
    Route::post('tag/store', [TagController::class, 'store'])->name('tag.store');
    Route::get('tag/edit/{id}', [TagController::class, 'show'])->name('tag.edit');
    Route::put('tag/update/{id}', [TagController::class, 'update'])->name('tag.update');
    Route::delete('tag/delete/{id}', [TagController::class, 'destroy'])->name('tag.delete');

    # Logs
    Route::get('logs', [LogController::class, 'index'])->name('admin.logs');

    # Logout
    Route::post('auth/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
});
