<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
	    protected $connection = 'centrealvisa';

	protected $table = 'PERSONS';

	public $timestamps = false;
	public $incrementing = false;

	protected $fillable = [
	'person_id' , 
	'creation_date', 
	'last_update_date', 
	'version', 
	'birth_date', 
	'name', 
	'name_weight', 
	'person_no', 
	'port_id', 
	'res_duration_by_day', 
	'nationality_code', 
	'deleted', 
	'visa_id'
	];

}
