@extends('layouts/main')
@section('title', 'Profile')

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
            @if (session()->has('error'))
                <div class="alert alert-danger alert-style-light absolute " role="alert" style="z-index: 1000;">
                    <span class="alert-icon-wrap mb-3">
                        {{ session('error') }}
                    </span>
                    <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>

                </div>
            @endif
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description">
                            <h1>Profile</h1>
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
                                    action="{{ route('profile.update', $user->id) }}" method="post"
                                    enctype="multipart/form-data" novalidate>
                                    @method('put')
                                    @csrf
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" placeholder="Masukan nama..." class="form-control" id="nama"
                                        aria-describedby="nama" name="nama" value="{{ old('user', $user->name) }}" required>
                                    <div class="invalid-feedback">
                                        Tidak boleh kosong
                                    </div>

                                    <label for="email" class="form-label mt-3">Email</label>
                                    <input type="email" placeholder="Masukan email..." class="form-control" id="email"
                                        aria-describedby="email" name="email" value="{{ old('user', $user->email) }}" required>
                                    <div class="invalid-feedback">
                                        Tidak boleh kosong
                                    </div>

                                    <label for="password" class="form-label mt-3">Password Baru</label>
                                    <input type="password" placeholder="Masukan password..." class="form-control"
                                        id="password" aria-describedby="password" name="password"
                                        autocomplete="new-password">

                                    <label for="repassword" class="form-label mt-3">Ulang Password</label>
                                    <input type="repassword" placeholder="Masukan ulang password..." class="form-control"
                                        id="repassword" aria-describedby="repassword" name="repassword"
                                        autocomplete="new-password">

                                    <button type="submit" class="btn btn-primary px-5 mt-3 float-end">Update</button>
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
    <script>
        document.getElementById('password').addEventListener('input', function() {
            var newPassword = this.value;
            var confirmPasswordInput = document.getElementById('repassword');

            if (newPassword.trim() !== '') {
                confirmPasswordInput.setAttribute('required', 'required');
            } else {
                confirmPasswordInput.removeAttribute('required');
            }
        });
    </script>
@endpush
