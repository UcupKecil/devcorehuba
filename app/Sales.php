<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $table = 'sales';
	protected $primaryKey = 'id_sales';

	public function penjualan(){
        return $this->hasMany('App\Penjualan', 'id_supplier');
    }
}
