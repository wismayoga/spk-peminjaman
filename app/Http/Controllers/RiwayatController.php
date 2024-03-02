<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $penilaians = DB::table('penilaians')
            ->leftJoin('alternatifs as tabel_alternatif', 'penilaians.id_alternatif', '=', 'tabel_alternatif.id')
            ->leftJoin('jenis_variabels as tabel_variabel', 'penilaians.id_jenisVariabel', '=', 'tabel_variabel.id')
            ->select("penilaians.*", 'tabel_alternatif.nama as nama_alternatif', 'tabel_alternatif.alamat as alamat', 'tabel_variabel.nama as nama_variabel');

        // Apply filter based on selected "alamat"
        if ($request->has('alamat') && !empty($request->alamat)) {
            $penilaians->where('tabel_alternatif.alamat', $request->alamat);
        }

        $penilaians = $penilaians->get();

        // Initialize status array
        $status = [];

        // Loop through penilaians
        foreach ($penilaians as $penilaian) {
            // Call the perhitungan method and store the result in $perhitungan
            $perhitungan = $this->perhitungan($penilaian);

            // Get the final result from perhitungan and store it in $result
            $result = $perhitungan['finalResult'];

            // Add the result to the $status array
            $status[] = $result;
        }

        return view('dashboard.riwayat', [
            'penilaians' => $penilaians,
            'status' => $status,
        ]);
    }

    // public function printByMonth(Request $request)
    // {
    //     $month = $request->input('month');

    //     $penilaians = $this->getPenilaiansByDate('month', $month, $request);

    //     $type = $request->has('month') ? 'month' : 'year';
    //     $value = $request->input('month') ?? $request->input('year');
    //     // dd($penilaians);
    //     return view('dashboard.pdf', [
    //         'penilaians' => $penilaians,
    //         'type' => $type,
    //         'value' => $value,
    //     ]);
    // }

    public function printByMonth(Request $request)
{
    $month = $request->input('month');
    $penilaians = $this->getPenilaiansByDate('month', $month, $request);

    $type = $request->has('month') ? 'month' : 'year';
    $value = $request->input('month') ?? $request->input('year');

    // Load your HTML view into Dompdf
    $html = view('dashboard.pdf', [
        'penilaians' => $penilaians,
        'type' => $type,
        'value' => $value,
    ])->render();

    // Generate the PDF
    $pdf = PDF::loadHtml($html);

    // Set paper size and orientation (optional)
    $pdf->setPaper('A4', 'portrait');

    // Output the PDF (inline download)
    return $pdf->stream("document.pdf");

    // Alternatively, you can save the PDF to a file
    // return $pdf->save("path/to/your/file.pdf");

    // Or directly send the PDF as a download response
    // return $pdf->download("document.pdf");
}

    public function printByYear(Request $request)
    {
        $year = $request->input('year');

        $penilaians = $this->getPenilaiansByDate('year', $year, $request);

        $type = $request->has('month') ? 'month' : 'year';
        $value = $request->input('month') ?? $request->input('year');
        // dd($penilaians);
        return view('dashboard.pdf', [
            'penilaians' => $penilaians,
            'type' => $type,
            'value' => $value,
        ]);
    }

    private function getPenilaiansByDate($type, $value, $request)
    {
        $penilaians = DB::table('penilaians')
            ->leftJoin('alternatifs as tabel_alternatif', 'penilaians.id_alternatif', '=', 'tabel_alternatif.id')
            ->leftJoin('jenis_variabels as tabel_variabel', 'penilaians.id_jenisVariabel', '=', 'tabel_variabel.id')
            ->select("penilaians.*", 'tabel_alternatif.nama as nama_alternatif', 'tabel_alternatif.alamat as alamat', 'tabel_variabel.nama as nama_variabel');
        // dd($penilaians->get());

        // Apply filter based on the selected date (month or year)
        if ($type === 'month') {
            $penilaians->whereMonth('penilaians.created_at', date('m', strtotime($value))); // Extract month from the date
            $penilaians->whereYear('penilaians.created_at', date('Y', strtotime($value))); // Extract year from the date
        } elseif ($type === 'year') {
            $penilaians->whereYear('penilaians.created_at', $value);
        }

        $penilaians = $penilaians->get();

        // Filter penilaians to include only those with status equal to 1
        $filteredPenilaians = $penilaians->filter(function ($penilaian) {
            $perhitungan = $this->perhitungan($penilaian);
            return $perhitungan['finalResult'] == 1;
        });

        // Initialize status array
        $status = $filteredPenilaians->pluck('status')->toArray();

        return $filteredPenilaians;
    }


    public function perhitungan($penilaian)
    {
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

        $perhitunganController = new PerhitunganController();

        //Hitung Himpunan
        if ($rk_tidak_himpunan->nama_kurva == "Linear Turun") {
            $rkResultA = $perhitunganController->linearTurun($penilaian->rk, $rk_tidak_himpunan->a, $rk_tidak_himpunan->b);
        } elseif ($rk_tidak_himpunan->nama_kurva == "Linear Naik") {
            $rkResultA = $perhitunganController->linearNaik($penilaian->rk, $rk_tidak_himpunan->a, $rk_tidak_himpunan->b);
        } elseif ($rk_tidak_himpunan->nama_kurva == "Segitiga") {
            $rkResultA = $perhitunganController->segitiga($penilaian->rk, $rk_tidak_himpunan->a, $rk_tidak_himpunan->b, $rk_tidak_himpunan->c);
        } else {
            $rkResultA = $perhitunganController->travesium($penilaian->rk, $rk_tidak_himpunan->a, $rk_tidak_himpunan->b, $rk_tidak_himpunan->c, $rk_tidak_himpunan->d);
        }

        if ($rk_jarang_himpunan->nama_kurva == "Linear Turun") {
            $rkResultB = $perhitunganController->linearTurun($penilaian->rk, $rk_jarang_himpunan->a, $rk_jarang_himpunan->b);
        } elseif ($rk_jarang_himpunan->nama_kurva == "Linear Naik") {
            $rkResultB = $perhitunganController->linearNaik($penilaian->rk, $rk_jarang_himpunan->a, $rk_jarang_himpunan->b);
        } elseif ($rk_jarang_himpunan->nama_kurva == "Segitiga") {
            $rkResultB = $perhitunganController->segitiga($penilaian->rk, $rk_jarang_himpunan->a, $rk_jarang_himpunan->b, $rk_jarang_himpunan->c);
        } else {
            $rkResultB = $perhitunganController->travesium($penilaian->rk, $rk_jarang_himpunan->a, $rk_jarang_himpunan->b, $rk_jarang_himpunan->c, $rk_jarang_himpunan->d);
        }

        if ($rk_sering_himpunan->nama_kurva == "Linear Turun") {
            $rkResultC = $perhitunganController->linearTurun($penilaian->rk, $rk_sering_himpunan->a, $rk_sering_himpunan->b);
        } elseif ($rk_sering_himpunan->nama_kurva == "Linear Naik") {
            $rkResultC = $perhitunganController->linearNaik($penilaian->rk, $rk_sering_himpunan->a, $rk_sering_himpunan->b);
        } elseif ($rk_sering_himpunan->nama_kurva == "Segitiga") {
            $rkResultC = $perhitunganController->segitiga($penilaian->rk, $rk_sering_himpunan->a, $rk_sering_himpunan->b, $rk_sering_himpunan->c);
        } else {
            $rkResultC = $perhitunganController->travesium($penilaian->rk, $rk_sering_himpunan->a, $rk_sering_himpunan->b, $rk_sering_himpunan->c, $rk_sering_himpunan->d);
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
        if ($penghasilan_tidak_himpunan->nama_kurva == "Linear Turun") {
            $penghasilanResultA = $perhitunganController->linearTurun($penilaian->penghasilan, $penghasilan_tidak_himpunan->a, $penghasilan_tidak_himpunan->b);
        } elseif ($penghasilan_tidak_himpunan->nama_kurva == "Linear Naik") {
            $penghasilanResultA = $perhitunganController->linearNaik($penilaian->penghasilan, $penghasilan_tidak_himpunan->a, $penghasilan_tidak_himpunan->b);
        } elseif ($penghasilan_tidak_himpunan->nama_kurva == "Segitiga") {
            $penghasilanResultA = $perhitunganController->segitiga($penilaian->penghasilan, $penghasilan_tidak_himpunan->a, $penghasilan_tidak_himpunan->b, $penghasilan_tidak_himpunan->c);
        } else {
            $penghasilanResultA = $perhitunganController->travesium($penilaian->penghasilan, $penghasilan_tidak_himpunan->a, $penghasilan_tidak_himpunan->b, $penghasilan_tidak_himpunan->c, $penghasilan_tidak_himpunan->d);
        }

        if ($penghasilan_jarang_himpunan->nama_kurva == "Linear Turun") {
            $penghasilanResultB = $perhitunganController->linearTurun($penilaian->penghasilan, $penghasilan_jarang_himpunan->a, $penghasilan_jarang_himpunan->b);
        } elseif ($penghasilan_jarang_himpunan->nama_kurva == "Linear Naik") {
            $penghasilanResultB = $perhitunganController->linearNaik($penilaian->penghasilpenghasilan, $penghasilan_jarang_himpunan->a, $penghasilan_jarang_himpunan->b);
        } elseif ($penghasilan_jarang_himpunan->nama_kurva == "Segitiga") {
            $penghasilanResultB = $perhitunganController->segitiga($penilaian->penghasilan, $penghasilan_jarang_himpunan->a, $penghasilan_jarang_himpunan->b, $penghasilan_jarang_himpunan->c);
        } else {
            $penghasilanResultB = $perhitunganController->travesium($penilaian->penghasilan, $penghasilan_jarang_himpunan->a, $penghasilan_jarang_himpunan->b, $penghasilan_jarang_himpunan->c, $penghasilan_jarang_himpunan->d);
        }

        if ($penghasilan_sering_himpunan->nama_kurva == "Linear Turun") {
            $penghasilanResultC = $perhitunganController->linearTurun($penilaian->penghasilan, $penghasilan_sering_himpunan->a, $penghasilan_sering_himpunan->b);
        } elseif ($penghasilan_sering_himpunan->nama_kurva == "Linear Naik") {
            $penghasilanResultC = $perhitunganController->linearNaik($penilaian->penghasilan, $penghasilan_sering_himpunan->a, $penghasilan_sering_himpunan->b);
        } elseif ($penghasilan_sering_himpunan->nama_kurva == "Segitiga") {
            $penghasilanResultC = $perhitunganController->segitiga($penilaian->penghasilan, $penghasilan_sering_himpunan->a, $penghasilan_sering_himpunan->b, $penghasilan_sering_himpunan->c);
        } else {
            $penghasilanResultC = $perhitunganController->travesium($penilaian->penghasilan, $penghasilan_sering_himpunan->a, $penghasilan_sering_himpunan->b, $penghasilan_sering_himpunan->c, $penghasilan_sering_himpunan->d);
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
            $tanggunganResultA = $perhitunganController->linearTurun($penilaian->tanggungan, $tanggungan_tidak_himpunan->a, $tanggungan_tidak_himpunan->b);
        } elseif ($tanggungan_tidak_himpunan->nama_kurva == "Linear Naik") {
            $tanggunganResultA = $perhitunganController->linearNaik($penilaian->tanggungan, $tanggungan_tidak_himpunan->a, $tanggungan_tidak_himpunan->b);
        } elseif ($tanggungan_tidak_himpunan->nama_kurva == "Segitiga") {
            $tanggunganResultA = $perhitunganController->segitiga($penilaian->tanggungan, $tanggungan_tidak_himpunan->a, $tanggungan_tidak_himpunan->b, $tanggungan_tidak_himpunan->c);
        } else {
            $tanggunganResultA = $perhitunganController->travesium($penilaian->tanggungan, $tanggungan_tidak_himpunan->a, $tanggungan_tidak_himpunan->b, $tanggungan_tidak_himpunan->c, $tanggungan_tidak_himpunan->d);
        }

        if ($tanggungan_jarang_himpunan->nama_kurva == "Linear Turun") {
            $tanggunganResultB = $perhitunganController->linearTurun($penilaian->tanggungan, $tanggungan_jarang_himpunan->a, $tanggungan_jarang_himpunan->b);
        } elseif ($tanggungan_jarang_himpunan->nama_kurva == "Linear Naik") {
            $tanggunganResultB = $perhitunganController->linearNaik($penilaian->tanggungan, $tanggungan_jarang_himpunan->a, $tanggungan_jarang_himpunan->b);
        } elseif ($tanggungan_jarang_himpunan->nama_kurva == "Segitiga") {
            $tanggunganResultB = $perhitunganController->segitiga($penilaian->tanggungan, $tanggungan_jarang_himpunan->a, $tanggungan_jarang_himpunan->b, $tanggungan_jarang_himpunan->c);
        } else {
            $tanggunganResultB = $perhitunganController->travesium($penilaian->tanggungan, $tanggungan_jarang_himpunan->a, $tanggungan_jarang_himpunan->b, $tanggungan_jarang_himpunan->c, $tanggungan_jarang_himpunan->d);
        }

        if ($tanggungan_sering_himpunan->nama_kurva == "Linear Turun") {
            $tanggunganResultC = $perhitunganController->linearTurun($penilaian->tanggungan, $tanggungan_sering_himpunan->a, $tanggungan_sering_himpunan->b);
        } elseif ($tanggungan_sering_himpunan->nama_kurva == "Linear Naik") {
            $tanggunganResultC = $perhitunganController->linearNaik($penilaian->tanggungan, $tanggungan_sering_himpunan->a, $tanggungan_sering_himpunan->b);
        } elseif ($tanggungan_sering_himpunan->nama_kurva == "Segitiga") {
            $tanggunganResultC = $perhitunganController->segitiga($penilaian->tanggungan, $tanggungan_sering_himpunan->a, $tanggungan_sering_himpunan->b, $tanggungan_sering_himpunan->c);
        } else {
            $tanggunganResultC = $perhitunganController->travesium($penilaian->tanggungan, $tanggungan_sering_himpunan->a, $tanggungan_sering_himpunan->b, $tanggungan_sering_himpunan->c, $tanggungan_sering_himpunan->d);
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
            $jaminanResultA = $perhitunganController->linearTurun($penilaian->jaminan, $jaminan_tidak_himpunan->a, $jaminan_tidak_himpunan->b);
        } elseif ($jaminan_tidak_himpunan->nama_kurva == "Linear Naik") {
            $jaminanResultA = $perhitunganController->linearNaik($penilaian->jaminan, $jaminan_tidak_himpunan->a, $jaminan_tidak_himpunan->b);
        } elseif ($jaminan_tidak_himpunan->nama_kurva == "Segitiga") {
            $jaminanResultA = $perhitunganController->segitiga($penilaian->jaminan, $jaminan_tidak_himpunan->a, $jaminan_tidak_himpunan->b, $jaminan_tidak_himpunan->c);
        } else {
            $jaminanResultA = $perhitunganController->travesium($penilaian->jaminan, $jaminan_tidak_himpunan->a, $jaminan_tidak_himpunan->b, $jaminan_tidak_himpunan->c, $jaminan_tidak_himpunan->d);
        }

        if ($jaminan_jarang_himpunan->nama_kurva == "Linear Turun") {
            $jaminanResultB = $perhitunganController->linearTurun($penilaian->jaminan, $jaminan_jarang_himpunan->a, $jaminan_jarang_himpunan->b);
        } elseif ($jaminan_jarang_himpunan->nama_kurva == "Linear Naik") {
            $jaminanResultB = $perhitunganController->linearNaik($penilaian->jaminan, $jaminan_jarang_himpunan->a, $jaminan_jarang_himpunan->b);
        } elseif ($jaminan_jarang_himpunan->nama_kurva == "Segitiga") {
            $jaminanResultB = $perhitunganController->segitiga($penilaian->jaminan, $jaminan_jarang_himpunan->a, $jaminan_jarang_himpunan->b, $jaminan_jarang_himpunan->c);
        } else {
            $jaminanResultB = $perhitunganController->travesium($penilaian->jaminan, $jaminan_jarang_himpunan->a, $jaminan_jarang_himpunan->b, $jaminan_jarang_himpunan->c, $jaminan_jarang_himpunan->d);
        }

        if ($jaminan_sering_himpunan->nama_kurva == "Linear Turun") {
            $jaminanResultC = $perhitunganController->linearTurun($penilaian->jaminan, $jaminan_sering_himpunan->a, $jaminan_sering_himpunan->b);
        } elseif ($jaminan_sering_himpunan->nama_kurva == "Linear Naik") {
            $jaminanResultC = $perhitunganController->linearNaik($penilaian->jaminan, $jaminan_sering_himpunan->a, $jaminan_sering_himpunan->b);
        } elseif ($jaminan_sering_himpunan->nama_kurva == "Segitiga") {
            $jaminanResultC = $perhitunganController->segitiga($penilaian->jaminan, $jaminan_sering_himpunan->a, $jaminan_sering_himpunan->b, $jaminan_sering_himpunan->c);
        } else {
            $jaminanResultC = $perhitunganController->travesium($penilaian->jaminan, $jaminan_sering_himpunan->a, $jaminan_sering_himpunan->b, $jaminan_sering_himpunan->c, $jaminan_sering_himpunan->d);
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
        if ($penilaian->rk <= max($rk_tidak_himpunan->a, $rk_tidak_himpunan->b, $rk_tidak_himpunan->c, $rk_tidak_himpunan->d)) {
            $linguistik_rk = 'Tidak Pernah';
        } else if ($penilaian->rk <= max($rk_jarang_himpunan->a, $rk_jarang_himpunan->b, $rk_jarang_himpunan->c, $rk_jarang_himpunan->d)) {
            if (($penilaian->rk == $rk_jarang_himpunan->d)) {
                $linguistik_rk = 'Sering';
            } else {
                $linguistik_rk = 'Jarang';
            }
        } else {
            $linguistik_rk = 'Sering';
        }

        if ($penilaian->penghasilan <= max($penghasilan_tidak_himpunan->a, $penghasilan_tidak_himpunan->b, $penghasilan_tidak_himpunan->c, $penghasilan_tidak_himpunan->d)) {
            $linguistik_penghasilan = 'Kurang';
        } else if ($penilaian->penghasilan <= max($penghasilan_jarang_himpunan->a, $penghasilan_jarang_himpunan->b, $penghasilan_jarang_himpunan->c, $penghasilan_jarang_himpunan->d)) {
            $linguistik_penghasilan = 'Cukup';
        } else {
            $linguistik_penghasilan = 'Banyak';
        }

        if ($penilaian->tanggungan <= max($tanggungan_tidak_himpunan->a, $tanggungan_tidak_himpunan->b, $tanggungan_tidak_himpunan->c, $tanggungan_tidak_himpunan->d)) {
            $linguistik_tanggungan = 'Sedikit';
        } else if ($penilaian->tanggungan <= max($tanggungan_jarang_himpunan->a, $tanggungan_jarang_himpunan->b, $tanggungan_jarang_himpunan->c, $tanggungan_jarang_himpunan->d)) {
            if (($penilaian->tanggungan == $tanggungan_jarang_himpunan->d)) {
                $linguistik_tanggungan = 'Banyak';
            } else {
                $linguistik_tanggungan = 'Cukup';
            }
        } else {
            $linguistik_tanggungan = 'Banyak';
        }

        if ($penilaian->jaminan <= max($jaminan_tidak_himpunan->a, $jaminan_tidak_himpunan->b, $jaminan_tidak_himpunan->c, $jaminan_tidak_himpunan->d)) {
            $linguistik_jaminan = 'Kurang';
        } else if ($penilaian->jaminan <= max($jaminan_jarang_himpunan->a, $jaminan_jarang_himpunan->b, $jaminan_jarang_himpunan->c, $jaminan_jarang_himpunan->d)) {
            $linguistik_jaminan = 'Cukup';
        } else {
            $linguistik_jaminan = 'Baik';
        }
        //END HITUNG LINGUISTIK-------------------------------------------------------------------------------------------------

        //START PENCOCOKAN RULE DENGAN INPUT--------------------------------------------------------------------------
        $maxHasilPersamaan = -1; // Initialize with a value lower than the possible hasil_persamaan
        $selectedRule = null;

        foreach ($inferensi as $rule) {
            if ($rule['hasil_persamaan'] > $maxHasilPersamaan) {
                $maxHasilPersamaan = $rule['hasil_persamaan'];
                $selectedRule = $rule;
            }
        }
        // dd($maxHasilPersamaan, $selectedRule);
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

        return [
            'finalResult' => $finalResult,
            // Add other results if needed
        ];
    }
}
