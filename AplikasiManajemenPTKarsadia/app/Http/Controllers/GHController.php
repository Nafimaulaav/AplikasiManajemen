<?php

namespace App\Http\Controllers;

use App\Helpers\RiwayatHelper;
use App\Models\ModelGreenhouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class GHController extends Controller
{
    /**
     * Menampilkan daftar greenhouse.
     */
    public function index()
    {
        $greenhouses = ModelGreenhouse::orderBy('id_greenhouse', 'asc')->get();

        // ID pada form hanya digunakan sebagai preview.
        // ID sebenarnya tetap dibuat otomatis oleh ModelGreenhouse.
        $last = ModelGreenhouse::orderBy('id_greenhouse', 'desc')->first();

        if ($last) {
            $num = intval(substr($last->id_greenhouse, 2)) + 1;
            $newid = 'GH' . str_pad($num, 4, '0', STR_PAD_LEFT);
        } else {
            $newid = 'GH0001';
        }

        return view('greenhouse.index', compact('greenhouses', 'newid'));
    }

    /**
     * Menyimpan greenhouse baru.
     */
    public function StoreGreenhouse(Request $request)
    {
        $validated = $request->validate([
            'nama_greenhouse' => 'required|string|max:50',
            'alamat_greenhouse' => 'required|string|max:100',
            'gambar_greenhouse' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'status_greenhouse' => 'required|in:Aktif,Tidak Aktif,Perbaikan',
        ]);

        if ($request->hasFile('gambar_greenhouse')) {
            $path = $request
                ->file('gambar_greenhouse')
                ->store('greenhouse_images', 'public');

            $validated['gambar_greenhouse'] = 'storage/' . $path;
        }

        $greenhouse = ModelGreenhouse::create($validated);

        RiwayatHelper::catat(
            'Tambah',
            'Greenhouse',
            'Menambahkan greenhouse baru: ' . $greenhouse->nama_greenhouse
        );

        return redirect()
            ->route('greenhouse.index')
            ->with('success', 'Greenhouse berhasil ditambahkan.');
    }

    /**
     * Memperbarui data utama greenhouse.
     */
    public function UpdateGreenhouse(Request $request, $id_greenhouse)
    {
        $greenhouse = ModelGreenhouse::findOrFail($id_greenhouse);

        $validated = $request->validate([
            'nama_greenhouse' => 'required|string|max:50',
            'alamat_greenhouse' => 'required|string|max:100',
            'status_greenhouse' => 'required|in:Aktif,Tidak Aktif,Perbaikan',
            'gambar_greenhouse' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        if ($request->hasFile('gambar_greenhouse')) {
            $path = $request
                ->file('gambar_greenhouse')
                ->store('greenhouse_images', 'public');

            // Hapus gambar lama setelah gambar baru berhasil disimpan.
            $this->hapusGambarGreenhouse($greenhouse->gambar_greenhouse);

            $validated['gambar_greenhouse'] = 'storage/' . $path;
        }

        $greenhouse->update($validated);

        RiwayatHelper::catat(
            'Ubah',
            'Greenhouse',
            'Mengubah data greenhouse: ' . $greenhouse->nama_greenhouse
        );

        return redirect()
            ->route('greenhouse.index')
            ->with('success', 'Greenhouse berhasil diperbarui.');
    }

    /**
     * Menampilkan detail greenhouse beserta riwayat QC.
     */
    public function DetailGreenhouse($id_greenhouse)
    {
        $greenhouse = ModelGreenhouse::with([
            'logQC' => function ($query) {
                $query->orderBy('tanggal_qc', 'desc');
            }
        ])->findOrFail($id_greenhouse);

        return view('greenhouse.detailgh', compact('greenhouse'));
    }

    /**
     * Memperbarui data monitoring greenhouse.
     */
    public function updateMonitoring(Request $request, $id_greenhouse)
    {
        $greenhouse = ModelGreenhouse::findOrFail($id_greenhouse);

        $validated = $request->validate([
            'waktu_monitoring' => 'required|date',
            'suhu_greenhouse' => 'required|numeric|between:-50,100',
            'kelembaban_greenhouse' => 'required|numeric|between:0,100',
            'intensitas_cahaya_greenhouse' => 'required|numeric|min:0',
            'volume_air_greenhouse' => 'required|numeric|min:0',
        ]);

        $greenhouse->update($validated);

        RiwayatHelper::catat(
            'Ubah',
            'Monitoring Greenhouse',
            'Memperbarui monitoring greenhouse: ' . $greenhouse->nama_greenhouse
        );

        return redirect()
            ->route('detail_greenhouse', $id_greenhouse)
            ->with('success', 'Monitoring greenhouse berhasil diperbarui.');
    }

    /**
     * Memperbarui spesifikasi greenhouse.
     */
    public function updateSpecs(Request $request, $id_greenhouse)
    {
        $greenhouse = ModelGreenhouse::findOrFail($id_greenhouse);

        $validated = $request->validate([
            'luas_greenhouse' => 'required|numeric|gt:0',
            'tinggi_greenhouse' => 'required|numeric|gt:0',
            'sistem_dipakai_greenhouse' => 'required|string|max:50',
        ]);

        $greenhouse->update($validated);

        RiwayatHelper::catat(
            'Ubah',
            'Spesifikasi Greenhouse',
            'Memperbarui spesifikasi greenhouse: ' . $greenhouse->nama_greenhouse
        );

        return redirect()
            ->route('detail_greenhouse', $id_greenhouse)
            ->with('success', 'Spesifikasi greenhouse berhasil diperbarui.');
    }

    /**
     * Menghapus greenhouse.
     */
    public function DestroyGreenhouse($id_greenhouse)
    {
        $greenhouse = ModelGreenhouse::findOrFail($id_greenhouse);

        $namaGreenhouse = $greenhouse->nama_greenhouse;
        $gambarGreenhouse = $greenhouse->gambar_greenhouse;

        $greenhouse->delete();

        // Hapus file gambar setelah record database berhasil dihapus.
        $this->hapusGambarGreenhouse($gambarGreenhouse);

        RiwayatHelper::catat(
            'Hapus',
            'Greenhouse',
            'Menghapus greenhouse: ' . $namaGreenhouse
        );

        return redirect()
            ->route('greenhouse.index')
            ->with('success', 'Greenhouse berhasil dihapus.');
    }

    /**
     * Menghapus gambar greenhouse lama.
     *
     * Fungsi ini juga dapat menangani gambar lama yang sebelumnya
     * tersimpan di folder public/images.
     */
    private function hapusGambarGreenhouse(?string $path): void
    {
        if (!$path) {
            return;
        }

        // Format baru: storage/greenhouse_images/nama-file.jpg
        if (str_starts_with($path, 'storage/')) {
            $storagePath = substr($path, strlen('storage/'));

            Storage::disk('public')->delete($storagePath);

            return;
        }

        // Format lama: images/nama-file.jpg
        File::delete(public_path($path));
    }
}