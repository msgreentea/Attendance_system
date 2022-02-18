<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Breaktime;
// use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        // 左押したら翌日　<-  -> 右押したら前日
        // デフォルト：今日の日付

        // if ($request->) {
        //     $date = $request->;
        // } else {
        //     $date = Carbon::today()->format('Y-m-d');
        // }







        $id = Auth::id();
        $date = Carbon::today()->format('Y-m-d');

        // (attendance)id,dateで絞る
        $individual_daily_attendance = Attendance::where('user_id', $id)->where('date', $date)->first();

        // (breaktime)attendance_idで絞る
        $breaktimes = Breaktime::where('attendances_id', $individual_daily_attendance->user_id)->get();

        dd($breaktimes);
        // $daily_breaktimes = Breaktime::where('attendances_id', $id)->where('created_at', $individual_daily_attendance->date)->first();
        foreach ($breaktimes as $breaktime) {
            $daily_breaktimes = Breaktime::where('created_at', $individual_daily_attendance->date)->get();
            dd($daily_breaktimes);
            // each breaktimeの計算
        }







        $all_records = [];

        return view('attendance.index', compact('all_recirds'));
    }
}