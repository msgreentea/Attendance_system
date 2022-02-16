<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Breaktime;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $user_id = Auth::id();
        $attendance = Attendance::where('user_id', $user_id)->first();
        dd($attendance);
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