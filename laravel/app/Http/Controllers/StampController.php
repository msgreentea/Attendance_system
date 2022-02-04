<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\Breaktime;
use App\Models\User;
use Carbon\Carbon;


class StampController extends Controller
{
    public function index()
    {
        var_dump(route('stamp.index'));
        // 現在認証しているユーザーを取得
        // if (Auth::check()) {
        //     return view('stamp.index');
        // } else {
        //     return view('auth.login');
        // }

        // $user = Auth::getUser();
        // $items = User::peginate(5);
        // $param = [
        //     // 'items' => $items,
        //     'user' => $user
        // ];
        // return view('stamp.index', $param);
        return view('stamp.index');
    }

    // 勤務開始
    public function punchin(Request $request)
    {
        $time = Carbon::now();

        $id = $request->id;
        $user_id = $request->user_id;
        $date = $time->today();
        $start_time = $time->hour . $time->minute;

        $punchin = Attendances::create([
            'id' => $id,
            'user_id' => $user_id,
            'date' => $date,
            'start_time' => $start_time,
        ]);

        return redirect('stamp.index');
    }

    // 勤務終了
    public function puchout(Request $request)
    {
    }


    // 休憩開始
    public function breakin(Request $request)
    {
        $time = Carbon::now();

        $id = $request->id;
        $attendances_id = $request->attendances_id;
        $start_time = $time->hour . $time->minute;

        $punchin = Breaktimes::create([
            'id' => $id,
            'attendances_id' => $attendances_id,
            'start_time' => $start_time,
        ]);

        return redirect('stamp.index');
    }

    // 休憩終了
    public function breakout(Request $request)
    {
    }
}