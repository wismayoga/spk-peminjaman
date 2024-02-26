<?php

namespace App\Http\Controllers;

use App\Models\Aturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class aturanController extends Controller
{
    public function index()
    {
        //get posts

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
            ->simplePaginate(10);

        //render view with posts
        return view('dashboard.aturan', compact('aturans'));
        // return view('dashboard.harga.edit', ['harga' => $harga]);

    }

    public function create()
    {
        $rk = DB::table('himpunans')
            ->where('himpunans.id_variabel', '=', 1)
            ->select('himpunans.*')
            ->get();
        $penghasilan = DB::table('himpunans')
            ->where('himpunans.id_variabel', '=', 2)
            ->select('himpunans.*')
            ->get();
        $tanggungan = DB::table('himpunans')
            ->where('himpunans.id_variabel', '=', 3)
            ->select('himpunans.*')
            ->get();
        $jaminan = DB::table('himpunans')
            ->where('himpunans.id_variabel', '=', 4)
            ->select('himpunans.*')
            ->get();

        return view('dashboard.aturanCreate', [
            'rk' => $rk,
            'penghasilan' => $penghasilan,
            'tanggungan' => $tanggungan,
            'jaminan' => $jaminan,
        ]);
    }

    public function store(Request $request)
    {
        //validate form
        // $this->validate($request, [
        //     'nama'   => 'required|min:5'
        // ]);
        // dd($request);

        $id_rk = $request->rk;
        $id_penghasilan = $request->penghasilan;
        $id_tanggungan = $request->tanggungan;
        $id_jaminan = $request->jaminan;

        $aturan = Aturan::where([
            'id_rk' => $id_rk,
            'id_penghasilan' => $id_penghasilan,
            'id_tanggungan' => $id_tanggungan,
            'id_jaminan' => $id_jaminan,
        ])->first();

        if ($aturan) {
            // If the record exists, update it
            $aturan->update([
                'hasil' => $request->hasil,
            ]);

            $message = 'Aturan sudah ada, berhasil diupdate.';
        } else {
            // If the record doesn't exist, create it
            Aturan::create([
                'id_rk' => $id_rk,
                'id_penghasilan' => $id_penghasilan,
                'id_tanggungan' => $id_tanggungan,
                'id_jaminan' => $id_jaminan,
                'hasil' => $request->hasil,
            ]);

            $message = 'Aturan berhasil ditambah.';
        }

        return redirect()->route('aturan.index')->with('success', $message);
    }

    public function edit(Aturan $aturan)
    {
        $aturan = DB::table('aturans')
            ->where('aturans.id', '=', $aturan->id)
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
            ->first();

        $rk = DB::table('himpunans')
            ->where('himpunans.id_variabel', '=', 1)
            ->select('himpunans.*')
            ->get();
        $penghasilan = DB::table('himpunans')
            ->where('himpunans.id_variabel', '=', 2)
            ->select('himpunans.*')
            ->get();
        $tanggungan = DB::table('himpunans')
            ->where('himpunans.id_variabel', '=', 3)
            ->select('himpunans.*')
            ->get();
        $jaminan = DB::table('himpunans')
            ->where('himpunans.id_variabel', '=', 4)
            ->select('himpunans.*')
            ->get();

        return view('dashboard.aturanEdit', [
            'aturan' => $aturan,
            'rk' => $rk,
            'penghasilan' => $penghasilan,
            'tanggungan' => $tanggungan,
            'jaminan' => $jaminan,
        ]);
    }

    public function update(Request $request, Aturan $aturan)
    {
        // if($request->nama == $aturan->nama){
        //     return redirect()->route('variabel.index')->with(['success' => 'Variabel tidak diubah.']);
        // }

        // $this->validate($request, [
        //     'nama'   => 'required|min:5'
        // ]);

        $aturan->update([
            'id_rk' => $request->rk,
            'id_penghasilan' => $request->penghasilan,
            'id_tanggungan' => $request->tanggungan,
            'id_jaminan' => $request->jaminan,
            'hasil' => $request->hasil,
        ]);

        return redirect()->route('aturan.index')->with(['success' => 'Aturan berhasil diubah.']);
    }

    public function destroy(Aturan $aturan)
    {

        Aturan::destroy($aturan->id);

        return redirect()->route('aturan.index')->with('success', 'Aturan berhasil dihapus.');
    }
}
