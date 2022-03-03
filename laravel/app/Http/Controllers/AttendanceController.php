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
    // public function index(Request $request, $date)
    {

        // ページを送ってって「その日の記録がない」場合はどうするの？
        // ifの中でifは出来るの？
        // dd($request);
        $attendances = Attendance::all();
        $today = Carbon::today();
        $other_date = $request->other_date;
        // dd($other_date);

        // if ($request->other_date == null) { // デフォルトはtoday
        //     $date = $today;
        //     // dump($date);
        // } elseif ($request->previous != null) {
        //     $date = $today->addDays(1);
        // } elseif ($request->next != null) {
        //     $date = $today->addDays(-1);
        // }

        if ($other_date == 'previous') { // ＜
            $date = $today->subDay();
            // dd($date);
        } elseif ($request->next != null) { // ＞
            $date = $today->addDay();
        } else {
            $date = $today;
        }



        // $date = Carbon::today()->format('Y-m-d');


        // 日ごとの勤怠情報 -> 勤務開始・勤務終了
        $attendances = Attendance::where('date', $date)->paginate(2); // $dateのattendance全部取得

        $breaktime_totals = [];

        foreach ($attendances as $attendance) {
            $breaktimes = $attendance->breaktimes; // $dateのbreaktime全部取得
            $breaktime_total = new Carbon('00:00');
            $working_hours = new Carbon('00:00');

            foreach ($breaktimes as $breaktime) {
                $breakin = new Carbon($breaktime->start_time);
                $breakout = new Carbon($breaktime->end_time);

                $subtotal = $breakout->diffInSeconds($breakin); //１回の休憩時間の小計
                $breaktime_total->addSecond($subtotal);
                $breaktime_totals[$attendance->id] = $breaktime_total;
            }
            // Attendance::where('id', $attendance->id)->update(['breaktime_total' => $breaktime_total]); //breaktime_totalカラムがある場合

            $punchin = new Carbon($attendance->start_time);
            $punchout = new Carbon($attendance->end_time);

            $work = $punchout->diffinseconds($punchin); // 休憩時間を除いた出勤時間(秒)
            // dd($work);
            // dd($breaktime_total);
            // $working_hours = $work->diffinseconds($breaktime_total);
            // dd($working_hours);
            $working_hours = $work;

            // １日の休憩時間の合計
            $breaktime_totals[$attendance->id] = $breaktime_total;

            // 勤務時間
            // $working_hours =
            // dump($attendance->addSecond($breaktime_total));

            // dump($breaktime_total);
            // dump($breaktime_total);
        }
        // dump($working);
        // exit();


        // dump($breaktime_totals); // 人数分取得できる
        // dump($breaktime_totals->breaktime_total);







        $all_records = [
            'date' => $date,
            'attendances' => $attendances,
            'breaktimes' => $breaktimes,
            'breaktime_totals' => $breaktime_totals, // 休憩時間の算出は大丈夫。渡し方がわからん
            'working_hours' => $working_hours
        ];

        return view('attendance.index', $all_records);
        // return view('attendance.index', compact('date', 'attendances', 'breaktime_totals'));
    }
}