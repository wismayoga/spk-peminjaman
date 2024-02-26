<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\JenisVariabel;
use App\Models\Penilaian;
use App\Models\Variabel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class penilaianController extends Controller
{
    public function index()
    {
        $alternatifs = DB::table('alternatifs')
            ->leftJoin('penilaians as tabel_penilaian', 'tabel_penilaian.id_alternatif', '=', 'alternatifs.id')
            ->select('alternatifs.*', 'tabel_penilaian.updated_at as tanggal')
            ->simplePaginate(10);
        $penilaians = Penilaian::all();
        $variabels = Variabel::all();
        $jenisJaminan = JenisVariabel::where('id_variabel', '=', 4)->get();

        //render view with posts
        return view('dashboard.penilaian', [
            'alternatifs' => $alternatifs,
            'penilaians' => $penilaians,
            'variabels' => $variabels,
            'jenisJaminan' => $jenisJaminan,
        ]);
    }

    public function cari(Request $request)
    {
        $cari = $request->cari;

        $alternatifs = DB::table('alternatifs')
            ->where('alternatifs.nama', 'like', "%" . $cari . "%")
            ->leftJoin('penilaians as tabel_penilaian', 'tabel_penilaian.id_alternatif', '=', 'alternatifs.id')
            ->select('alternatifs.*', 'tabel_penilaian.updated_at as tanggal')
            ->get();
        $penilaians = Penilaian::all();
        $variabels = Variabel::all();
        $jenisJaminan = JenisVariabel::where('id_variabel', '=', 4)->get();

        //render view with posts
        return view('dashboard.penilaian', [
            'alternatifs' => $alternatifs,
            'penilaians' => $penilaians,
            'variabels' => $variabels,
            'jenisJaminan' => $jenisJaminan,
        ]);
    }

    public function store(Request $request)
    {
        //validate form
        // $this->validate($request, [
        //     'nama'   => 'required|min:5'
        // ]);
        $penghasilan = str_replace(',', '', $request->penghasilan);
        $jaminan = str_replace(',', '', $request->jaminan);

        if($request->slipgaji != ''){
            //upload new image
            $imageName = 'Slipgaji' . '-' . time() . '.' . $request->slipgaji->extension();
            $image = $request->file('slipgaji');
            $image->storeAs('public/foto/slipgaji/', $imageName);
        }else{
            $imageName = 'empty';
        }

        // dd($request);

        Penilaian::create([
            'id_alternatif'     => $request->id_alternatif,
            'id_jenisVariabel'     => $request->jenis_jaminan,
            'rk'     => $request->rk,
            'penghasilan'     => $penghasilan,
            'tanggungan'     => $request->tanggungan,
            'jaminan'     => $jaminan,
            'slip_gaji'     => $imageName,
            'merk_kendaraan'     => $request->merk_kendaraan ?? "",
            'jenis_kendaraan'     => $request->jenis_kendaraan ?? "",
            'tahun_kendaraan'     => $request->tahun_kendaraan ?? "",
        ]);

        return redirect()->route('perhitungan.show', $request->id_alternatif)->with('success', 'Penilaian berhasil ditambah.');
    }

    public function update(Request $request, Penilaian $penilaian)
    {
        // $this->validate($request, [
        //     'nama'   => 'required|min:5'
        // ]);
        $penghasilan = str_replace(',', '', $request->penghasilan);
        $jaminan = str_replace(',', '', $request->jaminan);

        if($request->slipgaji != null){
            Storage::disk('local')->delete('public/foto/slipgaji/' . $penilaian->slipgaji);
            //upload new image
            $imageName = 'Slipgaji' . '-' . time() . '.' . $request->slipgaji->extension();
            $image = $request->file('slipgaji');
            $image->storeAs('public/foto/slipgaji/', $imageName);
        }elseif($penilaian->slipgaji == null){
            $imageName =  'empty';
        }else{
            $imageName =  $penilaian->slipgaji;
        }

        $penilaian->update([
            'id_alternatif'     => $request->id_alternatif,
            'id_jenisVariabel'     => $request->jenis_jaminan,
            'rk'     => $request->rk,
            'penghasilan'     => $penghasilan,
            'tanggungan'     => $request->tanggungan,
            'jaminan'     => $jaminan,
            'slip_gaji'     => $imageName,
            'merk_kendaraan'     => $request->merk_kendaraan ?? "",
            'jenis_kendaraan'     => $request->jenis_kendaraan ?? "",
            'tahun_kendaraan'     => $request->tahun_kendaraan ?? "",
        ]);

        return redirect()->route('perhitungan.show', $request->id_alternatif)->with(['success' => 'Penilaian berhasil diubah.']);
    }
}
