<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_pengguna' => 'required|string|max:255',
            'nama_toko'     => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6',
        ]);

        User::create([
            'nama_pengguna' => $request->nama_pengguna,
            'nama_toko'     => $request->nama_toko,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Berhasil daftar, silakan login.');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
        }

        // simpan data user ke session
        session(['user_id' => $user->id]);

        return redirect()->route('barang.index');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user_id');
        $request->session()->flush();

        return redirect()->route('login')->with('success', 'Berhasil logout.');
    }
}
