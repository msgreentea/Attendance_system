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
        // dd($date);
        // if ($request->) {
        //     $date = $request->;
        // } else {
        //     $date = Carbon::today()->format('Y-m-d');
        // }



        $date = Carbon::today()->format('Y-m-d');


        // 日ごとの勤怠情報 -> 勤務開始・勤務終了
        // $dateのattendance全部取得
        $attendances = Attendance::where('date', $date)->get();
        $breaktime_totals = [];

        foreach ($attendances as $attendance) {
            // $dateのbreaktime全部取得
            $breaktimes = $attendance->breaktimes;
            $breaktime_total = new Carbon('00:00');
            foreach ($breaktimes as $breaktime) {
                $breakin = new Carbon($breaktime->start_time);
                $breakout = new Carbon($breaktime->end_time);

                $subtotal = $breakout->diffInSeconds($breakin); //１回の休憩時間の小計
                $breaktime_total->addSecond($subtotal)->format('H:i:s');
            }
            // １日の休憩時間の合計
            $breaktime_totals[$attendance->id] = $breaktime_total;

            // 勤務時間
            // $working_hours =

            // dump($breaktime_total);
        }
        // dump($breaktime_totals); // 人数分取得できる
        // dump($breaktime_totals->breaktime_total);
        // exit();







        $all_records = [
            'date' => $date,
            'attendances' => $attendances,
            'breaktimes' => $breaktimes,
            'breaktime_total' => $breaktime_total,
            'breaktime_totals' => $breaktime_totals, // 休憩時間の算出は大丈夫。渡し方がわからん
        ];

        return view('attendance.index', $all_records);
        // return view('attendance.index', compact('date', 'attendances', 'breaktime_totals'));
    }
}