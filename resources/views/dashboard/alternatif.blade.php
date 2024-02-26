@extends('layouts/main')
@section('title', 'Data Nasabah')

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
                            <h1>Data Nasabah</h1>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <form class="row" action="{{ route('cariNasabah') }}" method="GET">
                            <div class="col-10 mb-3">
                                <input type="text" class="form-control" name="cari" placeholder="Cari Nasabah .."
                                    value="{{ old('cari') }}">
                            </div>
                            <div class="col-2">
                                <input class="btn btn-info" type="submit" value="Cari" style="height: 41px;">
                                <a href="{{ route('alternatif.index') }}" class="btn btn-info pull-right"
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

                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="mt-1">Jumlah Nasabah: <b>{{ $alternatifsCount }}</b></h5>
                                    </div>
                                    <div class="col">

                                        <div class="float-end">
                                            <a href="{{ route('alternatif.create') }}" class="btn btn-primary pull-right">
                                                <i class="material-icons">add</i> Tambah
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered" id="riwayatTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col" style="">Nama Lengkap</th>
                                            <th scope="col" style="">NIK</th>
                                            <th scope="col" style="">Jenis Kelamin</th>
                                            <th scope="col" style="">Tempat Tanggal Lahir</th>
                                            {{-- <th scope="col" style="">Pekerjaan</th> --}}
                                            <th scope="col" style="">Alamat</th>
                                            <th scope="col" style="">Tanggal Terdaftar</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myUL">
                                        @foreach ($alternatifs as $key => $alternatif)
                                            <tr>
                                                <th scope="row">{{ $alternatifs->firstItem() + $loop->index }}</th>
                                                <td>{{ $alternatif->nama }}</td>
                                                <td>{{ $alternatif->nik }}</td>
                                                <td>{{ $alternatif->jenis_kelamin }}</td>
                                                <td>{{ $alternatif->tempatlahir }}, {{ $alternatif->tanggal_lahir }}</td>
                                                {{-- <td>{{ $alternatif->pekerjaan }}</td> --}}
                                                <td>{{ $alternatif->alamat }}</td>
                                                <td>{{ \Carbon\Carbon::parse($alternatif->created_at)->translatedFormat('l, d-m-Y') }}
                                                </td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col">
                                                            <a href="alternatif/{{ $alternatif->id }}/edit" type="button"
                                                                class="btn btn-warning headlin2 headline-md2">
                                                                <i class="material-icons">edit</i>
                                                                Edit
                                                            </a>

                                                            <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                                                action="{{ route('alternatif.destroy', $alternatif->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger"><i
                                                                        class="material-icons">delete</i>Hapus</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $alternatifs->links() }}
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
            var alamatColumn = row.cells[5].innerText.trim(); // Assuming the "alamat" column is at index 2
            if (selectedAlamat === '' || alamatColumn === selectedAlamat) {
                row.style.display = '';
                row.cells[0].innerText = counter++; // Update and increment the counter for visible rows
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>
@endpush
