<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visa extends Model
{
	protected $connection = 'centrealvisa';

	protected $table= 'visa';
	public $timestamps = false;
	public $incrementing = false;
	protected $primaryKey = 'visa_id';
	protected $fillable = [
	'visa_id' , 
	'creation_date',
	'last_update_date',
	'ceated_user_login' ,
	'issue_year' ,
	'port_id' ,
	'visa_accepted_no' ,
	'visa_end_date' , 
	'visa_issue_date' , 
	'visa_no' , 
	'visa_type' ,
	'VISA_ACCEPTANCE_DATE' , 
	'creation_location' ,
	'granted_org_code' , 
	'MULTIPULE' , 
	'deleted' ,
	'VERSION' ,  
	'accepted_org_id' 
	];

}
