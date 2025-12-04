<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelTanaman extends Model
{
    // buat nama tabel
    protected $table = 'tanaman';
    // buat bikin primary key
    protected $primaryKey = 'id_tanaman';
    // biar kaga auto increment, soalnya pake string, pengen biar TN0001
    public $incrementing = false;
    // buat tipe data primary key string
    protected $keyType = 'string';
    // biar kaga pake timestamps, soalnya kaga ada created_at sama updated_at nya
    public $timestamps = false;

    // kolom yg bisa diisi
    protected $fillable = [
        'id_tanaman',
        'varietas',
        'tanggal_tanam',
        'jumlah_tanaman',
        'status_tumbuh',
        'perkiraan_panen',
        'id_greenhouse'
    ];

    // relasi ke model greenhouse
    public function greenhouse()
    {
        return $this->belongsTo(ModelGreenhouse::class, 'id_greenhouse', 'id_greenhouse');
    }

    // auto generate ID "TN0001"
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id_tanaman = self::generateId();
        });
    }

    private static function generateId()
    {
        // ambil ID terbesar
        $last = self::orderBy('id_tanaman', 'desc')->first();

        // kalo belum ada data
        if (!$last) {
            return 'TN0001';
        }

        // ambil angka setelah TN
        $num = intval(substr($last->id_tanaman, 2)) + 1;

        // buat format TN0001
        return 'TN' . str_pad($num, 4, '0', STR_PAD_LEFT);
    }
}
