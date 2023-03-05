<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisMember extends Model
{
    protected $table = 'jenis_member';
	protected $primaryKey = 'id_jenis';
	
	
	public function member(){
		return $this->hasMany('App\Member', 'jenis_member');
	}
}
