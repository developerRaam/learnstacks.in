<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\HomeController;

Route::get('/admin', function () {
    return redirect()->route('admin.login');
});

Route::name('admin.')->group(function () {

    Route::middleware('LogoutMiddleware')->group(function (){
        Route::prefix('admin/')->group(function (){
            Route::get('login', [AuthController::class, 'index'])->name('login');
            Route::post('login', [AuthController::class, 'login']);
            Route::get('forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');
            Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
            Route::get('change-password', [AuthController::class, 'showChangePassword'])->name('change-password');
            Route::post('change-password', [AuthController::class, 'changePassword']);
            Route::get('verify-otp', [AuthController::class, 'showVerifyOtp'])->name('verify-otp');
            Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
        });
    });
    
    Route::middleware(['LoginMiddleware'])->prefix('admin/')->group(function () {
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
        
        Route::get('dashboard', [DashboardController::class,'index'])->name('dashboard');

        Route::resource('user', UserController::class)->name('index', 'user')->only('index', 'show', 'update');

        Route::resource('banner', BannerController::class)->name('index', 'banner');

        Route::resource('profile', ProfileController::class)->name('index', 'profile')->only('index', 'edit', 'update');
        Route::get('change-password', [ProfileController::class,'changePassword'])->name('changePassword');
        Route::post('change-password', [ProfileController::class,'savePassword'])->name('savePassword');

    });

});

Route::name('frontend.')->group(function () {
    Route::get('/', [HomeController::class, 'home'])->name('home');
    Route::get('blog', [BlogController::class, 'blog'])->name('blog');
});