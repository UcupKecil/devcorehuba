<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockDetail extends Model
{
    protected $table = 'stock_details';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kode_produk', 'jumlah','id_user'
    ];
}
