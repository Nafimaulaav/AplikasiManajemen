<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelPendapatan extends Model
{
    // buat nama tabel
    protected $table = 'pendapatan';
    // buat bikin primary key
    protected $primaryKey = 'id_pendapatan';
    // biar kaga auto increment, soalnya pake string, pengen biar PD0001
    public $incrementing = false;
    // buat tipe data primary key string
    protected $keyType = 'string';
    // biar kaga pake timestamps, soalnya kaga ada created_at sama updated_at nya
    public $timestamps = false;

    // kolom yg bisa diisi
    protected $fillable = [
        'id_pendapatan',
        'keterangan',
        'tanggal_transaksi',
        'jumlah_pendapatan',
        'id_pesanan'
    ];

    // relasi ke model pesanan
    public function pesanan()
    {
        return $this->belongsTo(ModelPesanan::class, 'id_pesanan', 'id_pesanan');
    }

    // auto generate id PD0001, PD0002, dst
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id_pendapatan = self::generateId();
        });
    }

    private static function generateId()
    {
        // ambil ID terbesar (PDxxxx terakhir)
        $last = self::orderBy('id_pendapatan', 'desc')->first();

        // klo gada data
        if (!$last) {
            return 'PD0001';
        }

        // ambil angka dari ID
        $num = intval(substr($last->id_pendapatan, 2)) + 1;

        // return dalam format PD0001
        return 'PD' . str_pad($num, 4, '0', STR_PAD_LEFT);
    }
}
