<div class="container">
    <!-- Block 1: Title -->
    <div class="title-container">
        <h2 class="mb-3">Kelas {{ $kelas->nama_kelas }} - Jenjang ke-{{ $kelas->jenjang }}</h2>

        <!-- Elemen untuk data jam -->
        <div id="kelas-status"
            data-jam-mulai="{{ $kelasPelajaran->jam_mulai ?? '' }}"
            data-jam-selesai="{{ $kelasPelajaran->jam_selesai ?? '' }}"
            data-hari="{{ $kelasPelajaran->hari ?? '' }}">
        </div>

        <!-- Status akan diperbarui melalui JavaScript -->
        <div id="kelas-status-text" class="alert">
            {{ $statusKelas ?? 'Data kelas tidak tersedia.' }}
        </div>
    </div>

    <!-- Navigasi -->
    <ul class="nav nav-tabs mb-4 custom-nav">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('guru.kelas.siswa') || request()->routeIs('guru.kelas.master') ? 'active' : '' }}"
                href="{{ route('guru.kelas.siswa', ['kelas_id' => $kelas->id, 'kelasPelajaranId' => $kelasPelajaran->id]) }}">
                Daftar Siswa
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('guru.kelas.absen') ? 'active' : '' }}"
                href="{{ route('guru.kelas.absen', ['kelas_id' => $kelas->id, 'kelasPelajaranId' => $kelasPelajaran->id]) }}">
                Absensi
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('guru.kelas.tugas') ? 'active' : '' }}"
                href="{{ route('guru.kelas.tugas', ['kelas_id' => $kelas->id, 'kelasPelajaranId' => $kelasPelajaran->id]) }}">
                Tugas
            </a>
        </li>
    </ul>
    <!-- Block 2: Table -->
    <div class="table-container">
        <!-- Konten Dinamis -->
        <main id="content">
            @yield('kelas-content', view($defaultView ?? 'v_guru.kelas_menu.siswa.list_siswa', [
                'kelas' => $kelas, 
                'kelasPelajaran' => $kelasPelajaran, 
                'statusKelas' => $statusKelas,
                'siswas' => $kelas->siswa()->with('user')->get() // Tambahkan ini
            ]))
        </main>
    </div>
</div>
@endsection
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #ffffff;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 100%;
        width: 90%;
        margin: 0 0 2% 3%;
        padding: 0;
    }
    .title-container {
        width: 98%;
    }
    .title-container,
    .table-container {
        display: inline-block;
        background-color: #d4d4d4;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 2%;
    }

    .table-container {
        margin-top: 2%;
        padding: 1%;
        width: 100%;
    }

    .title {
        font-size: 24px;
        text-align: left;
    }

    /* Navigasi */
    .custom-nav {
        border-bottom: 5px solid #007bff; /* Warna garis bawah */
        display: flex; /* Mengatur agar item navigasi menyamping */
        flex-wrap: wrap; /* Agar navigasi turun baris di layar kecil */
        padding: 0; /* Menghilangkan padding pada ul */
        list-style: none; /* Menghilangkan titik hitam */
        margin: 3% 0 0 0 ; /* Menghilangkan margin default */
    }

    .custom-nav .nav-item {
        flex-grow: 0.1; /* Membuat semua item tumbuh sama besar */
        margin-right: 10px; /* Jarak antar item */
        
    }

    .custom-nav .nav-link {
        padding: 12px 0; /* Padding vertikal yang sama, horizontal diatur ke 0 */
        font-size: 14px; /* Ukuran teks */
        color: #007bff; /* Warna teks default */
        text-decoration: none; /* Menghilangkan garis bawah */
        transition: background-color 0.3s, color 0.3s; /* Transisi halus */
        white-space: nowrap; /* Mencegah teks terpotong */
        text-align: center; /* Menyelaraskan teks ke tengah */
        display: block; /* Membuat link menjadi block agar memenuhi lebar item */
    }

    .custom-nav .nav-link:hover {
        background-color: rgba(0, 123, 255, 0.1); /* Warna latar belakang saat hover */
        color: #0056b3; /* Warna teks saat hover */
    }

    .custom-nav .nav-link.active {
        background-color: #007bff; /* Warna latar belakang untuk link aktif */
        color: #fff; /* Warna teks untuk link aktif */
    }

    /* Responsiveness */
    @media (max-width: 768px) {
        .custom-nav {
            flex-direction: column; /* Navigasi menjadi vertikal di layar kecil */
            align-items: flex-start; /* Menyelaraskan item ke kiri */
        }

        .custom-nav .nav-item {
            margin-right: 0; /* Menghilangkan jarak horizontal */
            margin-bottom: 5px; /* Menambahkan jarak vertikal antar item */
        }

        .custom-nav .nav-link {
            width: 100%; /* Link memenuhi lebar penuh */
            text-align: left; /* Menyelaraskan teks ke kiri */
        }
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Ambil elemen status kelas
        const statusElement = document.getElementById("kelas-status");
        const statusTextElement = document.getElementById("kelas-status-text");

        // Ambil data dari atribut
        const jamMulai = statusElement.getAttribute("data-jam-mulai");
        const jamSelesai = statusElement.getAttribute("data-jam-selesai");
        const hari = statusElement.getAttribute("data-hari");
        
        // Cek apakah data valid
        if (!jamMulai || !jamSelesai || !hari) {
            statusTextElement.textContent = "Data kelas tidak tersedia.";
            statusTextElement.className = "alert alert-danger";
            return;
        }

        // Simulasi untuk override hari saat testing
        const overrideHari = "Jumat"; // Ganti manual sesuai kebutuhan, misalnya "Senin", "Selasa", dst.
        const useOverride = true; // Set ke false jika ingin kembali ke waktu real-time

        // Konversi waktu ke format Date untuk perbandingan
        const now = new Date();
        const currentDay = useOverride ? overrideHari : now.toLocaleString("id-ID", { weekday: "long" });
        const currentTime = now.getHours() + ":" + now.getMinutes();

        // Bandingkan hari
        if (currentDay.toLowerCase() !== hari.toLowerCase()) {
            statusTextElement.textContent = "Kelas tidak berlangsung hari ini.";
            statusTextElement.className = "alert alert-danger";
            return;
        }

        // Bandingkan waktu
        if (currentTime >= jamMulai && currentTime <= jamSelesai) {
            statusTextElement.textContent = "Status: Kelas sedang berlangsung.";
            statusTextElement.className = "alert alert-success";
        } else {
            statusTextElement.textContent = "Kelas belum dimulai atau sudah selesai.";
            statusTextElement.className = "alert alert-warning";
        }
    });
</script>