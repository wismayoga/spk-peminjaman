@extends('layouts/main')
@section('title', 'Data Variabel')

@section('content')
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description">
                            <h1>Tambah Data Jenis Variabel</h1>
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
                                <form class="py-2 needs-validation" action="{{ route('jenisVariabel.store') }}" method="post"
                                    enctype="multipart/form-data" novalidate>
                                    @csrf
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama Jenis Variabel</label>
                                        <input type="text" placeholder="Masukan nama variabel..." class="form-control"
                                            id="nama" aria-describedby="nama" name="nama" required>
                                        <div class="invalid-feedback">
                                            Masukan nama terlebih dahulu
                                        </div>
                                    </div>

                                    <div>
                                        <label for="variabel" class="form-label">Variabel</label>
                                            <select class="form-select" id="variabel" name="variabel" required>
                                                <option value="{{null}}" selected>--Pilih Variabel--</option>
                                                @foreach($variabels as $variabel)
                                                <option value="{{$variabel->id}}">{{$variabel->nama}}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Tidak boleh kosong
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
