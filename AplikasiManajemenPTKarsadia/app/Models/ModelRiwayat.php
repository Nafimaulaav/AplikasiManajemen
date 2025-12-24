<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelRiwayat extends Model
{
    // buat bikin tabelnya
    protected $table = 'riwayat';
    
    // buat yg bisa diiisi
    protected $fillable =[
        'tipe_aksi',
        'menu_terkait',
        'deskripsi',
        'id_user',
    ];

    // buat foreign key
    public function user()
    {
        return $this->belongsTo(ModelUser::class, 'id_user','id_user');
    }
}
