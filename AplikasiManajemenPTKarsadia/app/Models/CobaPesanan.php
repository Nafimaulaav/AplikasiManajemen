<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class CobaPesanan extends Model
{
    // buat nama tabel
    protected $table = 'pesanan';
    // buat bikin primary key
    protected $primaryKey = 'id_pesanan';
    // biar kaga auto increment, soalnya pake string, pengen biar U0001 gitu dah
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
}

?>