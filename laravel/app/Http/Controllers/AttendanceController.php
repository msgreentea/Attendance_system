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
        // デフォルト：今日の日付

        // 名前：$user_id
        // 勤務開始：Attendance(日付で絞る)->start_time　
        // 勤務終了：Attendance(日付で絞る)->end_time　
        // 休憩時間：Breaktime(日付で絞る)->end_time - start_time のsum　
        // 勤務時間：勤務終了時刻 - 休憩時間 - 勤務開始時刻　

        // $attendance = Attendance::where('user_id', $user_id)->where('date', $date)->first();

        $id = Auth::id();
        $date = Carbon::today()->format('Y-m-d');
        $attendance = Attendance::where('user_id', $id)->where('date', $date)->latest()->first();
        $breaktime = Breaktime::where('attendances_id', $id)->first();
        // dd($breaktime);
        dd($breaktime->end_time - $breaktime->start_time);
        $breaktime_total = $breaktime->end_time - $breaktime->start_time;
        dd($breaktime->end_time - $breaktime->start_time);
        // $working_hours = ;

        $all_records = [
            'start_time' => $attendance->start_time,
            'end_time' => $attendance->end_time,
            'breaktime_total' => $breaktime_total,
            // 'working_hours' =>
        ];

        // return view('attendance.index', ['all_records' => $all_records]);
        return view('attendance.index', compact('user_id', 'attendance', 'breaktime'));
    }
}