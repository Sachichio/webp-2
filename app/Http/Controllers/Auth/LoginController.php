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
            'login' => 'required|string', // Bisa email atau username
            'password' => 'required|string',
        ], [
            'login.required' => 'Email atau Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $login = $request->input('login');
        $password = $request->input('password');

        // Cek apakah input berupa email atau username
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Buat kredensial untuk login
        $credentials = [
            $fieldType => $login,
            'password' => $password,
        ];

        // Cek apakah pengguna ada di database
        $user = User::where($fieldType, $login)->first();

        if (!$user) {
            // Jika pengguna tidak ditemukan
            return back()->withErrors(['login' => 'Email/Username tidak ditemukan.']);
        }

        // Proses autentikasi
        if (Auth::attempt($credentials)) {
            $user = Auth::user(); // Ambil data user yang sedang login

            // Cek status user (aktif atau tidak)
            if ($user->status == 0) {
                // Jika status tidak aktif, logout user dan beri pesan
                Auth::logout();
                return redirect()->route('login')->withErrors(['login' => 'Akun Anda tidak aktif.']);
            }

            // Redirect berdasarkan role
            if ($user->isRole(0)) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isRole(1)) {
                return redirect()->route('guru.dashboard');
            } elseif ($user->isRole(2)) {
                return redirect()->route('siswa.dashboard');
            }
        }

        // Jika login gagal
        return back()->withErrors(['login' => 'Password salah.  ']);
    }

    public function logout()
    {
        Auth::logout(); // Logout pengguna
        return redirect()->route('home'); // Arahkan kembali ke halaman utama atau login
    }
}
