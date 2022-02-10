<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Breaktime extends Model
{
    use HasFactory;

    protected $fillale = [
        'attendances_id',
        'start_time',
        'end_time'
    ];

    // （従）Attendanceモデルへの紐付け
    public function attendance()
    {
        return $this->belongsTo('App\Models\Attendance');
    }
}