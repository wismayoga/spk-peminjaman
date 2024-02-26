<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Aturan;
use App\Models\Penilaian;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class perhitunganController extends Controller
{
    public function index()
    {
        // Get penilaians with related alternatif names
        $penilaians = DB::table('penilaians')
            ->leftJoin('alternatifs as tabel_alternatif', 'penilaians.id_alternatif', '=', 'tabel_alternatif.id')
            ->select("penilaians.*", 'tabel_alternatif.nama as nama_alternatif')
            ->get();
        

        // Fetch himpunan data for each variabel (assuming 1 is a placeholder, adjust accordingly)
        $rk_tidak_aturan = DB::table('himpunans')->where('id_variabel', '=', 1)->where('nama', '=', 'Tidak Pernah')->first();
        $rk_jarang_aturan = DB::table('himpunans')->where('id_variabel', '=', 1)->where('nama', '=', 'Jarang')->first();
        $rk_sering_aturan = DB::table('himpunans')->where('id_variabel', '=', 1)->where('nama', '=', 'Sering')->first();

        // Initialize an array to store results
        $rkResults = [];
        foreach ($penilaians as $key => $penilaian) {
            // Determine rk_tidak, rk_jarang, rk_sering based on your conditions
            $rk_tidak = ($penilaian->rk <= $rk_tidak_aturan->max) ? 1 : 0;
            $rk_jarang = ($penilaian->rk >= $rk_jarang_aturan->min && $penilaian->rk <= $rk_jarang_aturan->max) ? 1 : 0;
            $rk_sering = ($penilaian->rk > $rk_jarang_aturan->max) ? 1 : 0;

            // Store the results in an array
            $rkResults[] = [
                'nama' => $penilaian->nama_alternatif,
                'rk' => $penilaian->rk,
                'rk_tidak' => $rk_tidak,
                'rk_jarang' => $rk_jarang,
                'rk_sering' => $rk_sering,
            ];
        }

        // ---------------------------------------------------------------------------------------------------------------

        // Fetch himpunan data for each variabel (assuming 1 is a placeholder, adjust accordingly)
        $penghasilan_tidak_aturan = DB::table('himpunans')->where('id_variabel', '=', 2)->where('nama', '=', 'Kurang')->first();
        $penghasilan_jarang_aturan = DB::table('himpunans')->where('id_variabel', '=', 2)->where('nama', '=', 'Cukup')->first();
        $penghasilan_sering_aturan = DB::table('himpunans')->where('id_variabel', '=', 2)->where('nama', '=', 'Banyak')->first();

        // Initialize an array to store results
        $penghasilanResults = [];
        foreach ($penilaians as $key => $penilaian) {
            // Determine rk_tidak, rk_jarang, rk_sering based on your conditions
            $penghasilan_tidak = ($penilaian->penghasilan <= $penghasilan_tidak_aturan->max) ? 1 : 0;
            $penghasilan_jarang = ($penilaian->penghasilan >= $penghasilan_jarang_aturan->min && $penilaian->penghasilan <= $penghasilan_jarang_aturan->max) ? 1 : 0;
            $penghasilan_sering = ($penilaian->penghasilan > $penghasilan_jarang_aturan->max) ? 1 : 0;

            // Store the results in an array
            $penghasilanResults[] = [
                'nama' => $penilaian->nama_alternatif,
                'penghasilan' => $penilaian->penghasilan,
                'penghasilan_tidak' => $penghasilan_tidak,
                'penghasilan_jarang' => $penghasilan_jarang,
                'penghasilan_sering' => $penghasilan_sering,
            ];
        }

        // ---------------------------------------------------------------------------------------------------------------

        // Fetch himpunan data for each variabel (assuming 1 is a placeholder, adjust accordingly)
        $tanggungan_tidak_aturan = DB::table('himpunans')->where('id_variabel', '=', 3)->where('nama', '=', 'Sedikit')->first();
        $tanggungan_jarang_aturan = DB::table('himpunans')->where('id_variabel', '=', 3)->where('nama', '=', 'Cukup')->first();
        $tanggungan_sering_aturan = DB::table('himpunans')->where('id_variabel', '=', 3)->where('nama', '=', 'Banyak')->first();

        // Initialize an array to store results
        $tanggunganResults = [];
        foreach ($penilaians as $key => $penilaian) {
            // Determine rk_tidak, rk_jarang, rk_sering based on your conditions
            $tanggungan_tidak = ($penilaian->tanggungan <= $tanggungan_tidak_aturan->max) ? 1 : 0;
            $tanggungan_jarang = ($penilaian->tanggungan >= $tanggungan_jarang_aturan->min && $penilaian->tanggungan <= $tanggungan_jarang_aturan->max) ? 1 : 0;
            $tanggungan_sering = ($penilaian->tanggungan > $tanggungan_jarang_aturan->max) ? 1 : 0;

            // Store the results in an array
            $tanggunganResults[] = [
                'nama' => $penilaian->nama_alternatif,
                'tanggungan' => $penilaian->tanggungan,
                'tanggungan_tidak' => $tanggungan_tidak,
                'tanggungan_jarang' => $tanggungan_jarang,
                'tanggungan_sering' => $tanggungan_sering,
            ];
        }

        // ---------------------------------------------------------------------------------------------------------------

        // Fetch himpunan data for each variabel (assuming 1 is a placeholder, adjust accordingly)
        $jaminan_tidak_aturan = DB::table('himpunans')->where('id_variabel', '=', 4)->where('nama', '=', 'Kurang')->first();
        $jaminan_jarang_aturan = DB::table('himpunans')->where('id_variabel', '=', 4)->where('nama', '=', 'Cukup')->first();
        $jaminan_sering_aturan = DB::table('himpunans')->where('id_variabel', '=', 4)->where('nama', '=', 'Baik')->first();

        // Initialize an array to store results
        $jaminanResults = [];
        foreach ($penilaians as $key => $penilaian) {
            // Determine rk_tidak, rk_jarang, rk_sering based on your conditions
            $jaminan_tidak = ($penilaian->jaminan <= $jaminan_tidak_aturan->max) ? 1 : 0;
            $jaminan_jarang = ($penilaian->jaminan >= $jaminan_jarang_aturan->min && $penilaian->jaminan <= $jaminan_jarang_aturan->max) ? 1 : 0;
            $jaminan_sering = ($penilaian->jaminan > $jaminan_jarang_aturan->max) ? 1 : 0;

            // Store the results in an array
            $jaminanResults[] = [
                'nama' => $penilaian->nama_alternatif,
                'jaminan' => $penilaian->jaminan,
                'jaminan_tidak' => $jaminan_tidak,
                'jaminan_jarang' => $jaminan_jarang,
                'jaminan_sering' => $jaminan_sering,
            ];
        }

        // ---------------------------------------------------------------------------------------------------------------

        // Render view with data
        return view('dashboard.perhitungan', [
            'penilaians' => $penilaians,
            'rkResults' => $rkResults,
            'penghasilanResults' => $penghasilanResults,
            'tanggunganResults' => $tanggunganResults,
            'jaminanResults' => $jaminanResults,
        ]);
    }

    public function show(string $id): View
    {
        $penilaian = DB::table('penilaians')
            ->where('penilaians.id', '=', $id)
            ->leftJoin('alternatifs as tabel_alternatif', 'penilaians.id_alternatif', '=', 'tabel_alternatif.id')
            ->select("penilaians.*", 'tabel_alternatif.nama as nama_alternatif')
            ->first();

        //FUNGSI PERHITUNGAN

        //hitung riwayat keterlambatan
        $rk_tidak_aturan = DB::table('himpunans')->where('id_variabel', '=', 1)->where('nama', '=', 'Tidak Pernah')->first();
        $rk_jarang_aturan = DB::table('himpunans')->where('id_variabel', '=', 1)->where('nama', '=', 'Jarang')->first();
        $rk_sering_aturan = DB::table('himpunans')->where('id_variabel', '=', 1)->where('nama', '=', 'Sering')->first();

        $rk_tidak = ($penilaian->rk <= $rk_tidak_aturan->max) ? 1 : 0;
        $rk_jarang = ($penilaian->rk >= $rk_jarang_aturan->min && $penilaian->rk <= $rk_jarang_aturan->max) ? 1 : 0;
        $rk_sering = ($penilaian->rk > $rk_jarang_aturan->max) ? 1 : 0;

        if ($rk_tidak == 1) {
            $hasil_rk = 'Tidak Pernah';
        } else if ($rk_jarang == 1) {
            $hasil_rk = 'Jarang';
        } else if ($rk_sering == 1) {
            $hasil_rk = 'Sering';
        }

        //hitung penghasilan
        $penghasilan_tidak_aturan = DB::table('himpunans')->where('id_variabel', '=', 2)->where('nama', '=', 'Kurang')->first();
        $penghasilan_jarang_aturan = DB::table('himpunans')->where('id_variabel', '=', 2)->where('nama', '=', 'Cukup')->first();
        $penghasilan_sering_aturan = DB::table('himpunans')->where('id_variabel', '=', 2)->where('nama', '=', 'Banyak')->first();

        $penghasilan_tidak = ($penilaian->penghasilan <= $penghasilan_tidak_aturan->max) ? 1 : 0;
        $penghasilan_jarang = ($penilaian->penghasilan >= $penghasilan_jarang_aturan->min && $penilaian->penghasilan <= $penghasilan_jarang_aturan->max) ? 1 : 0;
        $penghasilan_sering = ($penilaian->penghasilan > $penghasilan_jarang_aturan->max) ? 1 : 0;

        if ($penghasilan_tidak == 1) {
            $hasil_penghasilan = 'Kurang';
        } else if ($penghasilan_jarang == 1) {
            $hasil_penghasilan = 'Cukup';
        } else if ($penghasilan_sering == 1) {
            $hasil_penghasilan = 'Banyak';
        }

        //hitung tanggungan
        $tanggungan_tidak_aturan = DB::table('himpunans')->where('id_variabel', '=', 3)->where('nama', '=', 'Sedikit')->first();
        $tanggungan_jarang_aturan = DB::table('himpunans')->where('id_variabel', '=', 3)->where('nama', '=', 'Cukup')->first();
        $tanggungan_sering_aturan = DB::table('himpunans')->where('id_variabel', '=', 3)->where('nama', '=', 'Banyak')->first();

        $tanggungan_tidak = ($penilaian->tanggungan <= $tanggungan_tidak_aturan->max) ? 1 : 0;
        $tanggungan_jarang = ($penilaian->tanggungan >= $tanggungan_jarang_aturan->min && $penilaian->tanggungan <= $tanggungan_jarang_aturan->max) ? 1 : 0;
        $tanggungan_sering = ($penilaian->tanggungan > $tanggungan_jarang_aturan->max) ? 1 : 0;

        if ($tanggungan_tidak == 1) {
            $hasil_tanggungan = 'Sedikit';
        } else if ($tanggungan_jarang == 1) {
            $hasil_tanggungan = 'Cukup';
        } else if ($tanggungan_sering == 1) {
            $hasil_tanggungan = 'Banyak';
        }

        //hitunga jaminan
        $jaminan_tidak_aturan = DB::table('himpunans')->where('id_variabel', '=', 4)->where('nama', '=', 'Kurang')->first();
        $jaminan_jarang_aturan = DB::table('himpunans')->where('id_variabel', '=', 4)->where('nama', '=', 'Cukup')->first();
        $jaminan_sering_aturan = DB::table('himpunans')->where('id_variabel', '=', 4)->where('nama', '=', 'Baik')->first();

        $jaminan_tidak = ($penilaian->jaminan <= $jaminan_tidak_aturan->max) ? 1 : 0;
        $jaminan_jarang = ($penilaian->jaminan >= $jaminan_jarang_aturan->min && $penilaian->jaminan <= $jaminan_jarang_aturan->max) ? 1 : 0;
        $jaminan_sering = ($penilaian->jaminan > $jaminan_jarang_aturan->max) ? 1 : 0;

        if ($jaminan_tidak == 1) {
            $hasil_jaminan = 'Kurang';
        } else if ($jaminan_jarang == 1) {
            $hasil_jaminan = 'Cukup';
        } else if ($jaminan_sering == 1) {
            $hasil_jaminan = 'Baik';
        }

        //get aturan
        $aturans = DB::table('aturans')
            ->leftJoin('himpunans as tabel_rk', 'aturans.id_rk', '=', 'tabel_rk.id')
            ->leftJoin('himpunans as tabel_penghasilan', 'aturans.id_penghasilan', '=', 'tabel_penghasilan.id')
            ->leftJoin('himpunans as tabel_tanggungan', 'aturans.id_tanggungan', '=', 'tabel_tanggungan.id')
            ->leftJoin('himpunans as tabel_jaminan', 'aturans.id_jaminan', '=', 'tabel_jaminan.id')
            ->select(
                "aturans.*",
                "tabel_rk.nama as rk_nama",
                "tabel_penghasilan.nama as penghasilan_nama",
                "tabel_tanggungan.nama as tanggungan_nama",
                "tabel_jaminan.nama as jaminan_nama"
            )
            ->get();

        $matchedResults = $this->matchAttributes($aturans, $hasil_rk, $hasil_penghasilan, $hasil_tanggungan, $hasil_jaminan);
        // dd($matchedResults);
        // Assuming $matchedResults is the array you created earlier
        $totalWeight = 0;
        $weightedSum = 0;

        foreach ($matchedResults as $index => $result) {
            $weight = $result['hasil_persamaan'];
            $hasil = $result['hasil'];

            $weightedSum += $hasil * $weight;
            $totalWeight += $weight;
        }

        // Avoid division by zero
        if ($totalWeight !== 0) {
            $finalResult = $weightedSum / $totalWeight;
        } else {
            $finalResult = 0; // or handle this case as needed
        }

        // dd($finalResult);

        return view('dashboard.perhitunganShow', [
            'penilaian' => $penilaian,
            'hasil_rk' => $hasil_rk,
            'hasil_penghasilan' => $hasil_penghasilan,
            'hasil_tanggungan' => $hasil_tanggungan,
            'hasil_jaminan' => $hasil_jaminan,
            'aturans' => $aturans,
            'matchedResults' => $matchedResults,
            'finalResult' => $finalResult,
        ]);
    }

    public function matchAttributes($aturans, $hasil_rk, $hasil_penghasilan, $hasil_tanggungan, $hasil_jaminan)
    {
        $matchedResults = [];

        foreach ($aturans as $aturan) {
            // Check if attributes match
            $isMatch = (
                $aturan->rk_nama == $hasil_rk &&
                $aturan->penghasilan_nama == $hasil_penghasilan &&
                $aturan->tanggungan_nama == $hasil_tanggungan &&
                $aturan->jaminan_nama == $hasil_jaminan
            );

            // Set "Hasil Persamaan" based on the match
            $hasilPersamaan = $isMatch ? 1 : 0;

            // Add the result to the array
            $matchedResults[] = [
                'rk_nama' => $aturan->rk_nama,
                'penghasilan_nama' => $aturan->penghasilan_nama,
                'tanggungan_nama' => $aturan->tanggungan_nama,
                'jaminan_nama' => $aturan->jaminan_nama,
                'hasil' => $aturan->hasil,
                'hasil_persamaan' => $hasilPersamaan,
            ];
        }

        return $matchedResults;
    }
}
