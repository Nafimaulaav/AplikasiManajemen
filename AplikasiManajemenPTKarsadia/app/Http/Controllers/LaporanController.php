<?php

namespace App\Http\Controllers;

use App\Helpers\RiwayatHelper;
use App\Models\ModelGreenhouse;
use App\Models\ModelLaporanHarian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Throwable;

class LaporanController extends Controller
{
    /**
     * Menampilkan seluruh laporan harian.
     */
    public function index()
    {
        $dataLaporan = ModelLaporanHarian::with('greenhouse')
            ->orderBy('tanggal_laporan', 'desc')
            ->get();

        $greenhouse = ModelGreenhouse::orderBy('id_greenhouse', 'asc')->get();

        return view('laporan.index', compact('dataLaporan', 'greenhouse'));
    }

    /**
     * Menyimpan laporan harian baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $validated['catatan'] = $validated['catatan'] ?? '-';

        $gambarBaru = null;

        if ($request->hasFile('gambar_laporan')) {
            $gambarBaru = $request
                ->file('gambar_laporan')
                ->store('laporan', 'public');

            $validated['gambar_laporan'] = $gambarBaru;
        }

        try {
            $laporan = ModelLaporanHarian::create($validated);
        } catch (Throwable $error) {
            // Hapus gambar jika penyimpanan database gagal.
            if ($gambarBaru) {
                Storage::disk('public')->delete($gambarBaru);
            }

            throw $error;
        }

        RiwayatHelper::catat(
            'Tambah',
            'Laporan',
            'Menambahkan laporan baru: ' . $laporan->judul_laporan
        );

        return redirect()
            ->route('laporan.index')
            ->with('success', 'Laporan harian berhasil ditambahkan.');
    }

    /**
     * Memperbarui laporan harian.
     */
    public function update(Request $request, $id_laporanharian)
    {
        $laporan = ModelLaporanHarian::findOrFail($id_laporanharian);

        $validated = $request->validate($this->rules());

        $validated['catatan'] = $validated['catatan'] ?? '-';

        $gambarLama = $laporan->gambar_laporan;
        $gambarBaru = null;

        if ($request->hasFile('gambar_laporan')) {
            $gambarBaru = $request
                ->file('gambar_laporan')
                ->store('laporan', 'public');

            $validated['gambar_laporan'] = $gambarBaru;
        }

        try {
            $laporan->update($validated);
        } catch (Throwable $error) {
            // Cegah file baru tertinggal jika pembaruan database gagal.
            if ($gambarBaru) {
                Storage::disk('public')->delete($gambarBaru);
            }

            throw $error;
        }

        // Hapus gambar lama setelah pembaruan berhasil.
        if ($gambarBaru && $gambarLama) {
            Storage::disk('public')->delete($gambarLama);
        }

        RiwayatHelper::catat(
            'Ubah',
            'Laporan',
            'Mengubah data laporan: ' . $laporan->judul_laporan
        );

        return redirect()
            ->route('laporan.index')
            ->with('success', 'Laporan harian berhasil diperbarui.');
    }

    /**
     * Menghapus laporan harian.
     */
    public function destroy($id_laporanharian)
    {
        $laporan = ModelLaporanHarian::findOrFail($id_laporanharian);

        $judulLaporan = $laporan->judul_laporan;
        $tanggalLaporan = $laporan->tanggal_laporan?->format('d-m-Y') ?? '-';
        $gambarLaporan = $laporan->gambar_laporan;

        $laporan->delete();

        // Hapus file gambar setelah data database berhasil dihapus.
        if ($gambarLaporan) {
            Storage::disk('public')->delete($gambarLaporan);
        }

        RiwayatHelper::catat(
            'Hapus',
            'Laporan',
            'Menghapus laporan "' . $judulLaporan . '" pada ' . $tanggalLaporan
        );

        return redirect()
            ->route('laporan.index')
            ->with('success', 'Laporan harian berhasil dihapus.');
    }

    /**
     * Aturan validasi tambah dan edit laporan.
     */
    private function rules(): array
    {
        return [
            'judul_laporan' => 'required|string|max:100',
            'tanggal_laporan' => 'required|date',
            'aktivitas' => 'required|in:Penanaman,Perawatan,Pembersihan',
            'nama_petugas' => 'required|string|max:50',
            'gambar_laporan' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'catatan' => 'nullable|string|max:255',
            'id_greenhouse' => 'required|exists:greenhouse,id_greenhouse',
        ];
    }
}