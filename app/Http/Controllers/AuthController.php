<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function userLogin()
    {
        return view('auth.login', [
            'title' => 'Sipo Login Page',
            'subtitle' => "Administrator",
            'setting' => Setting::first(),
        ]);
    }
    public function pelakuLogin()
    {
        return view('auth.login', [
            'title' => 'Sipo Login Page | Pelaku',
            'subtitle' => "Pelaku",
            'setting' => Setting::first(),
        ]);
    }
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if ($request->input('jenis_login') == 'Administrator') {
            if (Auth::guard('admin')->attempt($credentials)) {
                return redirect()->intended('/');
            }
        } else {
            if (Auth::guard('pelaku')->attempt($credentials)) {
                return redirect()->intended('/');
            }
        }
        return back()->withErrors([
            'email' => 'Akun tidak terdaftar',
        ]);
    }
    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        } else {
            Auth::guard('pelaku')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
        return redirect('/user/login');
    }
}
