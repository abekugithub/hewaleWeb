<?php
//include(JPATH_PLUGINS."/smsgh/Api.php");

class smsgetway{
	private $config;
	private $url;
	private $apiHost;
	private $apiMessage;
	
	function __construct(){
		global $config;
		//$this->config=$config;
			
		/*$this->apiHost = new SmsghApi();
		$this->apiHost->setClientId($this->config->smsusername);
		$this->apiHost->setClientSecret($this->config->smspassword);
		$this->apiHost->setContextPath("v3");
		$this->apiHost->setHttps(true);
		$this->apiHost->setHostname($this->config->smsurl);
		$this->apiMessage = new ApiMessage();
		$this->apiMessage->setFrom('CAGD');*/
	}
	
	/**
	 * 
	 * @param string $phone
	 * @param string $msg
	 
	public function sendSms($phone,$msg){
		$result = false;
		try {
			$this->apiMessage->setTo($phone);
			$this->apiMessage->setContent($msg);
			$this->apiMessage->setRegisteredDelivery(true);
			$response = $this->apiHost->getMessages()->send($this->apiMessage);
		
			$result = $response->getResponseStatus();
			
		
		} catch (Smsgh_ApiException $ex) {
			//echo 'ERROR: ', $ex->message(), "\n";
		}
	return $result;
	}*/
	
	/**
	 * 
	 * @param string $phone
	 * @param string $msg
	 */
	public function sendSms($phone,$msg){
		/*
		$url = 'http://quicksmsgh.com/bulksms/';
		$result = false;
		$fields = array(
'username' => urlencode('daakye'),
'password' => urlencode('eaglE_123'),
'type' => urlencode("0"),
'dlr' => urlencode('1'),
'destination' => urlencode($phone),
'source' => urlencode('HEWALE'),
'message'=>urlencode($msg)
*/

	//smartsmsgh
		$url = 'http://txtkube.com:1401/send';
		$result = false;
		$fields = array(
			'username' => urlencode('eelPsPrc'),
			'password' => urlencode('CcsA1csm'),
			'from' => urlencode("HEWALE"),
			'to' => urlencode($phone),
			'content' => urlencode($msg),
		
);
$fields_string = "";
foreach ($fields as $key => $value) {
$fields_string .= $key . '=' . $value . '&';
}
rtrim($fields_string, '&');
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POST, count($fields));
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
$result = curl_exec($ch);
curl_close($ch);

$data = explode('|',$result);
if($data['0'] == "1701"){
$result = "Success";
}else{
	$errormsg = array('1703'=>'Invalid Username Or Password',
					'1704'=>'Invalid value in type field',
						'1705'=>'Invalid Message ',
						'1706'=>'Invalid Destination ',
						'1707'=>'Invalid Source (Sender ',
						'1708'=>'Invalid value for dlr field ',
						'1709'=>'User validation failed ',
						'1710'=>'Internal Error ',
						'1025'=>'Insufficient Credit User '
						);
	
$result = $errormsg[$data['0']];
}
		
		
	return $result;
	}
	
	/**
	 * sends same message in bulk
	 * @param array $arrayphone
	 * @param string $msg
	 */
	public function sendBulkSms($arrayphone,$msg){
		$returns =array();
		if(is_array($arrayphone)){
			foreach ($arrayphone as $phone){
				$returns[] =$this->sendSms($phone, $msg);
			}
		}else{
			$returns[] =$this->sendSms($phone, $msg);	
		}
		
		return $returns;
		
	}//end
	
	
		/*
			This function will validate the cellphone number
		*/
		function validateNumber($number, $forced_prefix = NULL, $number_length = '0'){
			
			if (!$forced_prefix){
				$forced_prefix = "+233";
			}
			
			// Remove any non-numeric characters in the number
			$number = preg_replace('/[^\+0-9]/s','',$number);
			
			// If a prefix is allready added then return the number "as is"
			if ( substr($number, 0, 1) == "+" || substr($number, 0, 2) === "00" ){
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
}
?>