<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\RegisteredUserController;


Route::get('/', [AttendanceController::class, 'stamp'])->name('stamp');
Route::get('/login', [AuthenticatedSessionController::class, 'login'])->name('login');
Route::get('/register', [RegisteredUserController::class, 'register'])->name('register');