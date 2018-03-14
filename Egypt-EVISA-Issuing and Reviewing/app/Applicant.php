<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Applicant extends Model
{
	protected $table = 'APPLICANT';
	protected $primaryKey = 'APPLICATION_NO';

	public static $validations = [
	'application_no' => 'required|regex:/(^[A-Za-z0-9\-]+$)+/'
	];

	public static $date_validation = [
	'from_date' => 'required|date_format:d/m/Y',
	'to_date' => 'required|date_format:d/m/Y'
	];

	public static $messages = [
	'application_no.required' => 'يجيب ادخال رقم الطلب',
	'application_no.regex'=> '  رقم غير صحيح',
	'date.required' => 'يجب ادخال التاريخ',
	'from_date.date' => '  هذا التاريخ غير صحيح ',
	'from_date.date_format' => 'لابد ادخال التاريخ بهذا الشكل: يوم/شهر/سنة',
	'to_date.date' => '  هذا التاريخ غير صحيح ',
	'to_date.date_format' => 'لابد ادخال التاريخ بهذا الشكل: يوم/شهر/سنة'
	];

	public function getnationality(){
		return $this->belongsTo('App\Country','current_nationality','country_id');
	}

	public function getenrollment(){
		return $this->hasOne('App\Applicationenrollment' , 'application_no' , 'application_no' ) ; 
	}

	public function getlog(){
	return $this->hasMany('App\Applicationlog' , 'application_no' , 'application_no' ) ; 	
	}

	public function getapplication(){
		return $this->belongsTo('App\Application','reference_no','reference_no');
	}
	

}
