@extends('layouts/main')
@section('title', 'Data Aturan')

@section('content')
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description">
                            <h1>Tambah Data Aturan</h1>
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
                                <form class="py-2 needs-validation" action="{{ route('aturan.store') }}" method="post"
                                    enctype="multipart/form-data" novalidate>
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-2 col-12">
                                            <label for="rk" class="form-label">Riwayat Keterlambatan</label>
                                            <select class="form-select" id="rk" name="rk" required>
                                                <option selected>--Pilih Riwayat--</option>
                                                @foreach($rk as $rk)
                                                <option value="{{$rk->id}}">{{$rk->nama}}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Tidak boleh kosong
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <label for="penghasilan" class="form-label">Penghasilan</label>
                                            <select class="form-select" id="penghasilan" name="penghasilan" required>
                                                <option selected>--Pilih Penghasilan--</option>
                                                @foreach($penghasilan as $penghasilan)
                                                <option value="{{$penghasilan->id}}">{{$penghasilan->nama}}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Tidak boleh kosong
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <label for="penghasilan" class="form-label">Tanggungan</label>
                                            <select class="form-select" id="tanggungan" name="tanggungan" required>
                                                <option selected>--Pilih Tanggungan--</option>
                                                @foreach($tanggungan as $tanggungan)
                                                <option value="{{$tanggungan->id}}">{{$tanggungan->nama}}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Tidak boleh kosong
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <label for="jaminan" class="form-label">Jaminan</label>
                                            <select class="form-select" id="jaminan" name="jaminan" required>
                                                <option selected>--Pilih Jaminan--</option>
                                                @foreach($jaminan as $jaminan)
                                                <option value="{{$jaminan->id}}">{{$jaminan->nama}}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Tidak boleh kosong
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <label for="hasil" class="form-label">THEN</label>
                                            <input type="number" placeholder="Masukan Keputusan..."
                                                class="form-control" id="hasil" aria-describedby="hasil" name="hasil"
                                                required>
                                            <div class="invalid-feedback">
                                                Masukan Nilai Keputusan
                                            </div>
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
                    var isValid = true;

                    // Validate dropdowns
                    var dropdowns = form.querySelectorAll('.form-select');
                    dropdowns.forEach(function(dropdown) {
                        if (dropdown.value === "--Pilih Riwayat--" || dropdown.value === "--Pilih Penghasilan--" || dropdown.value === "--Pilih Tanggungan--" || dropdown.value === "--Pilih Jaminan--") {
                            isValid = false;
                            dropdown.setCustomValidity('Pilih opsi yang valid');
                        } else {
                            dropdown.setCustomValidity('');
                        }
                    });

                    // Validate the "THEN" input
                    var thenInput = form.querySelector('#hasil');
                    if (!/^[01]$/.test(thenInput.value)) {
                        // isValid = true;
                        // thenInput.setCustomValidity('Masukan Nilai Keputusan');
                    } else {
                        thenInput.setCustomValidity('');
                    }

                    if (!form.checkValidity() || !isValid) {
                        event.preventDefault();
                        event.stopPropagation();
                    }

                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
@endpush

