<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;
use Illuminate\support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    //tampilkan halaman login
    public function loginform()
    {
        return view('auth.login');
    }
    //proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }  

        return back()->with('error','Email atau password salah.');
    }
    //tampilkan halaman register
    public function registerform()
    {
        return view('auth.register');
    }
    //proses register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:3|confirmed',
        ]);

        $user_model = new User();
        $user =$user_model->get_user()->where('email', $request['email'])->first();
        
        if (!empty($user)) {
            return redirect()->route('register')->with(['error' => 'Email sudah terdaftar.']);
        } 
        
        user::registerUser($request);
        return redirect()->route('login')->with('success', 'Akun berhasil dibuat, login dah.');
    }

    //proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }
}