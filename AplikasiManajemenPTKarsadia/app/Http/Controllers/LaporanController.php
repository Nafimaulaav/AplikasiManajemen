<?php

namespace App\Http\Controllers;

use App\Helpers\RiwayatHelper;
use Illuminate\Http\Request;
use App\Models\ModelLaporanHarian;
use App\Models\ModelGreenhouse;


class LaporanController extends Controller
{
    // buat nampilin halaman laporan
    public function index()
    {
        $dataLaporan = ModelLaporanHarian::with('greenhouse')->orderBy('tanggal_laporan', 'desc')->get();
        $greenhouse = ModelGreenhouse::all();

        // $dataLaporan = ModelLaporanHarian::latest()->get();
        // $greenhouse = ModelGreenhouse::all();
        return view('laporan.index', compact('dataLaporan', 'greenhouse'));
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

        if ($request->hasFile('gambar_laporan')){
            $validated['gambar_laporan'] = $request->file('gambar_laporan')->store('laporan', 'public');
        } else {
            $validated['gambar_laporan'] = null;
        }

        // simpen data laporan harian
        $laporan = ModelLaporanHarian::create($validated);


        // buat record tambah ke riwayat
        RiwayatHelper::catat(
            'Tambah',
            'Laporan',
            'Menambahkan laporan baru: ' . $laporan->judul_laporan
        );

        return redirect()
            ->route('laporan.index')
            ->with('success', 'Laporan harian berhasil ditambahkan');

    }

    // // buat nampilin form laporan
    public function formUpdateLaporan($id_laporanharian)
    {
        $laporan = ModelLaporanHarian::findOrFail($id_laporanharian);
        return view('laporan.edit', compact('laporan'));
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

        // buat record ubah ke riwayat
        RiwayatHelper::catat(
            'Ubah',
            'Laporan',
            'Mengubah data laporan: ' . $laporan->judul_laporan
        );

        return redirect()
            ->route('laporan.index')
            ->with('success', 'Laporan harian berhasil diupdate');
    }

    // buat hapus laporan harian
    public function destroy($id_laporanharian)
    {
        $laporan = ModelLaporanHarian::findOrFail($id_laporanharian);
        
        // buat nyimpen snapshot
        $judulLaporan = $laporan->judul_laporan ?? 'Laporan Harian';
        $tanggalLaporan = $laporan->tanggal_laporan;

        // hapus
        $laporan->delete();

        // buat record hapus ke riwayat
        RiwayatHelper::catat(
            'Hapus',
            'Laporan',
            'Menghapus laporan "' . $judulLaporan . '" pada ' . $tanggalLaporan
        );
        return redirect()
            ->route('laporan.index')
            ->with('success', 'Laporan harian berhasil dihapus');
    }
}