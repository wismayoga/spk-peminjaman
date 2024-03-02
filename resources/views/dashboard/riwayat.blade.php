@extends('layouts/main')
@section('title', 'Riwayat')

@section('content')
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">

                @if (session()->has('success'))
                    <div class="alert alert-success alert-style-light absolute " role="alert" style="z-index: 1000;">
                        <span class="alert-icon-wrap mb-3">
                            {{ session('success') }}
                        </span>
                        <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>

                    </div>
                @endif

                <div class="row">
                    <div class="col">
                        <div class="page-description">
                            <h1>Riwayat</h1>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <form class="row" action="{{ route('cariPerhitungan') }}" method="GET">
                            <div class="col-10 mb-3">
                                <input type="text" class="form-control" name="cari" placeholder="Cari Nasabah .."
                                    value="{{ old('cari') }}">
                            </div>
                            <div class="col-2">
                                <input class="btn btn-info" type="submit" value="Cari" style="height: 41px;">
                                <a href="{{ route('perhitungan.index') }}" class="btn btn-info pull-right"
                                    style="height: 41px; padding-top:9px;">
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Dropdown filter -->
                <div class="row mt-3 mb-3">
                    <div class="col">
                        <label for="alamatFilter" class="form-label"><b>Filter Alamat:</b></label>
                        <select class="form-select" id="alamatFilter" onchange="filterTable()">
                            <option value="">Semua</option>
                            <option value="Juwuklegi">Juwuklegi</option>
                            <option value="Batunya">Batunya</option>
                            <option value="Banjar Abing">Banjar Abing</option>
                            <option value="Taman Tanda">Taman Tanda</option>
                        </select>
                    </div>
                </div>

                <!-- Date range filter -->
                <div class="row mt-3 mb-3">
                    <b>
                        <p style="font-size: 10pt">Filter Rentang Tanggal:</p>
                    </b>
                    <div class="col">
                        <label for="fromDate">Dari Tanggal:</label>
                        <input type="date" class="form-control" id="fromDate" onchange="filterTable()">
                    </div>
                    <div class="col">
                        <label for="toDate">Hingga Tanggal:</label>
                        <input type="date" class="form-control" id="toDate" onchange="filterTable()">
                    </div>
                </div>

                <div class="row mt-3 mb-3">
                    <div class="row">
                        <div class="col-4">
                            <b>
                                <p style="font-size: 10pt">Print PDF: Bulan</p>
                            </b>
                        </div>
                        <div class="col-4">
                            <b>
                                <p style="font-size: 10pt">Print PDF: Tahun</p>
                            </b>
                        </div>
                    </div>
                
                    <div class="row">
                        <div class="col-4">
                            <form action="{{ route('printByMonth') }}" method="post" style="display: flex; align-items: center; ">
                                @csrf
                                <input type="month" name="month" class="form-control" style="margin-right: 10px;">
                                <button type="submit" class="btn btn-primary" style="display: flex; align-items: left;"><i class="material-icons">picture_as_pdf</i>Cetak</button> 
                            </form>
                        </div>
                        <div class="col-4">
                            <form action="{{ route('printByYear') }}" method="post" style="display: flex; align-items: center; ">
                                @csrf
                                <input type="text" name="year" class="form-control" style="margin-right: 10px;" placeholder="2024">
                                <button type="submit" class="btn btn-primary" style="display: flex; align-items: left;"><i class="material-icons">picture_as_pdf</i>Cetak</button> 
                            </form>
                        </div>
                    </div>
                </div>
                

                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="mt-1">Disetujui</h5>
                                    </div>

                                </div>
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered" id="riwayatTable">
                                    <thead class="text-center">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col" style="width: 400px;">Nama Nasabah</th>
                                            <th scope="col" style="width: 400px;">Alamat</th>
                                            <th scope="col" style="width: 500px;">Deskripsi</th>
                                            <th scope="col" style="width: 500px;">Maksimal Jaminan</th>
                                            <th scope="col" style="width: 500px;">Jenis Jaminan</th>
                                            <th scope="col" style="width: 500px;">Tanggal</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myUL">
                                        @php
                                            $counter = 1; // Initialize counter variable
                                        @endphp
                                        @foreach ($penilaians as $key => $penilaian)
                                            @if ($status[$key] == 1)
                                                <tr class="text-center">
                                                    <th scope="row">{{ $counter }}</th>
                                                    <td class="text-start">{{ $penilaian->nama_alternatif }}</td>
                                                    <td class="text-start">{{ $penilaian->alamat }}</td>
                                                    <td class="text-start">Memenuhi Kriteria</td>
                                                    <td class="text-start">Rp.
                                                        {{ number_format(($penilaian->jaminan * 60) / 100, 0, ',', '.') }}
                                                    </td>
                                                    <td class="text-start">{{ $penilaian->nama_variabel }}</td>
                                                    <td class="text-start">{{ $penilaian->created_at }}</td>
                                                    <td>
                                                        <b style="color: green">Disetujui</b>
                                                    </td>
                                                </tr>
                                                @php
                                                    $counter++; // Increment counter after each row
                                                @endphp
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .headline-md,
        h2,
        form {
            display: inline-block;
        }

        .headline-md {
            width: 200px;
            height: 36px;
            margin-right: 15px;
        }

        .headline-md2,
        h2,
        form {
            display: inline-block;
        }

        .headline-md2 {
            margin-right: 3px;
        }
    </style>
@endpush

@push('script')
    <script>
        function filterTable() {
            var selectedAlamat = document.getElementById('alamatFilter').value;
            var tableRows = document.querySelectorAll('#riwayatTable tbody tr');

            var counter = 1; // Initialize counter variable

            tableRows.forEach(function(row) {
                var alamatColumn = row.cells[2].innerText.trim(); // Assuming the "alamat" column is at index 2
                if (selectedAlamat === '' || alamatColumn === selectedAlamat) {
                    row.style.display = '';
                    row.cells[0].innerText = counter++; // Update and increment the counter for visible rows
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>

    <script>
        function filterTable() {
            var selectedAlamat = document.getElementById('alamatFilter').value;
            var fromDate = document.getElementById('fromDate').value;
            var toDate = document.getElementById('toDate').value;

            var tableRows = document.querySelectorAll('#riwayatTable tbody tr');
            var counter = 1;

            tableRows.forEach(function(row) {
                var alamatColumn = row.cells[2].innerText.trim();
                var tanggalColumn = row.cells[6].innerText.trim(); // Assuming the "tanggal" column is at index 6

                var isAlamatMatch = selectedAlamat === '' || alamatColumn === selectedAlamat;

                // Parse the date string to a Date object
                var rowDate = new Date(tanggalColumn);

                // Format the fromDate and toDate values to match the format 'YYYY-MM-DD'
                var formattedFromDate = fromDate.split('-').map(s => s.padStart(2, '0')).join('-');
                var formattedToDate = toDate.split('-').map(s => s.padStart(2, '0')).join('-');

                // Compare dates after formatting
                var isDateInRange = (fromDate === '' || rowDate >= new Date(formattedFromDate)) &&
                    (toDate === '' || rowDate <= new Date(formattedToDate));

                if (isAlamatMatch && isDateInRange) {
                    row.style.display = '';
                    row.cells[0].innerText = counter++;
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
@endpush
