<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request, $date = null) //文字列で$dateが渡ってきてる //$dateを渡さずアクセスしたらnull
    {
        if ($date == null) {
            $date = Carbon::today();
        } else {
            $date = new Carbon($date); //Carbonに直す　 new Carbon(null):今の時間が取れる
        }

        $attendances = Attendance::all();
        $previous_date = $date->copy()->subDay(); //$todayがupdateされてしまう(参照渡し) //copyすることで別の値として定義出来る
        $next_date = $date->copy()->addDay();

        // パラメーターでdateを渡さない場合
        // if ($other_date == 'previous') { // ＜
        //     $date = $today->subDay();
        // } elseif ($request->next != null) { // ＞
        //     $date = $today->addDay();
        // } else {
        //     $date = $today;
        // }


        // 日ごとの勤怠情報 -> 勤務開始・勤務終了
        $attendances = Attendance::where('date', $date->format('Y-m-d'))->paginate(5);
        $breaktimes = [];

        $breaktime_totals = [];
        $working_hours = [];

        foreach ($attendances as $attendance) {
            $breaktimes = $attendance->breaktimes; // $dateのbreaktime全部取得
            $breaktime_total = 0;

            foreach ($breaktimes as $breaktime) {
                $breakin = new Carbon($breaktime->start_time);
                $breakout = new Carbon($breaktime->end_time);

                $subtotal = $breakout->diffInSeconds($breakin); //１回の休憩時間の小計
                $breaktime_total += $subtotal;
            }
            $punchin = new Carbon($attendance->start_time);
            $punchout = new Carbon($attendance->end_time);

            $work = $punchout->diffinseconds($punchin); // 出勤時間と退勤時間の差分(秒)
            $working_seconds = $work - $breaktime_total; // -休憩時間(合計)

            $working_hms = $this->toHMS($working_seconds);
            $working_hours[$attendance->id] = $working_hms;

            // １日の休憩時間の合計
            $breaktime_total = $this->toHMS($breaktime_total);
            $breaktime_totals[$attendance->id] = $breaktime_total;
        }

        $all_records = [
            'date' => $date, // パラメーターで渡ってきたやつ
            'previous_date' => $previous_date,
            'next_date' => $next_date,
            'attendances' => $attendances,
            'breaktimes' => $breaktimes,
            'breaktime_totals' => $breaktime_totals,
            'working_hours' => $working_hours
        ];

        return view('attendance.index', $all_records);
    }
    // 秒を時間に変換する関数を作る
    private function toHMS($total_seconds)
    {
        $hours = floor($total_seconds / 3600); // floor 切り捨てる
        $minutes = floor($total_seconds % 3600 / 60);
        $seconds = $total_seconds % 60;

        // $minutes = floor(($total_seconds - 3600 * $hours) / 60);
        return sprintf('%02d', $hours) . ':' . sprintf('%02d', $minutes) . ':' . sprintf('%02d', $seconds);
    }
}