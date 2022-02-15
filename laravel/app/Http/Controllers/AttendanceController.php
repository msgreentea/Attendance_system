<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Breaktime;
use App\Models\User;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendance = Attendance::all();
        dd($attendance->date);
        $breaktime = Breaktime::all();

        $date = $attendance->date;
        dd($date);

        $all_records = [
            'attendance' => $attendance,
            'breaktime' => $breaktime,
            'date' => $date,
        ];
        // dd($all_records);

        return view('attendance.index', compact('all_records'));
    }
}