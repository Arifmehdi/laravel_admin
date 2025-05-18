<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InventoryController;

Route::get('/', function () {
    return view('Auth.login');
});

Route::get('admin/dashboard',[DashboardController::class,'index'])->name('admin.dashboard');
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

Route::get('admin/blank',[DashboardController::class,'blank'])->name('admin.blank');
Route::get('admin/inventories',[InventoryController::class,'index'])->name('admin.inventory');
Route::get('admin/auto-news',[BlogController::class,'autoNews'])->name('admin.autoNews');
Route::get('admin/reviews',[BlogController::class,'reviews'])->name('admin.reviews');
Route::get('admin/tools-and-advice',[BlogController::class,'toolsAndAdvice'])->name('admin.toolsAndAdvice');
Route::get('admin/car-buying-advice',[BlogController::class,'carBuyingAdvice'])->name('admin.carBuyingAdvice');
Route::get('admin/car-tips',[BlogController::class,'carTips'])->name('admin.carTips');

Route::get('admin/news',[BlogController::class,'news'])->name('admin.news');
Route::get('admin/innovation',[BlogController::class,'innovation'])->name('admin.innovation');
Route::get('admin/opinion',[BlogController::class,'opinion'])->name('admin.opinion');
Route::get('admin/financial',[BlogController::class,'financial'])->name('admin.financial');

