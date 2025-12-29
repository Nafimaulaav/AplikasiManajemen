<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelTransaksiHarian;
use Carbon\Carbon;
use App\Helpers\RiwayatHelper;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
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
            ->value('total_transaksi_harian') ?? 0;

        $rekapPendapatan = ModelTransaksiHarian::orderBy('tanggal_waktu_transaksi', 'desc')->get();

        return view('transaksi.transaksi', compact(
            'totalPendapatanBulanIni',
            'jumlahPendapatan',
            'pendapatanTerbaru',
            'rekapPendapatan'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_waktu_transaksi' => 'required',
            'total_transaksi_harian' => 'required|numeric',
            'nama_petugas' => 'required|string'
        ]);

        ModelTransaksiHarian::create([
            'tanggal_waktu_transaksi' => $request->tanggal_waktu_transaksi,
            'total_transaksi_harian' => $request->total_transaksi_harian,
            'nama_petugas' => $request->nama_petugas,
        ]);
        
        // buat record tambah ke riwayat
        $tanggal = Carbon::parse($request->tanggal_waktu_transaksi)->format('d-m-Y');
        RiwayatHelper::catat(
            'Tambah',
            'Transaksi',
            'Menambahkan data transaksi pada ' . $tanggal
        );

        return redirect()->route('pendapatan')->with('success', 'Data berhasil disimpan!');
    }

    // --- TAMBAHKAN DARI SINI ---

    /**
     * Menampilkan halaman edit (form edit)
     */
    public function edit($id)
    {
        if(!Auth::user()->is_admin) {
            return redirect()->route('pendapatan')
                ->with('error', 'Anda tidak memiliki izin untuk mengedit data transaksi.');
        }
        // Mencari data berdasarkan ID (primary key kamu adalah id_transaksi)
        $transaksi = ModelTransaksiHarian::findOrFail($id);

        // Melempar data ke view edit.blade.php
        return view('transaksi.edit', compact('transaksi'));
    }

    /**
     * Memproses perubahan data ke database
     */
    public function update(Request $request, $id)
    {
        if(!Auth::user()->is_admin) {
            return redirect()->route('pendapatan')
                ->with('error', 'Anda tidak memiliki izin untuk mengupdate data transaksi.');
        }
        // Validasi inputan
        $request->validate([
            'tanggal_waktu_transaksi' => 'required',
            'total_transaksi_harian' => 'required|numeric',
            'nama_petugas' => 'required|string'
        ]);

        // Cari datanya
        $transaksi = ModelTransaksiHarian::findOrFail($id);

        // Update datanya
        $transaksi->update([
            'tanggal_waktu_transaksi' => $request->tanggal_waktu_transaksi,
            'total_transaksi_harian' => $request->total_transaksi_harian,
            'nama_petugas' => $request->nama_petugas,
        ]);

        // buat record update ke riwayat
        $tanggal = Carbon::parse($request->tanggal_waktu_transaksi)->format('d-m-Y');
        RiwayatHelper::catat(
            'Ubah',
            'Transaksi',
            'Mengubah data transaksi pada ' . $tanggal
        );

        // Balikkan ke halaman utama dengan pesan sukses
        return redirect()->route('pendapatan')->with('success', 'Data berhasil diperbarui!');
    }

    // --- SAMPAI SINI ---

    public function destroy($id)
    {
        if(!Auth::user()->is_admin) {
            return redirect()->route('pendapatan')
                ->with('error', 'Anda tidak memiliki izin untuk menghapus data transaksi.');
        }
        ModelTransaksiHarian::findOrFail($id)->delete();
        // buat record hapus ke riwayat
        RiwayatHelper::catat(
            'Hapus',
            'Transaksi',
            'Menghapus data transaksi dengan ID ' . $id
        );
        return redirect()->route('pendapatan')->with('success', 'Data berhasil dihapus!');
    }
}