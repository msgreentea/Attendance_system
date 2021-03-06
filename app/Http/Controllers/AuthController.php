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
    public function login(LoginRequest $request)
    {

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('stamp.index');
            // return redirect()->intended('stamp.index');
            // return redirect(route('stamp.index'));
        }
        return back()->withErrors([
            'email' => 'メールアドレスかパスワードが間違っています。',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // return redirect(route('auth.show'));
        return redirect()->route('auth.show');
        // return redirect()->route('auth.show')->with('logout', 'ログアウトしました');
    }
}