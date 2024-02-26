@extends('layouts/main')
@section('title', 'Himpunan Fuzzy')

@section('content')
    <div class="app-content">
        <div class="content-wrapper">
            @if (session()->has('success'))
                <div class="alert alert-success alert-style-light absolute " role="alert" style="z-index: 1000;">
                    <span class="alert-icon-wrap mb-3">
                        {{ session('success') }}
                    </span>
                    <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>

                </div>
            @endif

            <!-- Modal Tambah-->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form class="py-2 needs-validation" action="{{ route('himpunan.store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <input name="variabel" type="hidden" value="secret">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Himpunan Fuzzy</label>
                                    <input type="text" class="form-control" id="nama" aria-describedby="nama"
                                        name="nama" required>
                                </div>

                                <div class="mb-3">
                                    <label for="kurva" class="form-label">Kurva</label>
                                    <select class="form-select" id="kurva" name="kurva">
                                        <option selected>--Pilih Kurva--</option>
                                        <option value="Liniar Naik">Liniar Naik</option>
                                        <option value="Liniar Turun">Liniar Turun</option>
                                        <option value="Segitiga">Segitiga</option>
                                        <option value="Trapesium">Trapesium</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="a" class="form-label" id="label_a">Domain (a)</label>
                                    <input type="number" class="form-control" id="a" aria-describedby="a"
                                            name="a">
                                </div>

                                <div class="mb-3">
                                    <label for="b" class="form-label" id="label_b">Domain (b)</label>
                                    <input type="number" class="form-control" id="b" aria-describedby="b"
                                        name="b">
                                </div>

                                <div class="mb-3">
                                    <label for="c" class="form-label" id="label_c">Domain (c)</label>
                                    <input type="number" class="form-control" id="c" aria-describedby="c"
                                        name="c" "required if segitiga selected">
                                </div>

                                <div class="mb-3">
                                    <label for="d" class="form-label" id="label_d">Domain (d)</label>
                                    <input type="number" class="form-control" id="d" aria-describedby="d"
                                        name="d">
                                </div>

                                <div class="mb-3">
                                    <img id="selectedImage" src="" height="100" alt="">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>



            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description">
                            <h1>Data Himpunan Fuzzy</h1>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="mt-1">Fungsi Keanggotaan Variabel Riwayat Keterlambatan</h5>
                                    </div>
                                    <div class="col">
                                        <div class="float-end">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal" data-title="Tambah Riwayat Keterlambatan">
                                                <i class="material-icons">add</i> Tambah
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col" style="width: 500px;">Nama Himpunan Fuzzy</th>
                                            <th scope="col">Jenis Kurva</th>
                                            <th scope="col">Domain</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rk as $key => $rk)
                                            <tr>
                                                <th scope="row">{{ $key + 1 }}</th>
                                                <td>{{ $rk->nama }}</td>
                                                <td>{{ $rk->nama_kurva }}</td>

                                                @if ($rk->nama_kurva == 'Linear Turun' || $rk->nama_kurva == 'Linear Naik')
                                                    <td>[{{ $rk->a }}], [{{ $rk->b }}]</td>
                                                @endif

                                                @if ($rk->nama_kurva == 'Segitiga')
                                                    <td>[{{ $rk->a }}], [{{ $rk->b }}],
                                                        [{{ $rk->c }}]</td>
                                                @endif

                                                @if ($rk->nama_kurva == 'Trapesium')
                                                    <td>[{{ $rk->a }}], [{{ $rk->b }}],
                                                        [{{ $rk->c }}], [{{ $rk->d }}]</td>
                                                @endif

                                                <td>
                                                    <div class="row">
                                                        <div class="col">
                                                            <a href="himpunan/{{ $rk->id }}/edit" type="button"
                                                                class="btn btn-warning headlin2 headline-md2">
                                                                <i class="material-icons">edit</i>
                                                                Edit
                                                            </a>

                                                            <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                                                action="{{ route('himpunan.destroy', $rk->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger"><i
                                                                        class="material-icons">delete</i>Hapus</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="mt-1">Fungsi Keanggotaan Variabel Penghasilan</h5>
                                    </div>
                                    <div class="col">
                                        <div class="float-end">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal" data-title="Tambah Penghasilan">
                                                <i class="material-icons">add</i> Tambah
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col" style="width: 500px;">Nama Himpunan Fuzzy</th>
                                            <th scope="col">Jenis Kurva</th>
                                            <th scope="col">Domain</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($penghasilan as $key => $penghasilan)
                                            <tr>
                                                <th scope="row">{{ $key + 1 }}</th>
                                                <td>{{ $penghasilan->nama }}</td>
                                                <td>{{ $penghasilan->nama_kurva }}</td>
                                                @if ($penghasilan->nama_kurva == 'Linear Turun' || $penghasilan->nama_kurva == 'Linear Naik')
                                                    <td>[{{ $penghasilan->a }}], [{{ $penghasilan->b }}]</td>
                                                @endif

                                                @if ($penghasilan->nama_kurva == 'Segitiga')
                                                    <td>[{{ $penghasilan->a }}], [{{ $penghasilan->b }}],
                                                        [{{ $penghasilan->c }}]</td>
                                                @endif

                                                @if ($penghasilan->nama_kurva == 'Trapesium')
                                                    <td>[{{ $penghasilan->a }}], [{{ $penghasilan->b }}],
                                                        [{{ $penghasilan->c }}], [{{ $penghasilan->d }}]</td>
                                                @endif

                                                <td>
                                                    <div class="row">
                                                        <div class="col">
                                                            <a href="himpunan/{{ $penghasilan->id }}/edit" type="button"
                                                                class="btn btn-warning headlin2 headline-md2">
                                                                <i class="material-icons">edit</i>
                                                                Edit
                                                            </a>

                                                            <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                                                action="{{ route('himpunan.destroy', $penghasilan->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger"><i
                                                                        class="material-icons">delete</i>Hapus</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="mt-1">Fungsi Keanggotaan Variabel Tanggungan</h5>
                                    </div>
                                    <div class="col">
                                        <div class="float-end">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal" data-title="Tambah Tanggungan">
                                                <i class="material-icons">add</i> Tambah
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col" style="width: 500px;">Nama Himpunan Fuzzy</th>
                                            <th scope="col">Jenis Kurva</th>
                                            <th scope="col">Domain</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tanggungan as $key => $tanggungan)
                                            <tr>
                                                <th scope="row">{{ $key + 1 }}</th>
                                                <td>{{ $tanggungan->nama }}</td>
                                                <td>{{ $tanggungan->nama_kurva }}</td>
                                                @if ($tanggungan->nama_kurva == 'Linear Turun' || $tanggungan->nama_kurva == 'Linear Naik')
                                                    <td>[{{ $tanggungan->a }}], [{{ $tanggungan->b }}]</td>
                                                @endif

                                                @if ($tanggungan->nama_kurva == 'Segitiga')
                                                    <td>[{{ $tanggungan->a }}], [{{ $tanggungan->b }}],
                                                        [{{ $tanggungan->c }}]</td>
                                                @endif

                                                @if ($tanggungan->nama_kurva == 'Trapesium')
                                                    <td>[{{ $tanggungan->a }}], [{{ $tanggungan->b }}],
                                                        [{{ $tanggungan->c }}], [{{ $tanggungan->d }}]</td>
                                                @endif
                                                <td>
                                                    <div class="row">
                                                        <div class="col">
                                                            <a href="himpunan/{{ $tanggungan->id }}/edit" type="button"
                                                                class="btn btn-warning headlin2 headline-md2">
                                                                <i class="material-icons">edit</i>
                                                                Edit
                                                            </a>

                                                            <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                                                action="{{ route('himpunan.destroy', $tanggungan->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger"><i
                                                                        class="material-icons">delete</i>Hapus</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="mt-1">Fungsi Keanggotaan Variabel Jaminan</h5>
                                    </div>
                                    <div class="col">
                                        <div class="float-end">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal" data-title="Tambah Jaminan">
                                                <i class="material-icons">add</i> Tambah
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col" style="width: 500px;">Nama Himpunan Fuzzy</th>
                                            <th scope="col">Jenis Kurva</th>
                                            <th scope="col">Domain</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jaminan as $key => $jaminan)
                                            <tr>
                                                <th scope="row">{{ $key + 1 }}</th>
                                                <td>{{ $jaminan->nama }}</td>
                                                <td>{{ $jaminan->nama_kurva }}</td>
                                                @if ($jaminan->nama_kurva == 'Linear Turun' || $jaminan->nama_kurva == 'Linear Naik')
                                                    <td>[{{ $jaminan->a }}], [{{ $jaminan->b }}]</td>
                                                @endif

                                                @if ($jaminan->nama_kurva == 'Segitiga')
                                                    <td>[{{ $jaminan->a }}], [{{ $jaminan->b }}],
                                                        [{{ $jaminan->c }}]</td>
                                                @endif

                                                @if ($jaminan->nama_kurva == 'Trapesium')
                                                    <td>[{{ $jaminan->a }}], [{{ $jaminan->b }}],
                                                        [{{ $jaminan->c }}], [{{ $jaminan->d }}]</td>
                                                @endif
                                                <td>
                                                    <div class="row">
                                                        <div class="col">
                                                            <a href="himpunan/{{ $jaminan->id }}/edit" type="button"
                                                                class="btn btn-warning headlin2 headline-md2">
                                                                <i class="material-icons">edit</i>
                                                                Edit
                                                            </a>

                                                            <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                                                action="{{ route('himpunan.destroy', $jaminan->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger"><i
                                                                        class="material-icons">delete</i>Hapus</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
    <script>
        $(document).ready(function() {
            $('#exampleModal, #exampleModal2').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var title = button.data('title');
                var modal = $(this);

                modal.find('.modal-title').text(title);

                modal.find('input[name="variabel"]').val(title);
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {

            // Initially hide the input for domain a
            $("#a, #label_a, #b, #label_b, #c, #label_c, #d, #label_d").hide();
            // $("#b").hide();
            // $("#label_b").hide();

            // Add change event listener to the dropdown
            $("#kurva").change(function() {
                
                // Check if "Liniar Naik" is selected
                if ($(this).val() === "Liniar Naik") {
                    // If selected, show the input for domain a
                    $("#a, #label_a, #b, #label_b").show();
                    $("#c, #label_c, #d, #label_d").hide();
                    $("#a, #b").prop('required', true);
                    $("#c, #d").prop('required', false);
                    $("#selectedImage").attr("src", "{{ asset('assets/images/1.png') }}");
                }else if ($(this).val() === "Liniar Turun") {
                    // If selected, show the input for domain a
                    $("#a, #label_a, #b, #label_b").show();
                    $("#c, #label_c, #d, #label_d").hide();
                    $("#a, #b").prop('required', true);
                    $("#c, #d").prop('required', false);
                    $("#selectedImage").attr("src", "{{ asset('assets/images/2.png') }}");
                } else if ($(this).val() === "Segitiga") {
                    // If selected, show the input for domain a
                    $("#a, #label_a, #b, #label_b, #c, #label_c").show();
                    $("#d, #label_d").hide();
                    $("#a, #b, #c").prop('required', true);
                    $("#d").prop('required', false);
                    $("#selectedImage").attr("src", "{{ asset('assets/images/3.png') }}");
                } else if ($(this).val() === "Trapesium") {
                    // If selected, show the input for domain a
                    $("#a, #label_a, #b, #label_b, #c, #label_c, #d, #label_d").show();
                    $("#a, #b, #c, #d").prop('required', true);
                    $("#selectedImage").attr("src", "{{ asset('assets/images/4.png') }}");
                } else {
                    // If not selected, hide the input for domain a
                    $("#a, #label_a, #b, #label_b, #c, #label_c, #d, #label_d").hide();
                    $("#a, #b, #c, #d").prop('required', false);
                    $("#selectedImage").attr("src", ""); 
                }
            });
        });
        // 
    </script>
@endpush
