<?php
/**
 * Smart Payment Class
 * All paymodes: 0908172=>MTN, 0908173=>Airtel, 0908174=>Vodafone, 0908175=>TiGo
 * Suported Networks: MTN, Airtel, Vodafone, Tigo
 * BY: Reggie Gyan @ Orcons Systems.
 * Copyright: Orcons Systems
 */

define('SMART_API_URL',"https://smartpaygh.com/frontapi/index.php?");
define('SMART_API_KEY','3dk76da3eeew7f5d1032d2d3d');
define('SMART_SECRET_KEY','d45s2addb4ekdd6c8dd2qqdcf');

class SmartpayClass{

  public function smartConnect($data = array(), $url){
		// var_dump($data);die;
		$gclient = new \GuzzleHttp\Client();
		$this->gclient = $gclient;
		$response = '';
		try{
			$response = $this->gclient->request(
				'POST',
				$url,
				[
					//'debug' => true,
					'verify' => false,					
					'form_params' => $data
				]
			);
		} catch (\Exception $e) {					
			error_log($e->getMessage(), 0);
		}

		//echo $response->getBody();
    // exit;
		
		if(!\is_object($response)){
			return false;
		}
		$response_code = $response->getStatusCode();
		$response_level = substr($response_code, 0, 1);
		//var_dump('$response_code',$response_code,'$response_level',$response_level);
		if($response_level == '2'){
			$response = json_decode($response->getBody(), true);   
			// $response = $response->getBody(); 
			// die($response);  
			return $response;             
		}
		else{
			// echo $response->getReasonPhrase();
			return false;
		}
		return json_decode($response->getBody());
		// return $response->getBody();
		
	}

  public function momo_payment($paymode,$phonenumber,$payamount,$network,$description=null,$voucher_code=null){
    $payload = [
        'apiKey' => SMART_API_KEY,
        'secretKey' => SMART_SECRET_KEY,
        'action' => 'makepayment',
        'payaccountno' => $phonenumber, // Phone number to deduct
        'payamount' => $payamount, // amount to deduct
        'currency' => 'GHS',
        'description' => $description, // Required
        'paymode' => $paymode, // All paymodes: 0908172=>MTN, 0908173=>Airtel, 0908174=>Vodafone, 0908175=>TiGo
        'nw' => $network, // all: MTN, Airtel, Vodafone, Tigo
				'voucher_code' => $voucher_code // for vodacash, generate a voucher
    ];
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => SMART_API_URL,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_SSL_VERIFYHOST => false,
      CURLOPT_POSTFIELDS => $payload,
      CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/x-www-form-urlencoded"
      ),
    ));
  
    $response = curl_exec($curl);
    // var_dump($response);
    // die('hello');
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
      return "cURL Error #:" . $err;
    } else {
      return $response;
    }
  }

  public function card_payments($cardnumber,
  $cardholder,$cardexpirydate,$cardccc,$payamount,$description=null){
    $payload = [
        'apiKey' => SMART_API_KEY,
        'secretKey' => SMART_SECRET_KEY,
        'action' => 'makepayment',
        'cardnumber' => $cardnumber, // Card number to deduct
        'cardholder' => $cardholder, // Full Name on card
        'payamount' => $payamount, // amount to deduct
        'currency' => 'GHS',
        'description' => $description, // Required
        'cardcc' => $cardccc, // Three Digit Number behind the card
        'cardexpirydate' => $cardexpirydate // When is the card invalid date
    ];
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => SMART_API_URL.http_build_query($payload),
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/x-www-form-urlencoded"
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
  
}

