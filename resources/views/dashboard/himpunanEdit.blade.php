@extends('layouts/main')
@section('title', 'Himpunan Fuzzy')

@section('content')
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description">
                            <h1>Edit Data Himpunan {{ $himpunan->nama_variabel }}</h1>
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
                                <form action="{{ route('himpunan.update', $himpunan->id) }}" method="post"
                                    class="py-2 needs-validation" enctype="multipart/form-data" novalidate>
                                    @method('put')
                                    @csrf
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama Himpunan Fuzzy</label>
                                        <input type="text" class="form-control" id="nama" aria-describedby="nama"
                                            name="nama" value="{{ $himpunan->nama }}" required>
                                        <div class="invalid-feedback">
                                            Nama tidak boleh kosong
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="kurva" class="form-label">Kurva</label>
                                        <select class="form-select" id="kurva" name="kurva">
                                            <option value="1" {{ $himpunan->id_kurva == 1 ? 'selected' : '' }}>Liniar
                                                Naik</option>
                                            <option value="2" {{ $himpunan->id_kurva == 2 ? 'selected' : '' }}>Liniar
                                                Turun</option>
                                            <option value="3" {{ $himpunan->id_kurva == 3 ? 'selected' : '' }}>Segitiga
                                            </option>
                                            <option value="4" {{ $himpunan->id_kurva == 4 ? 'selected' : '' }}>
                                                Trapesium</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="a" class="form-label" id="label_a">Domain (a)</label>
                                        <input type="number" class="form-control" id="a" aria-describedby="a"
                                            name="a" value="{{ $himpunan->a }}" required>
                                        <div class="invalid-feedback">
                                            Tidak boleh kosong
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="b" class="form-label" id="label_b">Domain (b)</label>
                                        <input type="number" class="form-control" id="b" aria-describedby="b"
                                            name="b" value="{{ $himpunan->b }}" required>
                                        <div class="invalid-feedback">
                                            Tidak boleh kosong
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="c" class="form-label" id="label_c">Domain (c)</label>
                                        <input type="number" class="form-control" id="c" aria-describedby="c"
                                            name="c" value="{{ $himpunan->c }}" required>
                                        <div class="invalid-feedback">
                                            Tidak boleh kosong
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="d" class="form-label" id="label_d">Domain (d)</label>
                                        <input type="number" class="form-control" id="d" aria-describedby="d"
                                            name="d" value="{{ $himpunan->d }}" required>
                                        <div class="invalid-feedback">
                                            Tidak boleh kosong
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>

                            </div>
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
    <!-- Add this script tag to include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initial setup based on the current value of 'kurva'
            toggleFields($("#kurva").val());

            // Add an event listener to the 'kurva' dropdown
            $("#kurva").change(function() {
                // Get the selected value of 'kurva'
                var selectedKurva = $(this).val();

                // Toggle visibility of fields based on the selected value
                toggleFields(selectedKurva);
            });

            function toggleFields(selectedKurva) {
                // Hide all domain fields
                $("#a, #b, #c, #d").closest(".mb-3").hide();

                // Show relevant domain fields based on the selected 'kurva'
                if (selectedKurva == 1 || selectedKurva == 2) {
                    $("#a, #b").closest(".mb-3").show();
                    // Set values for domain c and d
                    $("#c").val(0);
                    $("#d").val(0);
                } else if (selectedKurva == 3) {
                    $("#a, #b, #c").closest(".mb-3").show();
                    // Set values for domain d
                    $("#d").val(0);
                } else if (selectedKurva == 4) {
                    $("#a, #b, #c, #d").closest(".mb-3").show();
                }
            }
        });
    </script>
    
@endpush
