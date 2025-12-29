<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ModelGreenhouse;
use App\Models\ModelPanen;
use App\Models\ModelTransaksiHarian;
use App\Models\ModelLaporanHarian;
use App\Models\ModelRiwayat;

class DashboardController extends Controller
{
    public function index()
    {
        $pendaptan = 0;

        if (Auth::check() && Auth::user()->role === 'admin'){
            $pendaptan = ModelTransaksiHarian::sum('total_transaksi_harian');
        }

        $panenTerakhir = ModelPanen::orderBy('tanggal_panen', 'desc')->first();
        return view('dashboard.index', [
             //status greenhouse
            'aktif' => ModelGreenhouse::where('status_greenhouse', 'Aktif')->count(),
            'perbaikan' => ModelGreenhouse::where('status_greenhouse', 'Perbaikan')->count(),
            'tidak_aktif' => ModelGreenhouse::where('status_greenhouse', 'Tidak Aktif')->count(),

            // kualitas panen
            'kualitasA' => ModelPanen::sum('jumlah_grade_a'),
            'kualitasB' => ModelPanen::sum('jumlah_grade_b'),
            'kualitasC' => ModelPanen::sum('jumlah_grade_c'),

            //total panen
            'totalPanen' => ModelPanen::sum('jumlah_panen'),

            // panen terkahir
            'panenTerakhir' => $panenTerakhir ? $panenTerakhir->tanggal_panen : 0,

            //Pendapatan
            'pendapatan' => $pendaptan,

            // laporan
            'laporanPerawatan' => ModelLaporanHarian::where('aktivitas', 'Perawatan')->count(),
            'laporanPenanaman' => ModelLaporanHarian::where('aktivitas', 'Penanaman')->count(),
            'laporanPembersihan' => ModelLaporanHarian::where('aktivitas', 'Pembersihan')->count(),


            // riwayat
            'riwayat' => ModelRiwayat::latest()->take(5)->get(),  
        ]);
        
    }
}
