<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $fillable = [
        'nama', 'email','NIP','NoKTP','alamat','foto'
    ];
}
