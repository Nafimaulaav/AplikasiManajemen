<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelQC extends Model
{
    // buat nama tabel
    protected $table = 'log_quality_control';
    // buat bikin primary key
    protected $primaryKey = 'id_log_qc';
    // buat increment
    public $incrementing = true;
    protected $keyType = 'int';


    // kolom yg bisa diisi
    protected $fillable = [
        'id_log_qc',
        'tanggal_qc',
        'nama_petugas',
        'varietas_melon',
        'status_tumbuh',
        'total_tanaman',
        'jumlah_tanaman_tumbuh',
        'jumlah_tanaman_sehat',
        'jumlah_tanaman_sakit',
        'jumlah_tanaman_mati',
        'id_greenhouse'
    ];

    // relasi ke model greenhouse
    public function greenhouse()
    {
        return $this->belongsTo(ModelGreenhouse::class, 'id_greenhouse', 'id_greenhouse');
    }

}
