<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Frontend\CommentController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Frontend\Auth\LoginController;
use App\Http\Controllers\Frontend\Users\NoteController;
use App\Http\Controllers\Frontend\Auth\GoogleController;
use App\Http\Controllers\Frontend\Users\AddCategoryController;
use App\Http\Controllers\Frontend\PageController as FrontendPageController;
use App\Http\Controllers\Frontend\PostController as FrontendPostController;
use App\Http\Controllers\Frontend\Users\DashboardController as UsersDashboardController; 

// tool routes
require_once __DIR__ . '/tool.php';

Route::get('admin', function () {
    return "kkk";
    return redirect('/admin/login');
});

Route::name('admin.')->prefix('admin')->group(function () {

    Route::middleware('LogoutMiddleware')->group(function (){
        Route::get('login', [AuthController::class, 'index'])->name('login');
        Route::post('login', [AuthController::class, 'login']);
        Route::get('forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');
        Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
        Route::get('change-password', [AuthController::class, 'showChangePassword'])->name('change-password');
        Route::post('change-password', [AuthController::class, 'changePassword']);
        Route::get('verify-otp', [AuthController::class, 'showVerifyOtp'])->name('verify-otp');
        Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
    });
    
    Route::middleware(['LoginMiddleware'])->group(function () {
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
        
        Route::get('dashboard', [DashboardController::class,'index'])->name('dashboard');

        Route::resource('user', UserController::class)->name('index', 'user');

        Route::resource('banner', BannerController::class)->name('index', 'banner');

        Route::resource('profile', ProfileController::class)->name('index', 'profile')->only('index', 'edit', 'update');
        Route::get('change-password', [ProfileController::class,'changePassword'])->name('changePassword');
        Route::post('change-password', [ProfileController::class,'savePassword'])->name('savePassword');

        Route::resource('posts', PostController::class)->name('index', 'posts');

        Route::resource('pages', PageController::class)->name('index', 'pages');

        Route::get('edit-setting', [SettingController::class,'edit'])->name('setting');
        Route::post('update-setting', [SettingController::class,'update'])->name('updateSetting');

        Route::get('subscriber', [SubscriberController::class, 'index'])->name('subscriber');

        // media
        Route::get('media', [MediaController::class, 'index'])->name('media');
        Route::post('media/uploadFile', [MediaController::class, 'uploadFile'])->name('uploadFile');
        Route::get('media/getFiles', [MediaController::class, 'getFiles'])->name('getFiles');
        Route::post('media/createFolder', [MediaController::class, 'createFolder'])->name('createFolder');
        Route::post('media/delete', [MediaController::class, 'delete'])->name('deleteMedia');

        Route::resource('category', CategoryController::class)->name('index', 'category');
        Route::resource('sub-category', SubCategoryController::class)->name('index', 'subcategory');

        Route::get('view-permission', [PermissionController::class, 'viewPermission'])->name('viewPermission');
        Route::post('give-permission', [PermissionController::class, 'givePermission'])->name('givePermission');
        Route::get('get-permission/{user_id}', [PermissionController::class, 'getPermission']);
    });

});

Route::name('frontend.')->group(function () {

    Route::middleware('FrontendLogoutMiddleware')->group(function (){
        // Google Login
        Route::get('login', [LoginController::class, 'login'])->name('login');
        Route::controller(GoogleController::class)->group(function(){
            Route::get('auth/google', 'redirectToGoogle')->name('googlelogin');
            Route::get('auth/google/callback', 'handleGoogleCallback');
        });
    });

    Route::middleware(['FrontendLoginMiddleware'])->group(function ($request) {
        route::prefix('user/')->group(function () {
            Route::get('logout', [LoginController::class, 'logout'])->name('logout');
            Route::get('dashboard', [UsersDashboardController::class, 'index'])->name('dashboard');
            Route::resource('note', NoteController::class)->name('index', 'note');
            Route::resource('chapter', AddCategoryController::class)->name('index', 'chapter');
        });
    });

    Route::get('/', [HomeController::class, 'home'])->name('home');
    Route::get('category/{catagory_slug}', [FrontendPostController::class, 'post'])->name('post');
    Route::get('post/{slug}', [FrontendPostController::class, 'postShow'])->name('postShow');
    Route::post('email-subscribe', [HomeController::class, 'subscribe'])->name('subscribe');
    
    Route::get('get-comment/{post_id}', [CommentController::class, 'getComment'])->name('getComment');
    Route::post('comment', [CommentController::class, 'comment'])->name('comment');

    Route::get('{slug}', [FrontendPageController::class, 'page'])->name('page');
});