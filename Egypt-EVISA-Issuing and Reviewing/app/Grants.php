<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grants extends Model
{
    protected $table = 'orc_users_grants';
	protected $primaryKey = 'user_id';
	public $timestamps = false;

	protected $fillable = ['user_id', 'permission_id'];

	public function getpermission(){
		return $this->hasOne('App\Permission','permission_id','permission_id');
	}  
}
