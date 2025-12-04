<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelUlasan extends Model
{
    // buat nama tabel
    protected $table = 'ulasan';
    // buat bikin primary key
    protected $primaryKey = 'id_ulasan';
    // biar kaga auto increment, soalnya pake string, pengen biar UL0001
    public $incrementing = false;
    // buat tipe data primary key string
    protected $keyType = 'string';
    // biar kaga pake timestamps, soalnya kaga ada created_at sama updated_at nya
    public $timestamps = false;

    // kolom yg bisa diisi
    protected $fillable = [
        'id_ulasan',
        'rating',
        'isi_ulasan',
        'tanggal_ulasan',
        'id_pesanan'
    ];

    // relasi ke model pesanan
    public function pesanan()
    {
        return $this->belongsTo(ModelPesanan::class, 'id_pesanan', 'id_pesanan');
    }

    // AUTO GENERATE ID ULxxxx
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id_ulasan) {
                $model->id_ulasan = self::generateId();
            }
        });
    }

    private static function generateId()
    {
        // Ambil ID terbesar
        $last = self::orderBy('id_ulasan', 'desc')->first();

        if (!$last) {
            return 'UL0001';
        }

        // Ambil angka setelah prefix UL
        $num = intval(substr($last->id_ulasan, 2)) + 1;

        // Format UL0001
        return 'UL' . str_pad($num, 4, '0', STR_PAD_LEFT);
    }
}
