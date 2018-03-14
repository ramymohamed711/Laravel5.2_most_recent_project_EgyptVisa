<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
        protected $table = 'orc_users';
        protected $primaryKey = 'id';


    protected $fillable = [
        'id' , 'name', 'email', 'PASSWORD', 'STATUS' , 'user_group'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
    *get user's permissions
    */
    public function getgrants(){
        return $this->hasMany('App\Grants','user_id','id');
    }


    public static $validations = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:orc_users',
            'password' => 'required|min:6|confirmed',
        ];

    public static $editvalidations = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'confirmed|min:6',
        ];

    public static $changepassword = [
     'oldpassword' => 'required',
     'password' => 'required|min:6|confirmed',
    ];    
    
    public static $messages = [
            'name.required' => 'يجيب ادخال الاسم ',
            'name.max' => 'الحد الاقصى لعدد احرف الاسم هو 255 حرف',
            'email.required' => 'يجب ادخال الايميل ',
            'email.emai' => 'يجب ادخال ايميل صحيح',
            'email.unique' => 'قد تم تسجيل هذا الايمل من قبل',
            'email.max' => 'العدد الاقصى هو 255 حرف',
            'password.required' => 'يجب ادخال كلمة السر',
            'password.min' => 'الحد الادنى هو 6 حروف',            
            'password.confirmed' => 'يجب ان تطابق كلمة السر مع تاكيد كلمة السر', 
            'oldpassword.required' => 'يجب ادخال كلمة السر الحالية',
            
        ];
}
