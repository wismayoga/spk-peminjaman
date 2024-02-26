@extends('layouts/main')
@section('title', 'Dashboard')

@section('content')
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description">
                            <h1>Dashboard Petugas</h1>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-4">
                        <div class="card widget widget-stats">
                            <div class="card-body">
                                <a href="{{ route('alternatif.index') }}" class="text-decoration-none">
                                    <div class="widget-stats-container d-flex">
                                        <div class="widget-stats-icon widget-stats-icon-primary">
                                            <i class="material-icons-outlined">
                                                <span class="material-symbols-outlined mt-3" style="font-size: 28px;">
                                                    groups
                                                </span>
                                            </i>
                                        </div>
                                        <div class="widget-stats-content mt-2">
                                            <span class="widget-stats-amount">Data Nasabah</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card widget widget-stats">
                            <div class="card-body">
                                <a href="{{ route('penilaian.index') }}" class="text-decoration-none">
                                    <div class="widget-stats-container d-flex">
                                        <div class="widget-stats-icon widget-stats-icon-warning">
                                            <i class="material-icons-outlined">
                                                <span class="material-symbols-outlined mt-3" style="font-size: 28px;">
                                                    stylus
                                                </span>
                                            </i>
                                        </div>
                                        <div class="widget-stats-content mt-2">
                                            <span class="widget-stats-amount">Data Penilaian</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card widget widget-stats">
                            <div class="card-body">
                                <a href="{{ route('perhitungan.index') }}" class="text-decoration-none">
                                    <div class="widget-stats-container d-flex">
                                        <div class="widget-stats-icon widget-stats-icon-danger">
                                            <i class="material-icons-outlined">
                                                <span class="material-symbols-outlined mt-3" style="font-size: 28px;">
                                                    keyboard_onscreen
                                                </span>
                                            </i>
                                        </div>
                                        <div class="widget-stats-content mt-2">
                                            <span class="widget-stats-amount" style="font-size: 26px;">Hasil Perhitungan</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
