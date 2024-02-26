@extends('layouts/main')
@section('title', 'Data Variabel')

@section('content')
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description">
                            <h1>Tambah Data Variabel</h1>
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
                                <form class="py-2 needs-validation" action="{{ route('variabel.store') }}" method="post"
                                    enctype="multipart/form-data" novalidate>
                                    @csrf
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama Variabel</label>
                                        <input type="text" placeholder="Masukan nama variabel..." class="form-control"
                                            id="nama" aria-describedby="nama" name="nama" required>
                                        <div class="invalid-feedback">
                                            Masukan nama terlebih dahulu
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="semesta" class="form-label">Rentang Nilai Semesta</label>
                                        <div class="row">
                                            <div class="col-3">
                                                <input type="text" placeholder="Nilai minimal..." class="form-control"
                                                    id="min" aria-describedby="min" name="min" required>
                                                <div class="invalid-feedback">
                                                    Masukan nilai terlebih dahulu
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <input type="text" placeholder="Nilai maksimal..." class="form-control"
                                                    id="max" aria-describedby="max" name="max" required>
                                                <div class="invalid-feedback">
                                                    Masukan nilai terlebih dahulu
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="keterangan" class="form-label">Tipe Nilai Semesta</label>
                                        <input type="text" placeholder="Masukan keterangan..." class="form-control"
                                            id="keterangan" aria-describedby="keterangan" name="keterangan" required>
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
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation');

            // Loop over them and prevent submission
            Array.from(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }

                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
@endpush
