<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisPembayaran extends Model
{
    protected $table = 'jenis_pembayaran';
	protected $primaryKey = 'id_jenis';
	
	
	public function member(){
		return $this->hasMany('App\Penjualan', 'jenis_pembayaran');
	}
}
