<?php  
namespace App\Traits;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use App\Applicant;
use App\Visa; 
use App\Person;
use App\FSTATUS;
use App\ISSUEDVISA;
use App\Nationalitydesc;
use Carbon ;
use Auth;
use Config;

trait CentralVisaFunctions
{

  /**
  * Generate VISA number
  */
  public function generatevisanumber(){
    $visa_no = 'EV-'.date('Y').rand(10000000000,99999999999);
    return $visa_no;
  }


  /**
  * Get blacklist phonatic 
  */
  public function blacklistphonatic($name){
    $encoded_name = urlencode(mb_convert_encoding($name,'ISO-8859-6','UTF-8'));
    $encoded_name = str_replace('%','_',$encoded_name);
    $url = 'http://localhost:5555/blphonatics/Bltest.jsp?name='.$encoded_name;
    $phonatic = file_get_contents($url);
    $phonatic = trim($phonatic);
    return $phonatic;
  }
  

  /**
  * Get names from application object
  */
  public function preparecentraldata($application){
    $nationality_code = Nationalitydesc::where('DESCRIPTION','=',$application->current_nationality)->first(); 
    $data = ['ar_fullname'=>empty($application->ar_fullname)?'':$application->ar_fullname,
    'latin_name' => $application->latin_fullname,
    'visa_no' => $this->generatevisanumber(),
    'birth_date' => $application->birthdate , 
    'travdocno' => $application->trav_do_cno , 
    'reference_no' => $application->reference_no,
    'serial' => $application->serial,
    'current_nationality' => $nationality_code->nationality_code
    ];

    return $data ; 
  }

  /**
  * insert data in VISA and persons tables 
  */
  public function CENTRALVISAINSERT($data){
    $visa_id = collect(\DB::select(' SELECT CENTRALVISA.VISA_SEQ.nextval FROM DUAL'))->first();
    $visa_id = $visa_id->nextval;

    $person_id = collect(\DB::select(' SELECT CENTRALVISA.VISA_PER_SEQ.nextval FROM DUAL'))->first();
    $person_id = $person_id->nextval;    

    $visa_data = ['visa_id' => $visa_id ,
    'creation_date'=> \DB::raw('sysdate'),
    'last_update_date' => \DB::raw('sysdate'),
    'VERSION' => '0', 
    'created_user_login' =>  Auth::user()->name , 
    'issue_year' => date('Y'), 
    'port_id' => '90', 
    'visa_accepted_no' => 'AUTO', 
    'visa_end_date' => Carbon\Carbon::now('Africa/Cairo')->addDays(90)->format('Ymd'), 
    'visa_issue_date' => Carbon\Carbon::now('Africa/Cairo')->format('Ymd') , 
    'visa_no' => $data['visa_no'], 
    'visa_type' => '1', 
    'creation_location' => '90', 
    'granted_org_code' => '100',
    'MULTIPULE' => '0', 
    'deleted' => '0', 
    'VISA_ACCEPTANCE_DATE' => Carbon\Carbon::now('Africa/Cairo')->format('Ymd'), 
    'accepted_org_id' => '4' 
    ];

    $person_data = ['person_id'=> $person_id, 
    'creation_date' => \DB::raw('sysdate'), 
    'last_update_date' => \DB::raw('sysdate'),
    'version'=> '0', 
    'birth_date' => Carbon\Carbon::parse($data['birth_date'])->format('Ymd'), 
    'name' => !empty($data['ar_fullname'])?$data['ar_fullname']:$data['latin_name'], 
    'name_weight' => $this->blacklistphonatic(!empty($data['ar_fullname'])?$data['ar_fullname']:$data['latin_name']), 
    'person_no' => '0', 
    'port_id' => '90', 
    'res_duration_by_day' => '30', 
    'nationality_code' => $data['current_nationality'], 
    'deleted' => '0', 
    'visa_id' => $visa_id];

    if(Visa::create($visa_data) && Person::create($person_data)) { 

      $ftatus_data = ['fstatus_id'=> 2 , 
      'status_date'=> Carbon\Carbon::now('Africa/Cairo')->format('Ymd'), 
      'reference_no'=>$data['reference_no'] ,
      'serial'=>$data['serial']];
      var_dump($ftatus_data);

      FSTATUS::create($ftatus_data);

      $issuedvisa_data = ['visa_no'=> $data['visa_no'] , 
      'issuing_date'=> Carbon\Carbon::now('Africa/Cairo')->format('Ymd'), 
      'expire_date'=>Carbon\Carbon::now('Africa/Cairo')->addDays(90)->format('Ymd') ,
      'reference_no'=>$data['reference_no'],
      'serial'=>$data['serial']
      ];
      var_dump($issuedvisa_data);
      ISSUEDVISA::create($issuedvisa_data);

      return true;
    }   
    return false;

  }





}