<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'APP_STATUS';
	protected $primaryKey = 'APPSTATUS_ID';
	protected $fillable = [
        'appstatus_id' , 'appstatus_name'
    ];

	
}
