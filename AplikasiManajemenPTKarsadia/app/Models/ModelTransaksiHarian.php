<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelTransaksiHarian extends Model
{
    // buat nama tabel
    protected $table = 'transaksi_harian';
    // buat bikin primary key
    protected $primaryKey = 'id_transaksi';
    // biar kaga auto increment, soalnya pake string, pengen biar TR0001
    public $incrementing = false;
    // buat tipe data primary key string
    protected $keyType = 'string';
    // biar kaga pake timestamps, soalnya kaga ada created_at sama updated_at nya
    public $timestamps = false;

    // kolom yg bisa diisi
    protected $fillable = [
        'id_transaksi',
        'tanggal_waktu_transaksi',
        'total_transaksi_harian',
        'nama_petugas'
    ];

    // auto generate id TR0001, TR0002, dst
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id_transaksi = self::generateId();
        });
    }

    private static function generateId()
    {
        // ambil ID terbesar (TRxxxx terakhir)
        $last = self::orderBy('id_transaksi', 'desc')->first();

        // klo gada data
        if (!$last) {
            return 'TR0001';
        }

        // ambil angka dari ID
        $num = intval(substr($last->id_transaksi, 2)) + 1;

        // return dalam format TR0001
        return 'TR' . str_pad($num, 4, '0', STR_PAD_LEFT);
    }
}
