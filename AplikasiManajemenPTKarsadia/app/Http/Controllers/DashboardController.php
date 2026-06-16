<?php

namespace App\Http\Controllers;

use App\Models\ModelGreenhouse;
use App\Models\ModelLaporanHarian;
use App\Models\ModelPanen;
use App\Models\ModelRiwayat;
use App\Models\ModelTransaksiHarian;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menampilkan ringkasan data aplikasi.
     */
    public function index()
    {
        $isAdmin = Auth::user()?->role === 'admin';

        $panenTerakhir = ModelPanen::orderByDesc('tanggal_panen')->first();

        $tanggalPanenTerakhir = $panenTerakhir?->tanggal_panen
            ? Carbon::parse($panenTerakhir->tanggal_panen)->format('d-m-Y')
            : '-';

        return view('dashboard.index', [
            // Hak akses.
            'isAdmin' => $isAdmin,

            // Status greenhouse.
            'aktif' => ModelGreenhouse::where(
                'status_greenhouse',
                'Aktif'
            )->count(),

            'perbaikan' => ModelGreenhouse::where(
                'status_greenhouse',
                'Perbaikan'
            )->count(),

            'tidak_aktif' => ModelGreenhouse::where(
                'status_greenhouse',
                'Tidak Aktif'
            )->count(),

            // Kualitas panen.
            'kualitasA' => ModelPanen::sum('jumlah_grade_a'),
            'kualitasB' => ModelPanen::sum('jumlah_grade_b'),
            'kualitasC' => ModelPanen::sum('jumlah_grade_c'),

            // Total dan tanggal panen terakhir.
            'totalPanen' => ModelPanen::sum('jumlah_panen'),
            'panenTerakhir' => $tanggalPanenTerakhir,

            // Pendapatan hanya ditampilkan kepada admin.
            'pendapatan' => $isAdmin
                ? ModelTransaksiHarian::sum('total_transaksi_harian')
                : null,

            // Laporan harian.
            'laporanPerawatan' => ModelLaporanHarian::where(
                'aktivitas',
                'Perawatan'
            )->count(),

            'laporanPenanaman' => ModelLaporanHarian::where(
                'aktivitas',
                'Penanaman'
            )->count(),

            'laporanPembersihan' => ModelLaporanHarian::where(
                'aktivitas',
                'Pembersihan'
            )->count(),

            // Riwayat aktivitas hanya ditampilkan kepada admin.
            'riwayat' => $isAdmin
                ? ModelRiwayat::with('user')
                    ->latest('created_at')
                    ->take(5)
                    ->get()
                : collect(),
        ]);
    }
}