<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Breaktime;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DateTime;

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
        // 名前
        $name = Auth::user()->name;


        // 日ごとの勤怠情報 -> 勤務開始・勤務終了
        $attendance = Attendance::where('date', $date)->where('user_id', $id)->first();

        $punchin = new DateTime($attendance->start_time);
        $punchout = new DateTime($attendance->end_time);




        // 日ごとの休憩時間たち
        $breaktimes = Breaktime::where('attendance_id', $attendance->id)->get();

        // 休憩時間
        $breaktime_sum = new DateTime('00:00'); // 休憩時間をばらして、それぞれ休憩時間を出したものを合計したい
        foreach ($breaktimes as $breaktime) {
            // ★each breaktimeの計算
            // ※timespanとは？
            $breakin = new DateTime($breaktime->start_time);
            $breakout = new DateTime($breaktime->end_time);
            // var_dump($breakin);
            // var_dump($breakout);
            $total = $breakin->diff($breakout);
            // $total = $breakout->diff($breakin);
            $breaktime_sum->add($total);
        }
        $breaktime_total = date_format($breaktime_sum, 'H:i:s');


        // 勤務時間
        // $a = $punchout->diff($punchin);
        // $b = new DateTime($a, '00:00');
        // dd($a);
        // dd($a->diff($breaktime_sum));
        // $b = date_format($a, 'H:i:s');




        // $users = User::all('id', 'name');

        $attendances = Attendance::where('date', $date)->get();
        foreach ($attendances as $attendance) {
            // $name = User::where('name', $name)->get('name');

            $punchin = new DateTime($attendance->start_time);
            $punchout = new DateTime($attendance->end_time);
        }

        // $attendance = Attendance::where('user_id', $id)->where('date', $date)->first();




        $all_records = [
            'date' => $date,
            'attendance' => $attendance,
            'name' => $name,
            'punchin' => $attendance->start_time,
            'punchout' => $attendance->end_time,
            'breaktime_total' => $breaktime_total
        ];

        return view('attendance.index', compact('all_records'));
    }
}