<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'start_time',
        'end_time'
    ];

    // (主）Userモデルへの紐付け
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    //（従）Breaktimeモデルへの紐づけ
    public function breaktime()
    {
        return $this->hasMany('App\Models\Breaktime');
    }
}