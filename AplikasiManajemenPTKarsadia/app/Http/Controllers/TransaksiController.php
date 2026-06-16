<?php

namespace App\Http\Controllers;

use App\Helpers\RiwayatHelper;
use App\Models\ModelTransaksiHarian;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Menampilkan halaman pendapatan.
     */
    public function index()
    {
        $bulan = Carbon::now()->month;
        $tahun = Carbon::now()->year;

        $totalPendapatanBulanIni = ModelTransaksiHarian::whereMonth(
            'tanggal_waktu_transaksi',
            $bulan
        )
            ->whereYear('tanggal_waktu_transaksi', $tahun)
            ->sum('total_transaksi_harian');

        $jumlahPendapatan = ModelTransaksiHarian::whereMonth(
            'tanggal_waktu_transaksi',
            $bulan
        )
            ->whereYear('tanggal_waktu_transaksi', $tahun)
            ->count();

        $pendapatanTerbaru = ModelTransaksiHarian::latest(
            'tanggal_waktu_transaksi'
        )
            ->value('total_transaksi_harian') ?? 0;

        $rekapPendapatan = ModelTransaksiHarian::orderBy(
            'tanggal_waktu_transaksi',
            'desc'
        )->get();

        $newId = ModelTransaksiHarian::generateId();

        return view('transaksi.transaksi', compact(
            'totalPendapatanBulanIni',
            'jumlahPendapatan',
            'pendapatanTerbaru',
            'rekapPendapatan',
            'newId'
        ));
    }

    /**
     * Menyimpan transaksi baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $transaksi = ModelTransaksiHarian::create($validated);

        RiwayatHelper::catat(
            'Tambah',
            'Transaksi',
            'Menambahkan transaksi '
            . $transaksi->id_transaksi
            . ' pada '
            . $transaksi->tanggal_waktu_transaksi->format('d-m-Y H:i')
        );

        return redirect()
            ->route('pendapatan')
            ->with('success', 'Data transaksi berhasil disimpan.');
    }

    /**
     * Memperbarui transaksi.
     */
    public function update(Request $request, $id)
    {
        $transaksi = ModelTransaksiHarian::findOrFail($id);

        $validated = $request->validate($this->rules());

        $transaksi->update($validated);

        RiwayatHelper::catat(
            'Ubah',
            'Transaksi',
            'Mengubah transaksi '
            . $transaksi->id_transaksi
            . ' pada '
            . $transaksi->tanggal_waktu_transaksi->format('d-m-Y H:i')
        );

        return redirect()
            ->route('pendapatan')
            ->with('success', 'Data transaksi berhasil diperbarui.');
    }

    /**
     * Menghapus transaksi.
     */
    public function destroy($id)
    {
        $transaksi = ModelTransaksiHarian::findOrFail($id);

        $idTransaksi = $transaksi->id_transaksi;
        $tanggalTransaksi = $transaksi
            ->tanggal_waktu_transaksi
            ?->format('d-m-Y H:i') ?? '-';

        $transaksi->delete();

        RiwayatHelper::catat(
            'Hapus',
            'Transaksi',
            'Menghapus transaksi '
            . $idTransaksi
            . ' pada '
            . $tanggalTransaksi
        );

        return redirect()
            ->route('pendapatan')
            ->with('success', 'Data transaksi berhasil dihapus.');
    }

    /**
     * Aturan validasi transaksi.
     */
    private function rules(): array
    {
        return [
            'tanggal_waktu_transaksi' => 'required|date',
            'total_transaksi_harian' => 'required|integer|min:1',
            'nama_petugas' => 'required|string|max:100',
        ];
    }
}