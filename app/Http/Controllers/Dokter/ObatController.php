<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Http\Requests\ObatUpdateRequest;
use Illuminate\Http\Request;

use App\Models\Obat;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class ObatController extends Controller
{
    public function index(){
        $obats = Obat::get(); 
 
        return view('dokter.obat.index')->with([ 
            'obats' => $obats, 
        ]); 
    }

    public function store(Request $request) 
    { 
        $request->validate([ 
            'namaObat' => 'required|string', 
            'kemasan' => 'required|string', 
            'harga' => 'required|integer', 
        ]); 
 
        Obat::create([ 
            'nama_obat' => $request->namaObat, 
            'kemasan' => $request->kemasan, 
            'harga' => $request->harga, 
        ]); 
 
        return redirect()->back()->with('status', 'obat-created'); 
    } 
 
    public function edit($id)
    {
        $obat = Obat::findOrFail($id);

        return view('dokter.obat.edit')->with([ 
            'obat' => $obat, 
        ]); 
    }

    public function update(ObatUpdateRequest $request, $id): RedirectResponse
    {
        $obat = Obat::findOrFail($id);

        $obat->update([
            'nama_obat' => $request->namaObat,
            'kemasan' => $request->kemasan,
            'harga' => $request->harga,
        ]);

        // Redirect kembali ke halaman daftar obat
        return redirect()->route('obat.index');
    }

    
    public function destroy($id)
    {
        $obat = Obat::findOrFail($id);
        $obat->delete();

        return redirect()->back()->with('status', 'obat-updated'); 
    }
}
