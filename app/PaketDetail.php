<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaketDetail extends Model
{
    protected $table = 'paket_details';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_paket','kode_produk', 'nama_produk','harga_beli', 'diskon','harga_jual',
    ];
}
