<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

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
     * @param App\Http\Requests\LoginRequest $loginRequest
     */
    public function login(LoginRequest $loginRequest)
    {
        // $this->validate($loginRequest, [
        //     'email' => 'email|required',
        //     'password' => 'required|min:8'
        // ]);

        // if (Auth::attempt(['email' => $loginRequest->input('email'), 'password' => $loginRequest->input('password')])) {
        //     return redirect()->route('stamp.index');
        // }
        // return redirect()->back();




        $credentials = $loginRequest->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $loginRequest->session()->regenerate();

            // return redirect()->intended('stamp.index');
            return redirect('stamp.index');
        }

        return back()->withErrors([
            'login_error' => 'メールアドレスかパスワードが間違っています。',
        ]);
    }

    public function logout()
    {
    }
}