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
                            <h1>Data Perhitungan</h1>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="mt-1">Tabel Matriks Keputusan</h5>
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
                                            <th scope="col" style="width: 400px;">Nama Alternatif</th>
                                            <th scope="col">Riwayat Keterlambatan</th>
                                            <th scope="col">Penghasilan</th>
                                            <th scope="col">Tanggungan</th>
                                            <th scope="col">Jaminan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myUL">
                                        @foreach ($penilaians as $key => $penilaian)
                                            <tr class="text-center">
                                                <th scope="row">{{ $key + 1 }}</th>
                                                <td class="text-start">{{ $penilaian->nama_alternatif }}</td>
                                                <td>{{ $penilaian->rk }}</td>
                                                <td>{{ $penilaian->penghasilan }}</td>
                                                <td>{{ $penilaian->tanggungan }}</td>
                                                <td>{{ $penilaian->jaminan }}</td>

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
                                        <h5 class="mt-1">Derajat Keanggotaan Variabel Riwayat Keterlambatan</h5>
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
                                            <th scope="col" rowspan="2" style="vertical-align : middle;">No</th>
                                            <th scope="col" rowspan="2" style="vertical-align : middle;width: 300px;">
                                                Nama Alternatif</th>
                                            <th scope="col" rowspan="2" style="vertical-align : middle;width: 300px;">
                                                Riwayat Keterlambatan</th>
                                            <th scope="col" colspan="3">Derajat Keanggotaan</th>
                                        </tr>
                                        <tr>
                                            <th scope="col" style="width: 150px;">Tidak Pernah</th>
                                            <th scope="col" style="width: 150px;">Jarang</th>
                                            <th scope="col" style="width: 150px;">Sering</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myUL">
                                        @foreach ($rkResults as $key => $result)
                                            <tr class="text-center">
                                                <th scope="row">{{ $key + 1 }}</th>
                                                <td class="text-start">{{ $result['nama'] }}</td>
                                                <td class="text-start">{{ $result['rk'] }}</td>
                                                <!-- Adjust the column names based on your actual data structure -->
                                                <td>{{ $result['rk_tidak'] }}</td>
                                                <td>{{ $result['rk_jarang'] }}</td>
                                                <td>{{ $result['rk_sering'] }}</td>
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
                                        <h5 class="mt-1">Derajat Keanggotaan Variabel Penghasilan</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead class="text-center">
                                        <tr>
                                            <th scope="col" rowspan="2" style="vertical-align : middle;">No</th>
                                            <th scope="col" rowspan="2" style="vertical-align : middle;width: 300px;">
                                                Nama Alternatif</th>
                                            <th scope="col" rowspan="2" style="vertical-align : middle;width: 300px;">
                                                Penghasilan</th>
                                            <th scope="col" colspan="3">Derajat Keanggotaan</th>
                                        </tr>
                                        <tr>
                                            <th scope="col" style="width: 150px;">Kurang</th>
                                            <th scope="col" style="width: 150px;">Cukup</th>
                                            <th scope="col" style="width: 150px;">Banyak</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myUL">
                                        @foreach ($penghasilanResults as $key => $result)
                                            <tr class="text-center">
                                                <th scope="row">{{ $key + 1 }}</th>
                                                <td class="text-start">{{ $result['nama'] }}</td>
                                                <td class="text-start">{{ $result['penghasilan'] }}</td>
                                                <!-- Adjust the column names based on your actual data structure -->
                                                <td>{{ $result['penghasilan_tidak'] }}</td>
                                                <td>{{ $result['penghasilan_jarang'] }}</td>
                                                <td>{{ $result['penghasilan_sering'] }}</td>
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
                                        <h5 class="mt-1">Derajat Keanggotaan Variabel Tanggungan</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead class="text-center">
                                        <tr>
                                            <th scope="col" rowspan="2" style="vertical-align : middle;">No</th>
                                            <th scope="col" rowspan="2" style="vertical-align : middle;width: 300px;">
                                                Nama Alternatif</th>
                                            <th scope="col" rowspan="2" style="vertical-align : middle;width: 300px;">
                                                Tanggungan</th>
                                            <th scope="col" colspan="3">Derajat Keanggotaan</th>
                                        </tr>
                                        <tr>
                                            <th scope="col" style="width: 150px;">Sedikit</th>
                                            <th scope="col" style="width: 150px;">Cukup</th>
                                            <th scope="col" style="width: 150px;">Banyak</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myUL">
                                        @foreach ($tanggunganResults as $key => $result)
                                            <tr class="text-center">
                                                <th scope="row">{{ $key + 1 }}</th>
                                                <td class="text-start">{{ $result['nama'] }}</td>
                                                <td class="text-start">{{ $result['tanggungan'] }}</td>
                                                <!-- Adjust the column names based on your actual data structure -->
                                                <td>{{ $result['tanggungan_tidak'] }}</td>
                                                <td>{{ $result['tanggungan_jarang'] }}</td>
                                                <td>{{ $result['tanggungan_sering'] }}</td>
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
                                        <h5 class="mt-1">Derajat Keanggotaan Variabel Jaminan</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead class="text-center">
                                        <tr>
                                            <th scope="col" rowspan="2" style="vertical-align : middle;">No</th>
                                            <th scope="col" rowspan="2" style="vertical-align : middle;width: 300px;">
                                                Nama Alternatif</th>
                                            <th scope="col" rowspan="2" style="vertical-align : middle;width: 300px;">
                                                Jaminan</th>
                                            <th scope="col" colspan="3">Derajat Keanggotaan</th>
                                        </tr>
                                        <tr>
                                            <th scope="col" style="width: 150px;">Kurang</th>
                                            <th scope="col" style="width: 150px;">Cukup</th>
                                            <th scope="col" style="width: 150px;">Baik</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myUL">
                                        @foreach ($jaminanResults as $key => $result)
                                            <tr class="text-center">
                                                <th scope="row">{{ $key + 1 }}</th>
                                                <td class="text-start">{{ $result['nama'] }}</td>
                                                <td class="text-start">{{ $result['jaminan'] }}</td>
                                                <!-- Adjust the column names based on your actual data structure -->
                                                <td>{{ $result['jaminan_tidak'] }}</td>
                                                <td>{{ $result['jaminan_jarang'] }}</td>
                                                <td>{{ $result['jaminan_sering'] }}</td>
                                            </tr>
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
    <script></script>
@endpush
