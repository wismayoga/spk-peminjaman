@extends('layouts/main')
@section('title', 'Data Alternatif')

@section('content')
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description">
                            <h1>Edit Data Nasabah</h1>
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
                                <form class="py-2 needs-validation"
                                    action="{{ route('alternatif.update', $alternatif->id) }}" method="post"
                                    enctype="multipart/form-data" novalidate>
                                    @method('put')
                                    @csrf
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" placeholder="Masukan nama lengkap..." class="form-control"
                                        id="nama" aria-describedby="nama" name="nama"
                                        value="{{ $alternatif->nama }}" required>
                                    <div class="invalid-feedback">
                                        Tidak boleh kosong
                                    </div>

                                    <label for="nik" class="form-label mt-3">Nomor Induk Keluarga (NIK)</label>
                                    <input type="number" placeholder="Masukan nomor NIK..." class="form-control"
                                        id="nik" aria-describedby="nik" name="nik" value="{{ $alternatif->nik }}"
                                        required>
                                    <div class="invalid-feedback">
                                        Tidak boleh kosong
                                    </div>

                                    <label for="inputMask1" class="form-label mt-3">Tanggal Lahir</label>
                                    <input type="text" class="form-control" placeholder="dd/mm/yyyy" aria-label="Date"
                                        id="inputMask1" name="tanggal_lahir" data-inputmask-inputformat="dd/mm/yyyy"
                                        data-inputmask-alias="datetime"
                                        value="{{ \DateTime::createFromFormat('Y-m-d', $alternatif->tanggal_lahir)->format('d/m/Y') }}"
                                        required>
                                    <div class="invalid-feedback">
                                        Tidak boleh kosong
                                    </div>

                                    <label for="jenis_kelamin" class="form-label mt-3">Jenis Kelamin</label>
                                    <select class="form-select" aria-label="Default select example" id="jenis_kelamin"
                                        name="jenis_kelamin" required>
                                        <option value="{{ null }}">--Jenis Kelamin--</option>
                                        <option value="Laki-laki" <?php echo $alternatif->jenis_kelamin == 'Laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                                        <option value="Perempuan" <?php echo $alternatif->jenis_kelamin == 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                                    </select>


                                    {{-- <label for="pekerjaan" class="form-label mt-3">Pekerjaan</label>
                                    <input type="text" placeholder="Masukan pekerjaan..." class="form-control"
                                        id="pekerjaan" aria-describedby="pekerjaan" name="pekerjaan" value="{{ $alternatif->pekerjaan }}" required>
                                    <div class="invalid-feedback">
                                        Tidak boleh kosong
                                    </div> --}}

                                    <label for="alamat" class="form-label mt-3">Alamat</label>
                                    <select class="form-select" aria-label="Default select example" id="alamat"
                                        name="alamat" required>
                                        <option value="{{ null }}"
                                            {{ $alternatif->alamat == null ? 'selected' : '' }}>--Pilih Alamat--</option>
                                        <option value="Batunya" {{ $alternatif->alamat == 'Batunya' ? 'selected' : '' }}>
                                            Batunya</option>
                                        <option value="Banjar Abing"
                                            {{ $alternatif->alamat == 'Banjar Abing' ? 'selected' : '' }}>Banjar Abing
                                        </option>
                                        <option value="Taman Tanda"
                                            {{ $alternatif->alamat == 'Taman Tanda' ? 'selected' : '' }}>Taman Tanda
                                        </option>
                                        <option value="Juwuklegi"
                                            {{ $alternatif->alamat == 'Juwuklegi' ? 'selected' : '' }}>Juwuklegi</option>
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
