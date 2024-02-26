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

                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="mt-1">Perhitungan</h5>
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
                                            <th scope="col" style="width: 800px;">Nama Nasabah</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myUL">
                                        @foreach ($penilaians as $key => $penilaian)
                                            <tr class="text-center">    
                                                <th scope="row">{{ $penilaians->firstItem() + $loop->index }}</th>
                                                <td class="text-start">{{ $penilaian->nama_alternatif }}</td>
                                                <td>
                                                    <a href="{{ route('perhitungan.show', $penilaian->id) }}"
                                                        class="btn btn-primary pull-right">
                                                        <i class="material-icons">info</i> Detail
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{$penilaians->links()}}
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
