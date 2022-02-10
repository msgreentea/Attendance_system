<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendance = Attendance::all();
        $paginate = Attendance::paginate(5);
        return view('attendance.index', compact('attendance', 'paginate'));
    }
}