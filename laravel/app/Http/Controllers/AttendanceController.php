<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Breaktime;
use App\Models\User;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendance = Attendance::all();
        dd($attendance);

        return view('attendance.index', compact('attendance'));
    }
}