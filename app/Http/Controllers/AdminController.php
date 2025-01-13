<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Pelajaran;
use App\Models\Admin;

class AdminController extends Controller
{

    // DASHBOARD
    public function dashboard()
    {
        // Menghitung jumlah data di masing-masing tabel
        $jumlahGuru = Guru::count(); // Menghitung jumlah guru
        $jumlahSiswa = Siswa::count(); // Menghitung jumlah siswa
        $jumlahKelas = Kelas::count(); // Menghitung jumlah kelas
        $jumlahPelajaran = Pelajaran::count(); // Menghitung jumlah mata pelajaran

        return view('v_admin.dashboard', compact('jumlahGuru', 'jumlahSiswa', 'jumlahKelas', 'jumlahPelajaran'));
    }

    // PROFILE PICTURE
    public function profile()
    {
        $user = Auth::user();
        $admin = $user->admin; // Ambil data admin terkait

        // Pastikan jika foto default, tampilkan foto default
        if (!$user->foto || $user->foto == 'default.jpg') {
            $user->foto = 'default.jpg';
        }

        return view('v_admin.profile', compact('user', 'admin'));
    }
    public function updateProfile(Request $request)
    {
        $user = Auth::user(); // Mengambil data user yang sedang login
        $admin = $user->admin;  // Mengambil data admin terkait

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
            $destinationPath = public_path('uploads/profile/admin/' . $newUsername);

            // Pastikan folder tujuan ada, jika tidak buat foldernya
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);  // Membuat folder jika belum ada
            }

            // Pindahkan file ke folder tujuan
            $file->move($destinationPath, $filename);

            // Hapus foto lama jika ada dan bukan foto default
            if ($user->foto && $user->foto != 'default.jpg') {
                $oldPhotoPath = public_path('uploads/profile/admin/' . $oldUsername . '/' . $user->foto);
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath); // Menghapus foto lama
                }

                // Hapus folder lama jika kosong
                $oldFolderPath = public_path('uploads/profile/admin/' . $oldUsername);
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

        // Update data admin
        $admin->nama = $request->nama;
        $admin->hp = $request->hp;  // Update nomor telepon
        $admin->save();

        // Jika ada password yang di-update, hash dan simpan
        if ($request->password) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        // Jika username berubah, pastikan folder foto juga diubah
        if ($oldUsername != $newUsername) {
            $oldFolderPath = public_path('uploads/profile/admin/' . $oldUsername);
            $newFolderPath = public_path('uploads/profile/admin/' . $newUsername);

            // Pindahkan gambar ke folder baru jika perlu
            $oldPhotoPath = public_path('uploads/profile/admin/' . $oldUsername . '/' . $user->foto);
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

        return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui!');
    }
    public function destroyPhoto()
    {
        $user = Auth::user();

        // Pastikan foto yang ada bukan foto default
        if ($user->foto && $user->foto != 'default.jpg') {
            $folderPath = public_path('uploads/profile/admin/' . $user->username);
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

    // MANAJEMEN GURU
    public function manajemenGuru()
    {
        $gurus = Guru::with(['user', 'pelajaran'])->get();
        return view('v_admin.guru.manajemen_guru', compact('gurus'));
    }
    public function createGuru()// Ambil semua data pelajaran
    {
        $mataPelajaran = Pelajaran::all(); 
        return view('v_admin.guru.create_guru', compact('mataPelajaran'));
    }
    public function storeGuru(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|string|unique:guru,nip',
            'nama' => 'required|string|max:255',
            'gender' => 'required|string|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'nullable|date',
            'email' => 'required|email|unique:user,email',
            'hp' => 'required|string|digits_between:10,13',
            'password' => 'required|string|min:8',
            'status' => 'required|boolean',
            'alamat' => 'required|string',
            'pelajaran_id' => 'nullable|exists:pelajaran,id',
        ], [
            'nip.required' => 'NIP wajib diisi.',
            'nip.unique' => 'NIP sudah terdaftar.',
            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama maksimal 255 karakter.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'gender.in' => 'Jenis kelamin tidak valid.',
            'tanggal_lahir.date' => 'Tanggal lahir harus berupa tanggal yang valid.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'hp.required' => 'Nomor HP wajib diisi.',
            'hp.digits_between' => 'Nomor HP harus terdiri dari 10 hingga 13 digit.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'status.required' => 'Status wajib dipilih.',
            'status.boolean' => 'Status tidak valid.',
            'alamat.required' => 'Alamat wajib diisi.',
            'pelajaran_id.exists' => 'Pelajaran yang dipilih tidak valid.',
        ]);

        // Proses pembuatan user dan guru
        $user = User::create([
            'username' => $validated['nip'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 1, // Guru
            'status' => $validated['status'],
        ]);

        $guru = Guru::create([
            'user_id' => $user->id,
            'nip' => $validated['nip'],
            'nama' => $validated['nama'],
            'jenis_kelamin' => $validated['gender'],
            'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
            'hp' => $validated['hp'],
            'alamat' => $validated['alamat'],
            'pelajaran_id' => $validated['pelajaran_id'] ?? null,
        ]);

        return redirect()->route('admin.manajemenGuru')->with('success', 'Guru berhasil ditambahkan.');
    }
    public function editGuru($id)
    {
        $guru = Guru::with(['user', 'pelajaran'])->findOrFail($id);
        $mataPelajaran = Pelajaran::all(); // Ambil semua data pelajaran
        return view('v_admin.guru.update_guru', compact('guru', 'mataPelajaran'));
    }
    public function updateGuru(Request $request, $id)
    {
        $guru = Guru::with('user')->findOrFail($id);
    
        if (!$guru->user) {
            return back()->withErrors(['user' => 'Data user tidak ditemukan.']);
        }
    
        $validated = $request->validate([
            'nip' => 'required|string', // NIP dapat diubah
            'nama' => 'required|string|max:255',
            'gender' => 'required|string|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'email' => 'required|email|unique:user,email,' . $guru->user->id,
            'hp' => 'required|string|max:13',
            'password' => 'nullable|string|min:8',
            'status' => 'nullable|boolean',
            'alamat' => 'required|string',
        ], [
            'nip.required' => 'NIP harus diisi.',
            'nama.required' => 'Nama harus diisi.',
            'gender.required' => 'Jenis kelamin harus dipilih.',
            'tanggal_lahir.required' => 'Tanggal lahir harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'hp.required' => 'Nomor HP harus diisi.',
            'hp.max' => 'Nomor HP maksimal 13 karakter.',
            'password.min' => 'Password minimal 8 karakter.',
            'alamat.required' => 'Alamat harus diisi.',
            'status.boolean' => 'Status harus berupa true atau false.',
        ]);
    
        // Update username di tabel user
        $guru->user->update([
            'username' => $validated['nip'], // Update username menjadi NIP baru
            'email' => $validated['email'],
            'password' => $request->filled('password') ? bcrypt($validated['password']) : $guru->user->password,
            'status' => $validated['status'] ?? $guru->user->status,
        ]);
    
        // Update guru
        $guru->update([
            'nip' => $validated['nip'],
            'nama' => $validated['nama'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'jenis_kelamin' => $validated['gender'],
            'hp' => $validated['hp'],
            'alamat' => $validated['alamat'],
        ]);
    
        return redirect()->route('admin.manajemenGuru')->with('success', 'Guru berhasil diperbarui.');
    }       
    public function deleteGuru($id)
    {
        $guru = Guru::findOrFail($id);

        // Hapus relasi pelajaran terlebih dahulu
        $guru->pelajaran()->detach();

        // Hapus user yang berelasi
        $guru->user()->delete();

        // Hapus data guru
        $guru->delete();

        return redirect()->route('admin.manajemenGuru')->with('success', 'Guru berhasil dihapus.');
    }
    
    // MANAJEMEN SISWA
    public function manajemenSiswa()
    {
        $siswas = Siswa::with(['user', 'kelas'])->get();
        return view('v_admin.siswa.manajemen_siswa', compact('siswas'));
    }
    public function createSiswa()
    {
        $kelas = Kelas::all(); // Ambil semua data kelas
        return view('v_admin.siswa.create_siswa', compact('kelas'));
    }
    public function storeSiswa(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|string|unique:siswa,nis',
            'nama' => 'required|string|max:255',
            'gender' => 'required|string|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'nullable|date',
            'email' => 'required|email|unique:user,email',
            'hp' => 'required|string|digits_between:10,13',
            'password' => 'required|string|min:8',
            'status' => 'required|boolean',
            'alamat' => 'required|string',
        ], [
            // Pesan kesalahan yang sesuai
        ]);
    
        // Proses pembuatan user dan siswa
        $user = User::create([
            'username' => $validated['nis'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 2, // Siswa
            'status' => $validated['status'],
        ]);
    
        $siswa = Siswa::create([
            'user_id' => $user->id,
            'nis' => $validated['nis'],
            'nama' => $validated['nama'],
            'jenis_kelamin' => $validated['gender'],
            'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
            'hp' => $validated['hp'],
            'alamat' => $validated['alamat'],
        ]);
    
        return redirect()->route('admin.manajemenSiswa')->with('success', 'Siswa berhasil ditambahkan.');
    }    
    public function editSiswa($id)
    {
        $siswa = Siswa::with(['user', 'kelas'])->findOrFail($id);
        $kelas = Kelas::all(); // Ambil semua data kelas
        return view('v_admin.siswa.update_siswa', compact('siswa', 'kelas'));
    }
    public function updateSiswa(Request $request, $id)
    {
        $siswa = Siswa::with('user')->findOrFail($id);
    
        if (!$siswa->user) {
            return back()->withErrors(['user' => 'Data user tidak ditemukan.']);
        }
    
        $validated = $request->validate([
            'nis' => 'required|string', // NIS dapat diubah
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'email' => 'required|email|unique:user,email,' . $siswa->user->id,
            'hp' => 'required|string|max:13',
            'password' => 'nullable|string|min:8',
            'status' => 'nullable|boolean',
            'alamat' => 'required|string',
        ], [
            'nis.required' => 'NIS harus diisi.',
            'nama.required' => 'Nama harus diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih.',
            'tanggal_lahir.required' => 'Tanggal lahir harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'hp.required' => 'Nomor HP harus diisi.',
            'hp.max' => 'Nomor HP maksimal 13 karakter.',
            'password.min' => 'Password minimal 8 karakter.',
            'alamat.required' => 'Alamat harus diisi.',
            'status.boolean' => 'Status harus berupa true atau false.',
        ]);
    
        // Update username di tabel user
        $siswa->user->update([
            'username' => $validated['nis'], // Update username menjadi NIS baru
            'email' => $validated['email'],
            'password' => $request->filled('password') ? bcrypt($validated['password']) : $siswa->user->password,
            'status' => $validated['status'] ?? $siswa->user->status,
        ]);
    
        // Update siswa
        $siswa->update([
            'nis' => $validated['nis'],
            'nama' => $validated['nama'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'hp' => $validated['hp'],
            'alamat' => $validated['alamat'],
        ]);
    
        return redirect()->route('admin.manajemenSiswa')->with('success', 'Siswa berhasil diperbarui.');
    }    
    public function deleteSiswa($id)
    {
        $siswa = Siswa::findOrFail($id);

        // Hapus user yang berelasi
        $siswa->user()->delete();

        // Hapus data siswa
        $siswa->delete();

        return redirect()->route('admin.manajemenSiswa')->with('success', 'Siswa berhasil dihapus.');
    }

    // MANAJEMEN MATA PELAJARAN
    public function manajemenPelajaran()
    {
        $pelajarans = Pelajaran::with('guru')->get(); // Mengambil relasi guru pada pelajaran
        return view('v_admin.pelajaran.mata_pelajaran', compact('pelajarans'));
    }
    public function createPelajaran()
    {
        return view('v_admin.pelajaran.create_pelajaran');
    }
    public function storePelajaran(Request $request)
    {
        // Validasi data yang dikirimkan
        $validated = $request->validate([
            'nama_pelajaran' => 'required|string|max:255',
            'jenjang' => 'required|integer|min:1|max:3', // Validasi untuk jenjang
        ]);

        // Tentukan angka kelas berdasarkan jenjang
        $kelasJenjangMapping = [
            1 => 7,
            2 => 8,
            3 => 9,
        ];
        $kelasJenjang = $kelasJenjangMapping[$validated['jenjang']] ?? null;

        // Pastikan jenjang valid
        if ($kelasJenjang === null) {
            return back()->withErrors(['jenjang' => 'Jenjang tidak valid.'])->withInput();
        }

        // Tambahkan jenjang ke nama mata pelajaran
        $namaPelajaranDenganJenjang = $validated['nama_pelajaran'] . ' Kelas ' . $kelasJenjang;

        // Cek apakah mata pelajaran sudah ada di jenjang yang sama
        $existingPelajaran = Pelajaran::where('nama_pelajaran', $namaPelajaranDenganJenjang)
                                    ->where('jenjang', $validated['jenjang'])
                                    ->exists();

        if ($existingPelajaran) {
            // Jika mata pelajaran sudah ada di jenjang yang sama, tampilkan pesan error
            return back()->withErrors([
                'nama_pelajaran' => 'Mata pelajaran ini sudah terdaftar pada jenjang tersebut.',
            ])->withInput();
        }

        // Simpan data mata pelajaran ke database
        Pelajaran::create([
            'nama_pelajaran' => $namaPelajaranDenganJenjang,
            'jenjang' => $validated['jenjang'],
        ]);

        return redirect()->route('admin.manajemenPelajaran')->with('success', 'Mata pelajaran berhasil ditambahkan!');
    }
    public function editPelajaran($id)
    {
        $pelajaran = Pelajaran::with('guru')->findOrFail($id);
    
        // Nama dasar mata pelajaran tanpa tambahan jenjang
        $namaDasarPelajaran = preg_replace('/ Kelas \d+$/', '', $pelajaran->nama_pelajaran);
    
        // Ambil semua data guru terkait pelajaran
        $guruTerdaftar = \DB::table('pelajaran_guru')
            ->join('pelajaran', 'pelajaran.id', '=', 'pelajaran_guru.pelajaran_id')
            ->select('pelajaran_guru.guru_id', 'pelajaran.nama_pelajaran', 'pelajaran.jenjang')
            ->get();
    
        // Map guru untuk menentukan status mereka
        $gurus = Guru::all()->map(function ($guru) use ($pelajaran, $guruTerdaftar, $namaDasarPelajaran) {
            $isGuruTerdaftar = $guruTerdaftar->where('guru_id', $guru->id);
    
            if ($isGuruTerdaftar->isEmpty()) {
                // Guru belum mengajar di mana pun, aktifkan untuk semua pilihan
                $guru->is_disabled = false;
            } else {
                // Guru sudah terdaftar, cek nama dasar pelajaran dan jenjang
                $isMataPelajaranSama = $isGuruTerdaftar->filter(function ($pelajaranGuru) use ($namaDasarPelajaran) {
                    return preg_replace('/ Kelas \d+$/', '', $pelajaranGuru->nama_pelajaran) === $namaDasarPelajaran;
                });
    
                $isJenjangSama = $isGuruTerdaftar->where('jenjang', $pelajaran->jenjang);
    
                // Guru tidak tersedia jika mengajar di jenjang yang sama
                if ($isJenjangSama->isNotEmpty()) {
                    $guru->is_disabled = true;
                } else {
                    // Guru tersedia jika mata pelajaran sama di jenjang berbeda
                    $guru->is_disabled = !$isMataPelajaranSama->where('jenjang', '!=', $pelajaran->jenjang)->isNotEmpty();
                }
            }
    
            return $guru;
        });
    
        return view('v_admin.pelajaran.update_pelajaran', compact('pelajaran', 'gurus'));
    }    
    public function updatePelajaran(Request $request, $id)
    {
        $pelajaran = Pelajaran::findOrFail($id);

        $validated = $request->validate([
            'guru' => 'nullable|exists:guru,id',
        ]);

        // Update guru untuk mata pelajaran
        $pelajaran->guru()->sync($validated['guru'] ? [$validated['guru']] : []);

        return redirect()->route('admin.manajemenPelajaran')->with('success', 'Mata pelajaran berhasil diperbarui!');
    }     
    public function deletePelajaran($id)
    {
        $pelajaran = Pelajaran::findOrFail($id);
        $pelajaran->delete();

        return redirect()->route('admin.manajemenPelajaran')->with('success', 'Mata pelajaran berhasil dihapus!');
    }

    // MANAJAMEN KELAS
    public function manajemenKelas()
    {
        // Mengambil data kelas beserta relasi guru, siswa, dan pelajaran
        $kelas = Kelas::with('guru', 'siswa', 'pelajaran')->get();
        return view('v_admin.kelas.manajemen_kelas', compact('kelas')); // Path view sesuai
    }
    public function createKelas()
    {
        return view('v_admin.kelas.create_kelas');
    }
    public function storeKelas(Request $request)
    {
        // Validasi data yang dikirimkan
        $validated = $request->validate([
            'nama_kelas' => [
                'required',
                'string',
                'max:255',
                'regex:/^[789][A-Z]$/i', // Nama kelas harus angka 7, 8, atau 9 diikuti satu huruf
            ],
            'jenjang' => 'required|integer|min:1|max:3',
        ]);

        // Validasi kesesuaian jenjang dengan nama kelas
        $angkaKelas = (int) substr($validated['nama_kelas'], 0, 1); // Ambil angka pertama pada nama kelas
        $expectedJenjang = match ($angkaKelas) {
            7 => 1,
            8 => 2,
            9 => 3,
            default => null, // Tidak valid jika angka tidak 7, 8, atau 9
        };

        if ($validated['jenjang'] != $expectedJenjang) {
            return back()->withErrors(['jenjang' => 'Jenjang tidak sesuai dengan nama kelas.'])->withInput();
        }

        // Cek jika nama kelas sudah ada (case-insensitive), setelah jenjang sesuai
        $kelasNama = strtolower($validated['nama_kelas']);
        $kelasExists = Kelas::whereRaw('LOWER(nama_kelas) = ?', [$kelasNama])->exists();

        if ($kelasExists) {
            return back()->withErrors(['nama_kelas' => 'Nama kelas sudah digunakan.'])->withInput();
        }

        // Simpan data kelas ke database
        Kelas::create([
            'nama_kelas' => strtoupper($validated['nama_kelas']), // Simpan nama kelas dalam huruf besar
            'jenjang' => $validated['jenjang'],
        ]);

        return redirect()->route('admin.manajemenKelas')->with('success', 'Kelas berhasil ditambahkan.');
    }
    public function editKelas($id)
    {
        // Ambil data kelas beserta relasi siswa, pelajaran, dan guru
        $kelas = Kelas::with(['siswa', 'pelajaran', 'guru'])->findOrFail($id);

        // Filter siswa yang belum terdaftar di kelas lain
        $siswaTerdaftar = Kelas::where('id', '!=', $id)
            ->with('siswa:id')
            ->get()
            ->pluck('siswa')
            ->flatten()
            ->pluck('id')
            ->unique();
        $siswaList = Siswa::whereNotIn('id', $siswaTerdaftar)->get();

        // Filter guru yang belum menjadi wali kelas di kelas lain
        $waliKelasTerdaftar = Kelas::where('id', '!=', $id)
            ->with('guru:id')
            ->get()
            ->pluck('guru')
            ->flatten()
            ->pluck('id')
            ->unique();
        $guruList = Guru::whereNotIn('id', $waliKelasTerdaftar)->get();

        // Filter mata pelajaran sesuai jenjang kelas
        $pelajaranList = Pelajaran::where('jenjang', $kelas->jenjang)->get();

        // Mapping jadwal berdasarkan pelajaran
        $jadwalList = $pelajaranList->map(function ($pelajaran) use ($kelas) {
            $pivot = $kelas->pelajaran->find($pelajaran->id)?->pivot;
            return [
                'pelajaran_id' => $pelajaran->id,
                'nama_pelajaran' => $pelajaran->nama_pelajaran,
                'hari' => $pivot->hari ?? null,
                'jam_mulai' => $pivot->jam_mulai ?? null,
                'jam_selesai' => $pivot->jam_selesai ?? null,
            ];
        });

        return view('v_admin.kelas.update_kelas', compact('kelas', 'siswaList', 'guruList', 'jadwalList'));
    }    public function updateKelas(Request $request, $id)
    {
        $validated = $request->validate([
            'siswa' => 'nullable|array',
            'siswa.*' => 'exists:siswa,id',
            'wali_kelas' => 'nullable|exists:guru,id',
            'jadwal' => 'nullable|array',
        ]);

        $kelas = Kelas::findOrFail($id);

        // Update siswa
        $kelas->siswa()->sync($request->input('siswa', []));

        // Update wali kelas
        $kelas->guru()->sync($request->input('wali_kelas') ? [$request->input('wali_kelas')] : []);

        // Validasi dan Update jadwal pelajaran
        foreach ($request->input('jadwal', []) as $pelajaranId => $jadwalData) {
            if (!empty($jadwalData['selected'])) {
                // Validasi: Semua data jadwal harus ada jika checkbox dipilih
                if (empty($jadwalData['hari']) || empty($jadwalData['jam_mulai']) || empty($jadwalData['jam_selesai'])) {
                    return back()->withErrors([
                        "jadwal.{$pelajaranId}" => "Semua data jadwal harus diisi untuk pelajaran yang dipilih."
                    ])->withInput();
                }

                // Validasi: Jam mulai harus sebelum jam selesai
                if (strtotime($jadwalData['jam_mulai']) >= strtotime($jadwalData['jam_selesai'])) {
                    return back()->withErrors([
                        "jadwal.{$pelajaranId}" => "Jam selesai harus lebih besar dari jam mulai untuk pelajaran yang dipilih."
                    ])->withInput();
                }

                // Simpan jadwal
                $kelas->pelajaran()->syncWithoutDetaching([
                    $pelajaranId => [
                        'hari' => $jadwalData['hari'],
                        'jam_mulai' => $jadwalData['jam_mulai'],
                        'jam_selesai' => $jadwalData['jam_selesai'],
                    ]
                ]);
            } else {
                // Hapus pelajaran dari kelas jika tidak dipilih
                $kelas->pelajaran()->detach($pelajaranId);
            }
        }

        return redirect()->route('admin.manajemenKelas')->with('success', 'Kelas dan jadwal berhasil diperbarui!');
    }   
    public function deleteKelas($id)
    {
        // Cari kelas berdasarkan ID
        $kelas = Kelas::findOrFail($id);

        // Hapus relasi siswa dan pelajaran terlebih dahulu
        $kelas->siswa()->detach();
        $kelas->pelajaran()->detach();

        // Hapus kelas
        $kelas->delete();

        // Redirect setelah hapus
        return redirect()->route('admin.manajemenKelas')->with('success', 'Kelas berhasil dihapus!');
    }
}
