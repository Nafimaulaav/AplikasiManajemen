<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelQC;
use App\Models\ModelGreenhouse;

class TambahQCController extends Controller
{
    // TAMPILKAN FORM TAMBAH QC UNTUK GREENHOUSE TERTENTU
    public function FormTambahQC($id_greenhouse)
    {
        $greenhouse = ModelGreenhouse::find($id_greenhouse);

        if (!$greenhouse) {
            return redirect()->back()->with('error', 'Greenhouse tidak ditemukan.');
        }

        return view('tambah_qc', compact('greenhouse'));
    }

    // SIMPAN DATA QC BARU
    public function StoreQC(Request $request)
    {
        // validasi
        $validated = $request->validate([
            'tanggal_qc' => 'required|date',
            'nama_petugas' => 'required|string|max:50',
            'varietas_melon' => 'required|string|max:50',
            'status_tumbuh' => 'required|string|max:50',
            'total_tanaman' => 'required|integer',
            'jumlah_tanaman_tumbuh' => 'required|integer',
            'jumlah_tanaman_sehat' => 'required|integer',
            'jumlah_tanaman_sakit' => 'required|integer',
            'jumlah_tanaman_mati' => 'required|integer',
            'id_greenhouse' => 'required|exists:greenhouse,id_greenhouse',
        ]);

        ModelQC::create($validated);

        return redirect()->route('detail_greenhouse', $validated['id_greenhouse'])
                         ->with('success', 'Data QC berhasil ditambahkan!');
    }
}
