<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelLaporanHarian extends Model
{
    // buat nama tabel
    protected $table = 'laporanharian';
    // buat bikin primary key
    protected $primaryKey = 'id_laporanharian';
    // biar kaga auto increment, soalnya pake string, pengen biar LP0001
    public $incrementing = false;
    // buat tipe data primary key string
    protected $keyType = 'string';
    // biar kaga pake timestamps, soalnya kaga ada created_at sama updated_at nya
    public $timestamps = false;

    // kolom yg bisa diisi
    protected $fillable = [
        'id_laporanharian',
        'tanggal_laporan',
        'aktivitas',
        'catatan',
        'gambar',
        'id_greenhouse'
    ];

    // relasi ke model greenhouse
    public function greenhouse()
    {
        return $this->belongsTo(ModelGreenhouse::class, 'id_greenhouse', 'id_greenhouse');
    }

    // coba bikin auto generate id laporan harian
    protected static function boot()
    {
        parent::boot();
        static::creating(function($model) {
            if (!$model->id_laporanharian) {
                $last = self::orderBy('id_laporanharian', 'desc')->first();
                if ($last) {
                    $number = intval(substr($last->id_laporanharian, 2)) + 1;
                } else {
                    $number = 1;
                }

                // format id nya LP0001, LP0002, dst
                $model->id_laporanharian = 'LP' . str_pad($number, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}


