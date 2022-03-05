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
        $today = Carbon::today()->format('Y-m-d');

        $punchin_btn = false;
        $punchout_btn = false;
        $breakin_btn = false;
        $breakout_btn = false;
        // 全部押せない

        // 非活性化
        $attendance = Attendance::where('user_id', $user->id)->where('date', $today)->first();

        // 押せるボタン　押せるボタンのみ渡したい。
        if ($attendance != null) { //出勤データがある = 少なくとも出勤処理はしてる。退勤してるか・休憩してるかはまだわからない
            // ★　以下　出勤開始処理済みの処理　★
            // この時点ではまだどのボタンも押せない

            if ($attendance->end_time != null) { //退勤処理済み
                // (全部押せない)
                var_dump('should have left already');
                $punchin_btn = false;
                $punchout_btn = false;
                $breakin_btn = false;
                $breakout_btn = false;

                return view('stamp.index', compact('user', 'attendance', 'punchin_btn', 'punchout_btn', 'breakin_btn', 'breakout_btn'));
            } else { // 退勤処理をしていない。出勤処理のみ。休憩してるかはまだわからない

                // ★　以下出勤済み・退勤処理をしていないやつ　★
                $breaktime = Breaktime::where('attendance_id', $attendance->id)->wherenull('end_time')->first();

                if ($breaktime != null) { //休憩データがある = 少なくとも休憩開始処理はしてる。休憩終了してるかはまだわからない

                    if ($breaktime->end_time != null) { // 休憩終了済み
                        // 休憩開始ボタン・退勤処理ボタンが押せる
                        var_dump('supposed to be out of the breaktime');
                        $breakin_btn = true;
                        $punchout_btn = true;
                        // 出勤ボタン・休憩終了ボタンが押せない
                        $punchin_btn = false;
                        $breakout_btn = false;
                        return view('stamp.index', compact('user', 'attendaselect nce', 'punchin_btn', 'punchout_btn', 'breakin_btn', 'breakout_btn'));
                    } else { // 休憩終了していない
                        // 休憩終了ボタンが押せる
                        var_dump('supposed to be in the breaktime');
                        $breakout_btn = true;
                        // 出勤処理ボタン・休憩開始ボタン・退勤処理ボタンが押せない
                        $punchin_btn = false;
                        $breakin_btn = false;
                        $punchout_btn = false;

                        return view('stamp.index', compact('user', 'attendance', 'punchin_btn', 'punchout_btn', 'breakin_btn', 'breakout_btn'));
                    }
                } else { //休憩データが無い
                    var_dump($breaktime);
                    var_dump('didnt start breaktime yet');
                    // 休憩開始ボタン・退勤処理ボタンが押せる(鬼畜モード)
                    $breakin_btn = true;
                    $punchout_btn = true;
                    // 出勤処理ボタン・休憩終了ボタンが押せない
                    $punchin_btn = false;
                    $breakout_btn = false;
                    return view('stamp.index', compact('user', 'attendance', 'punchin_btn', 'punchout_btn', 'breakin_btn', 'breakout_btn'));
                }
            }
            // 出勤データがない
        } else {
            var_dump('I didint even start working yet');
            // 出勤開始処理のみ押せる
            $punchin_btn = true;
            // (休憩開始・休憩終了・退勤ボタンが押せない)
            $breakin_btn = false;
            $breakout_btn = false;
            $punchout_btn = false;
            return view('stamp.index', compact('user', 'attendance', 'punchin_btn', 'punchout_btn', 'breakin_btn', 'breakout_btn'));
        }
        exit();

        // $btn = [
        //     'punchin_btn' => $punchin_btn,
        //     'punchout_btn' => $punchout_btn,
        //     'breakin_btn' => $breakin_btn,
        //     'breakout_btn' => $breakout_btn,
        // ];
        // return view('stamp.index', compact('user', 'attendance', 'btn'));
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
            return redirect()->route('stamp.index')->with('status', '出勤！本日も頑張りましょう。');
        } elseif ($old_punchin->end_time != null) {
            return redirect()->route('stamp.index')->with('status', '本日は既に退勤処理済みです。');
        } else {
            return redirect()->route('stamp.index')->with('status', '勤務中です。');
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
            return redirect()->route('stamp.index')->with('status', '出勤処理をしていません。');
        } elseif ($attendance->end_time != null) { //
            return redirect()->route('stamp.index')->with('status', '既に退勤しています。');
        }

        $breaktime = Breaktime::where('attendance_id', $attendance->id)->wherenull('end_time')->first();

        // 既に出勤処理済み & （退勤処理がされていない）
        if ($breaktime != null && $breaktime->end_time == null) { // breaktimeにデータがある(休憩開始処理済み) & 休憩終了処理をしていない時
            return redirect()->route('stamp.index')->with('status', '休憩終了処理をしていません。');
        } else {
            $now = Carbon::now()->format('H:i:s');

            $attendance->update([
                'end_time' => $now
            ]);
            return redirect()->route('stamp.index')->with('status', '退勤！お疲れ様でした ☺︎');
        }
    }


    // 休憩開始
    public function breakin(Request $request)
    {
        $user_id = Auth::id();
        $today = Carbon::today()->format('Y-m-d');
        $attendance = Attendance::where('user_id', $user_id)->where('date', $today)->first();

        if ($attendance == null) { // 出勤処理をしていない時
            return redirect()->route('stamp.index')->with('status', '出勤処理をしていません。');
        } elseif ($attendance->end_time != null) { // すでに退勤処理をしている時
            return redirect()->route('stamp.index')->with('status', '既に退勤しています。');
        }

        $breaktime = Breaktime::where('attendance_id', $attendance->id)->wherenull('end_time')->first();

        if ($breaktime != null) { // breaktimeにデータがある(休憩開始処理済み)
            return redirect()->route('stamp.index')->with('status', '休憩中です。');
        } else { // breaktimeにデータが無い。開始していない時
            $now = Carbon::now()->format('H:i:s');

            Breaktime::create([
                'attendance_id' => $attendance->id,
                'start_time' => $now,
            ]);
            return redirect()->route('stamp.index')->with('status', '休憩開始 ☺︎');
        }
    }

    // 休憩終了
    public function breakout(Request $request)
    {
        $user_id = Auth::id();
        $today = Carbon::today()->format('Y-m-d');
        $attendance = Attendance::where('user_id', $user_id)->where('date', $today)->first();

        if ($attendance == null) {
            return redirect()->route('stamp.index')->with('status', '出勤処理をしていません。');
        } elseif ($attendance->end_time != null) {
            return redirect()->route('stamp.index')->with('status', '既に退勤しています。');
        }

        $breaktime = Breaktime::where('attendance_id', $attendance->id)->wherenull('end_time')->first();

        if ($breaktime == null) { // breaktimeにデータがない(休憩開始処理をしていない)時
            return redirect()->route('stamp.index')->with('status', '休憩開始処理をしていません。');
        } else { // breaktimeにデータがある(休憩開始処理済みの)時
            $now = Carbon::now()->format('H:i:s');

            $breaktime->update([
                'end_time' => $now
            ]);
            return redirect()->route('stamp.index')->with('status', '休憩終了！引き続き頑張りましょう。');
        }
    }
}