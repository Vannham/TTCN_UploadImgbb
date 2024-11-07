<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Thêm dòng này để sử dụng Auth

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Logic xử lý đăng nhập bằng Laravel's Auth
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            // Đăng nhập thành công
            return redirect()->intended(route('dashboard'));   
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không hợp lệ.',
        ]);
    }
}
