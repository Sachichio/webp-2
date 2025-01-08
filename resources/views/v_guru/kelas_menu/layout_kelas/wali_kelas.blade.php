@extends('v_guru.layouts.guru_master')

@section('content')
<div class="container">
    <!-- Block 1: Title -->
    <div class="title-container">
        <h2 class="mb-3">Daftar Siswa - Kelas {{ $kelas->nama_kelas }}</h2>
    </div>

    <!-- Block 2: Table -->
    <div class="table-container">
        <div class="table-header">
            <input type="text" id="searchInput" class="search-bar" placeholder="Cari...">
        </div>
        <table class="table table-striped table-bordered" id="siswaTable">
            <thead>
                <tr>
                    <th onclick="sortTable(0)">Nama</th>
                    <th onclick="sortTable(1)">NIS</th>
                    <th onclick="sortTable(2)">Jenis Kelamin</th>
                    <th onclick="sortTable(3)">Email</th>
                    <th onclick="sortTable(4)">Nomor Telpon</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($siswas as $siswa)
                <tr>
                    <td>{{ $siswa->nama }}</td>
                    <td>{{ $siswa->nis }}</td>
                    <td>{{ $siswa->jenis_kelamin }}</td>
                    <td>{{ $siswa->user->email }}</td>
                    <td>{{ $siswa->hp }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div id="notFoundMessage" style="display: none; text-align: center; margin-top: 10px;">Data tidak ditemukan</div>
        <div class="pagination-controls">
            <div class="pagination-info">
                <span id="entriesInfo">Showing 1 to 5 of {{ $siswas->count() }} entries</span>
            </div>
            <button id="prevBtn" class="btn-secondary-pre" onclick="prevPage()" disabled>Previous</button>
            <button id="nextBtn" class="btn-secondary-next" onclick="nextPage()">Next</button>
        </div>
    </div>
</div>

@endsection

<!-- CSS Internal -->
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

    .title-container,
    .table-container {
        display: inline-block;
        width: 100%;
        background-color: #d4d4d4;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 2%;
    }

    .table-container {
        margin-top: 2%;
        padding-top: 3%;
    }

    .title {
        font-size: 24px;
        text-align: left;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    .table th, .table td {
        padding: 8px;
        text-align: left;
        border: 1px solid #ddd;
    }

    .table th {
        background-color: #f4f4f4;
        cursor: pointer;
    }

    .table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .table th:hover {
        background-color: #eaeaea;
    }

    .table-header {
        display: flex;
        justify-content: flex-start;
        margin-bottom: 2%;
        gap: 10px;
    }

    .search-bar {
        padding: 10px;
        width: 300px;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-sizing: border-box;
    }

    .search-bar:focus {
        outline: none;
        border-color: #305cde;
    }

    .pagination-controls {
        display: flex;
        align-items: center;
        gap: 10px;  
        margin-top: 20px;
    }

    .pagination-info {
        font-size: 12px;
    }
    .btn-secondary-pre {
        background-color: #6c757d;
        color: white;
        padding: 5px 8px;
        font-size: 12px;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }

    .btn-secondary-pre:hover {
        background-color: #565e64;
    }

    .btn-secondary-next {
        background-color: #6c757d;
        color: white;
        padding: 5px 20px;
        font-size: 12px;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }

    .btn-secondary-next:hover {
        background-color: #565e64;
    }

    /* Responsiveness */
    @media (max-width: 768px) {
        .table th, .table td {
            padding: 10px;
            font-size: 10px;
        }

        .table-container {
            padding: 10px;
        }

        .search-bar {
            width: 200px;
        }

        .pagination-controls {
            flex-direction: column;
            align-items: flex-start;
        }

        .pagination-info {
            margin-bottom: 10px;
        }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    const table = document.getElementById("siswaTable");
    const rows = Array.from(table.getElementsByTagName("tbody")[0].getElementsByTagName("tr"));
    const searchInput = document.getElementById("searchInput");

    let currentPage = 1;
    const rowsPerPage = 5; // Jumlah maksimum baris per halaman
    let sortOrder = [true, true, true, true, true]; // Untuk menyimpan urutan sorting kolom

    /**
     * Fungsi untuk memfilter baris berdasarkan input pencarian
     */
    function filterRows() {
        const filter = searchInput.value.toLowerCase();
        return rows.filter(row => {
            const cells = Array.from(row.getElementsByTagName("td"));
            return cells.some(cell =>
                cell.textContent.toLowerCase().includes(filter)
            );
        });
    }

    /**
     * Fungsi untuk menampilkan baris sesuai halaman saat ini
     */
    function paginateTable() {
        const filteredRows = filterRows(); // Ambil baris yang sesuai pencarian
        const totalRows = filteredRows.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage);

        // Sembunyikan semua baris terlebih dahulu
        rows.forEach(row => (row.style.display = "none"));

        // Tampilkan baris yang sesuai dengan halaman saat ini
        const start = (currentPage - 1) * rowsPerPage;
        const end = Math.min(currentPage * rowsPerPage, totalRows);
        for (let i = start; i < end; i++) {
            filteredRows[i].style.display = ""; // Tampilkan baris
        }

        // Update status tombol navigasi
        document.getElementById("prevBtn").disabled = currentPage === 1;
        document.getElementById("nextBtn").disabled = currentPage === totalPages;

        // Update informasi jumlah data
        const startEntry = totalRows > 0 ? start + 1 : 0;
        const endEntry = totalRows > 0 ? end : 0;
        document.getElementById("entriesInfo").innerText = `Showing ${startEntry} to ${endEntry} of ${totalRows} entries`;
    }

    /**
     * Navigasi ke halaman sebelumnya
     */
    document.getElementById("prevBtn").addEventListener("click", function () {
        if (currentPage > 1) {
            currentPage--;
            paginateTable();
        }
    });

    /**
     * Navigasi ke halaman berikutnya
     */
    document.getElementById("nextBtn").addEventListener("click", function () {
        const filteredRows = filterRows();
        const totalPages = Math.ceil(filteredRows.length / rowsPerPage);

        if (currentPage < totalPages) {
            currentPage++;
            paginateTable();
        }
    });

    /**
     * Event pencarian
     */
    searchInput.addEventListener("input", function () {
        currentPage = 1; // Reset ke halaman pertama saat pencarian berubah
        paginateTable();
    });

    /**
     * Fungsi untuk mengurutkan tabel berdasarkan kolom
     */
    function sortTable(columnIndex) {
        const filteredRows = filterRows();
        sortOrder[columnIndex] = !sortOrder[columnIndex]; // Toggle sort order (asc/desc)

        filteredRows.sort((a, b) => {
            const cellA = a.cells[columnIndex].innerText.trim();
            const cellB = b.cells[columnIndex].innerText.trim();

            if (!isNaN(cellA) && !isNaN(cellB)) {
                // Sort angka
                return sortOrder[columnIndex]
                    ? parseFloat(cellA) - parseFloat(cellB)
                    : parseFloat(cellB) - parseFloat(cellA);
            } else {
                // Sort teks
                return sortOrder[columnIndex]
                    ? cellA.localeCompare(cellB)
                    : cellB.localeCompare(cellA);
            }
        });

        // Tambahkan kembali baris yang telah diurutkan ke tabel
        const tbody = table.getElementsByTagName("tbody")[0];
        filteredRows.forEach(row => tbody.appendChild(row));

        // Reset ke halaman pertama setelah sorting
        currentPage = 1;
        paginateTable();
    }

    /**
     * Tambahkan event listener untuk sorting di header tabel
     */
    const headers = table.getElementsByTagName("th");
    Array.from(headers).forEach((header, index) => {
        header.addEventListener("click", function () {
            sortTable(index);
        });
    });

    /**
     * Inisialisasi saat halaman dimuat
     */
    paginateTable();
});

</script>
