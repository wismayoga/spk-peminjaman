@extends('layouts/main')
@section('title', 'Data Perhitungan')

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
                            <h1>Detail Perhitungan</h1>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="mt-1">Data Nasabah</h5>
                                    </div>
                                    {{-- <div class="col">
                                        <div class="float-end">
                                            <a href="{{ route('variabel.create') }}" class="btn btn-primary pull-right">
                                                <i class="material-icons">add</i> Tambah
                                            </a>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>

                            <div class="card-body">
                                <table class="table">
                                    <thead class="text-center">
                                        <tr>
                                            {{-- <th scope="col">No</th>
                                            <th scope="col" style="width: 800px;">Nama Nasabah</th>
                                            <th scope="col">Aksi</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody id="myUL">
                                        <tr>
                                            <th scope="col" style="width: 210px;">Nama Nasabah</th>
                                            <th class="text-start" scope="col" style="width: 15px;">:</th>
                                            <td class="text-start">{{ $penilaian->nama_alternatif }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="col" style="width: 210px;">Riwayat Keterlambatan</th>
                                            <th class="text-start" scope="col" style="width: 15px;">:</th>
                                            <td class="text-start">{{ $penilaian->rk }} kali</td>
                                        </tr>
                                        <tr>
                                            <th scope="col" style="width: 210px;">Penghasilan</th>
                                            <th class="text-start" scope="col" style="width: 15px;">:</th>
                                            <td class="text-start">Rp
                                                {{ number_format($penilaian->penghasilan, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="col" style="width: 210px;">Tanggungan</th>
                                            <th class="text-start" scope="col" style="width: 15px;">:</th>
                                            <td class="text-start">{{ $penilaian->tanggungan }} orang</td>
                                        </tr>
                                        <tr>
                                            <th scope="col" style="width: 210px;">Jaminan</th>
                                            <th class="text-start" scope="col" style="width: 15px;">:</th>
                                            <td class="text-start"><b>{{ $penilaian->nama_jenisVariabel }}</b> dengan nilai
                                                Rp
                                                {{ number_format($penilaian->jaminan, 0, ',', '.') }}</td>
                                        </tr>
                                        {{-- <tr>
                                            <th scope="col" style="width: 210px;">Status Pinjaman</th>
                                            <th class="text-start" scope="col" style="width: 15px;">:</th>
                                            <td class="text-start">
                                                @if ($finalResult == 1)
                                                    <p>
                                                        <b>Disetujui, Dengan total Rp
                                                            {{ number_format(($penilaian->jaminan * 60) / 100, 0, ',', '.') }}</b>
                                                    </p>
                                                @else
                                                    <p>
                                                        <b>Ditolak</b>
                                                    </p>
                                                @endif

                                            </td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="mt-1">Hasil Fuzzifikasi</h5>
                                    </div>
                                    <div class="col">
                                        <div class="float-end">
                                            {{-- <a href="{{ route('variabel.create') }}" class="btn btn-primary pull-right">
                                                <i class="material-icons">add</i> Tambah
                                            </a> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead class="text-center">
                                        <tr>
                                            <th scope="col" class="col-md-1"><b>Keterangan</b></th>
                                            <th scope="col" class="col-md-2"><b>Riwayat Keterlambatan</b></th>
                                            <th scope="col" class="col-md-2"><b>Penghasilan</b></th>
                                            <th scope="col" class="col-md-2"><b>Tanggungan</b></th>
                                            <th scope="col" class="col-md-2"><b>Jaminan</b></th>
                                        </tr>
                                    </thead>
                                    <tbody id="myUL">
                                        <tr class="text-center">
                                            <td><b>Nilai Linguistik</b></td>
                                            <td>{{ $linguistik_rk }}</td>
                                            <td>{{ $linguistik_penghasilan }}</td>
                                            <td>{{ $linguistik_tanggungan }}</td>
                                            <td>{{ $linguistik_jaminan }}</td>
                                        </tr>
                                        <tr class="text-center">
                                            <td><b>Nilai Fuzzifikasi</b></td>
                                            <td>{{ $selectedRule['rk_nama'] }}</td>
                                            <td>{{ $selectedRule['penghasilan_nama'] }}</td>
                                            <td>{{ $selectedRule['tanggungan_nama'] }}</td>
                                            <td>{{ $selectedRule['jaminan_nama'] }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> 

                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="mt-1">Hasil Inverensi</h5>
                                    </div>
                                    {{-- <div class="col">
                                        <div class="float-end">
                                            <a href="{{ route('variabel.create') }}" class="btn btn-primary pull-right">
                                                <i class="material-icons">add</i> Tambah
                                            </a>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead class="text-center">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Riwayat Keterlambatan</th>
                                            <th scope="col">Penghasilan</th>
                                            <th scope="col">Tanggungan</th>
                                            <th scope="col">Jaminan</th>
                                            <th scope="col">Keputusan</th>
                                            <th scope="col">Hasil Inverensi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myUL">
                                        @foreach ($inferensi as $key => $result)
                                            <tr class="text-center">
                                                <th scope="row">{{ $key + 1 }}</th>
                                                <td>{{ $result['rk_nama'] }}</td>
                                                <td>{{ $result['penghasilan_nama'] }}</td>
                                                <td>{{ $result['tanggungan_nama'] }}</td>
                                                <td>{{ $result['jaminan_nama'] }}</td>
                                                <td>{{ $result['hasil'] }}</td>
                                                <td>{{ $result['hasil_persamaan'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="mt-1">Penegasan (Defuzzifikasi)</h5>
                                    </div>
                                    {{-- <div class="col">
                                        <div class="float-end">
                                            <a href="{{ route('variabel.create') }}" class="btn btn-primary pull-right">
                                                <i class="material-icons">add</i> Tambah
                                            </a>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead class="text-center">
                                        <tr>
                                            <th scope="col" class="col-md-9">Perhitungan Defuzzifikasi</th>
                                            <th scope="col" class="col-md-3">Weight Average</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myUL">
                                        <tr class="text-center">
                                            <td>
                                                <table class="table">
                                                    <tr style="border-bottom: 1px solid #000;">
                                                        <td>
                                                            @foreach ($inferensi as $key => $result)
                                                                ({{ $result['hasil'] }}*{{ $result['hasil_persamaan'] }})
                                                                @if (!$loop->last)
                                                                    +
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            @foreach ($inferensi as $key => $result)
                                                                {{ $result['hasil_persamaan'] }}
                                                                @if (!$loop->last)
                                                                    +
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>

                                            <td style="text-align: center; vertical-align: middle;">
                                                {{ $finalResult }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="mt-1">Hasil Keputusan</h5>
                                    </div>
                                    <div class="col">
                                        {{-- <div class="float-end">
                                            <a href="{{ route('variabel.create') }}" class="btn btn-primary pull-right">
                                                <i class="material-icons">add</i> Tambah
                                            </a>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead class="text-center">
                                        <tr>
                                            <th scope="col" class="col-md-3">Status</th>
                                            <th scope="col" class="col-md-3">Jumlah Maksimal Pinjaman</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myUL">
                                        <tr class="text-center">
                                            @if ($finalResult == 1)
                                                <td class="text-center">
                                                    <b>DISETUJUI</b>
                                                </td>
                                                <td>{{ number_format(($penilaian->jaminan * 60) / 100, 0, ',', '.') }}</b>
                                                </td>
                                            @else
                                                <td class="text-center">
                                                    <b>DITOLAK</b>
                                                </td>
                                                <td>Rp {{ number_format((0 * 60) / 100, 0, ',', '.') }},-</b></td>
                                            @endif
                                        </tr>
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
    <script></script>
@endpush
