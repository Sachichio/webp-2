<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Admin, Guru, Siswa, Kelas, Pelajaran};

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // **1. Seed Admin Data**
        $admin1User = User::create([
            'username' => 'admin1',
            'email' => 'admin1@gmail.com',
            'password' => Hash::make('00000000'),
            'role' => 0, // Admin
            'status' => 1,
        ]);

        $admin2User = User::create([
            'username' => 'admin2',
            'email' => 'admin2@gmail.com',
            'password' => Hash::make('00000000'),
            'role' => 0, // Admin
            'status' => 1,
        ]);

        Admin::create([
            'user_id' => $admin1User->id,
            'nama' => 'John Doe',
            'hp' => '081234567890',
        ]);

        Admin::create([
            'user_id' => $admin2User->id,
            'nama' => 'Jane Doe',
            'hp' => '081234567891',
        ]);

        // **2. Seed Guru Data**
        $guruData = [
            ['nip' => '1987654321', 'nama' => 'Budi Santoso', 'jenis_kelamin' => 'L', 'hp' => '081234567892', 'alamat' => 'Jl. Guru 1'],
            ['nip' => '1987654322', 'nama' => 'Ani Puspitasari', 'jenis_kelamin' => 'P', 'hp' => '081234567893', 'alamat' => 'Jl. Guru 2'],
            ['nip' => '1987654323', 'nama' => 'Citra Dewi', 'jenis_kelamin' => 'P', 'hp' => '081234567894', 'alamat' => 'Jl. Guru 3'],
            ['nip' => '1987654324', 'nama' => 'Dian Pratama', 'jenis_kelamin' => 'L', 'hp' => '081234567895', 'alamat' => 'Jl. Guru 4'],
            ['nip' => '1987654325', 'nama' => 'Eko Putra', 'jenis_kelamin' => 'L', 'hp' => '081234567896', 'alamat' => 'Jl. Guru 5'],
        ];

        foreach ($guruData as $guru) {
            $user = User::create([
                'username' => $guru['nip'],
                'email' => strtolower(str_replace(' ', '.', $guru['nama'])) . '@gmail.com',
                'password' => Hash::make('00000000'),
                'role' => 1, // Guru
                'status' => 1,
            ]);

            Guru::create([
                'user_id' => $user->id,
                'nip' => $guru['nip'],
                'nama' => $guru['nama'],
                'jenis_kelamin' => $guru['jenis_kelamin'],
                'hp' => $guru['hp'],
                'alamat' => $guru['alamat'],
                'tanggal_lahir' => '1980-01-01',
            ]);
        }

        // **3. Seed Siswa Data**
        $siswaData = [
            ['nis' => '20230101', 'nama' => 'Fajar Rahman', 'jenis_kelamin' => 'L', 'hp' => '081234567897', 'alamat' => 'Jl. Siswa 1'],
            ['nis' => '20230102', 'nama' => 'Gita Sari', 'jenis_kelamin' => 'P', 'hp' => '081234567898', 'alamat' => 'Jl. Siswa 2'],
            ['nis' => '20230103', 'nama' => 'Hendra Kurniawan', 'jenis_kelamin' => 'L', 'hp' => '081234567899', 'alamat' => 'Jl. Siswa 3'],
            ['nis' => '20230104', 'nama' => 'Intan Permata', 'jenis_kelamin' => 'P', 'hp' => '081234567800', 'alamat' => 'Jl. Siswa 4'],
            ['nis' => '20230105', 'nama' => 'Joko Widodo', 'jenis_kelamin' => 'L', 'hp' => '081234567801', 'alamat' => 'Jl. Siswa 5'],
            ['nis' => '20230106', 'nama' => 'Kirana Putri', 'jenis_kelamin' => 'P', 'hp' => '081234567802', 'alamat' => 'Jl. Siswa 6'],
            ['nis' => '20230107', 'nama' => 'Lukman Hakim', 'jenis_kelamin' => 'L', 'hp' => '081234567803', 'alamat' => 'Jl. Siswa 7'],
            ['nis' => '20230108', 'nama' => 'Maya Arini', 'jenis_kelamin' => 'P', 'hp' => '081234567804', 'alamat' => 'Jl. Siswa 8'],
            ['nis' => '20230109', 'nama' => 'Nanda Pratama', 'jenis_kelamin' => 'L', 'hp' => '081234567805', 'alamat' => 'Jl. Siswa 9'],
            ['nis' => '20230110', 'nama' => 'Oka Dharma', 'jenis_kelamin' => 'P', 'hp' => '081234567806', 'alamat' => 'Jl. Siswa 10'],
            ['nis' => '20230111', 'nama' => 'Putu Satria', 'jenis_kelamin' => 'L', 'hp' => '081234567807', 'alamat' => 'Jl. Siswa 11'],
            ['nis' => '20230112', 'nama' => 'Qori Andini', 'jenis_kelamin' => 'P', 'hp' => '081234567808', 'alamat' => 'Jl. Siswa 12'],
            ['nis' => '20230113', 'nama' => 'Rendi Wijaya', 'jenis_kelamin' => 'L', 'hp' => '081234567809', 'alamat' => 'Jl. Siswa 13'],
            ['nis' => '20230114', 'nama' => 'Sinta Amalia', 'jenis_kelamin' => 'P', 'hp' => '081234567810', 'alamat' => 'Jl. Siswa 14'],
            ['nis' => '20230115', 'nama' => 'Tio Saputra', 'jenis_kelamin' => 'L', 'hp' => '081234567811', 'alamat' => 'Jl. Siswa 15'],
            ['nis' => '20230116', 'nama' => 'Umi Azizah', 'jenis_kelamin' => 'P', 'hp' => '081234567812', 'alamat' => 'Jl. Siswa 16'],
            ['nis' => '20230117', 'nama' => 'Vina Pratiwi', 'jenis_kelamin' => 'P', 'hp' => '081234567813', 'alamat' => 'Jl. Siswa 17'],
            ['nis' => '20230118', 'nama' => 'Wahyu Firmansyah', 'jenis_kelamin' => 'L', 'hp' => '081234567814', 'alamat' => 'Jl. Siswa 18'],
            ['nis' => '20230119', 'nama' => 'Xenia Karina', 'jenis_kelamin' => 'P', 'hp' => '081234567815', 'alamat' => 'Jl. Siswa 19'],
            ['nis' => '20230120', 'nama' => 'Yoga Mahendra', 'jenis_kelamin' => 'L', 'hp' => '081234567816', 'alamat' => 'Jl. Siswa 20'],
        ];

        foreach ($siswaData as $siswa) {
            $user = User::create([
                'username' => $siswa['nis'],
                'email' => strtolower(str_replace(' ', '.', $siswa['nama'])) . '@gmail.com',
                'password' => Hash::make('00000000'),
                'role' => 2, // Siswa
                'status' => 1,
            ]);

            Siswa::create([
                'user_id' => $user->id,
                'nis' => $siswa['nis'],
                'nama' => $siswa['nama'],
                'jenis_kelamin' => $siswa['jenis_kelamin'],
                'hp' => $siswa['hp'],
                'alamat' => $siswa['alamat'],
                'tanggal_lahir' => '2005-06-15',
            ]);
        }

        // **4. Seed Kelas Data**
        $kelasData = [
            ['nama_kelas' => '7A', 'jenjang' => 1],
            ['nama_kelas' => '7B', 'jenjang' => 1],
            ['nama_kelas' => '8A', 'jenjang' => 2],
            ['nama_kelas' => '8B', 'jenjang' => 2],
            ['nama_kelas' => '9A', 'jenjang' => 3],
            ['nama_kelas' => '9B', 'jenjang' => 3],
        ];

        foreach ($kelasData as $kelas) {
            Kelas::create($kelas);
        }
    }
}
