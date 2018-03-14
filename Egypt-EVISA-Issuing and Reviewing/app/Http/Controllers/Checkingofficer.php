<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use App\Http\Requests;
use Illuminate\Support\Facades\Route;
use Session;
use Illuminate\Support\Facades\Redirect;
use App\Applicationlog;
use App\Applicant;
use App\Applicationenrollment;
use App\Permission;
use App\Grants;
use Validator;
use Auth;
use Hash;
use DB;
use Carbon ;
use PDO;
use App\Traits\CentralVisaFunctions; 


class Checkingofficer extends Controller
{


 protected $url_blwebserivce =  "http://127.0.0.1:8080/blwebservice-webservice/restBL/blacklist/";
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
		* Open checking officer main page 
    */

    public function Checkingofficer(){

     return view('Checkingofficer.Checkingofficer') ;
   }


        /**
		* Load under review applications and it's enrollment similarities
        */
    public function applications(){
      $application = null ; 
        	/**
            * Get application assigned to user
            */

        	$application = Applicationlog::where('ACTION_USER','=',Auth::user()->id)->first();
            /**
            * Get new application
            */

            if(empty($application))   {

                /**
                * Search for application not exisiting
                * under suspending or under auditing
                */

                $application =   Applicationlog::where("APPSTATUS_ID","=",'1')
                ->whereNull('ACTION_USER')
                ->whereNotExists(function($query)
                {
                  $query->select(DB::raw('APPLICATION_NO'))
                  ->from('UNDERSUSPEND')
                  ->whereRaw('application_log.APPLICATION_NO = UNDERSUSPEND.APPLICATION_NO ');
                })
                ->whereNotExists(function($query)
                {
                  $query->select(DB::raw('APPLICATION_NO'))
                  ->from('UNDERAUDTING')
                  ->whereRaw('application_log.APPLICATION_NO = UNDERAUDTING.APPLICATION_NO');
                }) ->whereNotExists(function($query)
                {
                  $query->select(DB::raw('APPLICATION_NO'))
                  ->from('FINISHED')
                  ->whereRaw('application_log.APPLICATION_NO = FINISHED.APPLICATION_NO');
                })
                ->orderBy("log_date")
                ->first();

              } /* End of get new application */

              if(!empty($application)){

                    /**
                    * Update action user
                    */
                    if(empty($application->ACTION_USER)){
                      Applicationlog::where('application_no','=',$application->application_no)
                      ->where('APPSTATUS_ID','=','1')
                      ->update(['ACTION_USER'=>Auth::user()->id]);
                    }

                    $application = $application->applicationdetails()->get();
                    $application = $application[0];

                    $barcode = new BarcodeGenerator();
                    $barcode->setText($application->application_no);
                    $barcode->setType(BarcodeGenerator::Code128);
                    $barcode->setScale(2);
                    $barcode->setThickness(25);
                    $barcode->setFontSize(10);
                    $code = $barcode->generate();
                    $application->barcode= $code;
                  }


                  
                  $similarities = $this->similarities_org($application);
                  return view('Checkingofficer.similarities',['application'=>$application,'similarities'=>$similarities]);

                  //return view('Checkingofficer.applications',['application'=>$application]) ;
                } /* End of applications action */



        /**
        * Show enrollment similarities 
        */

        public function getsimilarities($application_no){

          $review_check = Applicationlog::where('application_no','=',$application_no)
          ->where("APPSTATUS_ID","=",1)
          ->where("ACTION_USER",'=',Auth::user()->id)->first();
          $application = null ; 
          if(!empty($review_check)){
           $application = $this->checkapplication($application_no);  
         }  

         $similarities = $this->similarities_org($application);
         return view('Checkingofficer.similarities',['application'=>$application,'similarities'=>$similarities]);
       }




        /**
        * Search by application number 
        */
        public function search(){
          return view('Checkingofficer.search');
        }
        /**
        * Handle search for checking officer suspended applications
        */
        public function handelsearch(Request $request){
          $validator = Validator::make($request->all(),Application::$validations,Application::$messages);        
          if ($validator->fails()) {
            $this->throwValidationException(
              $request, $validator
              );
          }
          $application = $this->checkapplication($request->application_no);
          $review_check = Applicationlog::where('application_no','=',$request->application_no)
          ->where('appstatus_id','=',5)
          ->orwhere(function($q) use ($request) {
            $q->where('application_no','=',$request->application_no)
            ->where('appstatus_id' ,'=', 1)
            ->where('ACTION_USER' ,'=', Auth::user()->id);
          })->first();

          if(empty($application) || empty($review_check)){
            $validator->errors()->add('application_no', 'لا يمكن عرض هذا الطلب ');
            $this->throwValidationException(
              $request, $validator
              );
          }


          $similarities = $this->similarities_org($application);
          $barcode = new BarcodeGenerator();
          $barcode->setText($application->application_no);
          $barcode->setType(BarcodeGenerator::Code128);
          $barcode->setScale(2);
          $barcode->setThickness(25);
          $barcode->setFontSize(10);
          $code = $barcode->generate();
          $application->barcode= $code;
          return view('Checkingofficer.similarities',['application'=>$application,'similarities'=>$similarities]);
        }


        /**
        * send application to national security officer
        */
        public function sendtonationalsecurity(Request $request){
          $application = $this->checkapplication($request->application_no);
          if(!empty($application)){
            $data  = $request->only('application_no');
            DB::setDateFormat('yyyy-MM-dd hh.mi.ss am');
            $data = $request->only('application_no');

            $data = ['application_no'=>$request->application_no , 
            'user_id' => Auth::user()->id,
            'appstatus_id' => 2,
            'log_date'=>Carbon\Carbon::now('Africa/Cairo')->format('Y-M-d h.i.s A')
            ];
            $main_person_id = $request->main_person_id  ;
            if(!empty($main_person_id)){
              $enrollment = ['application_no'=>$request->application_no , 'main_person_id'=>$main_person_id] ; 
              if(Applicationlog::create($data) && Applicationenrollment::create($enrollment)){
                Applicationlog::where('application_no','=',$request->application_no)
                ->where('APPSTATUS_ID','=','1')
                ->where('ACTION_USER','=',Auth::user()->id)
                ->update(['ACTION_USER'=>'']);
                return "success";
              }
            }
          }
          return "Error";
        }

        /**
        * send application to contact  officer
        */
        public function sendtocontactofficer(Request $request){
          $application = $this->checkapplication($request->application_no);
          if(!empty($application)){
            $data  = $request->only('application_no');
            DB::setDateFormat('yyyy-MM-dd hh.mi.ss am');
            $data = $request->only('application_no');

            $data = ['application_no'=>$request->application_no , 
            'user_id' => Auth::user()->id,
            'appstatus_id' => 3,
            'log_date'=>Carbon\Carbon::now('Africa/Cairo')->format('Y-M-d h.i.s A')
            ];

            $main_person_id = $request->main_person_id  ;
            if(!empty($main_person_id)){
              $enrollment = ['application_no'=>$request->application_no , 'main_person_id'=>$main_person_id] ; 
              if(Applicationlog::create($data) && Applicationenrollment::create($enrollment)){
               Applicationlog::where('application_no','=',$request->application_no)
               ->where('APPSTATUS_ID','=','1')
               ->where('ACTION_USER','=',Auth::user()->id)
               ->update(['ACTION_USER'=>'']);
               return "success";
             }
           }
         }
         return "Error";
       }        

        /**
        * send application to national security and contact officers
        */
        public function sendtonationalandcontact(Request $request){
          $application = $this->checkapplication($request->application_no);
          if(!empty($application)){
            $data  = $request->only('application_no');
            DB::setDateFormat('yyyy-MM-dd hh.mi.ss am');
            $data = $request->only('application_no');

            $data_national = ['application_no'=>$request->application_no , 
            'user_id' => Auth::user()->id,
            'appstatus_id' => 2,
            'log_date'=>Carbon\Carbon::now('Africa/Cairo')->format('Y-M-d h.i.s A')
            ];

            $data_contact = ['application_no'=>$request->application_no , 
            'user_id' => Auth::user()->id,
            'appstatus_id' => 3,
            'log_date'=>Carbon\Carbon::now('Africa/Cairo')->format('Y-M-d h.i.s A')
            ];

            $main_person_id = $request->main_person_id  ;
            if(!empty($main_person_id)){
              $enrollment = ['application_no'=>$request->application_no , 'main_person_id'=>$main_person_id] ; 
              if(Applicationlog::create($data_national) && Applicationlog::create($data_contact) && Applicationenrollment::create($enrollment)){
               Applicationlog::where('application_no','=',$request->application_no)
               ->where('APPSTATUS_ID','=','1')
               ->where('ACTION_USER','=',Auth::user()->id)
               ->update(['ACTION_USER'=>'']);
               return "success";
             }
           }
         }
         return "Error";
       }


        /**
        * Negative similarities
        */
        public function negativesimilarities(Request $request){
          $application = $this->checkapplication($request->application_no);
          if(!empty($application)){
            $data  = $request->only('application_no');
            DB::setDateFormat('yyyy-MM-dd hh.mi.ss am');
            $data = $request->only('application_no');

            $data = ['application_no'=>$request->application_no , 
            'user_id' => Auth::user()->id,
            'appstatus_id' => 10,
            'log_date'=>Carbon\Carbon::now('Africa/Cairo')->format('Y-M-d h.i.s A')
            ];

            
            if(Applicationlog::create($data)){
             Applicationlog::where('application_no','=',$request->application_no)
             ->where('APPSTATUS_ID','=','1')
             ->where('ACTION_USER','=',Auth::user()->id)
             ->update(['ACTION_USER'=>'']);

             $data = $this->preparecentraldata($application);
             $this->CENTRALVISAINSERT($data);



             return "success";
           }
         }
         return "Error";

       }


        /*
        * Print function that suspendes the application
        */
        public function printapplication(Request $request) {
          $application = $this->checkapplication($request->application_no);

          /*Check application not suspended before*/
          $suspended_app = Applicationlog::where('application_no','=',$request->application_no)
          ->where('appstatus_id','=',5)->first();

          if(!empty($application) && empty($suspended_app)){
            DB::setDateFormat('yyyy-MM-dd hh.mi.ss am');
            $data = $request->only('application_no');

            $data = ['application_no'=>$request->application_no , 
            'user_id' => Auth::user()->id,
            'appstatus_id' => 5,
            'log_date'=>Carbon\Carbon::now('Africa/Cairo')->format('Y-M-d h.i.s A')
            ];

            if(Applicationlog::create($data)){
             Applicationlog::where('application_no','=',$request->application_no)
             ->where('APPSTATUS_ID','=','1')
             ->where('ACTION_USER','=',Auth::user()->id)
             ->update(['ACTION_USER'=>'']);
             return "success";
           }
         }
         return "Error";

       }


       /**
       * Check application validation rules
       */
       public function checkapplication($application_no){

         $application = Applicationlog::where("application_no","=",$application_no)
         ->where("APPSTATUS_ID","=",1)
         ->whereNotExists(function($query)
         {
          $query->select(DB::raw('application_no'))
          ->from('UNDERAUDTING')
          ->whereRaw('application_log.application_no = UNDERAUDTING.application_no');
        }) 
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


      /** Send name and birthdate to web service to get the similarties using name and birthdate */
      public function loadsimilarties($name , $birthdate ){
        $birthYear = substr($birthdate ,0,4);
        $birthMonth = substr($birthdate ,5,2);
        $birthDay = substr($birthdate ,8,2); 
        $privateKey = 'TF7Rgd3yY35uI6@WEBSERVICE';
        $hash = strtoupper(md5(strtoupper(md5(base64_encode($name).$privateKey ))));


        $content = '{"name":"'.$name.'","birthDay":"'.$birthDay.'","birthMonth":"'.$birthMonth.'","birthYear":"'.$birthYear.'","hash":"'.$hash.'"}';
        $curl = curl_init($this->url_blwebserivce.'blsearch');
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(                                                                          
          'Content-Type: application/json;charset=utf-8',                                                                                
          'Content-Length: ' . strlen($content))                                                                       
        );   
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        $json_response = curl_exec($curl);
        $json_response = json_decode($json_response,true);

        return $json_response  ;

      } /** End of get similarties */

      /** prepare the smilarities to be showen in views **/
      public function similarities_org($application){
        $main_persons = array();
        $similarities =  array();
        if(!empty($application)){
          $similarities_arabic = $this->loadsimilarties($application->ar_fullname , $application->birthdate);
          for ($i  = 0 ; $i < sizeof($similarities_arabic) ; $i++) {
            $similarities_arabic[$i]['enrollment_requester'] = explode(',', $similarities_arabic[$i]['enrollment_requester']);
            $similarities_arabic[$i]['enrollment_action'] = explode(',', $similarities_arabic[$i]['enrollment_action']);
            $main_persons[] = $similarities_arabic[$i]['main_person_id'];
          }

          $similarities_latin_1 = $this->loadsimilarties($application->latin_fullname , $application->birthdate);
          for ($i  = 0 ; $i < sizeof($similarities_latin_1) ; $i++) {
            $similarities_latin_1[$i]['enrollment_requester'] = explode(',', $similarities_latin_1[$i]['enrollment_requester']);
            $similarities_latin_1[$i]['enrollment_action'] = explode(',', $similarities_latin_1[$i]['enrollment_action']);
            $main_persons[] = $similarities_latin_1[$i]['main_person_id'];
          }



          if(!empty($similarities_arabic)){ $similarities= array_merge($similarities , $similarities_arabic);  }
          if(!empty($similarities_latin_1)){ $similarities= array_merge($similarities , $similarities_latin_1);  }
          



          array_multisort($main_persons, SORT_ASC, $similarities);
          $similarities = array_map("unserialize", array_unique(array_map("serialize", $similarities)));
        }
        return $similarities;
      }




      


    }
