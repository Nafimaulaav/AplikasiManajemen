<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelPesanan extends Model
{
    // buat nama tabel
    protected $table = 'pesanan';
    // buat bikin primary key
    protected $primaryKey = 'id_pesanan';
    // biar kaga auto increment, soalnya pake string, pengen biar PS0001 gitu dah
    public $incrementing = false;
    // buat tipe data primary key string
    protected $keyType = 'string';
    // biar kaga pake timestamps
    public $timestamps = false;

    // kolom yg bisa diisi
    protected $fillable = [
        'id_pesanan',
        'nama_pelanggan',
        'alamat',
        'tanggal_pesan',
        'tanggal_kirim',
        'total_harga',
        'status_pesanan'
    ];

    // relasi ke pendapatn
    public function pendapatan()
    {
        return $this->hasMany(ModelPendapatan::class, 'id_pesanan', 'id_pesanan');
    }

    // relasi ke ulasan
    public function ulasan()
    {
        return $this->hasOne(ModelUlasan::class, 'id_pesanan', 'id_pesanan');
    }

    // relasi ke stok yg keknya butuh
    public function stok()
    {
        return $this->hasMany(ModelStok::class, 'id_pesanan', 'id_pesanan');
    }

    // auto generate id PS0001, PS0002, dst
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // jangan timpa ID jika seeder atau manual insert memberi ID
            if (!$model->id_pesanan) {
                $model->id_pesanan = self::generateId();
            }
        });
    }

    private static function generateId()
    {
        // ambil ID terakhir
        $last = self::orderBy('id_pesanan', 'desc')->first();

        if (!$last) {
            return 'PS0001';
        }

        $num = intval(substr($last->id_pesanan, 2)) + 1;

        return 'PS' . str_pad($num, 4, '0', STR_PAD_LEFT);
    }

}

