<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class alternatifController extends Controller
{
    public function index()
    {
        //get posts
        $alternatifs = Alternatif::simplePaginate(2);
        $alternatifsCount = Alternatif::count();
        //render view with posts
        // return view('dashboard.alternatif', compact('alternatifs'));
        return view('dashboard.alternatif', [
            'alternatifs' => $alternatifs,
            'alternatifsCount' => $alternatifsCount,
        ]);
    }

    public function cari(Request $request)
    {
        // menangkap data pencarian
        $cari = $request->cari;

        // mengambil data dari table pegawai sesuai pencarian data
        $alternatifs = DB::table('alternatifs')
            ->where('nama', 'like', "%" . $cari . "%")
            ->get();

        // mengirim data pegawai ke view index
        return view('dashboard.alternatif', ['alternatifs' => $alternatifs]);
    }

    public function create()
    {
        return view('dashboard.alternatifCreate');
    }

    public function store(Request $request)
    {
        //validate form
        // $this->validate($request, [
        //     'nama'   => 'required|min:5'
        // ]);

        $tanggal_lahir = \DateTime::createFromFormat('d/m/Y', $request->tanggal_lahir)->format('Y-m-d');

        Alternatif::create([
            'nama'     => $request->nama,
            'nik'     => $request->nik,
            'tanggal_lahir'     => $tanggal_lahir,
            'tempatlahir'     => $request->tempatlahir,
            'jenis_kelamin'     => $request->jenis_kelamin,
            'pekerjaan'     => "",
            'alamat'     => $request->alamat,
        ]);

        return redirect()->route('alternatif.index')->with('success', 'Alternatif berhasil ditambah.');
    }

    public function edit(Alternatif $alternatif)
    {
        $alternatif = DB::table('alternatifs')
            ->where('id', '=', $alternatif->id)
            ->first();

        return view('dashboard.alternatifEdit', [
            'alternatif' => $alternatif,
        ]);
    }

    public function update(Request $request, Alternatif $alternatif)
    {
        // $this->validate($request, [
        //     'nama'   => 'required|min:5'
        // ]);
        $tanggal_lahir = \DateTime::createFromFormat('d/m/Y', $request->tanggal_lahir)->format('Y-m-d');

        $alternatif->update([
            'nama'   => $request->nama,
            'nik'   => $request->nik,
            'tanggal_lahir'   => $tanggal_lahir,
            'jenis_kelamin'   => $request->jenis_kelamin,
            'pekerjaan'   => "",
            'alamat'   => $request->alamat,
        ]);

        return redirect()->route('alternatif.index')->with(['success' => 'Alternatif berhasil diubah.']);
    }

    public function destroy(Alternatif $alternatif)
    {
        Alternatif::destroy($alternatif->id);

        return redirect()->route('alternatif.index')->with('success', 'Alternatif berhasil dihapus.');
    }
}
