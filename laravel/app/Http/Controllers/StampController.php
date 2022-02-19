<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\Breaktime;

class StampController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('stamp.index', ['user' => $user]);
    }

    // 勤務開始
    public function punchin(Request $request)
    {
        $user_id = Auth::id();

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
            return redirect()->route('stamp.index')->with('text', '出勤！本日も頑張りましょう。');
        } elseif ($old_punchin->end_time != null) {
            return redirect()->route('stamp.index')->with('text', '本日は既に退勤処理済みです。');
        } else {
            return redirect()->route('stamp.index')->with('text', '勤務中です。');
        }
    }

    // 勤務終了
    public function punchout(Request $request)
    {
        $user_id = Auth::id();
        $today = Carbon::today()->format('Y-m-d');
        $attendance = Attendance::where('user_id', $user_id)->where('date', $today)->first();

        //出勤時のエラーを先に書くことでbreaktimeのデータを持ってくる必要がなくなる。
        if ($attendance == null) { // そもそもattendanceにデータが無い場合。start_timeも何も無くて出勤開始していない時
            return redirect()->route('stamp.index')->with('text', '出勤処理をしていません。');
        } elseif ($attendance->end_time != null) { //
            return redirect()->route('stamp.index')->with('text', '既に退勤しています。');
        }

        $breaktime = Breaktime::where('attendance_id', $attendance->id)->wherenull('end_time')->first();

        // 既に出勤処理済み & （退勤処理がされていない）
        if ($breaktime != null && $breaktime->end_time == null) { // breaktimeにデータがある(休憩開始処理済み) & 休憩終了処理をしていない時
            return redirect()->route('stamp.index')->with('text', '休憩終了処理をしていません。');
        } else {
            $now = Carbon::now()->format('H:i:s');

            $attendance->update([
                'end_time' => $now
            ]);
            return redirect()->route('stamp.index')->with('text', '退勤！お疲れ様でした ☺︎');
        }
    }


    // 休憩開始
    public function breakin(Request $request)
    {
        $user_id = Auth::id();
        $today = Carbon::today()->format('Y-m-d');
        $attendance = Attendance::where('user_id', $user_id)->where('date', $today)->first();

        if ($attendance == null) { // 出勤処理をしていない時
            return redirect()->route('stamp.index')->with('text', '出勤処理をしていません。');
        } elseif ($attendance->end_time != null) { // すでに退勤処理をしている時
            return redirect()->route('stamp.index')->with('text', '既に退勤しています。');
        }

        $breaktime = Breaktime::where('attendance_id', $attendance->id)->wherenull('end_time')->first();

        if ($breaktime != null) { // breaktimeにデータがある(休憩開始処理済み)
            return redirect()->route('stamp.index')->with('text', '休憩中です。');
        } else { // breaktimeにデータが無い。開始していない時
            $now = Carbon::now()->format('H:i:s');

            Breaktime::create([
                'attendance_id' => $attendance->id,
                'start_time' => $now,
            ]);
            return redirect()->route('stamp.index')->with('text', '休憩開始 ☺︎');
        }
    }

    // 休憩終了
    public function breakout(Request $request)
    {
        $user_id = Auth::id();
        $today = Carbon::today()->format('Y-m-d');
        $attendance = Attendance::where('user_id', $user_id)->where('date', $today)->first();

        if ($attendance == null) {
            return redirect()->route('stamp.index')->with('text', '出勤処理をしていません。');
        } elseif ($attendance->end_time != null) {
            return redirect()->route('stamp.index')->with('text', '既に退勤しています。');
        }

        $breaktime = Breaktime::where('attendance_id', $attendance->id)->wherenull('end_time')->first();

        if ($breaktime == null) { // breaktimeにデータがない(休憩開始処理をしていない)時
            return redirect()->route('stamp.index')->with('text', '休憩開始処理をしていません。');
        } else { // breaktimeにデータがある(休憩開始処理済みの)時
            $now = Carbon::now()->format('H:i:s');

            $breaktime->update([
                'end_time' => $now
            ]);
            return redirect()->route('stamp.index')->with('text', '休憩終了！引き続き頑張りましょう。');
        }
    }
}