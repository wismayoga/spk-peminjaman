@extends('layouts/main')
@section('title', 'Data Alternatif')

@section('content')
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description">
                            <h1>Tambah Data Nasabah</h1>
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
                                <form class="py-2 needs-validation" action="{{ route('alternatif.store') }}" method="post"
                                    enctype="multipart/form-data" novalidate>
                                    @csrf
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" placeholder="Masukan nama lengkap..." class="form-control"
                                        id="nama" aria-describedby="nama" name="nama" required>
                                    <div class="invalid-feedback">
                                        Tidak boleh kosong
                                    </div>

                                    <label for="nik" class="form-label mt-3">Nomor Induk Kependudukan (NIK)</label>
                                    <input type="number" placeholder="Masukan NIK..." class="form-control" id="nik"
                                        aria-describedby="nik" name="nik" required>
                                    <div class="invalid-feedback">
                                        Tidak boleh kosong
                                    </div>

                                    <label for="inputMask1" class="form-label mt-3">Tanggal Lahir</label>
                                    <input type="text" class="form-control" placeholder="dd/mm/yyyy" aria-label="Date" id="inputMask1"
                                        name="tanggal_lahir" data-inputmask-inputformat="dd/mm/yyyy"
                                        data-inputmask-alias="datetime" required>
                                    <div class="invalid-feedback">
                                        Tidak boleh kosong
                                    </div>

                                    <label for="tempatlahir" class="form-label mt-3">Tempat Lahir</label>
                                    <input type="text" placeholder="Masukan tempat lahir..." class="form-control"
                                    id="tempatlahir" aria-describedby="tempatlahir" name="tempatlahir" required>
                                <div class="invalid-feedback">
                                    Tidak boleh kosong
                                </div>

                                    <label for="jenis_kelamin" class="form-label mt-3">Jenis Kelamin</label>
                                    <select class="form-select" aria-label="Default select example" id="jenis_kelamin" name="jenis_kelamin" required>
                                        <option selected value="{{null}}">--Jenis Kelamin--</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>

                                    {{-- <label for="pekerjaan" class="form-label mt-3">Pekerjaan</label>
                                    <input type="text" placeholder="Masukan pekerjaan..." class="form-control"
                                        id="pekerjaan" aria-describedby="pekerjaan" name="pekerjaan" required>
                                    <div class="invalid-feedback">
                                        Tidak boleh kosong
                                    </div> --}}

                                    <label for="alamat" class="form-label mt-3">Alamat</label>
                                    <select class="form-select" aria-label="Default select example" id="alamat" name="alamat" required>
                                        <option selected value="{{null}}">--Pilih Alamat--</option>
                                        <option value="Batunya">Batunya</option>
                                        <option value="Banjar Abing">Banjar Abing</option>
                                        <option value="Taman Tanda">Taman Tanda</option>
                                        <option value="Juwuklegi">Juwuklegi</option>
                                    </select>

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
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Inputmask library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>

    <script>
        $("#inputMask1").inputmask();
    </script>
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
