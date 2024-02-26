<?php

namespace App\Http\Controllers;

use App\Models\Variabel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class variabelController extends Controller
{
    public function index()
    {
        //get posts
        $variabels = Variabel::all();
        $jenisVariabels  = DB::table('jenis_variabels')
            ->leftJoin('variabels as tabel_vr', 'jenis_variabels.id_variabel', '=', 'tabel_vr.id')
            ->select(
                "jenis_variabels.*",
                "tabel_vr.nama as vr_nama"
            )
            ->get();
        //render view with posts
        // return view('dashboard.variabel', compact('variabels'));
        return view('dashboard.variabel', [
            'variabels' => $variabels,
            'jenisVariabels' => $jenisVariabels,
        ]);
        
    }

    public function create()
    {
        return view('dashboard.variabelCreate');
    }

    public function store(Request $request)
    {
        //validate form
        // $this->validate($request, [
        //     'nama'   => 'required|min:5'
        // ]);
        Variabel::create([
            'nama'     => $request->nama,
            'min'     => $request->min,
            'max'     => $request->max,
            'keterangan'     => $request->keterangan,
        ]);

        return redirect()->route('variabel.index')->with('success', 'Variabel berhasil ditambah.');
    }

    public function edit(Variabel $variabel)
    {
        $variabel = DB::table('variabels')
            ->where('id', '=', $variabel->id)
            ->first();
        
        return view('dashboard.variabelEdit', [
            'variabel' => $variabel,
        ]);
    }

    public function update(Request $request, Variabel $variabel)
    {
        if($request->nama == $variabel->nama && $request->min == $variabel->min && $request->max == $variabel->max && $request->keterangan == $variabel->keterangan){
            return redirect()->route('variabel.index')->with(['success' => 'Variabel tidak diubah.']);
        }

        // $this->validate($request, [
        //     'nama'   => 'required|min:5'
        // ]);

        $variabel->update([
            'nama'   => $request->nama,
            'min'     => $request->min,
            'max'     => $request->max,
            'keterangan'     => $request->keterangan,
        ]);

        return redirect()->route('variabel.index')->with(['success' => 'Variabel berhasil diubah.']);
    }

    public function destroy(Variabel $variabel)
    {
        Variabel::destroy($variabel->id);

        return redirect()->route('variabel.index')->with('success', 'Variabel berhasil dihapus.');
    }
}
