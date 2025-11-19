<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class CobaUser extends Authenticatable
{
    // buat nama tabel
    protected $table = 'users';
    // buat bikin primary key
    protected $primaryKey = 'id';
    // biar kaga auto increment, soalnya pake string, pengen biar U0001 gitu dah
    public $incrementing = false;
    // buat tipe data primary key string
    protected $keyType = 'string';
    // biar kaga pake timestamps
    public $timestamps = false;

    // kolom yg bisa diisi
    protected $fillable = [
        'id_user',
        'nama_user',
        'email',
        'password',
        'role'
    ];

    // biar password ga keliatan
    protected $hidden = [
        'password',
    ];
}

?>