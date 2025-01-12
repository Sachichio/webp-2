<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\KelasPelajaran;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Pelajaran;
use App\Models\Admin;
use App\Models\Materi;

class GuruController extends Controller
{
    // DASHBOARD
    public function dashboard()
    {
        $guru = Auth::user()->guru; // Ambil data guru yang sedang login
    
        // Menghitung jumlah siswa di kelas yang diajar oleh guru
        $jumlahSiswaDiajar = Siswa::whereHas('kelas', function ($query) use ($guru) {
            $query->whereHas('pelajaran', function ($query) use ($guru) {
                $query->whereHas('guru', function ($query) use ($guru) {
                    $query->where('guru_id', $guru->id);
                });
            });
        })->count();
    
        // Menghitung jumlah siswa di kelas yang menjadi wali kelas guru
        $jumlahSiswaWali = Siswa::whereHas('kelas', function ($query) use ($guru) {
            $query->whereHas('guru', function ($query) use ($guru) {
                $query->where('guru_id', $guru->id);
            });
        })->count();
    
        // Total jumlah siswa (diajar + wali kelas)
        $jumlahSiswa = $jumlahSiswaDiajar + $jumlahSiswaWali;
    
        // Menghitung jumlah kelas yang diajarkan oleh guru
        $jumlahKelasDiajar = Kelas::whereHas('pelajaran', function ($query) use ($guru) {
            $query->whereHas('guru', function ($query) use ($guru) {
                $query->where('guru_id', $guru->id);
            });
        })->count();
    
        // Menghitung jumlah kelas yang dipegang sebagai wali kelas
        $jumlahKelasWali = Kelas::whereHas('guru', function ($query) use ($guru) {
            $query->where('guru_id', $guru->id);
        })->count();
    
        // Total jumlah kelas (wali + diajar)
        $jumlahKelasTotal = $jumlahKelasDiajar + $jumlahKelasWali;
    
        // Kirim data ke view
        return view('v_guru.dashboard', compact('jumlahKelasTotal', 'jumlahSiswa'));
    }

    // PROFILE PICTURE
    public function profile()
    {
        $user = Auth::user();
        $guru = $user->guru; // Ambil data guru terkait

        // Pastikan jika foto default, tampilkan foto default
        if (!$user->foto || $user->foto == 'default.jpg') {
            $user->foto = 'default.jpg';
        }

        return view('v_guru.profile', compact('user', 'guru'));
    }
    public function updateProfile(Request $request)
    {
        $user = Auth::user(); // Mengambil data user yang sedang login
        $guru = $user->guru;  // Mengambil data guru terkait

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
            $destinationPath = public_path('uploads/profile/guru/' . $newUsername);

            // Pastikan folder tujuan ada, jika tidak buat foldernya
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);  // Membuat folder jika belum ada
            }

            // Pindahkan file ke folder tujuan
            $file->move($destinationPath, $filename);

            // Hapus foto lama jika ada dan bukan foto default
            if ($user->foto && $user->foto != 'default.jpg') {
                $oldPhotoPath = public_path('uploads/profile/guru/' . $oldUsername . '/' . $user->foto);
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath); // Menghapus foto lama
                }

                // Hapus folder lama jika kosong
                $oldFolderPath = public_path('uploads/profile/guru/' . $oldUsername);
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

        // Update data guru
        $guru->nama = $request->nama;
        $guru->hp = $request->hp;  // Update nomor telepon

        // Sinkronisasi NIP dengan username
        if ($guru->nip !== $newUsername) {
            $guru->nip = $newUsername; // Update NIP sesuai username baru
        }

        $guru->save();

        // Jika ada password yang di-update, hash dan simpan
        if ($request->password) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        // Jika username berubah, pastikan folder foto juga diubah
        if ($oldUsername != $newUsername) {
            $oldFolderPath = public_path('uploads/profile/guru/' . $oldUsername);
            $newFolderPath = public_path('uploads/profile/guru/' . $newUsername);

            // Pindahkan gambar ke folder baru jika perlu
            $oldPhotoPath = public_path('uploads/profile/guru/' . $oldUsername . '/' . $user->foto);
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

        return redirect()->route('guru.profile')->with('success', 'Profil berhasil diperbarui!');
    }
    public function destroyPhoto()
    {
        $user = Auth::user();

        // Pastikan foto yang ada bukan foto default
        if ($user->foto && $user->foto != 'default.jpg') {
            $folderPath = public_path('uploads/profile/guru/' . $user->username);
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

    // WALIKELAS
    public function waliKelas($kelas_id)
    {
        // Ambil data kelas berdasarkan ID
        $kelas = Kelas::find($kelas_id);
    
        // Cek apakah kelas ada
        if (!$kelas) {
            return redirect()->back()->with('error', 'Kelas tidak ditemukan');
        }
    
        // Ambil siswa yang terdaftar di kelas tersebut
        $siswas = $kelas->siswa()->with('user')->get();
    
        // Kirim data ke view
        return view('v_guru.kelas_menu.layout_kelas.wali_kelas', compact('siswas', 'kelas'));
    }

    // Menampilkan daftar kelas
    public function kelasList()
    {
        $guru = Guru::with(['kelas', 'pelajaran.kelas'])->where('user_id', Auth::id())->first();

        if (!$guru) {
            return redirect('/')->with('error', 'Data guru tidak ditemukan.');
        }

        $waliKelas = $guru->kelas ?? [];
        $mataPelajaran = $guru->pelajaran ?? [];

        $jadwalPelajaran = [];
        foreach ($mataPelajaran as $pelajaran) {
            foreach ($pelajaran->kelas as $kelasMatapelajaran) {
                $kelasPelajaran = KelasPelajaran::where('kelas_id', $kelasMatapelajaran->id)
                    ->where('pelajaran_id', $pelajaran->id)
                    ->first();

                if ($kelasPelajaran) {
                    $jadwalPelajaran[] = [
                        'kelas' => $kelasMatapelajaran->nama_kelas,
                        'pelajaran' => $pelajaran->nama_pelajaran,
                        'jam_mulai' => $kelasPelajaran->jam_mulai,
                        'jam_selesai' => $kelasPelajaran->jam_selesai,
                    ];
                }
            }
        }

        return view('v_guru.kelas_menu.kelas_list', compact('guru', 'waliKelas', 'mataPelajaran', 'jadwalPelajaran'));
    }


    // Masuk ke halaman utama kelas
    public function kelasMaster($kelasPelajaranId)
    {
        $kelasPelajaran = KelasPelajaran::with(['kelas', 'pelajaran'])->find($kelasPelajaranId);

        if (!$kelasPelajaran) {
            return redirect()->route('guru.kelas_terdaftar')->with('error', 'Data kelas tidak ditemukan.');
        }

        // Redirect langsung ke tab siswa
        return redirect()->route('guru.kelas.siswa', $kelasPelajaran->kelas->id);
    }

    // GURU (LIST SISWA)
    public function kelasSiswa($kelas_id)
    {
        $kelas = Kelas::with('siswa')->findOrFail($kelas_id);

        return view('v_guru.kelas_menu.siswa.list_siswa', compact('kelas'));
    }

    // GURU (ABSEN)
    public function kelasAbsen($kelas_id)
    {
        $kelas = Kelas::findOrFail($kelas_id);

        return view('v_guru.kelas_menu.absen.absen', compact('kelas'));
    }

    // GURU (TUGAS)
    public function kelasTugas($kelas_id)
    {
        $kelas = Kelas::findOrFail($kelas_id);

        return view('v_guru.kelas_menu.tugas.tugas', compact('kelas'));
    }


}
