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
        //     $date = $request->date;
        // } else {
        //     $date = Carbon::today()->format('Y-m-d');
        // }



        // 名前：$user_id
        // 勤務開始：Attendance(日付で絞る)->start_time　
        // 勤務終了：Attendance(日付で絞る)->end_time　
        // 休憩時間：Breaktime(日付で絞る)->end_time - start_time のsum　
        // 勤務時間：勤務終了時刻 - 休憩時間 - 勤務開始時刻　





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
        }







        $all_records = [];

        return view('attendance.index', compact('all_recirds'));
    }
}