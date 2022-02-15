<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StampController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;



// 打刻ページ
Route::get('/', [StampController::class, 'index'])->middleware("auth")->name('stamp.index');

Route::post('/punchin', [StampController::class, 'punchin'])->middleware("auth")->name('punchin');
Route::post('/punchout', [StampController::class, 'punchout'])->middleware("auth")->name('punchout');
Route::post('/breakin', [StampController::class, 'breakin'])->middleware("auth")->name('breakin');
Route::post('/breakout', [StampController::class, 'breakout'])->middleware("auth")->name('breakout');

// 会員登録ページ
Route::get('/register', [UserController::class, 'create'])->name('register.create');
Route::post('/register', [UserController::class, 'store'])->name('register.store');

// ログインページ
Route::get('/login', [AuthController::class, 'show'])->name('auth.show');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware("auth")->name('auth.logout');
Route::get('/logout', [AuthController::class, 'logout'])->middleware("auth")->name('auth.logout');

// 日付別勤怠ページ
// Route::get('/attendance/{id}', [AttendanceController::class, 'index'])->middleware("auth")->name('attendance.index');
Route::get('/attendance', [AttendanceController::class, 'index'])->middleware("auth")->name('attendance.index');