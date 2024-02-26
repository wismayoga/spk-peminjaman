<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\alternatifController;
use App\Http\Controllers\Dashboard2Controller;
use App\Http\Controllers\penilaianController;
use App\Http\Controllers\perhitunganController;
use App\Http\Controllers\RiwayatController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
})->name('landing');

Route::get('/login', [authController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [authController::class, 'login_action'])->name('login.action');
// Route::post('/logout', [authController::class, 'logout'])->name('logout');
Route::match(['get', 'post'], '/logout', [authController::class, 'logout'])->name('logout');
// Route::get('/logout', [authController::class, 'logout'])->name('logout');

Route::middleware(['middleware' => 'auth', 'cekRole:admin'])->group(function () {
    Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard');
});
Route::middleware(['middleware' => 'auth', 'cekRole:petugas'])->group(function () {
    Route::get('/dashboard2', [Dashboard2Controller::class, 'index'])->name('dashboard2');
});

Route::middleware(['middleware' => 'auth', 'cekRole:admin'])->prefix('dashboard')->group(function () {
    Route::resource('/variabel', \App\Http\Controllers\variabelController::class);
    Route::resource('/jenisVariabel', \App\Http\Controllers\VariabelJenisController::class);
    Route::resource('/himpunan', \App\Http\Controllers\himpunanController::class);
    Route::resource('/aturan', \App\Http\Controllers\aturanController::class);
    // Route::resource('/alternatif', \App\Http\Controllers\alternatifController::class);
    // Route::get('/alternatifs/cari', [alternatifController::class, 'cari'])->name('cariNasabah');
    // Route::resource('/penilaian', \App\Http\Controllers\penilaianController::class);
    // Route::get('/penilaians/cari', [penilaianController::class, 'cari'])->name('cariPenilaian');
    // Route::resource('/perhitungan', \App\Http\Controllers\perhitunganController::class);
    // Route::get('/perhitungans/cari', [perhitunganController::class, 'cari'])->name('cariPerhitungan');
    // Route::resource('/riwayat', \App\Http\Controllers\RiwayatController::class);
    // Route::resource('/riwayat2', \App\Http\Controllers\Riwayat2Controller::class);

    // Route::resource('/profile', \App\Http\Controllers\profilController::class);
});

Route::middleware(['middleware' => 'auth', 'cekRole:admin,petugas'])->prefix('dashboard')->group(function () {
    Route::resource('/alternatif', \App\Http\Controllers\alternatifController::class);
    Route::get('/alternatifs/cari', [alternatifController::class, 'cari'])->name('cariNasabah');
    Route::resource('/penilaian', \App\Http\Controllers\penilaianController::class);
    Route::get('/penilaians/cari', [penilaianController::class, 'cari'])->name('cariPenilaian');
    Route::resource('/perhitungan', \App\Http\Controllers\perhitunganController::class);
    Route::get('/perhitungans/cari', [perhitunganController::class, 'cari'])->name('cariPerhitungan');
    Route::resource('/riwayat', \App\Http\Controllers\RiwayatController::class);
    Route::resource('/riwayat2', \App\Http\Controllers\Riwayat2Controller::class);

    Route::resource('/profile', \App\Http\Controllers\profilController::class);

    Route::get('/generate-pdf', [RiwayatController::class, 'generatePdf'])->name('generate.pdf');
    Route::post('/print-by-month', [RiwayatController::class, 'printByMonth'])->name('printByMonth');
Route::post('/print-by-year', [RiwayatController::class, 'printByYear'])->name('printByYear');


});