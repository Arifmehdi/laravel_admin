<?php

use App\Http\Controllers\Admin\BannerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Auth\Authcontroller;

Route::get('/', function () {
    // return view('Auth.login');
    return redirect()->route('admin.login');
});


// Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');


// Route::get('admin/login',[LoginController::class,'index'])->name('admin.login');
// Route::post('admin/login',[LoginController::class,'login'])->name('admin.login.submit');
// Route::get('admin/logout',[LoginController::class,'logout'])->name('admin.logout');
// Route::get('admin/register',[RegisterController::class,'index'])->name('admin.register');
// Route::post('admin/register',[RegisterController::class,'register'])->name('admin.register.submit');
// Route::get('admin/forgot-password',[ForgotPasswordController::class,'index'])->name('admin.forgot.password');
// Route::post('admin/forgot-password',[ForgotPasswordController::class,'sendResetLink'])->name('admin.forgot.password.submit');
// Route::get('admin/reset-password/{token}',[ResetPasswordController::class,'index'])->name('admin.reset.password');
// Route::post('admin/reset-password',[ResetPasswordController::class,'reset'])->name('admin.reset.password.submit');
// Route::get('admin/profile',[ProfileController::class,'index'])->name('admin.profile');
// Route::post('admin/profile',[ProfileController::class,'update'])->name('admin.profile.update');
// Route::get('admin/change-password',[ChangePasswordController::class,'index'])->name('admin.change.password');
// Route::post('admin/change-password',[ChangePasswordController::class,'update'])->name('admin.change.password.update');

Route::prefix('admin')->as('admin.')->group(function () {
    Route::get('/login', [Authcontroller::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth.admin')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('blank', [DashboardController::class, 'blank'])->name('blank');
        Route::get('inventories', [InventoryController::class, 'index'])->name('inventory');

        Route::post('blog/store', [BlogController::class, 'store'])->name('blog.store');
        Route::get('auto-news', [BlogController::class, 'autoNews'])->name('autoNews');
        Route::get('reviews', [BlogController::class, 'reviews'])->name('reviews');
        Route::get('tools-and-advice', [BlogController::class, 'toolsAndAdvice'])->name('toolsAndAdvice');
        Route::get('car-buying-advice', [BlogController::class, 'carBuyingAdvice'])->name('carBuyingAdvice');
        Route::get('car-tips', [BlogController::class, 'carTips'])->name('carTips');

        Route::get('news', [BlogController::class, 'news'])->name('news');
        Route::get('innovation', [BlogController::class, 'innovation'])->name('innovation');
        Route::get('opinion', [BlogController::class, 'opinion'])->name('opinion');
        Route::get('financial', [BlogController::class, 'financial'])->name('financial');

        Route::get('banner', [BannerController::class, 'index'])->name('banner');
    });
});
