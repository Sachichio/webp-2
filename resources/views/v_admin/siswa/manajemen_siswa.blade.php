@extends('v_admin.layouts.admin_master')

@section('content')

<div class="container">
    <!-- Block 1: Title -->
    <div class="title-container">
        <h1 class="title">Manajemen Siswa</h1>
    </div>

    <!-- Block 2: Table -->
    <div class="table-container">
        <div class="table-header">
            <a href="{{ route('admin.createSiswa') }}" class="btn btn-primary">+ Add</a>
            <input type="text" id="searchInput" class="search-bar" placeholder="Cari...">
        </div>
        <table class="table table-striped table-bordered" id="siswaTable">
            <thead>
                <tr>
                    <th onclick="sortTable(0)">Nama</th>
                    <th onclick="sortTable(1)">NIS</th>
                    <th onclick="sortTable(2)">Email</th>
                    <th onclick="sortTable(3)">Kelas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($siswas as $siswa)
                <tr>
                    <td>{{ $siswa->nama }}</td>
                    <td>{{ $siswa->nis }}</td>
                    <td>{{ $siswa->user->email }}</td>
                    <td>
                        @if ($siswa->kelas->isEmpty())
                            <span class="text-muted">Belum Ada Kelas</span>
                        @else
                            @foreach($siswa->kelas as $kelas)
                                {{ $kelas->nama_kelas }}<br>
                            @endforeach
                        @endif
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.editSiswa', $siswa->id) }}" class="btn-secondary-edit" style="display: flex; align-items: center;">
                                <img src="{{ asset('backend/icons/edit.svg') }}" alt="Edit" style="width: 16px; height: 16px; vertical-align: middle; margin-right: 5px;">
                                Edit
                            </a>
                            <form action="{{ route('admin.deleteSiswa', $siswa->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger">
                                    <img src="{{ asset('backend/icons/delete.svg') }}" alt="Delete" style="width: 16px; height: 16px; vertical-align: middle; margin-right: 5px;">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div id="notFoundMessage" style="display: none; text-align: center; margin-top: 10px;">Not Found</div>
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

    .table th {
        background-color: #f4f4f4;
        cursor: pointer;
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

    .btn-primary {
        background-color: #305cde;
        color: white;
        padding: 10px 20px;
        font-size: 12px;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-group {
        display: flex; 
        gap: 5px;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
        padding: 5px 10px;
        border: none;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-danger:hover {
        background-color: #b02a37;
    }

    .btn-secondary-edit {
        background-color: #6c757d;
        color: white;
        padding: 5px 17px;
        font-size: 12px;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }

    .btn-secondary-edit:hover {
        background-color: #565e64;
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

    .pagination-controls {
        display: flex;
        align-items: center;
        gap: 10px;  
        margin-top: 20px;
    }

    .pagination-info {
        font-size: 12px;
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

        .btn-group {
            flex-direction: column;
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
    let currentPage = 1;
    const rowsPerPage = 5;

    function paginateTable() {
        const table = document.getElementById("siswaTable");
        const rows = Array.from(table.getElementsByTagName("tr"));
        const totalRows = rows.length - 1; // Exclude header row

        rows.forEach((row, index) => {
            if (index === 0) return; // Skip header

            const rowIndex = index - 1;
            row.style.display =
                rowIndex >= (currentPage - 1) * rowsPerPage && rowIndex < currentPage * rowsPerPage
                    ? ""
                    : "none";
        });

        const totalPages = Math.ceil(totalRows / rowsPerPage);
        document.getElementById("prevBtn").disabled = currentPage === 1;
        document.getElementById("nextBtn").disabled = currentPage === totalPages;

        const startEntry = (currentPage - 1) * rowsPerPage + 1;
        const endEntry = Math.min(currentPage * rowsPerPage, totalRows);
        document.getElementById("entriesInfo").innerText = `Showing ${startEntry} to ${endEntry} of ${totalRows} entries`;
    }

    function prevPage() {
        if (currentPage > 1) {
            currentPage--;
            paginateTable();
        }
    }

    function nextPage() {
        const table = document.getElementById("siswaTable");
        const rows = table.getElementsByTagName("tr").length - 1; // Exclude header row
        const totalPages = Math.ceil(rows / rowsPerPage);

        if (currentPage < totalPages) {
            currentPage++;
            paginateTable();
        }
    }

    document.getElementById("searchInput").addEventListener("input", function () {
        const filter = this.value.toLowerCase();
        const table = document.getElementById("siswaTable");
        const rows = Array.from(table.getElementsByTagName("tr"));
        let found = false;

        rows.forEach((row, index) => {
            if (index === 0) return; // Skip header

            const cells = Array.from(row.getElementsByTagName("td"));
            const rowContainsFilter = cells.some(cell =>
                cell && cell.innerText.toLowerCase().includes(filter)
            );

            row.style.display = rowContainsFilter ? "" : "none";
            if (rowContainsFilter) found = true;
        });

        if (!filter) {
            currentPage = 1;
            paginateTable();
        }

        document.getElementById("notFoundMessage").style.display = found ? "none" : "block";
    });

    let sortOrder = [true, true, true, true];

    function sortTable(columnIndex) {
        const table = document.getElementById("siswaTable");
        const rows = Array.from(table.rows).slice(1);

        sortOrder[columnIndex] = !sortOrder[columnIndex];

        const compareFunction = (a, b) => {
            const cellA = a.cells[columnIndex].innerText.trim();
            const cellB = b.cells[columnIndex].innerText.trim();

            return sortOrder[columnIndex] 
                ? cellA.localeCompare(cellB)
                : cellB.localeCompare(cellA);
        };

        rows.sort((a, b) => compareFunction(a, b));

        rows.forEach(row => table.appendChild(row));
        paginateTable();
    }

    window.onload = paginateTable;
</script>
