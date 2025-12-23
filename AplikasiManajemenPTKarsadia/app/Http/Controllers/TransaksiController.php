<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelTransaksiHarian;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    // ======================
    // READ (LAPORAN)
    // ======================
    public function index()
    {
        $bulan = Carbon::now()->month;
        $tahun = Carbon::now()->year;

        $totalPendapatanBulanIni = ModelTransaksiHarian::whereMonth('tanggal_waktu_transaksi', $bulan)
            ->whereYear('tanggal_waktu_transaksi', $tahun)
            ->sum('total_transaksi_harian');

        $jumlahPendapatan = ModelTransaksiHarian::whereMonth('tanggal_waktu_transaksi', $bulan)
            ->whereYear('tanggal_waktu_transaksi', $tahun)
            ->count();

        $pendapatanTerbaru = ModelTransaksiHarian::latest('tanggal_waktu_transaksi')
            ->value('total_transaksi_harian');

        $rekapPendapatan = ModelTransaksiHarian::orderBy('tanggal_waktu_transaksi', 'desc')->get();

        return view('transaksi.transaksi', compact(
            'totalPendapatanBulanIni',
            'jumlahPendapatan',
            'pendapatanTerbaru',
            'rekapPendapatan'
        ));
    }

    // ======================
    // CREATE
    // ======================
    public function create()
    {
        return view('transaksi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_waktu_transaksi' => 'required|date',
            'total_transaksi_harian' => 'required|numeric',
            'nama_petugas' => 'required|string'
        ]);

        ModelTransaksiHarian::create([
            'tanggal_waktu_transaksi' => $request->tanggal_waktu_transaksi,
            'total_transaksi_harian' => $request->total_transaksi_harian,
            'nama_petugas' => $request->nama_petugas,
        ]);

        return redirect()->route('pendapatan')
            ->with('success', 'Transaksi berhasil ditambahkan');
    }

    // ======================
    // UPDATE
    // ======================
    public function edit($id)
    {
        $transaksi = ModelTransaksiHarian::findOrFail($id);
        return view('transaksi.edit', compact('transaksi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_waktu_transaksi' => 'required|date',
            'total_transaksi_harian' => 'required|numeric',
            'nama_petugas' => 'required|string'
        ]);

        $transaksi = ModelTransaksiHarian::findOrFail($id);

        $transaksi->update([
            'tanggal_waktu_transaksi' => $request->tanggal_waktu_transaksi,
            'total_transaksi_harian' => $request->total_transaksi_harian,
            'nama_petugas' => $request->nama_petugas,
        ]);

        return redirect()->route('pendapatan')
            ->with('success', 'Transaksi berhasil diperbarui');
    }

    // ======================
    // DELETE
    // ======================
    public function destroy($id)
    {
        $transaksi = ModelTransaksiHarian::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('pendapatan')
            ->with('success', 'Transaksi berhasil dihapus');
    }
}
