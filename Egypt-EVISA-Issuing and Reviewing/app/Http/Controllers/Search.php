<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use Illuminate\Support\Facades\Route;
use Session;
use Illuminate\Support\Facades\Redirect;
use App\Applicationlog;
use App\Applicant;
use App\Permission;
use App\Country ; 
use App\Grants;
use App\User;
use Validator;
use Auth;
use Hash;
use DB;
use Carbon ;
use Yajra\Datatables\Datatables;



class Search extends Controller
{
	
	public function __construct(){
		$this->middleware('auth');
		$route = Route::getCurrentRoute()->getPath();
		$route = explode("/", $route);
		$exceptions = $route;
		$route = $route[0];
		$session = Session::get('grants');
		if(empty($session[$route])){
			abort('401');
		}

	}

   /**
   * Index function of search
   */
   public function Search(){
   	$nationalities = Country::all();
   	return view('Search.Search',['nationalities'=>$nationalities]);
   }

   /**
   * return applications list 	
   */
   public function applications()
   {	
   	$results = Applicant::all();
   	return Datatables::of($results)
   	->addColumn('application_date', function($row){
   		return $row->getapplication->creation_date;
   	})
   	->addColumn('nationality', function($row){
   		return $row->getnationality->description;
   	})
   	->make(true);
   	return $results;
   }


   /**
   * view application details and log
   */
   public function viewapplication($application_no){
   	$application = Applicant::where('application_no','=',$application_no)->first();
   	$logs = $application->getlog()->get();
	return view('search.application',['application'=>$application,'logs'=>$logs]);
   }





}