<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Cek kredensial dan login
        if (Auth::attempt($request->only('email', 'password'))) {
            // Redirect ke halaman yang diinginkan setelah login
            return redirect()->route('products.index')->with('success', 'Anda berhasil login.');
        }

        // Jika login gagal
        return redirect()->back()->withErrors(['email' => 'Email atau password salah.']);
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Anda berhasil logout.');
    }

    // Check
    public function check()
    {
        if (auth()->check()) {
            // User is logged in, redirect to products.index
            return redirect()->route('products.index');
        } else {
            // User is not logged in, redirect to login
            return redirect()->route('login');
        }
    }
}