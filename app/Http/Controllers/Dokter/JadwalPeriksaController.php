<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\JadwalPeriksa;

class JadwalPeriksaController extends Controller
{
    public function index() 
    { 
        $jadwalPeriksas = JadwalPeriksa::where('id_dokter', Auth::user()->id)->get(); 
 
        return view('dokter.jadwal-periksa.index')->with([ 
            'jadwalPeriksas' => $jadwalPeriksas, 
        ]); 
    } 
 
    public function store(Request $request) 
    { 
        $request->validate([ 
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu', 
            'jam_mulai' => 'required|date_format:H:i', 
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai', 
        ]); 
 
        // Cek jika dokter sudah memiliki jadwal periksa yang sama 
        if(JadwalPeriksa::where('id_dokter', Auth::user()->id) 
            ->where('hari', $request->hari) 
            ->where('jam_mulai', $request->jam_mulai) 
            ->where('jam_selesai', $request->jam_selesai) 
            ->exists()) { 
            return redirect()->back()->with('status', 'jadwal-periksa-exists'); 
        } 
 
        JadwalPeriksa::create([ 
            'id_dokter' => Auth::user()->id, 
            'hari' => $request->hari, 
            'jam_mulai' => $request->jam_mulai, 
            'jam_selesai' => $request->jam_selesai, 
            'status' => false, 
        ]); 
 
        return redirect()->back()->with('status', 'jadwal-periksa-created'); 
    } 
 
    public function update($id) 
    { 
        $jadwalPeriksa = JadwalPeriksa::findOrFail($id); 
 
        if (!$jadwalPeriksa->status) { 
            JadwalPeriksa::where('id_dokter', $jadwalPeriksa->id_dokter)->update(['status' => false]); 
 
            $jadwalPeriksa->status = true; 
            $jadwalPeriksa->save(); 
 
            return redirect()->back()->with('status', 'jadwal-periksa-updated'); 
        } 
 
        $jadwalPeriksa->status = false; 
        $jadwalPeriksa->save(); 
 
        return redirect()->back()->with('status', 'jadwal-periksa-updated'); 
    }
}