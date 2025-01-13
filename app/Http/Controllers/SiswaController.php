<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\KelasPelajaran;
use App\Models\Materi;
use App\Models\Pelajaran;
use App\Models\Admin;

class SiswaController extends Controller
{
    public function dashboard()
    {
        $siswa = Auth::user()->siswa; // Ambil data siswa yang sedang login

        // Menghitung jumlah kelas di mana siswa terdaftar
        $jumlahKelas = \DB::table('kelas_siswa')
            ->where('siswa_id', $siswa->id)
            ->count();

        // Menghitung jumlah mata pelajaran yang terdaftar di kelas siswa
        $kelasIds = \DB::table('kelas_siswa')
            ->where('siswa_id', $siswa->id)
            ->pluck('kelas_id'); // Mengambil semua kelas ID untuk siswa tersebut

        $jumlahMapel = \DB::table('kelas_pelajaran')
            ->whereIn('kelas_id', $kelasIds)
            ->distinct()
            ->count('pelajaran_id'); // Menghitung jumlah unik mata pelajaran

        // Menghitung total siswa di kelas tempat siswa berada
        $jumlahSiswa = \DB::table('kelas_siswa')
            ->whereIn('kelas_id', $kelasIds)
            ->distinct()
            ->count('siswa_id');

        return view('v_siswa.dashboard', compact('jumlahKelas', 'jumlahMapel', 'jumlahSiswa'));
    }

    // PROFILE PICTURE
    public function profile()
    {
        $user = Auth::user();
        $siswa = $user->siswa; // Ambil data siswa terkait

        // Pastikan jika foto default, tampilkan foto default
        if (!$user->foto || $user->foto == 'default.jpg') {
            $user->foto = 'default.jpg';
        }

        return view('v_siswa.profile', compact('user', 'siswa'));
    }
    public function updateProfile(Request $request)
    {
        $user = Auth::user(); // Mengambil data user yang sedang login
        $siswa = $user->siswa;  // Mengambil data siswa terkait

        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email,' . $user->id,
            'username' => 'required|string|unique:user,username,' . $user->id,
            'hp' => 'required|digits_between:10,13', // Validasi nomor telepon
            'password' => 'nullable|min:8|confirmed',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Menyimpan username lama
        $oldUsername = $user->username;
        $newUsername = $request->input('username');  // Mendapatkan username baru dari request

        // Proses update foto jika ada yang di-upload
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();

            // Tentukan folder tujuan penyimpanan berdasarkan username baru
            $destinationPath = public_path('uploads/profile/siswa/' . $newUsername);

            // Pastikan folder tujuan ada, jika tidak buat foldernya
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);  // Membuat folder jika belum ada
            }

            // Pindahkan file ke folder tujuan
            $file->move($destinationPath, $filename);

            // Hapus foto lama jika ada dan bukan foto default
            if ($user->foto && $user->foto != 'default.jpg') {
                $oldPhotoPath = public_path('uploads/profile/siswa/' . $oldUsername . '/' . $user->foto);
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath); // Menghapus foto lama
                }

                // Hapus folder lama jika kosong
                $oldFolderPath = public_path('uploads/profile/siswa/' . $oldUsername);
                if (is_dir($oldFolderPath) && count(scandir($oldFolderPath)) == 2) { // Hanya ada '.' dan '..'
                    rmdir($oldFolderPath); // Hapus folder jika kosong
                }
            }

            // Update path foto yang baru
            $user->foto = $filename;
        } else {
            // Jika tidak ada foto baru yang di-upload, tetap gunakan foto lama atau default
            if (!$user->foto) {
                $user->foto = 'default.jpg';
            }
        }

        // Update data user dengan username baru
        $user->email = $request->email;
        $user->username = $newUsername; // Update username di database
        $user->save();

        // Update data siswa
        $siswa->nama = $request->nama;
        $siswa->hp = $request->hp;  // Update nomor telepon

        // Sinkronisasi NIS dengan username
        if ($siswa->nis !== $newUsername) {
            $siswa->nis = $newUsername; // Update NIS sesuai username baru
        }

        $siswa->save();

        // Jika ada password yang di-update, hash dan simpan
        if ($request->password) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        // Jika username berubah, pastikan folder foto juga diubah
        if ($oldUsername != $newUsername) {
            $oldFolderPath = public_path('uploads/profile/siswa/' . $oldUsername);
            $newFolderPath = public_path('uploads/profile/siswa/' . $newUsername);

            // Pindahkan gambar ke folder baru jika perlu
            $oldPhotoPath = public_path('uploads/profile/siswa/' . $oldUsername . '/' . $user->foto);
            if (file_exists($oldPhotoPath)) {
                // Pastikan folder baru ada
                if (!file_exists($newFolderPath)) {
                    mkdir($newFolderPath, 0777, true);  // Membuat folder baru jika belum ada
                }
                // Pindahkan gambar ke folder baru
                rename($oldPhotoPath, $newFolderPath . '/' . $user->foto);
            }

            // Hapus folder lama jika kosong
            if (is_dir($oldFolderPath) && count(scandir($oldFolderPath)) == 2) { // Hanya ada '.' dan '..'
                rmdir($oldFolderPath); // Hapus folder jika kosong
            }
        }

        return redirect()->route('siswa.profile')->with('success', 'Profil berhasil diperbarui!');
    }
    public function destroyPhoto()
    {
        $user = Auth::user();

        // Pastikan foto yang ada bukan foto default
        if ($user->foto && $user->foto != 'default.jpg') {
            $folderPath = public_path('uploads/profile/siswa/' . $user->username);
            $fotoPath = $folderPath . '/' . $user->foto;

            // Menghapus foto dari server
            if (file_exists($fotoPath)) {
                unlink($fotoPath); 
            }

            // Hapus folder jika kosong
            if (is_dir($folderPath) && count(scandir($folderPath)) == 2) { // Hanya ada '.' dan '..'
                rmdir($folderPath); // Hapus folder jika kosong
            }
        }

        // Set foto ke default setelah dihapus
        $user->foto = 'default.jpg';
        $user->save(); // Jangan lupa untuk menyimpan perubahan di database

        return response()->json(['message' => 'Foto berhasil dihapus']);
    }
    public function kelasList()
    {
        // Mengambil data siswa yang login
        $siswa = Siswa::with(['kelas.kelasPelajaran.pelajaran'])->where('user_id', Auth::id())->first();

        // Jika siswa tidak ditemukan
        if (!$siswa) {
            return redirect('/')->with('error', 'Data siswa tidak ditemukan.');
        }

        // Mengambil daftar kelas siswa
        $kelasSiswa = $siswa->kelas;

        // Mengirim data ke view
        return view('v_siswa.kelas_menu.kelas_list', compact('kelasSiswa'));
    }


}
