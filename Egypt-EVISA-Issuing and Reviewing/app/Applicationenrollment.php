<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applicationenrollment extends Model
{
	protected $table = 'APP_ENROLLMENT';
		protected $primaryKey = 'APPLICATION_NO';
	public $incrementing = false;

	protected $fillable = [
        'application_no' , 'main_person_id'
    ];

    	public $timestamps = false;


}
