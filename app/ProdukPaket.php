<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdukPaket extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    
    public function kategori(){
        return $this->belongsTo('App\Kategori');
    }
}
