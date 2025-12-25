<?php

namespace App\Helpers;

use App\Models\ModelRiwayat;
use Illuminate\Support\Facades\Auth;

class RiwayatHelper
{
    public static function catat($tipeAksi, $menu, $deskripsi = null)
    {
        ModelRiwayat::create([
            'tipe_aksi'   => $tipeAksi,
            'menu_terkait'=> $menu,
            'deskripsi'   => $deskripsi ?? self::defaultDeskripsi($tipeAksi, $menu),
            'id_user'     => Auth::user()->id_user,
        ]);
    }

    private static function defaultDeskripsi($tipe, $menu)
    {
        $kata = [
            'Tambah' => 'menambahkan',
            'Ubah'   => 'mengubah',
            'Hapus'  => 'menghapus',
        ];

        return Auth::user()->name . ' ' . $kata[$tipe] . ' ' . $menu;
    }
}
