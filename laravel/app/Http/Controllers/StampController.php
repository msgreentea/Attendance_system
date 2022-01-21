<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StampController extends Controller
{
    public function stamp()
    {
        return view('stamp');
    }
}