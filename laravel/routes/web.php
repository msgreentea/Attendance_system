<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StampController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

// 打刻ページ
Route::get('/', [StampController::class, 'index'])->name('stamp.index');
Route::post('/punchin', [StampController::class, 'punchin'])->name('punchin');
Route::post('/punchout', [StampController::class, 'punchout'])->name('punchout');
Route::post('/breakin', [StampController::class, 'breakin'])->name('breakin');
Route::post('/breakout', [StampController::class, 'breakout'])->name('breakout');

// 日付別勤怠ページ
Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');

// ログインページ
Route::get('/login', [AuthController::class, 'show'])->name('show');

// 会員登録ページ
Route::get('/register', [UserController::class, 'create'])->name('create');