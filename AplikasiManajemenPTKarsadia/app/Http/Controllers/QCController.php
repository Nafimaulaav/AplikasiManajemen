<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelQC;
use App\Models\ModelGreenhouse;

class QCController extends Controller
{
    // buat bikin form tambah QC
    public function create($id_greenhouse)
    {
        $greenhouse = ModelGreenhouse::findOrFail($id_greenhouse);

        return view('qc.create', compact('greenhouse'));
    }

    // buat nyimpen data QC baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_qc' => 'required|date',
            'nama_petugas' => 'required|string|max:50',
            'gambar_qc.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'varietas_melon' => 'required|string|max:50',
            'status_tumbuh' => 'required|in:Vegetatif,Generatif,Panen,Gegetatif',
            'total_tanaman' => 'required|integer|min:0',
            'jumlah_tanaman_tumbuh' => 'required|integer|min:0',
            'jumlah_tanaman_sehat' => 'required|integer|min:0',
            'jumlah_tanaman_sakit' => 'required|integer|min:0',
            'jumlah_tanaman_mati' => 'required|integer|min:0',
            'id_greenhouse' => 'required|exists:greenhouse,id_greenhouse',
        ]);

        $gambarPaths = [];
        if ($request->hasFile('gambar_qc')) {
            foreach ($request->file('gambar_qc') as $image) {
                $path = $image->store('qc_images', 'public');
                $gambarPaths[] = $path;
            }
        }
        $validated['gambar_qc'] = $gambarPaths;

        ModelQC::create($validated);

        return redirect()
            ->route('detail_greenhouse', $validated['id_greenhouse'])
            ->with('success', 'Data QC berhasil ditambahkan');
    }

    // buat nampilin form edit QC
    public function edit($id_log_qc)
    {
        $qc = ModelQC::with('greenhouse')->findOrFail($id_log_qc);

        return view('qc.edit', compact('qc'));
    }

    // buat ngupdate data QC
    public function update(Request $request, $id_log_qc)
    {
        $qc = ModelQC::findOrFail($id_log_qc);

        $validated = $request->validate([
            'tanggal_qc' => 'required|date',
            'nama_petugas' => 'required|string|max:50',
            'varietas_melon' => 'required|string|max:50',
            'status_tumbuh' => 'required|in:Vegetatif,Generatif,Panen,Gegetatif',
            'total_tanaman' => 'required|integer|min:0',
            'jumlah_tanaman_tumbuh' => 'required|integer|min:0',
            'jumlah_tanaman_sehat' => 'required|integer|min:0',
            'jumlah_tanaman_sakit' => 'required|integer|min:0',
            'jumlah_tanaman_mati' => 'required|integer|min:0',
        ]);

        $qc->update($validated);

        return redirect()
            ->route('detail_greenhouse', $qc->id_greenhouse)
            ->with('success', 'Data QC berhasil diperbarui');
    }

    // buat hapus data QC
    public function destroy($id_log_qc)
    {
        $qc = ModelQC::findOrFail($id_log_qc);
        $id_greenhouse = $qc->id_greenhouse;

        $qc->delete();

        return redirect()
            ->route('detail_greenhouse', $id_greenhouse)
            ->with('success', 'Data QC berhasil dihapus');
    }
}
