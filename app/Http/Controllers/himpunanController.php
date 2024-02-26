<?php

namespace App\Http\Controllers;

use App\Models\Himpunan;
use App\Models\Variabel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class himpunanController extends Controller
{
    public function index()
    {
        $rk = DB::table('himpunans')
            ->where('id_variabel', 1)
            ->leftJoin('kurvas as tabel_kurva', 'himpunans.id_kurva', '=', 'tabel_kurva.id')
            ->select("himpunans.*", 'tabel_kurva.nama as nama_kurva')
            ->get();

        $penghasilan = DB::table('himpunans')
            ->where('id_variabel', 2)
            ->leftJoin('kurvas as tabel_kurva', 'himpunans.id_kurva', '=', 'tabel_kurva.id')
            ->select("himpunans.*", 'tabel_kurva.nama as nama_kurva')
            ->get();

        $tanggungan = DB::table('himpunans')
            ->where('id_variabel', 3)
            ->leftJoin('kurvas as tabel_kurva', 'himpunans.id_kurva', '=', 'tabel_kurva.id')
            ->select("himpunans.*", 'tabel_kurva.nama as nama_kurva')
            ->get();

        $jaminan = DB::table('himpunans')
            ->where('id_variabel', 4)
            ->leftJoin('kurvas as tabel_kurva', 'himpunans.id_kurva', '=', 'tabel_kurva.id')
            ->select("himpunans.*", 'tabel_kurva.nama as nama_kurva')
            ->get();
        
        $variabels = Variabel::all();

        //render view with posts
        return view('dashboard.himpunan', [
            'rk' => $rk,
            'penghasilan' => $penghasilan,
            'tanggungan' => $tanggungan,
            'jaminan' => $jaminan,
            'variabels' => $variabels,
        ]);
    }

    public function store(Request $request)
    {
        //validate form
        // $this->validate($request, [
        //     'nama'   => 'required|min:5'
        // ]);

        if ($request->variabel == 'Tambah Riwayat Keterlambatan') {
            $variabel = 1;
        } else if ($request->variabel == 'Tambah Penghasilan') {
            $variabel = 2;
        } else if ($request->variabel == 'Tambah Tanggungan') {
            $variabel = 3;
        } else {
            $variabel = 4;
        }

        if ($request->kurva == 'Liniar Naik') {
            $kurva = 1;
        } else if ($request->kurva == 'Liniar Turun') {
            $kurva = 2;
        } else if ($request->kurva == 'Segitiga') {
            $kurva = 3;
        } else {
            $kurva = 4;
        }

        if ($kurva == 1 || $kurva == 2) {
            Himpunan::create([
                'id_variabel' => $variabel,
                'id_kurva' => $kurva,
                'nama'     => $request->nama,
                'a'     => $request->a,
                'b'     => $request->b,
                'c'     => 0,
                'd'     => 0,
            ]);
        }

        if ($kurva == 3) {
            Himpunan::create([
                'id_variabel' => $variabel,
                'id_kurva' => $kurva,
                'nama'     => $request->nama,
                'a'     => $request->a,
                'b'     => $request->b,
                'c'     => $request->c,
                'd'     => 0,
            ]);
        }

        if ($kurva == 4) {
            Himpunan::create([
                'id_variabel' => $variabel,
                'id_kurva' => $kurva,
                'nama'     => $request->nama,
                'a'     => $request->a,
                'b'     => $request->b,
                'c'     => $request->c,
                'd'     => $request->d,
            ]);
        }

        return redirect()->route('himpunan.index')->with('success', 'Himpunan berhasil ditambah.');
    }

    public function edit(Himpunan $himpunan)
    {
        $himpunan = DB::table('himpunans')
            ->where('himpunans.id', '=', $himpunan->id)
            ->leftJoin('variabels as tabel_variabels', 'himpunans.id_variabel', '=', 'tabel_variabels.id')
            ->select("himpunans.*", 'tabel_variabels.nama as nama_variabel')
            ->first();

        return view('dashboard.himpunanEdit', [
            'himpunan' => $himpunan,
        ]);
    }

    public function update(Request $request, Himpunan $himpunan)
    {
        if ($request->nama == $himpunan->nama && $request->a == $himpunan->a && $request->b == $himpunan->b && $request->c == $himpunan->c && $request->d == $himpunan->d && $request->kurva == $himpunan->id_kurva) {
            return redirect()->route('himpunan.index')->with(['success' => 'Himpunan tidak diubah.']);
        }

        // $this->validate($request, [
        //     'nama'   => 'required|min:5'
        // ]);

        if ($request->kurva == 1 || $request->kurva == 2) {
            $himpunan->update([
                'id_kurva' => $request->kurva,
                'nama'     => $request->nama,
                'a'     => $request->a,
                'b'     => $request->b,
                'c'     => 0,
                'd'     => 0,
            ]);
        }

        if ($request->kurva == 3) {
            $himpunan->update([
                'id_kurva' => $request->kurva,
                'nama'     => $request->nama,
                'a'     => $request->a,
                'b'     => $request->b,
                'c'     => $request->c,
                'd'     => 0,
            ]);
        }

        if ($request->kurva == 4) {
            $himpunan->update([
                'id_kurva' => $request->kurva,
                'nama'     => $request->nama,
                'a'     => $request->a,
                'b'     => $request->b,
                'c'     => $request->c,
                'd'     => $request->d,
            ]);
        }
        return redirect()->route('himpunan.index')->with(['success' => 'Himpunan berhasil diubah.']);
    }

    public function destroy(Himpunan $himpunan)
    {
        Himpunan::destroy($himpunan->id);

        return redirect()->route('himpunan.index')->with('success', 'Himpunan berhasil dihapus.');
    }
}
