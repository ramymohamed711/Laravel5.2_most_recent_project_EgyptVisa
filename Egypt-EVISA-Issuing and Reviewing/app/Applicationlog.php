<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applicationlog extends Model
{
    protected $table = 'APPLICATION_LOG';
	protected $primaryKey = 'APPLICATION_NO';
	public $timestamps = false;
	public $incrementing = false;

	protected $fillable = [
        'user_id' , 'application_no', 'appstatus_id', 'log_date'
    ];

	public  function applicationdetails(){
		return $this->belongsTo('App\Applicant', 'application_no', 'application_no');
	}

	public function getuser(){
		return $this->hasOne('App\User','id', 'user_id');
	}

	public function getactionuser(){
		return $this->hasOne('App\User','id', 'action_user');
	}

	public function getstatus(){
		return $this->hasOne('App\Status','appstatus_id','appstatus_id');
	}

}
