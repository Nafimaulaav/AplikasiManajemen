<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelPanen;
use App\Models\ModelGreenhouse;

class PanenController extends Controller
{
    // Menampilkan semua data panen + kirim greenhouse untuk modal
    public function index()
    {
        $panen = ModelPanen::with('greenhouse')->get();
        $greenhouses = ModelGreenhouse::all(); // TAMBAHKAN INI
        return view('panen.index', compact('panen', 'greenhouses'));
    }

    // Menampilkan detail panen
    public function show($id_panen)
    {
        $panen = ModelPanen::with('greenhouse')->findOrFail($id_panen);
        return view('panen.show', compact('panen'));
    }

    // Form tambah panen
    public function FormCreatePanen()
    {
        $greenhouses = ModelGreenhouse::all();
        return view('panen.form', compact('greenhouses'));
    }

    // Simpan data panen baru
    public function StorePanen(Request $request)
    {
        $data = $request->validate([
            'tanggal_panen' => 'required|date',
            'jumlah_panen'  => 'required|integer',
            'jumlah_grade_a' => 'required|integer',
            'jumlah_grade_b' => 'required|integer',
            'jumlah_grade_c' => 'required|integer',
            'id_greenhouse' => 'required|string|max:10|exists:greenhouse,id_greenhouse',
        ]);

        ModelPanen::create($data);
        
        return redirect()->route('panen.index')
            ->with('success', 'Data panen berhasil ditambahkan');
    }

    // Form edit panen
    public function FormEditPanen($id_panen)
    {
        $panen = ModelPanen::findOrFail($id_panen);
        $greenhouses = ModelGreenhouse::all();
        return view('panen.form', compact('panen', 'greenhouses'));
    }

    // Update data panen
    public function UpdatePanen(Request $request, $id_panen)
    {
        $data = $request->validate([
            'tanggal_panen' => 'required|date',
            'jumlah_panen'  => 'required|integer',
            'jumlah_grade_a' => 'required|integer',
            'jumlah_grade_b' => 'required|integer',
            'jumlah_grade_c' => 'required|integer',
            'id_greenhouse' => 'required|string|max:10|exists:greenhouse,id_greenhouse',
        ]);

        $panen = ModelPanen::findOrFail($id_panen);
        $panen->update($data);

        return redirect()->route('panen.index')
            ->with('success', 'Data panen berhasil diupdate');
    }

    // Hapus data panen
    public function DestroyPanen($id_panen)
    {
        $panen = ModelPanen::findOrFail($id_panen);
        $panen->delete();

        return redirect()->route('panen.index')
            ->with('success', 'Data panen berhasil dihapus');
    }
}