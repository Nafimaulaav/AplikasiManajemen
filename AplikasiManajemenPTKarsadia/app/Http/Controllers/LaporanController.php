<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelLaporanHarian;

class LaporanController extends Controller
{
    // buat nampilin halaman laporan
    public function index()
    {
        $dataLaporan = ModelLaporanHarian::latest()->get();
        return view('laporan.index', compact('dataLaporan'));
    }

    // buat nampilin form tambah laporan harian
    public function create()
    {
        return view('laporan.create');
    }

    // buat nyimpen laporan harian baru
    public function store(Request $request)
    {
        // validasi input
        $validated = $request->validate([
            'judul_laporan' => 'required|string|max:100',
            'tanggal_laporan' => 'required|date',
            'aktivitas' => 'required|in:Penanaman,Perawatan,Pembersihan',
            'nama_petugas' => 'required|string|max:50',
            'gambar_laporan' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'catatan' => 'nullable|string',
            'id_greenhouse' => 'required|exists:greenhouse,id_greenhouse',
        ]);

        // simpen data laporan harian
        $laporan = ModelLaporanHarian::create($validated);

        return redirect()
            ->route('laporan.index')
            ->with('success', 'Laporan harian berhasil ditambahkan');

    }

    // buat update laporan harian
    public function update(Request $request, $id_laporanharian)
    {
        $laporan = ModelLaporanHarian::findOrFail($id_laporanharian);

        $validated = $request->validate([
            'judul_laporan' => 'required|string|max:100',
            'tanggal_laporan' => 'required|date',
            'aktivitas' => 'required|in:Penanaman,Perawatan,Pembersihan',
            'nama_petugas' => 'required|string|max:50',
            'catatan' => 'nullable|string',
        ]);

        $laporan->update($validated);

        return redirect()
            ->route('laporan.index')
            ->with('success', 'Laporan harian berhasil diupdate');
    }

    // buat hapus laporan harian
    public function destroy($id_laporanharian)
    {
        $laporan = ModelLaporanHarian::findOrFail($id_laporanharian);
        $laporan->delete();
        return redirect()
            ->route('laporan.index')
            ->with('success', 'Laporan harian berhasil dihapus');
    }
}