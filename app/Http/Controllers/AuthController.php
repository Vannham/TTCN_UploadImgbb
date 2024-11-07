<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Phương thức để hiển thị form đăng nhập
    public function showLoginForm()
    {
        return view('login'); // Trỏ đến view auth/login.blade.php
    }

    // Phương thức xử lý đăng nhập
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không hợp lệ.',
        ]);
    }
}
