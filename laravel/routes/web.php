<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StampController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\RegisteredUserController;

// 打刻ページ
Route::get('/', [StampController::class, 'stamp'])->name('stamp');

// 日付別勤怠ページ
Route::get('/attendance', [AttendanceController::class, 'attendance'])->name('attendance');

// ログインページ
Route::get('/login', [AuthenticatedSessionController::class, 'login'])->name('login');

// 会員登録ページ
Route::get('/register', [RegisteredUserController::class, 'register'])->name('register');