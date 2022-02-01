<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    /**
     * @return view
     */
    public function show()
    {
        return view('auth.login');
    }

    /**
     * @param App\Http\Requests\LoginRequest $request
     */
    public function login(LoginRequest $loginRequest)
    {
        dd($loginRequest->all());
    }

    public function logout()
    {
    }
}