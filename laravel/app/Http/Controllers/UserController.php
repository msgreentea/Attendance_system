<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Request\RegisterRequest;
use App\Models\User;

class UserController extends Controller
{
    public function create()
    {
        return view('user.create');
    }

    // public function store(RegisterRequest $registerRequest)
    public function store(Request $registerRequest)
    {
        $items = $registerRequest->all();
        User::create($items);

        return view('auth.login');
    }
}