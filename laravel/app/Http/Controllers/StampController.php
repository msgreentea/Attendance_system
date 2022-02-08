<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\Breaktime;
use App\Models\User;
use Attribute;

class StampController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('stamp.index', $user);
    }

    // 勤務開始
    public function punchin(Request $request)
    {
        $user_id = Auth::id();
        $date = Carbon::today()->format('Y-m-d');
        $start_time = Carbon::now()->format('H:i:s');

        if ($start_time != null) {
            $punchin = Attendance::create([
                'user_id' => $user_id,
                'date' => $date,
                'start_time' => $start_time
            ]);
        }


        return redirect()->route('stamp.index')->with('punchin', '出勤！今日も頑張りましょう。');
    }

    // 勤務終了
    public function puchout(Request $request)
    {
        $end_time = Carbon::now()->format('H:i:s');
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