<?php

use Illuminate\Support\Facades\Route;
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

