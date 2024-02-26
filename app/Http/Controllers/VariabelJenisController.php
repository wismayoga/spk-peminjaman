<?php

namespace App\Http\Controllers;

use App\Models\JenisVariabel;
use App\Models\Variabel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VariabelJenisController extends Controller
{
    public function create()
    {
        $variabels = Variabel::all();
        return view('dashboard.variabelJenisCreate', [
            'variabels' => $variabels,
        ]);
    }

    public function store(Request $request)
    {
        //validate form
        // $this->validate($request, [
        //     'nama'   => 'required|min:5'
        // ]);
        JenisVariabel::create([
            'id_variabel'     => $request->variabel,
            'nama'     => $request->nama,
        ]);

        return redirect()->route('variabel.index')->with('success', 'Jenis Variabel berhasil ditambah.');
    }

    public function edit(JenisVariabel $jenisVariabel)
    {
        $jenisVariabel = DB::table('jenis_variabels')
            ->where('jenis_variabels.id', '=', $jenisVariabel->id)
            ->leftJoin('variabels as tabel_vr', 'jenis_variabels.id_variabel', '=', 'tabel_vr.id')
            ->select(
                "jenis_variabels.*",
                "tabel_vr.nama as nama_variabel"
            )
            ->first();
        $variabels = Variabel::all();

        return view('dashboard.variabelJenisEdit', [
            'jenisVariabel' => $jenisVariabel,
            'variabels' => $variabels,
        ]);
    }

    public function update(Request $request, JenisVariabel $jenisVariabel)
    {
        if($request->nama == $jenisVariabel->nama && $request->variabel == $jenisVariabel->id_variabel){
            return redirect()->route('variabel.index')->with(['success' => 'Jenis variabel tidak diubah.']);
        }

        // $this->validate($request, [
        //     'nama'   => 'required|min:5'
        // ]);
        $jenisVariabel->update([
            'id_variabel'     => $request->variabel,
            'nama'   => $request->nama,
        ]);

        return redirect()->route('variabel.index')->with(['success' => 'Jenis Variabel berhasil diubah.']);
    }

    public function destroy(JenisVariabel $jenisVariabel)
    {
        JenisVariabel::destroy($jenisVariabel->id);

        return redirect()->route('variabel.index')->with('success', 'Jenis variabel berhasil dihapus.');
    }
}
