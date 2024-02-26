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
    public function linearTurun($input, $a, $b)
    {
        if ($input <= $a) {
            return 1;
        } elseif ($a <= $input && $input <= $b) {
            return ($b - $input) / ($b - $a);
        } elseif ($input >= $b) {
            return 0;
        } else {
            return 1; // Default value if none of the conditions are met
        }
    }

    public function linearNaik($input, $a, $b)
    {
        if ($input <= $a) {
            return 0;
        } elseif ($a <= $input && $input <= $b) {
            return ($input - $a) / ($b - $a);
        } elseif ($input >= $b) {
            return 1;
        } else {
            return 0;
        }
    }

    public function segitiga($input, $a, $b, $c)
    {
        if ($input <= $a) {
            return 0;
        } elseif ($a <= $input && $input <= $b) {
            return ($input - $a) / ($b - $a);
        } elseif ($b <= $input && $input <= $c) {
            return ($c - $input) / ($c - $b);
        } elseif ($input >= $c) {
            return 0; // masih ambigu
        } else {
            return 1; // Default value if none of the conditions are met
        }
    }

    public function travesium($input, $a, $b, $c, $d)
    {
        if ($input <= $a) {
            return 0;
        } elseif ($a <= $input && $input <= $b) {
            return ($input - $a) / ($b - $a);
        } elseif ($b <= $input && $input <= $c) {
            return 1;
        } elseif ($c <= $input && $input <= $d) {
            return ($d - $input) / ($d - $c);
        } elseif ($input >= $d) {
            return 0;
        } else {
            return 1; // Default value if none of the conditions are met
        }
    }

    public function index()
    {
        // Get penilaians with related alternatif names
        $penilaians = DB::table('penilaians')
            ->leftJoin('alternatifs as tabel_alternatif', 'penilaians.id_alternatif', '=', 'tabel_alternatif.id')
            ->select("penilaians.*", 'tabel_alternatif.nama as nama_alternatif')
            ->simplePaginate(10);

        // Render view with data
        return view('dashboard.perhitungan', [
            'penilaians' => $penilaians,

        ]);
    }

    public function cari(Request $request)
    {
        $cari = $request->cari;
        // Get penilaians with related alternatif names
        $penilaians = DB::table('penilaians')
            ->leftJoin('alternatifs as tabel_alternatif', 'penilaians.id_alternatif', '=', 'tabel_alternatif.id')
            ->select("penilaians.*", 'tabel_alternatif.nama as nama_alternatif')
            ->where('tabel_alternatif.nama', 'like', "%" . $cari . "%")
            ->get();

        // Render view with data
        return view('dashboard.perhitungan', [
            'penilaians' => $penilaians,

        ]);
    }

    public function show(string $id): View
    {
        $penilaian = DB::table('penilaians')
            ->where('penilaians.id', '=', $id)
            ->leftJoin('alternatifs as tabel_alternatif', 'penilaians.id_alternatif', '=', 'tabel_alternatif.id')
            ->leftJoin('jenis_variabels as tabel_jenis', 'penilaians.id_jenisVariabel', '=', 'tabel_jenis.id')
            ->select("penilaians.*", 'tabel_alternatif.nama as nama_alternatif', 'tabel_jenis.nama as nama_jenisVariabel')
            ->first();

        //START PERHITUNGAN RIWAYAT KETERLAMBATAN----------------------------------------------------------------------
        $rk_tidak_himpunan = DB::table('himpunans')
            ->leftJoin('kurvas as tabel_kurva', 'himpunans.id_kurva', '=', 'tabel_kurva.id')
            ->where('himpunans.id_variabel', '=', 1)->where('himpunans.nama', '=', 'Tidak Pernah')
            ->select("himpunans.*", 'tabel_kurva.nama as nama_kurva')
            ->first();

        $rk_jarang_himpunan = DB::table('himpunans')
            ->leftJoin('kurvas as tabel_kurva', 'himpunans.id_kurva', '=', 'tabel_kurva.id')
            ->where('himpunans.id_variabel', '=', 1)->where('himpunans.nama', '=', 'Jarang')
            ->select("himpunans.*", 'tabel_kurva.nama as nama_kurva')
            ->first();

        $rk_sering_himpunan = DB::table('himpunans')
            ->leftJoin('kurvas as tabel_kurva', 'himpunans.id_kurva', '=', 'tabel_kurva.id')
            ->where('himpunans.id_variabel', '=', 1)->where('himpunans.nama', '=', 'Sering')
            ->select("himpunans.*", 'tabel_kurva.nama as nama_kurva')
            ->first();

        //Hitung Himpunan
        if ($rk_tidak_himpunan->nama_kurva == "Linear Turun") {
            $rkResultA = $this->linearTurun($penilaian->rk, $rk_tidak_himpunan->a, $rk_tidak_himpunan->b);
        } elseif ($rk_tidak_himpunan->nama_kurva == "Linear Naik") {
            $rkResultA = $this->linearNaik($penilaian->rk, $rk_tidak_himpunan->a, $rk_tidak_himpunan->b);
        } elseif ($rk_tidak_himpunan->nama_kurva == "Segitiga") {
            $rkResultA = $this->segitiga($penilaian->rk, $rk_tidak_himpunan->a, $rk_tidak_himpunan->b, $rk_tidak_himpunan->c);
        } else {
            $rkResultA = $this->travesium($penilaian->rk, $rk_tidak_himpunan->a, $rk_tidak_himpunan->b, $rk_tidak_himpunan->c, $rk_tidak_himpunan->d);
        }

        if ($rk_jarang_himpunan->nama_kurva == "Linear Turun") {
            $rkResultB = $this->linearTurun($penilaian->rk, $rk_jarang_himpunan->a, $rk_jarang_himpunan->b);
        } elseif ($rk_jarang_himpunan->nama_kurva == "Linear Naik") {
            $rkResultB = $this->linearNaik($penilaian->rk, $rk_jarang_himpunan->a, $rk_jarang_himpunan->b);
        } elseif ($rk_jarang_himpunan->nama_kurva == "Segitiga") {
            $rkResultB = $this->segitiga($penilaian->rk, $rk_jarang_himpunan->a, $rk_jarang_himpunan->b, $rk_jarang_himpunan->c);
        } else {
            $rkResultB = $this->travesium($penilaian->rk, $rk_jarang_himpunan->a, $rk_jarang_himpunan->b, $rk_jarang_himpunan->c, $rk_jarang_himpunan->d);
        }

        if ($rk_sering_himpunan->nama_kurva == "Linear Turun") {
            $rkResultC = $this->linearTurun($penilaian->rk, $rk_sering_himpunan->a, $rk_sering_himpunan->b);
        } elseif ($rk_sering_himpunan->nama_kurva == "Linear Naik") {
            $rkResultC = $this->linearNaik($penilaian->rk, $rk_sering_himpunan->a, $rk_sering_himpunan->b);
        } elseif ($rk_sering_himpunan->nama_kurva == "Segitiga") {
            $rkResultC = $this->segitiga($penilaian->rk, $rk_sering_himpunan->a, $rk_sering_himpunan->b, $rk_sering_himpunan->c);
        } else {
            $rkResultC = $this->travesium($penilaian->rk, $rk_sering_himpunan->a, $rk_sering_himpunan->b, $rk_sering_himpunan->c, $rk_sering_himpunan->d);
        }
        //END PERHITUNGAN RIWAYAT KETERLAMBATAN----------------------------------------------------------------------

        //START PERHITUNGAN PENGHASILAN----------------------------------------------------------------------
        $penghasilan_tidak_himpunan = DB::table('himpunans')
            ->leftJoin('kurvas as tabel_kurva', 'himpunans.id_kurva', '=', 'tabel_kurva.id')
            ->where('himpunans.id_variabel', '=', 2)->where('himpunans.nama', '=', 'Kurang')
            ->select("himpunans.*", 'tabel_kurva.nama as nama_kurva')
            ->first();

        $penghasilan_jarang_himpunan = DB::table('himpunans')
            ->leftJoin('kurvas as tabel_kurva', 'himpunans.id_kurva', '=', 'tabel_kurva.id')
            ->where('himpunans.id_variabel', '=', 2)->where('himpunans.nama', '=', 'Cukup')
            ->select("himpunans.*", 'tabel_kurva.nama as nama_kurva')
            ->first();

        $penghasilan_sering_himpunan = DB::table('himpunans')
            ->leftJoin('kurvas as tabel_kurva', 'himpunans.id_kurva', '=', 'tabel_kurva.id')
            ->where('himpunans.id_variabel', '=', 2)->where('himpunans.nama', '=', 'Banyak')
            ->select("himpunans.*", 'tabel_kurva.nama as nama_kurva')
            ->first();

        //Hitung Himpunan
        // linguistik kurang
        if ($penghasilan_tidak_himpunan->nama_kurva == "Linear Turun") {
            $penghasilanResultA = $this->linearTurun($penilaian->penghasilan, $penghasilan_tidak_himpunan->a, $penghasilan_tidak_himpunan->b);
        } elseif ($penghasilan_tidak_himpunan->nama_kurva == "Linear Naik") {
            $penghasilanResultA = $this->linearNaik($penilaian->penghasilan, $penghasilan_tidak_himpunan->a, $penghasilan_tidak_himpunan->b);

        } elseif ($penghasilan_tidak_himpunan->nama_kurva == "Segitiga") {
            $penghasilanResultA = $this->segitiga($penilaian->penghasilan, $penghasilan_tidak_himpunan->a, $penghasilan_tidak_himpunan->b, $penghasilan_tidak_himpunan->c);
        } else {
            $penghasilanResultA = $this->travesium($penilaian->penghasilan, $penghasilan_tidak_himpunan->a, $penghasilan_tidak_himpunan->b, $penghasilan_tidak_himpunan->c, $penghasilan_tidak_himpunan->d);
        }
// linguistik cukup
        if ($penghasilan_jarang_himpunan->nama_kurva == "Linear Turun") {
            $penghasilanResultB = $this->linearTurun($penilaian->penghasilan, $penghasilan_jarang_himpunan->a - 1, $penghasilan_jarang_himpunan->b);
            if ($penghasilanResultB   ) {
                $penghasilanResultA = 0;
            }
        } elseif ($penghasilan_jarang_himpunan->nama_kurva == "Linear Naik") {
            $penghasilanResultB = $this->linearNaik($penilaian->penghasilpenghasilan, $penghasilan_jarang_himpunan->a - 1, $penghasilan_jarang_himpunan->b);
            if ($penghasilanResultB   ) {
                $penghasilanResultA = 0;
            }
        } elseif ($penghasilan_jarang_himpunan->nama_kurva == "Segitiga") {
            $penghasilanResultB = $this->segitiga($penilaian->penghasilan, $penghasilan_jarang_himpunan->a - 1, $penghasilan_jarang_himpunan->b, $penghasilan_jarang_himpunan->c);
            if ($penghasilanResultB   ) {
                $penghasilanResultA = 0;
            }
        } else {
            $penghasilanResultB = $this->travesium($penilaian->penghasilan, $penghasilan_jarang_himpunan->a - 1, $penghasilan_jarang_himpunan->b, $penghasilan_jarang_himpunan->c, $penghasilan_jarang_himpunan->d);
            if ($penghasilanResultB   ) {
                $penghasilanResultA = 0;
            }
        }

         // linguistik baik

        if ($penghasilan_sering_himpunan->nama_kurva == "Linear Turun") {
            $penghasilanResultC = $this->linearTurun($penilaian->penghasilan, $penghasilan_sering_himpunan->a - 1, $penghasilan_sering_himpunan->b);
            if ( $penghasilanResultC   ) {
                 $penghasilanResultB = 0;
            }
        } elseif ($penghasilan_sering_himpunan->nama_kurva == "Linear Naik") {
            $penghasilanResultC = $this->linearNaik($penilaian->penghasilan, $penghasilan_sering_himpunan->a - 1, $penghasilan_sering_himpunan->b);
            // if ($penghasilanResultB > 0) {
            //     $penghasilanResultB = 0;
            // }
          
            if ( $penghasilanResultC   ) {
                $penghasilanResultB = 0;
            }
           
        } elseif ($penghasilan_sering_himpunan->nama_kurva == "Segitiga") {
            $penghasilanResultC = $this->segitiga($penilaian->penghasilan, $penghasilan_sering_himpunan->a - 1, $penghasilan_sering_himpunan->b, $penghasilan_sering_himpunan->c);
            if ( $penghasilanResultC   ) {
                $penghasilanResultB = 0;
            }
        } else {
            $penghasilanResultC = $this->travesium($penilaian->penghasilan, $penghasilan_sering_himpunan->a - 1, $penghasilan_sering_himpunan->b, $penghasilan_sering_himpunan->c, $penghasilan_sering_himpunan->d);
            if ( $penghasilanResultC   ) {
                $penghasilanResultB = 0;
            }
        }
       
        //END PERHITUNGAN PENGHASILAN----------------------------------------------------------------------

        //START PERHITUNGAN TANGGUNGAN----------------------------------------------------------------------
        $tanggungan_tidak_himpunan = DB::table('himpunans')
            ->leftJoin('kurvas as tabel_kurva', 'himpunans.id_kurva', '=', 'tabel_kurva.id')
            ->where('himpunans.id_variabel', '=', 3)->where('himpunans.nama', '=', 'Sedikit')
            ->select("himpunans.*", 'tabel_kurva.nama as nama_kurva')
            ->first();

        $tanggungan_jarang_himpunan = DB::table('himpunans')
            ->leftJoin('kurvas as tabel_kurva', 'himpunans.id_kurva', '=', 'tabel_kurva.id')
            ->where('himpunans.id_variabel', '=', 3)->where('himpunans.nama', '=', 'Cukup')
            ->select("himpunans.*", 'tabel_kurva.nama as nama_kurva')
            ->first();

        $tanggungan_sering_himpunan = DB::table('himpunans')
            ->leftJoin('kurvas as tabel_kurva', 'himpunans.id_kurva', '=', 'tabel_kurva.id')
            ->where('himpunans.id_variabel', '=', 3)->where('himpunans.nama', '=', 'Banyak')
            ->select("himpunans.*", 'tabel_kurva.nama as nama_kurva')
            ->first();

        //Hitung Himpunan
        if ($tanggungan_tidak_himpunan->nama_kurva == "Linear Turun") {
            $tanggunganResultA = $this->linearTurun($penilaian->tanggungan, $tanggungan_tidak_himpunan->a, $tanggungan_tidak_himpunan->b);
        } elseif ($tanggungan_tidak_himpunan->nama_kurva == "Linear Naik") {
            $tanggunganResultA = $this->linearNaik($penilaian->tanggungan, $tanggungan_tidak_himpunan->a, $tanggungan_tidak_himpunan->b);
        } elseif ($tanggungan_tidak_himpunan->nama_kurva == "Segitiga") {
            $tanggunganResultA = $this->segitiga($penilaian->tanggungan, $tanggungan_tidak_himpunan->a, $tanggungan_tidak_himpunan->b, $tanggungan_tidak_himpunan->c);
        } else {
            $tanggunganResultA = $this->travesium($penilaian->tanggungan, $tanggungan_tidak_himpunan->a, $tanggungan_tidak_himpunan->b, $tanggungan_tidak_himpunan->c, $tanggungan_tidak_himpunan->d);
        }

        if ($tanggungan_jarang_himpunan->nama_kurva == "Linear Turun") {
            $tanggunganResultB = $this->linearTurun($penilaian->tanggungan, $tanggungan_jarang_himpunan->a, $tanggungan_jarang_himpunan->b);
        } elseif ($tanggungan_jarang_himpunan->nama_kurva == "Linear Naik") {
            $tanggunganResultB = $this->linearNaik($penilaian->tanggungan, $tanggungan_jarang_himpunan->a, $tanggungan_jarang_himpunan->b);
        } elseif ($tanggungan_jarang_himpunan->nama_kurva == "Segitiga") {
            $tanggunganResultB = $this->segitiga($penilaian->tanggungan, $tanggungan_jarang_himpunan->a, $tanggungan_jarang_himpunan->b, $tanggungan_jarang_himpunan->c);
        } else {
            $tanggunganResultB = $this->travesium($penilaian->tanggungan, $tanggungan_jarang_himpunan->a, $tanggungan_jarang_himpunan->b, $tanggungan_jarang_himpunan->c, $tanggungan_jarang_himpunan->d);
        }

        if ($tanggungan_sering_himpunan->nama_kurva == "Linear Turun") {
            $tanggunganResultC = $this->linearTurun($penilaian->tanggungan, $tanggungan_sering_himpunan->a, $tanggungan_sering_himpunan->b);
        } elseif ($tanggungan_sering_himpunan->nama_kurva == "Linear Naik") {
            $tanggunganResultC = $this->linearNaik($penilaian->tanggungan, $tanggungan_sering_himpunan->a, $tanggungan_sering_himpunan->b);
        } elseif ($tanggungan_sering_himpunan->nama_kurva == "Segitiga") {
            $tanggunganResultC = $this->segitiga($penilaian->tanggungan, $tanggungan_sering_himpunan->a, $tanggungan_sering_himpunan->b, $tanggungan_sering_himpunan->c);
        } else {
            $tanggunganResultC = $this->travesium($penilaian->tanggungan, $tanggungan_sering_himpunan->a, $tanggungan_sering_himpunan->b, $tanggungan_sering_himpunan->c, $tanggungan_sering_himpunan->d);
        }
        //END PERHITUNGAN TANGGUNGAN----------------------------------------------------------------------

        //START PERHITUNGAN JAMINAN----------------------------------------------------------------------
        $jaminan_tidak_himpunan = DB::table('himpunans')
            ->leftJoin('kurvas as tabel_kurva', 'himpunans.id_kurva', '=', 'tabel_kurva.id')
            ->where('himpunans.id_variabel', '=', 4)->where('himpunans.nama', '=', 'Kurang')
            ->select("himpunans.*", 'tabel_kurva.nama as nama_kurva')
            ->first();

        $jaminan_jarang_himpunan = DB::table('himpunans')
            ->leftJoin('kurvas as tabel_kurva', 'himpunans.id_kurva', '=', 'tabel_kurva.id')
            ->where('himpunans.id_variabel', '=', 4)->where('himpunans.nama', '=', 'Cukup')
            ->select("himpunans.*", 'tabel_kurva.nama as nama_kurva')
            ->first();

        $jaminan_sering_himpunan = DB::table('himpunans')
            ->leftJoin('kurvas as tabel_kurva', 'himpunans.id_kurva', '=', 'tabel_kurva.id')
            ->where('himpunans.id_variabel', '=', 4)->where('himpunans.nama', '=', 'Baik')
            ->select("himpunans.*", 'tabel_kurva.nama as nama_kurva')
            ->first();
            

        //Hitung Himpunan
        if ($jaminan_tidak_himpunan->nama_kurva == "Linear Turun") {
            $jaminanResultA = $this->linearTurun($penilaian->jaminan, $jaminan_tidak_himpunan->a, $jaminan_tidak_himpunan->b);
        } elseif ($jaminan_tidak_himpunan->nama_kurva == "Linear Naik") {
            $jaminanResultA = $this->linearNaik($penilaian->jaminan, $jaminan_tidak_himpunan->a, $jaminan_tidak_himpunan->b);
            
        } elseif ($jaminan_tidak_himpunan->nama_kurva == "Segitiga") {
            $jaminanResultA = $this->segitiga($penilaian->jaminan, $jaminan_tidak_himpunan->a, $jaminan_tidak_himpunan->b, $jaminan_tidak_himpunan->c);
        } else {
            $jaminanResultA = $this->travesium($penilaian->jaminan, $jaminan_tidak_himpunan->a, $jaminan_tidak_himpunan->b, $jaminan_tidak_himpunan->c, $jaminan_tidak_himpunan->d);
        }

        if ($jaminan_jarang_himpunan->nama_kurva == "Linear Turun") {
            $jaminanResultB = $this->linearTurun($penilaian->jaminan, $jaminan_jarang_himpunan->a- 1, $jaminan_jarang_himpunan->b);
            if ($jaminanResultB   ) {
                
                $jaminanResultA  = 0;
                
            }

            
        } elseif ($jaminan_jarang_himpunan->nama_kurva == "Linear Naik") {
            $jaminanResultB = $this->linearNaik($penilaian->jaminan, $jaminan_jarang_himpunan->a- 1, $jaminan_jarang_himpunan->b);
            if ($jaminanResultB   ) {
                
                $jaminanResultA  = 0;
            }
        } elseif ($jaminan_jarang_himpunan->nama_kurva == "Segitiga") {
            $jaminanResultB = $this->segitiga($penilaian->jaminan, $jaminan_jarang_himpunan->a -1 , $jaminan_jarang_himpunan->b, $jaminan_jarang_himpunan->c);
            // if ($jaminanResultA > 0) {
            //     $jaminanResultA = 0;
            // }
            if ($jaminanResultB   ) {
                $jaminanResultA  = 0;
            }
        } else {
            $jaminanResultB = $this->travesium($penilaian->jaminan, $jaminan_jarang_himpunan->a - 1, $jaminan_jarang_himpunan->b, $jaminan_jarang_himpunan->c, $jaminan_jarang_himpunan->d);
            if ($jaminanResultB   ) {
                $jaminanResultA  = 0;
            }
        }


        if ($jaminan_sering_himpunan->nama_kurva == "Linear Turun") {
            $jaminanResultC = $this->linearTurun($penilaian->jaminan, $jaminan_sering_himpunan->a- 1, $jaminan_sering_himpunan->b);
            if ($jaminanResultC   ) {
                 $jaminanResultB  = 0;
            }
        } elseif ($jaminan_sering_himpunan->nama_kurva == "Linear Naik") {
            $jaminanResultC = $this->linearNaik($penilaian->jaminan, $jaminan_sering_himpunan->a-1, $jaminan_sering_himpunan->b);
            // if ($jaminanResultB > 0) {
            //     $jaminanResultB = 01;
            // }
            if ($jaminanResultC   ) {
                 $jaminanResultB  = 0;
            }
        } elseif ($jaminan_sering_himpunan->nama_kurva == "Segitiga") {
            $jaminanResultC = $this->segitiga($penilaian->jaminan, $jaminan_sering_himpunan->a- 1, $jaminan_sering_himpunan->b, $jaminan_sering_himpunan->c);
            if ($jaminanResultC   ) {
                $jaminanResultB  = 0;
            }
        } else {
            $jaminanResultC = $this->travesium($penilaian->jaminan, $jaminan_sering_himpunan->a -1, $jaminan_sering_himpunan->b, $jaminan_sering_himpunan->c, $jaminan_sering_himpunan->d);
            if ($jaminanResultC   ) {
                $jaminanResultB  = 0;
            }
        }
        //END PERHITUNGAN JAMINAN----------------------------------------------------------------------


        //START INFERENSI-------------------------------------------------------------------------------------------

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

        $inferensi = [];

        foreach ($aturans as $aturan) {
            //Pencocokan Aturan dengan Hasil Himpunan
            if ($aturan->rk_nama == 'Tidak Pernah') {
                $riwayat_keterlambatan = $rkResultA;
            } elseif ($aturan->rk_nama == 'Jarang') {
                $riwayat_keterlambatan = $rkResultB;
            } else {
                $riwayat_keterlambatan = $rkResultC;
            }

            if ($aturan->penghasilan_nama == 'Kurang') {
                $penghasilan = $penghasilanResultA;
            } elseif ($aturan->penghasilan_nama == 'Cukup') {
                
                $penghasilan = $penghasilanResultB;
            } else {
                $penghasilan = $penghasilanResultC;
            }

            if ($aturan->tanggungan_nama == 'Sedikit') {
                $tanggungan = $tanggunganResultA;
            } elseif ($aturan->tanggungan_nama == 'Cukup') {
                $tanggungan = $tanggunganResultB;
            } else {
                $tanggungan = $tanggunganResultC;
            }

            if ($aturan->jaminan_nama == 'Kurang') {
                $jaminan = $jaminanResultA;
            } elseif ($aturan->jaminan_nama == 'Cukup') {
                $jaminan = $jaminanResultB;
            } else {
                $jaminan = $jaminanResultC;
            }

            $hasilPersamaan = min($riwayat_keterlambatan, $penghasilan, $tanggungan, $jaminan);

            // Add the result to the array
            $inferensi[] = [
                'rk_nama' => $riwayat_keterlambatan,
                'penghasilan_nama' => $penghasilan,
                'tanggungan_nama' => $tanggungan,
                'jaminan_nama' => $jaminan,
                'hasil' => $aturan->hasil,
                'hasil_persamaan' => $hasilPersamaan,
            ];
        }
        //END INFERENSI-------------------------------------------------------------------------------------------------


        //START HITUNG LINGUISTIK-----------------------------------------------------------------------------------------------
        // if ($penilaian->rk <= max($rk_tidak_himpunan->a, $rk_tidak_himpunan->b, $rk_tidak_himpunan->c, $rk_tidak_himpunan->d)) {
        //     $linguistik_rk = 'Tidak Pernah';
        // } else if ($penilaian->rk <= max($rk_jarang_himpunan->a, $rk_jarang_himpunan->b, $rk_jarang_himpunan->c, $rk_jarang_himpunan->d)) {
        //     if (($penilaian->rk == $rk_jarang_himpunan->d)) {
        //         $linguistik_rk = 'Sering';
        //     } else {
        //         $linguistik_rk = 'Jarang';
        //     }
        //     $linguistik_rk = 'Jarang';
        // } else {
        //     $linguistik_rk = 'Sering';
        // }

        if($penilaian->rk <= $rk_jarang_himpunan->a){
            $linguistik_rk = 'Tidak Pernah';
        }else if($penilaian->rk >= $rk_jarang_himpunan->a && $penilaian->rk < $rk_sering_himpunan->a){
            $linguistik_rk = 'Jarang';
        }else if($penilaian->rk >= $rk_sering_himpunan->a){
            $linguistik_rk = 'Sering';
        }
        

        // if ($penilaian->penghasilan < max($penghasilan_tidak_himpunan->a, $penghasilan_tidak_himpunan->b, $penghasilan_tidak_himpunan->c, $penghasilan_tidak_himpunan->d)) {
        //     if ($penghasilan_tidak_himpunan->b > $penghasilan_jarang_himpunan->a) {
        //         $linguistik_penghasilan = 'Cukup';
        //     } else {
        //         $linguistik_penghasilan = 'Kurang';
        //     }
        //     // $linguistik_penghasilan = 'Kurang';
        // } else if ($penilaian->penghasilan <= max($penghasilan_jarang_himpunan->a, $penghasilan_jarang_himpunan->b, $penghasilan_jarang_himpunan->c, $penghasilan_jarang_himpunan->d)) {
        //     if (($penilaian->penghasilan == $penghasilan_jarang_himpunan->d)) {

        //         $linguistik_penghasilan = 'Banyak';
        //     } else {
        //         if ($penghasilan_sering_himpunan->a < $penghasilan_jarang_himpunan->c) {
                    
        //             $linguistik_penghasilan = 'Banyak';
        //         } else {
        //             $linguistik_penghasilan = 'Cukup';
        //         }
        //     }
        //     // $linguistik_penghasilan = 'Cukup';  
        // } else {
        //     $linguistik_penghasilan = 'Banyak';
        // }

        if($penilaian->penghasilan < $penghasilan_jarang_himpunan->a){
            $linguistik_penghasilan = 'Kurang';
        }else if($penilaian->penghasilan >= $penghasilan_jarang_himpunan->a && $penilaian->penghasilan < $penghasilan_sering_himpunan->a){
            $linguistik_penghasilan = 'Cukup';
        }else if($penilaian->penghasilan >= $penghasilan_sering_himpunan->a){
            $linguistik_penghasilan = 'Banyak';
        }

        // if ($penilaian->tanggungan <= max($tanggungan_tidak_himpunan->a, $tanggungan_tidak_himpunan->b, $tanggungan_tidak_himpunan->c, $tanggungan_tidak_himpunan->d)) {
        //     $linguistik_tanggungan = 'Sedikit';
        // } else if ($penilaian->tanggungan <= max($tanggungan_jarang_himpunan->a, $tanggungan_jarang_himpunan->b, $tanggungan_jarang_himpunan->c, $tanggungan_jarang_himpunan->d)) {
        //     if (($penilaian->tanggungan == $tanggungan_jarang_himpunan->d)) {
        //         $linguistik_tanggungan = 'Banyak';
        //     } else {
        //         $linguistik_tanggungan = 'Cukup';
        //     }
        //     $linguistik_tanggungan = 'Cukup';
        // } else {
        //     $linguistik_tanggungan = 'Banyak';
        // }
        if($penilaian->tanggungan <= $tanggungan_jarang_himpunan->a){
            $linguistik_tanggungan = 'Sedikit';
        }else if($penilaian->tanggungan >= $tanggungan_jarang_himpunan->a && $penilaian->tanggungan <= $tanggungan_sering_himpunan->a){
            $linguistik_tanggungan = 'Cukup';
        }else if($penilaian->tanggungan > $tanggungan_sering_himpunan->a){
            $linguistik_tanggungan = 'Banyak';
        }
        


        // if ($penilaian->jaminan <= max($jaminan_tidak_himpunan->a, $jaminan_tidak_himpunan->b, $jaminan_tidak_himpunan->c, $jaminan_tidak_himpunan->d)) {
        //     if ($jaminan_tidak_himpunan->b > $jaminan_jarang_himpunan->a) {
        //         $linguistik_jaminan = 'Cukup';
        //     } else {
        //         $linguistik_jaminan = 'Kurang';
        //     }
        //     $linguistik_jaminan = 'Kurang';
        // } else if ($penilaian->jaminan <= max($jaminan_jarang_himpunan->a, $jaminan_jarang_himpunan->b, $jaminan_jarang_himpunan->c, $jaminan_jarang_himpunan->d)) {
        //     $linguistik_jaminan = 'Cukup';
        //     if (($penilaian->jaminan == $jaminan_jarang_himpunan->d)) {

        //         $linguistik_jaminan = 'Baik';
        //     } else {
        //         if ($jaminan_sering_himpunan->a < $jaminan_jarang_himpunan->c) {
                    
        //             $linguistik_jaminan = 'Baik';
        //         } else {
        //             $linguistik_jaminan = 'Cukup';
        //         }
        //     }
        // } else {
        //     $linguistik_jaminan = 'Baik';
        // }

        if($penilaian->jaminan < $jaminan_jarang_himpunan->a){
            $linguistik_jaminan = 'Kurang';
        }else if($penilaian->jaminan >= $jaminan_jarang_himpunan->a && $penilaian->jaminan < $jaminan_sering_himpunan->a){
            $linguistik_jaminan = 'Cukup';
        }else if($penilaian->jaminan >= $jaminan_sering_himpunan->a){
            $linguistik_jaminan = 'Baik';
        }
        //END HITUNG LINGUISTIK-------------------------------------------------------------------------------------------------

        //START PENCOCOKAN RULE DENGAN INPUT--------------------------------------------------------------------------
        $maxHasilPersamaan = -1; // Initialize with a value lower than the possible hasil_persamaan
        $selectedRule = null;
        foreach ($inferensi as $rule) {
            if ($rule['hasil_persamaan'] >= $maxHasilPersamaan) {
                $maxHasilPersamaan = $rule['hasil_persamaan'];
                $selectedRule = $rule;
            }
        }
        // dd($selectedRule);
        //END PENCOCOKAN RULE DENGAN INPUT--------------------------------------------------------------------------

        //START FINAL RESULT-------------------------------------------------------------------------------------------- 
        $totalWeight = 0;
        $weightedSum = 0;

        foreach ($inferensi as $index => $result) {
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
        //END FIINAL RESULT-------------------------------------------------------------------------------------------- 
// dd($linguistik_tanggungan);
        return view('dashboard.perhitunganShow', [
            'penilaian' => $penilaian,
            'inferensi' => $inferensi,
            'finalResult' => $finalResult,
            'linguistik_rk' => $linguistik_rk,
            'linguistik_penghasilan' => $linguistik_penghasilan,
            'linguistik_tanggungan' => $linguistik_tanggungan,
            'linguistik_jaminan' => $linguistik_jaminan,
            'selectedRule' => $selectedRule,
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
