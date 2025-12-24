<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelRiwayat;
use App\Models\ModelGreenhouse;
use App\Models\ModelLaporanHarian;
use App\Models\ModelQC;
use App\Models\ModelPanen;
use App\Models\ModelTransaksiHarian;

class RiwayatController extends Controller
{
    // buat nampilin halaman histori
    public function index() 
    {
        $riwayat = ModelRiwayat::with('user')
        ->orderBy('created_at', 'desc')
        ->get();

        return view('riwayat.index', compact('riwayat'));
    }

    // buat auto generate deskripsi
    public function generateDeskripsi($username, $tipe_aksi, $menu_terkait)
    {
        $kataKerja = [
            'Tambah' => 'menambahkan',
            'Ubah' => 'mengubah',
            'Hapus' => 'menghapus',
        ];

        $tambahanKata = $tipe_aksi === 'Tambah' ? ' baru' : '';

        return "{$username} {$kataKerja[$tipe_aksi]} {$menu_terkait} {$tambahanKata}";
    }
}
