<?php

namespace App\Http\Controllers\Dokter;

use App\Models\Obat;
use App\Models\Periksa;
use App\Models\JanjiPeriksa;
use Illuminate\Http\Request;
use App\Models\DetailPeriksa;
use App\Models\JadwalPeriksa;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MemeriksaController extends Controller
{
    public function index() 
    { 
        $jadwalPeriksa = JadwalPeriksa::where('id_dokter', Auth::user()->id) 
            ->where('status', true) 
            ->first(); 

        if (!$jadwalPeriksa) {
            return view('dokter.memeriksa.index')->with([
                'janjiPeriksas' => collect(), // kirim collection kosong
                'obats' => Obat::all(),
                'message' => 'Tidak ada pasien untuk diperiksa karena belum ada jadwal aktif.',
            ]);
        }

        $janjiPeriksas = JanjiPeriksa::where('id_jadwal_periksa', $jadwalPeriksa->id) 
            ->with(['pasien', 'jadwalPeriksa']) 
            ->get(); 

        $obats = Obat::all(); 

        return view('dokter.memeriksa.index')->with([ 
            'janjiPeriksas' => $janjiPeriksas, 
            'obats' => $obats, 
        ]); 
    }


    public function edit($id) 
    { 
        $janjiPeriksa = JanjiPeriksa::findOrFail($id); 
        $obats = Obat::all(); 
        $selectedObatIds = DetailPeriksa::where('id_periksa', $janjiPeriksa->periksa->id)
            ->pluck('id_obat')
            ->toArray();
 
        return view('dokter.memeriksa.edit')->with([ 
            'janjiPeriksa' => $janjiPeriksa, 
            'obats' => $obats, 
            'selectedObatIds' => $selectedObatIds, 
        ]); 
    } 
 
    public function periksa($id) 
    { 
        $janjiPeriksa = JanjiPeriksa::findOrFail($id); 
        $obats = Obat::all(); 
 
        return view('dokter.memeriksa.periksa')->with([ 
            'janjiPeriksa' => $janjiPeriksa, 
            'obats' => $obats, 
        ]); 
    } 
 
    public function store(Request $request, $id) 
    { 
        $request->validate([ 
            'tgl_periksa' => 'required|date', 
            'catatan' => 'required|string', 
            'obat' => 'required', 
            'biaya_periksa' => 'required|numeric', 
        ]); 
 
        $janjiPeriksa = JanjiPeriksa::findOrFail($id); 
 
        $periksa = Periksa::create([ 
            'id_janji_periksa' => $janjiPeriksa->id, 
            'tgl_periksa' => $request->tgl_periksa, 
            'catatan' => $request->catatan, 
            'biaya_periksa' => $request->biaya_periksa, 
        ]);

        foreach ($request->obat as $idObat) {
            DetailPeriksa::create([
                'id_periksa' => $periksa->id,
                'id_obat' => $idObat, 
            ]);
        }

        return redirect()->route('dokter.memeriksa.index')->with('status', 'memeriksa-created'); 
    } 
 
    public function update(Request $request, $id) 
    { 
        $request->validate([ 
            'tgl_periksa' => 'required|date', 
            'catatan' => 'required|string', 
            'obat' => 'required', 
            'biaya_periksa' => 'required|numeric', 
        ]); 
 
        $periksa = Periksa::findOrFail($id); 
 
        $periksa->update([ 
            'tgl_periksa' => $request->tgl_periksa, 
            'catatan' => $request->catatan, 
            'biaya_periksa' => $request->biaya_periksa, 
        ]); 

        foreach ($request->obat as $idObat) {
            DetailPeriksa::updateOrCreate(
                [
                    'id_periksa' => $periksa->id,
                    'id_obat' => $idObat,
                ],
                [
                    'id_periksa' => $periksa->id,
                    'id_obat' => $idObat,
                ]
            );
        }

        DetailPeriksa::whereNotIn('id_obat', $request->obat)
            ->where('id_periksa', $periksa->id)
            ->delete();
 
        return redirect()->route('dokter.memeriksa.index')->with('status', 'memeriksa-updated'); 
    }
}