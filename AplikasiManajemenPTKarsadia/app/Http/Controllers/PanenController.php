<?php

namespace App\Http\Controllers;

use App\Helpers\RiwayatHelper;
use App\Models\ModelGreenhouse;
use App\Models\ModelPanen;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PanenController extends Controller
{
    /**
     * Menampilkan seluruh data panen.
     */
    public function index()
    {
        $panen = ModelPanen::with('greenhouse')
            ->orderBy('tanggal_panen', 'desc')
            ->orderBy('id_panen', 'desc')
            ->get();

        $greenhouses = ModelGreenhouse::orderBy('id_greenhouse', 'asc')->get();

        return view('panen.index', compact('panen', 'greenhouses'));
    }

    /**
     * Menyimpan data panen baru.
     */
    public function StorePanen(Request $request)
    {
        $validated = $request->validate($this->rules());

        $this->validasiJumlahGrade($validated);

        $panen = ModelPanen::create($validated);

        RiwayatHelper::catat(
            'Tambah',
            'Panen',
            'Menambahkan data panen ' . $panen->id_panen
            . ' pada ' . $panen->tanggal_panen->format('d-m-Y')
        );

        return redirect()
            ->route('panen.index')
            ->with('success', 'Data panen berhasil ditambahkan.');
    }

    /**
     * Memperbarui data panen.
     */
    public function UpdatePanen(Request $request, $id_panen)
    {
        $panen = ModelPanen::findOrFail($id_panen);

        $validated = $request->validate($this->rules());

        $this->validasiJumlahGrade($validated);

        $panen->update($validated);

        RiwayatHelper::catat(
            'Ubah',
            'Panen',
            'Mengubah data panen ' . $panen->id_panen
            . ' pada ' . $panen->tanggal_panen->format('d-m-Y')
        );

        return redirect()
            ->route('panen.index')
            ->with('success', 'Data panen berhasil diperbarui.');
    }

    /**
     * Menghapus data panen.
     */
    public function DestroyPanen($id_panen)
    {
        $panen = ModelPanen::findOrFail($id_panen);

        $idPanen = $panen->id_panen;
        $tanggalPanen = $panen->tanggal_panen?->format('d-m-Y') ?? '-';

        $panen->delete();

        RiwayatHelper::catat(
            'Hapus',
            'Panen',
            'Menghapus data panen ' . $idPanen
            . ' pada ' . $tanggalPanen
        );

        return redirect()
            ->route('panen.index')
            ->with('success', 'Data panen berhasil dihapus.');
    }

    /**
     * Aturan validasi tambah dan edit panen.
     */
    private function rules(): array
    {
        return [
            'tanggal_panen' => 'required|date',
            'jumlah_panen' => 'required|integer|min:0',
            'jumlah_grade_a' => 'required|integer|min:0',
            'jumlah_grade_b' => 'required|integer|min:0',
            'jumlah_grade_c' => 'required|integer|min:0',
            'id_greenhouse' => 'required|exists:greenhouse,id_greenhouse',
        ];
    }

    /**
     * Mencegah jumlah grade melebihi jumlah panen.
     */
    private function validasiJumlahGrade(array $validated): void
    {
        $totalGrade =
            $validated['jumlah_grade_a']
            + $validated['jumlah_grade_b']
            + $validated['jumlah_grade_c'];

        if ($totalGrade > $validated['jumlah_panen']) {
            throw ValidationException::withMessages([
                'jumlah_panen' => 'Jumlah grade A, B, dan C tidak boleh melebihi total panen.',
            ]);
        }
    }
}