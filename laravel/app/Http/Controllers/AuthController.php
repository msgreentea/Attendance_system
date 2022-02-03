<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

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
        $credentials = $loginRequest->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $loginRequest->session()->regenerate();

            // return redirect('stamp.index');
            return view('stamp.index');
        }

        return back()->withErrors([
            'login_error' => 'メールアドレスかパスワードが間違っています。',
        ]);
    }

    public function logout()
    {
    }
}