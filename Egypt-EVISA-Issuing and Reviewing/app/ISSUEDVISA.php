<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ISSUEDVISA extends Model
{
    protected $connection = 'updatedorc';

	protected $table = 'ISSUED_VISA';
	public $incrementing = false;

	protected $fillable = [
        'visa_no' , 'expire_date'  , 'issuing_date' , 'reference_no' , 'serial'
    ];

    public $timestamps = false;
}
