<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
	return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');
Route::get('/users/users', ['as' => 'users','uses' =>'UsersController@users']);
Route::get('/users/create', ['as' => 'users','uses' =>'UsersController@create']);
Route::post('/users/add',['as'=>'update' , 'uses' => 'UsersController@add']);
Route::get('/users/changepassword', ['as' => 'changepassword','uses' =>'UsersController@changepassword']);
Route::post('/users/savepassword',['as'=>'savepassword' , 'uses' => 'UsersController@savepassword']);
Route::get('/users/edit/id/{id}', ['uses' =>'UsersController@edit']);
Route::post('/users/update',['as'=>'update' , 'uses' => 'UsersController@update']);
Route::post('/users/suspend',['as'=>'suspend' , 'uses' => 'UsersController@suspend']);
Route::get('/users/accessdenied', ['as' => 'accessdenied','uses' =>'HomeController@accessdenied']);

/*Checking officer actions*/
Route::get('/checkingofficer/checkingofficer', ['as' => 'checkingofficer','uses' =>'Checkingofficer@checkingofficer']);
Route::get('/checkingofficer/applications', ['as' => 'applications' ,'uses' =>'Checkingofficer@applications']);
Route::get('/checkingofficer/getsimilarities/application_no/{application_no}', ['as' => 'getsimilarities' ,'uses' =>'Checkingofficer@getsimilarities']);
Route::get('/checkingofficer/search', ['as' => 'search','uses' =>'Checkingofficer@search']);
Route::post('/checkingofficer/handelsearch',['as'=>'handelsearch' , 'uses' => 'Checkingofficer@handelsearch']);
Route::post('/checkingofficer/printapplication',['as'=>'printapplication' , 'uses' => 'Checkingofficer@printapplication']);
Route::post('/checkingofficer/sendtonationalsecurity',['as'=>'sendtonationalsecurity' , 'uses' => 'Checkingofficer@sendtonationalsecurity']);
Route::post('/checkingofficer/sendtocontactofficer',['as'=>'sendtocontactofficer' , 'uses' => 'Checkingofficer@sendtocontactofficer']);
Route::post('/checkingofficer/sendtonationalandcontact',['as'=>'sendtonationalandcontact' , 'uses' => 'Checkingofficer@sendtonationalandcontact']);
Route::post('/checkingofficer/negativesimilarities',['as'=>'negativesimilarities' , 'uses' => 'Checkingofficer@negativesimilarities']);





/*Contact officer actions*/
Route::get('/contactofficer/contactofficer', ['as' => 'contactofficer','uses' =>'Contactofficer@contactofficer']);
Route::get('/contactofficer/applications', ['as' => 'applications','uses' =>'Contactofficer@applications']);
Route::get('/contactofficer/getsimilarities/application_no/{application_no}', ['as' => 'getsimilarities' ,'uses' =>'contactofficer@getsimilarities']);
Route::get('/contactofficer/search', ['as' => 'search','uses' =>'contactofficer@search']);
Route::get('/contactofficer/loadprinted', ['as' => 'loadprinted','uses' =>'contactofficer@loadprinted']);
Route::post('/contactofficer/handelsearch',['as'=>'handelsearch' , 'uses' => 'contactofficer@handelsearch']);
Route::get('/contactofficer/printapplication/application_no/{application_no}',['as'=>'printapplication' , 'uses' => 'contactofficer@printapplication']);
Route::post('/contactofficer/acceptapplication',['as'=>'acceptapplication' , 'uses' => 'contactofficer@acceptapplication']);
Route::post('/contactofficer/rejectapplication',['as'=>'rejectapplication' , 'uses' => 'contactofficer@rejectapplication']);
Route::get('/contactofficer/printagain',['as'=>'printagain' , 'uses' => 'contactofficer@printagain']);





/*National security actions */
Route::get('/nationalsecurity/nationalsecurity', ['as' => 'nationalsecurity','uses' =>'Nationalsecurity@nationalsecurity']);
Route::get('/nationalsecurity/applications', ['as' => 'applications','uses' =>'Nationalsecurity@applications']);
Route::get('/nationalsecurity/getsimilarities/application_no/{application_no}', ['as' => 'getsimilarities' ,'uses' =>'nationalsecurity@getsimilarities']);
Route::get('/nationalsecurity/search', ['as' => 'search','uses' =>'Nationalsecurity@search']);
Route::post('/nationalsecurity/handelsearch',['as'=>'handelsearch' , 'uses' => 'nationalsecurity@handelsearch']);
Route::get('/nationalsecurity/printapplication/application_no/{application_no}',['as'=>'printapplication' , 'uses' => 'nationalsecurity@printapplication']);
Route::post('/nationalsecurity/acceptapplication',['as'=>'printapplication' , 'uses' => 'nationalsecurity@acceptapplication']);
Route::post('/nationalsecurity/rejectapplication',['as'=>'printapplication' , 'uses' => 'nationalsecurity@rejectapplication']);
Route::get('/nationalsecurity/loadprinted', ['as' => 'loadprinted','uses' =>'nationalsecurity@loadprinted']);
Route::get('/nationalsecurity/printagain',['as'=>'printagain' , 'uses' => 'nationalsecurity@printagain']);



/*Residence officer actiona */
Route::get('/residenceofficer/residenceofficer', ['as' => 'residenceofficer','uses' =>'residenceofficer@residenceofficer']);
Route::get('/residenceofficer/applications', ['as' => 'applications','uses' =>'residenceofficer@applications']);
Route::get('/residenceofficer/getsimilarities/application_no/{application_no}', ['as' => 'getsimilarities' ,'uses' =>'residenceofficer@getsimilarities']);
Route::get('/residenceofficer/search', ['as' => 'search','uses' =>'residenceofficer@search']);
Route::post('/residenceofficer/handelsearch',['as'=>'handelsearch' , 'uses' => 'residenceofficer@handelsearch']);
Route::get('/residenceofficer/printapplication/application_no/{application_no}',['as'=>'printapplication' , 'uses' => 'residenceofficer@printapplication']);
Route::post('/residenceofficer/acceptapplication',['as'=>'printapplication' , 'uses' => 'residenceofficer@acceptapplication']);
Route::post('/residenceofficer/rejectapplication',['as'=>'printapplication' , 'uses' => 'residenceofficer@rejectapplication']);
Route::get('/residenceofficer/loadprinted', ['as' => 'loadprinted','uses' =>'residenceofficer@loadprinted']);
Route::get('/residenceofficer/printagain',['as'=>'printagain' , 'uses' => 'residenceofficer@printagain']);


/*Search functions */
Route::get('/search/search',['as'=>'search' , 'uses' => 'search@search']);
Route::get('/search/applications',['as'=>'applications' , 'uses' => 'search@applications']);
Route::get('/search/viewapplication/application_no/{application_no}',['as'=>'viewapplication' , 'uses' => 'search@viewapplication']);
