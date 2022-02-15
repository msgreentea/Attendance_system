<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\Breaktime;
use App\Models\User;

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
        $breaktime = Breaktime::where('attendances_id', $user_id)->wherenull('end_time')->first();

        // 既に出勤処理済み & （退勤処理がされていない）
        if ($attendance == null) {
            return redirect()->route('stamp.index')->with('text', '出勤処理をしていません。');
        } elseif ($attendance->end_time != null) {
            return redirect()->route('stamp.index')->with('text', '既に退勤しています。');
        } elseif ($breaktime != null && $breaktime->end_time == null) {
            return redirect()->route('stamp.index')->with('text', '休憩終了処理をしていません。');
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
        $today = Carbon::today()->format('Y-m-d');
        $attendance = Attendance::where('user_id', $user)->where('date', $today)->first();
        $old_breakin = Breaktime::where('attendances_id', $user)->wherenull('end_time')->first();
        $now = Carbon::now()->format('H:i:s');

        // 無理パターン：　
        // 出勤がされていない時
        // 既に休憩開始されている時
        // 退勤済みの時
        // ↓
        // 以外の時に休憩打刻可能
        if ($attendance == null) {
            return redirect()->route('stamp.index')->with('text', '出勤処理をしていません。');
        } elseif ($attendance->end_time != null) {
            return redirect()->route('stamp.index')->with('text', '既に退勤しています。');
        } elseif ($old_breakin != null && $old_breakin >= $today && $old_breakin->start_time < $now) {
            return redirect()->route('stamp.index')->with('text', '休憩中です。');
        } else {
            $now = Carbon::now()->format('H:i:s');

            Breaktime::create([
                'attendances_id' => $user,
                'start_time' => $now,
            ]);
            return redirect()->route('stamp.index')->with('text', '休憩開始 ☺︎');
        }
    }

    // 休憩終了
    public function breakout(Request $request)
    {
        $user = Auth::id();
        $today = Carbon::today()->format('Y-m-d');
        $attendance = Attendance::where('user_id', $user)->where('date', $today)->first();
        $old_breakin = Breaktime::where('attendances_id', $user)->wherenull('end_time')->first();
        $now = Carbon::now()->format('H:i:s');

        if ($old_breakin != null && $old_breakin->end_time == null) {
            $now = Carbon::now()->format('H:i:s');

            Breaktime::where('attendances_id', $user)->update([
                'end_time' => $now
            ]);
            return redirect()->route('stamp.index')->with('text', '休憩終了！引き続き頑張りましょう。');
        } elseif ($attendance == null) {
            return redirect()->route('stamp.index')->with('text', '出勤処理をしていません。');
        } elseif ($attendance->end_time != null) {
            return redirect()->route('stamp.index')->with('text', '既に退勤しています。');
        } else {
            return redirect()->route('stamp.index')->with('text', '休憩開始処理をしていません。');
        }
    }
}