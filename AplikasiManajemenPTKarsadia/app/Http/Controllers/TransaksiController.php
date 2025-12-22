<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ModelTransaksiHarian;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function index()
    {
        $bulan = Carbon::now()->month;
        $tahun = Carbon::now()->year;

        // Total pendapatan bulan ini
        $totalPendapatanBulanIni = ModelTransaksiHarian::whereMonth('tanggal_waktu_transaksi', $bulan)
            ->whereYear('tanggal_waktu_transaksi', $tahun)
            ->sum('total_transaksi_harian');

        // Jumlah transaksi bulan ini
        $jumlahPendapatan = ModelTransaksiHarian::whereMonth('tanggal_waktu_transaksi', $bulan)
            ->whereYear('tanggal_waktu_transaksi', $tahun)
            ->count();

        // Pendapatan terbaru
        $pendapatanTerbaru = ModelTransaksiHarian::latest('tanggal_waktu_transaksi')
            ->value('total_transaksi_harian');

        // Rekap pendapatan
        $rekapPendapatan = ModelTransaksiHarian::orderBy('tanggal_waktu_transaksi', 'desc')->get();

        return view('transaksi.transaksi', compact(
            'totalPendapatanBulanIni',
            'jumlahPendapatan',
            'pendapatanTerbaru',
            'rekapPendapatan'
        ));
    }
}
