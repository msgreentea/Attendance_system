<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\Breaktime;
// use App\Models\User;

class StampController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // compact('user');

        return view('stamp.index', ['user' => $user]);
    }

    // 勤務開始
    public function punchin(Request $request)
    {
        $user_id = Auth::id();

        // $user = User::find($user_id);


        $today = Carbon::today()->format('Y-m-d');
        $start_time = Carbon::now()->format('H:i:s');
        // 最後に出勤処理をしたデータ
        $old_punchin = Attendance::where('user_id', $user_id)->where('date', $today)->first();


        // 1日1回
        if ($old_punchin == null) {
            Attendance::create([
                'user_id' => $user_id,
                'date' => $today,
                'start_time' => $start_time
            ]);
            return redirect()->route('stamp.index')->with('text', '出勤！今日も頑張りましょう。');
        } else {
            return redirect()->route('stamp.index')->with('text', 'すでに勤務しています。');
        }
    }

    // 勤務終了
    public function punchout(Request $request)
    {
        $user_id = Auth::id();
        $today = Carbon::today()->format('Y-m-d');
        $attendance = Attendance::where('user_id', $user_id)->where('date', $today)->first();
        $end_time = $attendance->end_time;


        // 既に出勤処理済み & （退勤処理がされていない）
        if ($attendance == null) {
            return redirect()->route('stamp.index')->with('text', '出勤処理をしていません。');
        } elseif ($end_time != null) {
            return redirect()->route('stamp.index')->with('text', '既に退勤しています。');
        } else {
            $now = Carbon::now()->format('H:i:s');

            Attendance::where('user_id', $user_id)->update([
                'end_time' => $now
            ]);
            return redirect()->route('stamp.index')->with('text', '退勤！お疲れ様でした。');
        }
    }


    // 休憩開始
    public function breakin(Request $request)
    {
        $user = Auth::id();

        $attendance = Attendance::where('user_id', $user)->first();

        // ★Attendanceテーブルのstart_timeの検索？の仕方がわからない
        $punchin_start_time = Attendance::where('user_id', $attendance->user_id)->where('start_time', $items->start_time)->first();
        dd($punchin_start_time);

        $punchin = Attendance::where('user_id', $user)->where('start_time')->first();
        dd($punchin);
        $start_time = Breaktime::where('attendances_id', $attendances_id)->first();


        // 無理パターン：　
        // 出勤がされていない時
        // 既に休憩開始されている時
        // 退勤済みの時

        // ↓
        // 以外の時に休憩打刻可能

        if ($punchin != null) {
            Attendance::create([
                'user_id' => $user_id,
                'start_time' => $start_time
            ]);
            return redirect()->route('stamp.index')->with('text', '出勤！今日も頑張りましょう。');
        } else {
            return redirect()->route('stamp.index')->with('text', 'すでに勤務しています。');
        }
    }

    // 休憩終了
    public function breakout(Request $request)
    {
    }
}