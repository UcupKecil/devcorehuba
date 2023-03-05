<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberEnduser extends Model
{
    protected $table = 'member';
	protected $primaryKey = 'id_member';

	public function penjualan(){
        return $this->hasMany('App\Penjualan', 'id_supplier');
    }
}
