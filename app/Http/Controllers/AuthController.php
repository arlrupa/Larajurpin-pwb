<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password), // ✅ sudah benar
            'role' => 'user',
        ]);

        return redirect('/login')->with('success', 'Akun berhasil dibuat. Silakan login.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
           // 'role' => 'required|in:admin,user',
        ]);

        // $user = User::where('username', $request->username)
        //     ->where('role', $request->role)
        //     ->first();

        // Cari user berdasarkan username
         $user = User::where('username', $request->username)->first();

        if (!$user) {
            return back()->with('error', 'Akun dengan role tersebut tidak ditemukan.');
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Password salah.');
        }

        // Auth::login($user);
        Auth::login($user, $request->has('remember'));

        // ✅ Redirect berdasarkan role
        if ($user->role === 'admin') {
            return redirect('/dashboard');
        } else {
            return redirect('/');
        }
    }
}
