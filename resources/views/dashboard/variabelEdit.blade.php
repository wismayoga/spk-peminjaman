@extends('layouts/main')
@section('title', 'Data Variabel')

@section('content')
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description">
                            <h1>Edit Data Variabel</h1>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3 float-end">
                        <div class="float-end">
                            <a href="{{ url()->previous() }}" class="btn btn-light pull-right">
                                <i class="material-icons">arrow_back_ios_new</i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('variabel.update', $variabel->id) }}" method="post"
                                    class="py-2 needs-validation" enctype="multipart/form-data" novalidate>
                                    @method('put')
                                    @csrf
                                    <label for="nama" class="form-label">Nama Variabel</label>
                                    <input type="text" class="form-control" id="nama" aria-describedby="nama"
                                        name="nama" value="{{ old('variabel', $variabel->nama) }}" required>
                                    <div id="nama" class="form-text">masukan nama variabel baru</div>

                                    <div class="mb-3">
                                        <label for="semesta" class="form-label">Rentang Nilai Semesta</label>
                                        <div class="row">
                                            <div class="col-3">
                                                <input type="text" placeholder="Nilai minimal..." class="form-control"
                                                    id="min" aria-describedby="min" name="min" value="{{ old('variabel', $variabel->min) }}" required>
                                                <div class="invalid-feedback">
                                                    Masukan nilai terlebih dahulu
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <input type="text" placeholder="Nilai maksimal..." class="form-control"
                                                    id="max" aria-describedby="max" name="max" value="{{ old('variabel', $variabel->max) }}" required>
                                                <div class="invalid-feedback">
                                                    Masukan nilai terlebih dahulu
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="keterangan" class="form-label">Tipe Nilai Semesta</label>
                                        <input type="text" placeholder="Masukan keterangan..." class="form-control"
                                            id="keterangan" aria-describedby="keterangan" value="{{ old('variabel', $variabel->keterangan) }}" name="keterangan" required>
                                        <div class="invalid-feedback">
                                            Masukan keterangan terlebih dahulu
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary px-5 mt-3 float-end">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
@endpush

@push('script')
@endpush
