<?php

namespace App\Http\Controllers;

use App\Models\Attendances;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendance = Attendances::all();
        $paginate = Attendances::paginate(5);
        return view('attendance.index', compact('attendance', 'paginate'));
    }
}