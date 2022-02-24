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






        // $users = User::all('id', 'name');

        $id = Auth::id();
        dd($id);
        // 名前
        $name = Auth::user()->name;
        $date = Carbon::today()->format('Y-m-d');

        // 日ごとの勤怠情報 -> 勤務開始・勤務終了
        $attendances = Attendance::where('date', $date)->get();
        foreach ($attendances as $attendance) {
            $name = User::where('name', $name)->get('name');

            $punchin = new DateTime($attendance->start_time);
            dd($punchin);
            $punchout = new DateTime($attendance->end_time);
        }

        $attendance = Attendance::where('user_id', $id)->where('date', $date)->first();



        // 日ごとの休憩時間たち
        // attendance->id じゃなくて attendance->user_idにしてた。意味がよくわかっていない
        $breaktimes = Breaktime::where('attendance_id', $attendance->id)->get();

        // 休憩時間
        $breaktime_sum = new DateTime('00:00'); // 休憩時間をばらして、それぞれ休憩時間を出したものを合計したい
        foreach ($breaktimes as $breaktime) {
            // ★each breaktimeの計算

            // ★strtotime
            // $start_time = strtotime($breaktime->start_time);
            // $end_time = strtotime($breaktime->end_time);
            // $total = $end_time - $start_time;
            // ※strtotime の 2038年問題 とは？
            // $breaktime_sum += $total;

            // ★datetime & diff
            // ※timespanとは？
            $start_time = $punchin;
            $end_time = $punchout;
            // $start_time = new DateTime($breaktime->start_time);
            // $end_time = new DateTime($breaktime->end_time);
            $total = $start_time->diff($end_time);
            $breaktime_sum->add($total);
        }
        $breaktime_total = date_format($breaktime_sum, 'H:i:s');

        // 勤務時間
        $a = $punchout->diff($punchin);
        // $b = new DateTime($a, '00:00');
        // dd($a);
        // dd($a->diff($breaktime_sum));
        // $b = date_format($a, 'H:i:s');



        $all_records = [
            'date' => $attendance->date,
            'attendance' => $attendance,
            'name' => $name,
            'punchin' => $attendance->start_time,
            'punchout' => $attendance->end_time,
            'breaktime_total' => $breaktime_total
        ];

        return view('attendance.index', compact('all_records'));
    }
}