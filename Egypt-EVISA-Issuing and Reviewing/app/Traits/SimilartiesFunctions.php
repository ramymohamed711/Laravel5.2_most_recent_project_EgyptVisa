<?php 
namespace App\Traits;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use App\Applicant;

trait SimilartiesFunctions
{
	/**
	* Generate barcode function
	*/
	public function generatebarcode($application_no)
	{

		$barcode = new BarcodeGenerator();
		$barcode->setText($application_no);
		$barcode->setType(BarcodeGenerator::Code128);
		$barcode->setScale(2);
		$barcode->setThickness(25);
		$barcode->setFontSize(10);
		$code = $barcode->generate();
		return $code;
	}

	/** Send name and birthdate to web service to get the similarties using name and birthdate */
      public function loadsimilarties($main_person_id ){

        $privateKey = 'TF7Rgd3yY35uI6@WEBSERVICE';
        $hash = strtoupper(md5(strtoupper(md5(base64_encode($main_person_id).$privateKey ))));
        $content = '{"id":"'.$main_person_id.'","hash":"'.$hash.'"}';
        $curl = curl_init($this->url_blwebserivce.'blsearchId');
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
        $main_person_id = $application->getenrollment()->first();

        $similarities = $this->loadsimilarties($main_person_id->main_person_id);
        $similarities['main_person_id'] =$main_person_id->main_person_id;
        $actions = array();
        $actions_tmp = explode(",", $similarities['actions']);
        foreach ($actions_tmp as $tmp ) {
          $actions[]= explode("-", $tmp);
        }
        
        $similarities['actions'] = $actions;
        return $similarities; 
      }





}