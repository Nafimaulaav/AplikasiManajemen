<?php

namespace App\Http\Controllers;

use App\Helpers\RiwayatHelper;
use App\Models\ModelQC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Throwable;

class QCController extends Controller
{
    /**
     * Menyimpan data QC baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $this->validasiJumlahTanaman($validated);

        $gambarBaru = $this->simpanGambar(
            $request->file('gambar_qc', [])
        );

        $validated['gambar_qc'] = $gambarBaru;

        try {
            $qc = ModelQC::create($validated);
        } catch (Throwable $error) {
            // Cegah file tertinggal jika penyimpanan database gagal.
            $this->hapusGambar($gambarBaru);

            throw $error;
        }

        RiwayatHelper::catat(
            'Tambah',
            'Quality Control',
            'Menambahkan data QC pada greenhouse: ' . $qc->id_greenhouse
        );

        return redirect()
            ->route('detail_greenhouse', $qc->id_greenhouse)
            ->with('success', 'Data QC berhasil ditambahkan.');
    }

    /**
     * Memperbarui data QC.
     */
    public function update(Request $request, $id_log_qc)
    {
        $qc = ModelQC::findOrFail($id_log_qc);

        $validated = $request->validate($this->rules());

        $this->validasiJumlahTanaman($validated);

        $gambarLama = $qc->gambar_qc ?? [];
        $gambarBaru = [];

        if ($request->hasFile('gambar_qc')) {
            $gambarBaru = $this->simpanGambar(
                $request->file('gambar_qc', [])
            );

            $validated['gambar_qc'] = $gambarBaru;
        }

        try {
            $qc->update($validated);
        } catch (Throwable $error) {
            // Hapus file baru jika pembaruan database gagal.
            $this->hapusGambar($gambarBaru);

            throw $error;
        }

        // Jika admin atau petugas mengunggah foto baru,
        // foto lama akan diganti dan dibersihkan.
        if ($gambarBaru !== []) {
            $this->hapusGambar($gambarLama);
        }

        RiwayatHelper::catat(
            'Ubah',
            'Quality Control',
            'Mengubah data QC pada greenhouse: ' . $qc->id_greenhouse
        );

        return redirect()
            ->route('detail_greenhouse', $qc->id_greenhouse)
            ->with('success', 'Data QC berhasil diperbarui.');
    }

    /**
     * Menghapus data QC dan seluruh foto terkait.
     */
    public function destroy($id_log_qc)
    {
        $qc = ModelQC::findOrFail($id_log_qc);

        $idGreenhouse = $qc->id_greenhouse;
        $gambarLama = $qc->gambar_qc ?? [];

        $qc->delete();

        $this->hapusGambar($gambarLama);

        RiwayatHelper::catat(
            'Hapus',
            'Quality Control',
            'Menghapus data QC pada greenhouse: ' . $idGreenhouse
        );

        return redirect()
            ->route('detail_greenhouse', $idGreenhouse)
            ->with('success', 'Data QC berhasil dihapus.');
    }

    /**
     * Aturan validasi tambah dan edit QC.
     */
    private function rules(): array
    {
        return [
            'tanggal_qc' => 'required|date',
            'nama_petugas' => 'required|string|max:50',
            'varietas_melon' => 'required|string|max:50',

            'status_tumbuh' => 'required|in:Vegetatif,Generatif,Panen',

            'total_tanaman' => 'required|integer|min:0',
            'jumlah_tanaman_tumbuh' => 'required|integer|min:0|lte:total_tanaman',
            'jumlah_tanaman_sehat' => 'required|integer|min:0|lte:total_tanaman',
            'jumlah_tanaman_sakit' => 'required|integer|min:0|lte:total_tanaman',
            'jumlah_tanaman_mati' => 'required|integer|min:0|lte:total_tanaman',

            'id_greenhouse' => 'sometimes|exists:greenhouse,id_greenhouse',

            // Maksimal empat gambar, masing-masing maksimal 5 MB.
            'gambar_qc' => 'nullable|array|max:4',
            'gambar_qc.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ];
    }

    /**
     * Memastikan jumlah tanaman tidak melebihi total tanaman.
     */
    private function validasiJumlahTanaman(array $validated): void
    {
        $jumlahKondisi =
            $validated['jumlah_tanaman_sehat']
            + $validated['jumlah_tanaman_sakit']
            + $validated['jumlah_tanaman_mati'];

        if ($jumlahKondisi > $validated['total_tanaman']) {
            throw ValidationException::withMessages([
                'total_tanaman' => 'Jumlah tanaman sehat, sakit, dan mati tidak boleh melebihi total tanaman.',
            ]);
        }
    }

    /**
     * Menyimpan gambar QC dan mengembalikan daftar path.
     */
    private function simpanGambar(array $gambar): array
    {
        $gambarPaths = [];

        foreach ($gambar as $file) {
            $gambarPaths[] = $file->store('qc_images', 'public');
        }

        return $gambarPaths;
    }

    /**
     * Menghapus seluruh gambar QC dari storage.
     */
    private function hapusGambar(array $gambarPaths): void
    {
        foreach ($gambarPaths as $path) {
            Storage::disk('public')->delete($path);
        }
    }
}