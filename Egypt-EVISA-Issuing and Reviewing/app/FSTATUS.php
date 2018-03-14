<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FSTATUS extends Model
{
    protected $connection = 'updatedorc';

	protected $table = 'APPLICATION_FSTATUS';
	public $incrementing = false;

	protected $fillable = [
        'fstatus_id' , 'status_date'  , 'reference_no' , 'serial'
    ];

    public $timestamps = false;

}
