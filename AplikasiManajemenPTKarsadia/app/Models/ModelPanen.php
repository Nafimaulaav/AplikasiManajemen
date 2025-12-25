<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelPanen extends Model
{
    // buat nama tabel
    protected $table = 'panen';
    // buat bikin primary key
    protected $primaryKey = 'id_panen';
    // biar kaga auto increment, soalnya pake string, pengen biar PN0001
    public $incrementing = false;
    // buat tipe data primary key string
    protected $keyType = 'string';
    // biar kaga pake timestamps, soalnya kaga ada created_at sama updated_at nya
    public $timestamps = false;

    // kolom yg bisa diisi
    protected $fillable = [
        'id_panen',
        'tanggal_panen',
        'jumlah_panen',
        'kualitas',
        'id_greenhouse'
    ];

    // relasi ke model greenhouse
    public function greenhouse()
    {
        return $this->belongsTo(ModelGreenhouse::class, 'id_greenhouse', 'id_greenhouse');
    }

        // auto generate id "PN0001"
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id_panen = self::generateId();
        });
    }

    private static function generateId()
    {
        // ambil id terbesar
        $last = self::orderBy('id_panen', 'desc')->first();

        // klo gada data
        if (!$last) {
            return 'PN0001';
        }

        // ambil angka setelah PN
        $num = intval(substr($last->id_panen, 2)) + 1;

        // format hasilnya PN0001
        return 'PN' . str_pad($num, 4, '0', STR_PAD_LEFT);
    }

}