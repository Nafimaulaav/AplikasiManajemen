<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class CobaGreenhouse extends Authenticatable
{
    // buat nama tabel
    protected $table = 'greenhouse';
    // buat bikin primary key
    protected $primaryKey = 'id_greenhouse';
    // biar kaga auto increment, soalnya pake string, pengen biar U0001 gitu dah
    public $incrementing = false;
    // buat tipe data primary key string
    protected $keyType = 'string';
    // biar kaga pake timestamps
    public $timestamps = false;

    // kolom yg bisa diisi
    protected $fillable = [
        'id_greenhouse',
        'nama_greenhouse',
        'lokasi_greenhouse',
        'status_greenhouse',
        'tanggal_operasional',
        'kapasitas'
    ];
}

?>