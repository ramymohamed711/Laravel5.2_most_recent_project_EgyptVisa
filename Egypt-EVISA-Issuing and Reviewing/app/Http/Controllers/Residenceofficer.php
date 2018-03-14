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
use App\Grants;
use App\FSTATUS;
use Validator;
use Auth;
use Hash;
use DB;
use Carbon ;
use App\Traits\SimilartiesFunctions  ;
use App\Traits\CentralVisaFunctions; 


class Residenceofficer extends Controller
{
  protected $url_blwebserivce =  "http://127.0.0.1:8080/blwebservice-webservice/restBL/blacklist/";
  use SimilartiesFunctions; 
  use CentralVisaFunctions ; 


      /**
      * Check user accessability 
      */
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
      * Open contact officer main page 
      */
      
      public function residenceofficer(){

        return view('residenceofficer.residenceofficer') ;
      }


      /**
      * Load under review applications and it's enrollment similarities
      */
      public function applications(){

        $applications = null ; /** load the assinged application for user */
        $numbers = null; /** load the assined applications numbers for user */

        /**
        * Get assgined application for this user 
        */
        $applications = Applicationlog::where('ACTION_USER','=',Auth::user()->id)->get();

        /**
        * If there isn't assigned applications
        * then assign new applications 10 by 10 
        */
        if($applications->isEmpty())   {


         $applications =   Applicationlog::where("APPSTATUS_ID","=",'4')
         ->whereNull('ACTION_USER')
         ->whereNotExists(function($query)
         {
          $query->select(DB::raw('APPLICATION_NO'))
          ->from('UNDERSUSPEND')
          ->whereRaw('application_log.APPLICATION_NO = UNDERSUSPEND.APPLICATION_NO AND APPSTATUS_ID = 6 ');
        })
         ->whereNotExists(function($query)
         {
           $query->select(DB::raw('APPLICATION_NO'))
           ->from('FINISHED')
           ->whereRaw('application_log.APPLICATION_NO = FINISHED.APPLICATION_NO');
         })
         ->orderBy("log_date")
         ->orderBy("log_date")
         ->take(10)
         ->get();
       }

      /**
      * assgin the new applications to user 
      */
      if(!$applications->isEmpty()){
        $numbers = '' ; 
        foreach ($applications as $application) {

          Applicationlog::where('application_no','=',$application->application_no)
          ->where('APPSTATUS_ID','=','4')
          ->update(['ACTION_USER'=>Auth::user()->id]);
          $numbers = $numbers.$application->application_no.',';

        }
      }

      /**
      * load application detalis from application model
      */
      $tmp_applications = array();
      foreach ($applications as $application) {
        $app = $application->applicationdetails()->get();
        $tmp_applications[] = $app[0]; 
      }

      $applications = (object)$tmp_applications ; 

      return view('residenceofficer.applications',['applications'=>$applications,'numbers'=>base64_encode(urlencode($numbers))]) ;
    } 
    /* End of get applications */


      /**
      * Show enrollment similarities 
      */

      public function getsimilarities($application_no){

        $review_check = Applicationlog::where('application_no','=',$application_no)
        ->where(function($query){
          $query->where("APPSTATUS_ID","=",4)
          ->where("ACTION_USER",'=',Auth::user()->id);
        })
        ->orWhere(function($query){
          $query->where("APPSTATUS_ID","=",6)
          ->where("USER_ID",'=',Auth::user()->id);
        })
        ->first();
        
        
        $application = null;
        if(!empty($review_check)){
         $application = $this->checkapplication($application_no);  
       }                   

       
       
       $similarities = $this->similarities_org($application);

       $log = $this->application_log($application_no);

       $application->barcode= $this->generatebarcode($application_no);

       return view('residenceofficer.similarities',['application'=>$application,'similarities'=>$similarities,'log'=>$log]);
     }


      /**
      * Search by application number 
      */
      public function search(){
        return view('residenceofficer.search');
      }
      /**
      * Handle search for contact officer suspended applications
      */
      public function handelsearch(Request $request){
        $validator = Validator::make($request->all(),Applicant::$validations,Applicant::$messages);        
        if ($validator->fails()) {
          $this->throwValidationException(
            $request, $validator
            );
        }

        $application = $this->checkapplication($request->application_no);
        $review_check = Applicationlog::where('application_no','=',$request->application_no)
        ->where('appstatus_id','=',6)
        ->orwhere(function($q) use ($request) {
          $q->where('application_no','=',$request->application_no)
          ->where('appstatus_id' ,'=', 4)
          ->where('ACTION_USER' ,'=', Auth::user()->id);
        })->first();

        if(empty($application) || empty($review_check)){
          $validator->errors()->add('application_no', 'لا يمكن عرض هذا الطلب ');
          $this->throwValidationException(
            $request, $validator
            );
        }

        $similarities = $this->similarities_org($application);
        $log = $this->application_log($request->application_no);
        $application->barcode= $this->generatebarcode($request->application_no);
        return view('residenceofficer.similarities',['application'=>$application,'similarities'=>$similarities,'search'=>true ,'log'=>$log]);
      }


      /*
      * Print function that suspendes the application
      */
      public function printapplication($application_no) {

        $numbers = base64_decode($application_no);
        $numbers = urldecode($numbers);
        $numbers = explode(',', $numbers);

        $error  = false ; 
        $applications =  array();
        foreach ($numbers as $application_no) {

          $application = $this->checkapplication($application_no);

          /*Check application not suspended before*/
          $suspended_app = Applicationlog::where('application_no','=',$application_no)
          ->where('appstatus_id','=',6)->first();
          /** Check the application must be assigned to this user */
          $review_app = Applicationlog::where('application_no','=',$application_no)
          ->where('appstatus_id','=',4)
          ->where('action_user','=',Auth::user()->id)
          ->first();


          if(!empty($application) && empty($suspended_app) && !empty($review_app)){
            DB::setDateFormat('yyyy-MM-dd hh.mi.ss am');

            $data = ['application_no'=>$application_no , 
            'user_id' => Auth::user()->id,
            'appstatus_id' => 6,
            'log_date'=>Carbon\Carbon::now('Africa/Cairo')->format('Y-M-d h.i.s A')
            ];

            if(Applicationlog::create($data)){
             Applicationlog::where('application_no','=',$application_no)
             ->where('APPSTATUS_ID','=','4')
             ->where('ACTION_USER','=',Auth::user()->id)
             ->update(['ACTION_USER'=>'']);
             $similarities = $this->similarities_org($application);
             $application->similarities = $similarities; 
             $log = $this->application_log($application_no);
             $application->log = $log;
             $application->barcode= $this->generatebarcode($application_no);
             $applications[] = $application;
           }
           else {
            $error = true;
          }
        }else if(!empty($suspended_app) && $suspended_app->user_id == Auth::user()->id){
          $similarities = $this->similarities_org($application);
          $application->similarities = $similarities; 
          $log = $this->application_log($application_no);
          $application->log = $log;
          $application->barcode= $this->generatebarcode($application_no);
          $applications[] = $application;
        }
      }
      if(!$error){

        return view('residenceofficer.printapplications',['applications'=>$applications,'print'=>true, 'error'=>$error]);
      }
      else{
       return "Error";
     }


   }
   /**end of print applications action*/

     /**
     * Contact officer reject application
     */
     public function rejectapplication(Request $request){
      $data = $request->only('application_no');
      $application = $this->checkapplication($request->application_no);

      if(!empty($application)){
        DB::setDateFormat('yyyy-MM-dd hh.mi.ss am');
        $data = $request->only('application_no');

        $data = ['application_no'=>$request->application_no , 
        'user_id' => Auth::user()->id,
        'appstatus_id' => 9,
        'log_date'=>Carbon\Carbon::now('Africa/Cairo')->format('Y-M-d h.i.s A')
        ];

        if(Applicationlog::create($data)){
         Applicationlog::where('application_no','=',$request->application_no)
         ->where('APPSTATUS_ID','=','4')
         ->where('ACTION_USER','=',Auth::user()->id)
         ->update(['ACTION_USER'=>'']);

         $ftatus_data = ['fstatus_id'=> 3 , 
         'status_date'=> Carbon\Carbon::now('Africa/Cairo')->format('Ymd'), 
         'reference_no'=>$data['reference_no'] ,
         'serial'=>$data['serial']];
         var_dump($ftatus_data);
         
         return "success";
       }// end of rejection creation

     }

     return "Error";
   }


     /**
     * Contact officer accept application
     */
     public function acceptapplication(Request $request){
      $data = $request->only('application_no');
      $application = $this->checkapplication($request->application_no);

      if(!empty($application)){
        DB::setDateFormat('yyyy-MM-dd hh.mi.ss am');
        $data = $request->only('application_no');

        $data = ['application_no'=>$request->application_no , 
        'user_id' => Auth::user()->id,
        'appstatus_id' => 10,
        'log_date'=>Carbon\Carbon::now('Africa/Cairo')->format('Y-M-d h.i.s A')
        ];

        if(Applicationlog::create($data)){
         Applicationlog::where('application_no','=',$request->application_no)
         ->where('APPSTATUS_ID','=','4')
         ->where('ACTION_USER','=',Auth::user()->id)
         ->update(['ACTION_USER'=>'']);
         $application = Applicant::find($request->application_no);
         $data = $this->preparecentraldata($application);
         $this->CENTRALVISAINSERT($data);


         return "success";
         }// end of approval creation
       }

       return "Error";
     }


        /**
      * Load printed applications
      */
        public function loadprinted(){
          return view('residenceofficer.loadprinted') ;
        }


      /**
      * print applications again by date
      */
      public function printagain(Request $request){

        $validator = Validator::make($request->all(),Applicant::$date_validation,Applicant::$messages);        
        if ($validator->fails()) {
          $this->throwValidationException(
            $request, $validator
            );
        }


        $numbers = '' ; 
        $from_date = $request->from_date;
        $to_date = $request->to_date ; 

        $from_date = Carbon\Carbon::createFromFormat('d/m/Y', $from_date)->format('Y-M-d'); 
        $to_date = Carbon\Carbon::createFromFormat('d/m/Y', $to_date)->format('Y-M-d'); 
        
        DB::setDateFormat('yyyy-MM-dd hh.mi.ss am');
        $applications =  Applicationlog::where('APPSTATUS_ID','=','6')
        ->where('USER_ID','=',Auth::user()->id)
        ->whereNotExists(function($query)
        {
          $query->select(DB::raw('application_no'))
          ->from('FINISHED')
          ->whereRaw('application_log.application_no = FINISHED.application_no');
        })
        ->whereDate('LOG_DATE','>=',$from_date)
        ->whereDate('LOG_DATE','<=',$to_date)
        ->orderBy("LOG_DATE",'ASC')
        ->paginate(10);

        $tmp_applications = array();
        foreach ($applications as $application) {
          $numbers = $numbers.$application->application_no.',';
          $app = $application->applicationdetails()->get();
          $application->details = (object)$app[0] ; 
        }
        return view('residenceofficer.printagain',['applications'=>$applications , 'numbers'=>base64_encode(urlencode($numbers))]);

      }

     /**
     * Check application validation rules
     */
     public function checkapplication($application_no){

       $application = Applicationlog::where("application_no","=",$application_no)
       ->where("APPSTATUS_ID","=",4)
       ->whereNotExists(function($query)
       {
        $query->select(DB::raw('application_no'))
        ->from('FINISHED')
        ->whereRaw('application_log.application_no = FINISHED.application_no');
      })->first();

       if(!empty($application)){
        $application = $application->applicationdetails()->get();
        $application = $application[0];
      }
      return $application;

    } /* End of check function */


    /** Get log of applications */
    public function application_log($application_no){
      $application_log = Applicationlog::where('application_no','=',$application_no)->whereIn('appstatus_id', [11, 12, 13,14])->orderBy('LOG_DATE','ASC')->get();
      $app_log = array();
      foreach ($application_log as $log) {
       $user = $log->getuser()->first();
       $status = $log->getstatus()->first();
       $app_log[]= [
       $user->name,
       $status->appstatus_name,
       $log->log_date
       ];
     }
     return $app_log;
   }





 }
