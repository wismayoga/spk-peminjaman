@extends('layouts/main')
@section('title', 'Data Penilaian')

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
                            <h1>Data Penilaian</h1>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <form class="row" action="{{ route('cariPenilaian') }}" method="GET">
                            <div class="col-10 mb-3">
                                <input type="text" class="form-control" name="cari" placeholder="Cari Nasabah .."
                                    value="{{ old('cari') }}">
                            </div>
                            <div class="col-2">
                                <input class="btn btn-info" type="submit" value="Cari" style="height: 41px;">
                                <a href="{{ route('penilaian.index') }}" class="btn btn-info pull-right"
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
                                        <h5 class="mt-1">Data Penilaian</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col" style="width: 600px;">Nama Nasabah</th>
                                            <th scope="col">Tanggal Diubah</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myUL">
                                        @foreach ($alternatifs as $key => $alternatif)
                                            <!-- Modal Tambah-->
                                            <div class="modal fade" id="exampleModal-{{ $alternatif->id }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Tambah
                                                                Penilaian ({{ $alternatif->nama }})</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <form class="py-2 needs-validation"
                                                            action="{{ route('penilaian.store') }}" method="post"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <input name="id_alternatif" type="hidden"
                                                                    value="{{ $alternatif->id }}">

                                                                <div class="mb-3">
                                                                    <label for="rk" class="form-label">Riwayat
                                                                        Keterlambatan
                                                                        ({{ $variabels[0]->keterangan }})</label>
                                                                    <input type="number" class="form-control"
                                                                        placeholder="{{ number_format($variabels[0]->min) }} - {{ number_format($variabels[0]->max) }}"
                                                                        id="rk" aria-describedby="rk" name="rk"
                                                                        required>
                                                                    <p style="font-size: 8pt; font-style:italic">*Masukan
                                                                        Jumlah Riwayat Keterlambatan </p>
                                                                </div>
                                                                <div class="invalid-feedback">
                                                                    Tidak boleh kosong
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="penghasilan" class="form-label">Penghasilan
                                                                        ({{ $variabels[1]->keterangan }})</label>
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="{{ number_format($variabels[1]->min) }} - {{ number_format($variabels[1]->max) }}"
                                                                                id="penghasilan"
                                                                                aria-describedby="penghasilan"
                                                                                name="penghasilan"
                                                                                oninput="formatCurrency(this)" required>
                                                                            <p style="font-size: 8pt; font-style:italic">
                                                                                *Masukan
                                                                                Nominal Penghasilan</p>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <input type="file" class="form-control"
                                                                                id="slipgaji" aria-describedby="slipgaji"
                                                                                name="slipgaji">
                                                                            <p style="font-size: 8pt; font-style:italic">*
                                                                                Foto slip gaji</p>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="invalid-feedback">
                                                                    Tidak boleh kosong
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="tanggungan" class="form-label">Tanggungan
                                                                        ({{ $variabels[2]->keterangan }})</label>
                                                                    <input type="number" class="form-control"
                                                                        placeholder="{{ number_format($variabels[2]->min) }} - {{ number_format($variabels[2]->max) }}"
                                                                        id="tanggungan" aria-describedby="tanggungan"
                                                                        name="tanggungan" required>
                                                                    <p style="font-size: 8pt; font-style:italic">*Masukan
                                                                        Jumlah Tanggungan Keluarga</p>
                                                                </div>
                                                                <div class="invalid-feedback">
                                                                    Tidak boleh kosong
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="jenis_jaminan" class="form-label">Jaminan
                                                                        ({{ $variabels[3]->keterangan }})</label>
                                                                    <div class="row">
                                                                        <div class="col-6">

                                                                            <select class="form-select"
                                                                                id="jenis_jaminan-{{ $alternatif->id }}"
                                                                                name="jenis_jaminan" required>
                                                                                <option value="{{ null }}"
                                                                                    selected>--Jenis Jaminan--
                                                                                </option>
                                                                                @foreach ($jenisJaminan as $jenis)
                                                                                    <option value="{{ $jenis->id }}">
                                                                                        {{ $jenis->nama }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            <p style="font-size: 8pt; font-style:italic">
                                                                                *Masukan Jenis Jaminan</p>
                                                                            <div class="invalid-feedback">
                                                                                Tidak boleh kosong
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">

                                                                            <input type="text" class="form-control"
                                                                                placeholder="{{ number_format($variabels[3]->min) }} - {{ number_format($variabels[3]->max) }}"
                                                                                id="jaminan" aria-describedby="jaminan"
                                                                                name="jaminan" required>
                                                                            <p style="font-size: 8pt; font-style:italic">
                                                                                *Masukan Nominal Jaminan</p>
                                                                            <div class="invalid-feedback">
                                                                                Tidak boleh kosong
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                                <div id="form_kendaraan-{{ $alternatif->id }}"
                                                                    style="display: none">
                                                                    <div class="mb-3">
                                                                        <label for="merk_kendaraan" class="form-label"
                                                                            id="label_merk_kendaraan-{{ $alternatif->id }}">Merk
                                                                            Kendaraan</label>
                                                                        <input type="text" class="form-control"
                                                                            placeholder="Merk Kendaraan" value=""
                                                                            id="merk_kendaraan-{{ $alternatif->id }}"
                                                                            aria-describedby="merk_kendaraan"
                                                                            name="merk_kendaraan">
                                                                        <p style="font-size: 8pt; font-style:italic;"
                                                                            id="p_jenis_kendaraan-{{ $alternatif->id }}">
                                                                            *Masukan
                                                                            Merk Kendaraan</p>
                                                                    </div>
                                                                    <div class="invalid-feedback">
                                                                        Tidak boleh kosong
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="jenis_kendaraan" class="form-label"
                                                                            id="label_jenis_kendaraan-{{ $alternatif->id }}">Jenis
                                                                            Kendaraan</label>
                                                                        <input type="text" class="form-control"
                                                                            placeholder="Jenis Kendaraan" value=""
                                                                            id="jenis_kendaraan-{{ $alternatif->id }}"
                                                                            aria-describedby="jenis_kendaraan"
                                                                            name="jenis_kendaraan">
                                                                        <p style="font-size: 8pt; font-style:italic;"
                                                                            id="p_jenis_kendaraan-{{ $alternatif->id }}">
                                                                            *Masukan
                                                                            Jenis Kendaraan</p>
                                                                    </div>
                                                                    <div class="invalid-feedback">
                                                                        Tidak boleh kosong
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="tahun_kendaraan" class="form-label"
                                                                            id="label_tahun_kendaraan-{{ $alternatif->id }}">Tahun
                                                                            Kendaraan</label>
                                                                        <input type="number" class="form-control"
                                                                            placeholder="Tahun Kendaraan" value=""
                                                                            id="tahun_kendaraan-{{ $alternatif->id }}"
                                                                            aria-describedby="tahun_kendaraan"
                                                                            name="tahun_kendaraan">
                                                                        <p style="font-size: 8pt; font-style:italic;"
                                                                            id="p_tahun_kendaraan-{{ $alternatif->id }}">
                                                                            *Masukan
                                                                            Tahun Kendaraan</p>
                                                                    </div>
                                                                    <div class="invalid-feedback">
                                                                        Tidak boleh kosong
                                                                    </div>
                                                                </div>


                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Simpan</button>

                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal Edit-->
                                            <div class="modal fade" id="editModal-{{ $alternatif->id }}" tabindex="-1"
                                                aria-labelledby="editModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel">Edit
                                                                Penilaian ({{ $alternatif->nama }})</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        @php
                                                            $penilaian = $penilaians->where('id_alternatif', $alternatif->id)->first();
                                                        @endphp
                                                        <form class="py-2 needs-validation"
                                                            action="{{ route('penilaian.update', $penilaian ? $penilaian->id : '') }}"
                                                            method="post" enctype="multipart/form-data">
                                                            @method('put')
                                                            @csrf
                                                            <div class="modal-body">
                                                                <input name="id_alternatif" type="hidden"
                                                                    value="{{ $alternatif->id }}">
                                                                <div class="mb-3">
                                                                    <label for="rk" class="form-label">Riwayat
                                                                        Keterlambatan
                                                                        ({{ $variabels[0]->keterangan }})</label>

                                                                    <input type="text" class="form-control"
                                                                        id="rk" aria-describedby="rk"
                                                                        name="rk"
                                                                        value="{{ $penilaian ? number_format($penilaian->rk, 0, ',', ',') : '' }}"
                                                                        required>
                                                                    <p style="font-size: 8pt; font-style:italic">*Masukan
                                                                        Jumlah Riwayat Keterlambatan </p>
                                                                </div>
                                                                <div class="invalid-feedback">
                                                                    Tidak boleh kosong
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="penghasilan"
                                                                        class="form-label">Penghasilan
                                                                        ({{ $variabels[1]->keterangan }})</label>

                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <input type="text" class="form-control"
                                                                                id="penghasilan"
                                                                                aria-describedby="penghasilan"
                                                                                name="penghasilan"
                                                                                value="{{ $penilaian ? number_format($penilaian->penghasilan, 0, ',', ',') : '' }}"
                                                                                required>
                                                                            <p style="font-size: 8pt; font-style:italic">
                                                                                *Masukan
                                                                                Nominal Penghasilan</p>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <input type="file" class="form-control"
                                                                                id="slipgaji" aria-describedby="slipgaji"
                                                                                name="slipgaji"
                                                                                value="{{ $penilaian ? $penilaian->slipgaji : 'empty' }}">
                                                                            <p style="font-size: 8pt; font-style:italic">*
                                                                                Foto slip gaji</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">
                                                                    Tidak boleh kosong
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="tanggungan" class="form-label">Tanggungan
                                                                        ({{ $variabels[2]->keterangan }})</label>
                                                                    <input type="number" class="form-control"
                                                                        id="tanggungan" aria-describedby="tanggungan"
                                                                        name="tanggungan"
                                                                        value="{{ $penilaian ? $penilaian->tanggungan : '' }}"
                                                                        required>
                                                                    <p style="font-size: 8pt; font-style:italic">*Masukan
                                                                        Jumlah Tanggungan Keluarga</p>
                                                                </div>
                                                                <div class="invalid-feedback">
                                                                    Tidak boleh kosong
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="jaminan" class="form-label">Jaminan
                                                                        ({{ $variabels[3]->keterangan }})</label>
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <select class="form-select"
                                                                                id="jenis_jaminan_edit-{{ $alternatif->id }}"
                                                                                name="jenis_jaminan" required>
                                                                                @foreach ($jenisJaminan as $jenis)
                                                                                    @if ($jenis->id == ($penilaian ? $penilaian->id_jenisVariabel : ''))
                                                                                        <option
                                                                                            value="{{ $jenis->id }}"
                                                                                            selected> {{ $jenis->nama }}
                                                                                        </option>
                                                                                    @endif
                                                                                    @if ($jenis->id !== ($penilaian ? $penilaian->id_jenisVariabel : ''))
                                                                                        <option
                                                                                            value="{{ $jenis->id }}">
                                                                                            {{ $jenis->nama }} </option>
                                                                                    @endif
                                                                                @endforeach
                                                                            </select>
                                                                            <p style="font-size: 8pt; font-style:italic">
                                                                                *Masukan Jenis Jaminan</p>
                                                                            <div class="invalid-feedback">
                                                                                Tidak boleh kosong
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="{{ number_format($variabels[3]->min) }} - {{ number_format($variabels[3]->max) }}"
                                                                                id="jaminan" aria-describedby="jaminan"
                                                                                value="{{ $penilaian ? number_format($penilaian->jaminan, 0, ',', ',') : '' }}"
                                                                                name="jaminan" required>
                                                                            <p style="font-size: 8pt; font-style:italic">
                                                                                *Masukan Nominal Jaminan</p>
                                                                            <div class="invalid-feedback">
                                                                                Tidak boleh kosong
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div id="form_kendaraan_edit-{{ $alternatif->id }}"
                                                                    style="display: none">
                                                                    <div class="mb-3">
                                                                        <label for="merk_kendaraan"
                                                                            class="form-label">Merk
                                                                            Kendaraan</label>
                                                                        <input type="text" class="form-control"
                                                                            placeholder="Merk Kendaraan"
                                                                            value="{{ $penilaian->merk_kendaraan ?? '' }}"
                                                                            aria-describedby="merk_kendaraan"
                                                                            name="merk_kendaraan">
                                                                        <p style="font-size: 8pt; font-style:italic;">
                                                                            *Masukan
                                                                            Merk Kendaraan</p>
                                                                    </div>
                                                                    <div class="invalid-feedback">
                                                                        Tidak boleh kosong1
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="jenis_kendaraan"
                                                                            class="form-label">Jenis
                                                                            Kendaraan</label>
                                                                        <input type="text" class="form-control"
                                                                            placeholder="Jenis Kendaraan"
                                                                            value="{{ $penilaian->jenis_kendaraan ?? '' }}"
                                                                            aria-describedby="jenis_kendaraan"
                                                                            name="jenis_kendaraan">
                                                                        <p style="font-size: 8pt; font-style:italic;">
                                                                            *Masukan
                                                                            Jenis Kendaraan</p>
                                                                    </div>
                                                                    <div class="invalid-feedback">
                                                                        Tidak boleh kosong2
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="tahun_kendaraan"
                                                                            class="form-label">Tahun
                                                                            Kendaraan</label>
                                                                        <input type="number" class="form-control"
                                                                            placeholder="Tahun Kendaraan"
                                                                            value="{{ $penilaian->tahun_kendaraan ?? '' }}"
                                                                            aria-describedby="tahun_kendaraan"
                                                                            name="tahun_kendaraan">
                                                                        <p style="font-size: 8pt; font-style:italic;">
                                                                            *Masukan
                                                                            Tahun Kendaraan</p>
                                                                    </div>
                                                                    <div class="invalid-feedback">
                                                                        Tidak boleh kosong3
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Simpan</button>

                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <tr>
                                                <th scope="row">{{ $key + 1 }}</th>

                                                <td>{{ $alternatif->nama }}</td>
                                                <td>{{ \Carbon\Carbon::parse($alternatif->tanggal)->translatedFormat('l, d-m-Y') }}
                                                </td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col">
                                                            {{-- <a href="penilaian/{{ $alternatif->id }}/edit" type="button"
                                                                class="btn btn-warning headlin2 headline-md2">
                                                                <i class="material-icons">edit</i>
                                                                Edit(penilaianID)
                                                            </a> --}}
                                                            @php
                                                                $penilaian = $penilaians->where('id_alternatif', $alternatif->id)->first();
                                                            @endphp

                                                            @if ($penilaian)
                                                                <button type="button" class="btn btn-warning"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#editModal-{{ $alternatif->id }}">
                                                                    <i class="material-icons">edit</i> edit
                                                                </button>
                                                            @else
                                                                <button type="button" class="btn btn-primary"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModal-{{ $alternatif->id }}">
                                                                    <i class="material-icons">add</i> Tambah
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $alternatifs->links() }}
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.btn-tambah').on('click', function(event) {
                var button = $(event.currentTarget);
                var modalId = button.data('target');
                var idAlternatif = modalId.split('-')[1];

                // Set the value of id_alternatif input in the modal
                $(modalId + ' input[name="id_alternatif"]').val(idAlternatif);
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            // Attach an event listener to the input elements
            $('#penghasilan, #jaminan').on('input', function() {
                // Get the current input value
                var inputValue = $(this).val();

                // Remove any existing commas and convert to a number
                var numericValue = parseFloat(inputValue.replace(/,/g, ''));

                // Check if the input is a valid number
                if (!isNaN(numericValue)) {
                    // Format the number with commas and update the input value
                    var formattedValue = numericValue.toLocaleString('en-US');
                    $(this).val(formattedValue);
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Function to handle the logic
            function handleJaminanChange(jenisJaminanValue, formKendaraan) {
                // console.log(formKendaraan);
                if (jenisJaminanValue == 1 || jenisJaminanValue == 2) {
                    formKendaraan.style.display = 'block';
                    // console.log('show' + formKendaraan);
                } else {
                    formKendaraan.style.display = 'none';
                }
            }

            // Function to handle the logic
            function handleJaminanChangeEdit(jenisJaminanValueEdit, formKendaraanEdit) {

                if (jenisJaminanValueEdit == 1 || jenisJaminanValueEdit == 2) {
                    formKendaraanEdit.style.display = 'block';
                } else {
                    formKendaraanEdit.style.display = 'none';
                    // console.log('none' + jenisJaminanValueEdit);
                }
            }

            // Loop through each alternatif
            @foreach ($alternatifs as $key => $alternatif)
                // Get the elements for jenis_kendaraan, merk_kendaraan, tahun_kendaraan
                var formKendaraan = document.getElementById('form_kendaraan-{{ $alternatif->id }}');
                var formKendaraanEdit = document.getElementById('form_kendaraan_edit-{{ $alternatif->id }}');

                // Add event listener for the change event
                document.getElementById('jenis_jaminan-{{ $alternatif->id }}').addEventListener('change',
                    function() {
                        var jenisJaminanValue = this.value;
                        // Trigger the logic on change
                        handleJaminanChange(jenisJaminanValue, formKendaraan);
                    });

                // ------------------------------------------------------------------------------------------


                // Trigger the logic when the page is accessed
                handleJaminanChangeEdit(document.getElementById('jenis_jaminan_edit-{{ $alternatif->id }}').value,
                    formKendaraanEdit);

                // Add event listener for the change event
                document.getElementById('jenis_jaminan_edit-{{ $alternatif->id }}').addEventListener('change',
                    function() {
                        var jenisJaminanValueEdit = this.value;

                        // Trigger the logic on change
                        handleJaminanChangeEdit(jenisJaminanValueEdit, formKendaraanEdit);
                    });
            @endforeach
        });
    </script>
@endpush
