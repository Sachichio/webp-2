<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('v_login.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'login' => 'required|string', // Bisa berupa email atau username
            'password' => 'required|string',
        ], [
            'login.required' => 'Email atau Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Identifikasi apakah input adalah email atau username
        $fieldType = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Buat kredensial
        $credentials = [
            $fieldType => $request->input('login'),
            'password' => $request->input('password'),
        ];

        // Proses autentikasi
        if (Auth::attempt($credentials)) {
            $user = Auth::user(); // Ambil data user yang sedang login

            // Cek status akun (aktif atau tidak)
            if ($user->status == 0) {
                Auth::logout();
                return redirect()->route('login')->withErrors(['login' => 'Akun Anda tidak aktif.']);
            }

            // Redirect berdasarkan role
            switch ($user->role) {
                case 0: // Admin
                    return redirect()->route('admin.dashboard');
                case 1: // Guru
                    return redirect()->route('guru.dashboard');
                case 2: // Siswa
                    return redirect()->route('siswa.dashboard');
                default:
                    Auth::logout();
                    return redirect()->route('login')->withErrors(['login' => 'Role tidak valid.']);
            }
        }

        // Jika login gagal
        return back()->withErrors(['login' => 'Email/Username atau Password salah.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
