<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\RegisteredUserController;

// 打刻ページ
Route::get('/', [AttendanceController::class, 'stamp'])->name('stamp');

// ログインページ
Route::get('/login', [AuthenticatedSessionController::class, 'login'])->name('login');

// 会員登録ページ
Route::get('/register', [RegisteredUserController::class, 'register'])->name('register');

//
