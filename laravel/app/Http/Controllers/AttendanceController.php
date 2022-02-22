<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Breaktime;
// use App\Models\User;
use Carbon\Carbon;
use DateTime;
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
        $name = Auth::user()->name;
        $date = Carbon::today()->format('Y-m-d');

        // 日ごとの勤怠情報
        $attendance = Attendance::where('user_id', $id)->where('date', $date)->first();

        // 日ごとの休憩時間たち
        // attendance->id じゃなくて attendance->user_idにしてた。意味がよくわかっていない
        $breaktimes = Breaktime::where('attendance_id', $attendance->id)->get();

        // 休憩時間をばらして、それぞれ休憩時間を出したものを合計したい
        $breaktime_total = 0;
        foreach ($breaktimes as $breaktime) {
            // each breaktimeの計算
            $start_time = new DateTime($breaktime->start_time);
            $end_time = new DateTime($breaktime->end_time);
            // $total = $start_time->diffInSeconds($end_time);
            $total = $end_time - $start_time;

            // strtotime と diff
            //  strtotime の 2038年問題 とは？

            var_dump($start_time);
            var_dump($end_time);
            var_dump($total);
        }
        echo $breaktime_total;

        // $date = $attendance->date;



        // 名前
        // 勤務開始
        // 勤務終了
        // 休憩時間の合計
        // 勤務時間
        $all_records = [
            'date' => $attendance->date,
            'attendance' => $attendance,
            'name' => $name,
            'punchin' => $attendance->start_time,
            'punchout' => $attendance->end_time
        ];

        return view('attendance.index', $all_records);
    }
}