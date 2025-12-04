<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelStok extends Model
{
    // buat nama tabel
    protected $table = 'stok';

    // Tidak ada primary key
    protected $primaryKey = null;
    public $incrementing = false;

    // Laravel harus tahu bahwa tidak ada key
    public $timestamps = false;

    // daftar kolom
    protected $fillable = [
        'nama_barang',
        'jumlah_barang',
        'id_panen',
        'id_pesanan'
    ];

    // relasi
    public function panen()
    {
        return $this->belongsTo(ModelPanen::class, 'id_panen', 'id_panen');
    }

    public function pesanan()
    {
        return $this->belongsTo(ModelPesanan::class, 'id_pesanan', 'id_pesanan');
    }

    // override keyName agar Eloquent tidak mencari primary key
    public function getKeyName()
    {
        return null;
    }
}
