<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//$sms = new smsgetway();
//echo $sms->sendSMS('233242925729','heloo albert');

class smsgetway extends engineClass{
    public  $sql;
	public $session;
	function  __construct() {
			global $sql,$session,$phpmailer;
			$this->session= $session;
			$this->sql = $sql;
		}	
	
	public function sendSMS($to,$msg,$from = "HEWALE"){
		$to = $this->validateNumber($to);
		$params = array("from" => $from, 
						"to" => $to,
						"text" => $msg);
		
        $response = $this->sendToCurl(json_encode($params));

	    $this->smslog($to,$msg,$response);
		return $response;
	}


public function sendToCurl($params){

	$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://53n5z.api.infobip.com/sms/2/text/single",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $params,
  CURLOPT_HTTPHEADER => array(
    "Accept: application/json",
    "Authorization: App 88c8733b869968b63bdc22af7ff6a98a-c7db27cb-a5ee-450a-8bde-edf3a734f128",
    "Content-type: application/json"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  return "cURL Error #:" . $err;
} else {
  return $response;
}
}

public function validateNumber($number, $forced_prefix = NULL, $number_length = '0'){
		
		if (!$forced_prefix){
			$forced_prefix = "+233";
		}
		
		// Remove any non-numeric characters in the number
		$number = preg_replace('/[^\+0-9]/s','',$number);
		
		// If a prefix is allready added then return the number "as is"
		if ( substr($number, 0, 1) == "+" || substr($number, 0, 2) === "00" || substr($number, 0, 3) === "233" ){
			return $number;
		}

		if (substr($number, 0, 1)=='0' && substr($number,0,2)!='00'){
			// single 0 at the beginning of number, we're supposed to remove that
			$number = substr($number,1);
		}
		
		// Add a prefix if the number doesn't have one yet
		if (isset($forced_prefix) && strlen($forced_prefix) > 0){
			if (substr($number, 0, strlen($forced_prefix)) != $forced_prefix){
				// The beginning of the number does not match the forced prefix
			}else{
				$number = substr($number, strlen($forced_prefix));
			}
		}
		
		// Check if the number is still not numeric, if so we return 0/false
		if (!is_numeric($number)){
			return 0;
		}
		
		// Check if the number has the correct length. 
		// Setting $number_length to 0 or false will skip this test
		if ($number_length && strlen($number) != $number_length){
			return 0;
		}
		
		// Add the forced prefix
		$number = $forced_prefix . $number;
		
		return $number;
    }
    
    /** 
     * This code below does the insertion of each message sent in the sms_log table
     * 
    */
     private function smslog($destination,$message,$response){
        $uniqid = uniqid(date('Y-m-d'));
        $currentdate = date('Y-m-d H:i:s');
        $stmt = $this->sql->Prepare("INSERT INTO hms_sms_logs(SMS_ID,SMS_DESTINATION,SMS_CONTENT,SMS_DATE_SENT,SMS_RESPONSE) VALUES (".$this->sql->Param('a').",".$this->sql->Param('b').",".$this->sql->Param('c').",".$this->sql->Param('d').",".$this->sql->Param('e').")" );
        $stmt = $this->sql->Execute($stmt,array($uniqid,$destination,$message,$currentdate,$response));
        print $this->sql->ErrorMsg();
    }

}



?>