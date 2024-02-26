<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class reportController extends Controller
{
    public function generatePDF($year, $month)
    {
        $perhitunganData = Perhitungan::whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->get();

        $pdf = PDF::loadView('perhitungan.pdf', ['perhitunganData' => $perhitunganData]);
        return $pdf->download('perhitungan_report.pdf');
    }
}
