@extends('layouts/main')
@section('title', 'Data Aturan')

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
                            <h1>Data Aturan Fuzzy</h1>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="mt-1">Data Aturan Fuzzy</h5>
                                    </div>
                                    <div class="col">
                                        <div class="float-end">
                                            <a href="{{ route('aturan.create') }}" class="btn btn-primary pull-right">
                                                <i class="material-icons">add</i> Tambah
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col" style="width: 900px;">Aturan</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myUL">
                                        @foreach ($aturans as $key => $aturan)
                                            <tr>
                                                <th scope="row">{{ $key + 1 }}</th>
                                                <td>
                                                    <b>IF</b> Riwayat Keterlambatan {{ $aturan->rk_nama }} <b>AND</b> Penghasilan
                                                    {{ $aturan->penghasilan_nama }} <b>AND</b> Tanggungan
                                                    {{ $aturan->tanggungan_nama }} <b>AND</b> Jaminan
                                                    {{ $aturan->jaminan_nama }} <b>THEN</b> {{ $aturan->hasil }}
                                                </td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col">
                                                            <a href="aturan/{{ $aturan->id }}/edit" type="button"
                                                                class="btn btn-warning headlin2 headline-md2">
                                                                <i class="material-icons">edit</i>
                                                                Edit
                                                            </a>

                                                            <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                                                action="{{ route('aturan.destroy', $aturan->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="subnmit" class="btn btn-danger"><i
                                                                        class="material-icons">delete</i>Hapus</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{$aturans->links()}}
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
