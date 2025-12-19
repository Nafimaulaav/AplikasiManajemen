<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class ModelUser extends Authenticatable
{
    use HasFactory;
    // buat nama tabel
    protected $table = 'users';
    // buat bikin primary key
    protected $primaryKey = 'id_user';
    // biar kaga auto increment, soalnya pake string, pengen biar U0001 gitu dah
    public $incrementing = false;
    // buat tipe data primary key string
    protected $keyType = 'string';
    // biar kaga pake timestamps
    public $timestamps = false;

    // kolom yg bisa diisi
    protected $fillable = [
        'id_user',
        'username',
        'password',
        'role'
    ];

    // biar password ga keliatan
    protected $hidden = [
        'password',
    ];

    // auto generate ID "U0001"
    protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        if (!$model->id_user) {
            $last = self::orderBy('id_user', 'desc')->first();
            $num = $last ? intval(substr($last->id_user, 1)) + 1 : 1;
            $model->id_user = 'U' . str_pad($num, 4, '0', STR_PAD_LEFT);
        }
    });
}

}
