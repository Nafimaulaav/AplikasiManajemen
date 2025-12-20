<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelGreenhouse extends Model
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
        'nama_greenhouse',
        'alamat_greenhouse',
        'gambar_greenhouse',
        'status_greenhouse',
        'suhu_greenhouse',
        'kelembaban_greenhouse',
        'intensitas_cahaya_greenhouse',
        'volume_air_greenhouse',
        'luas_greenhouse',
        'tinggi_greenhouse',
        'sistem_dipakai_greenhouse'
    ];

    // relasi ke model laporan harian
    public function laporanHarian()
    {
        return $this->hasMany(ModelLaporanHarian::class, 'id_greenhouse', 'id_greenhouse');
    }

    // relasi ke model log qc
    public function logQC()
    {
        return $this->hasMany(ModelQC::class, 'id_greenhouse', 'id_greenhouse');
    }

    // relasi ke model panen
    public function panen()
    {
        return $this->hasMany(ModelPanen::class, 'id_greenhouse', 'id_greenhouse');
    }

     protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (! $model->id_greenhouse) {
                $model->id_greenhouse = self::generateId();
            }
        });
    }

}

