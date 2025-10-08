<?php
//  $paymodelist = array(
//     '0908171' => 'SMP',
//     '0908172' => 'MTN',
//     '0908173' => 'AIR',
//     '0908174' => 'VOD',
//     '0908175' => 'TIG',
//     '0908176' => 'TIG',
// ); 
//Post Keeper
if($_REQUEST){
	foreach($_REQUEST as $key => $value){
		$prohibited = array('<script>','</script>','<style>','</style>');
		$value = str_ireplace($prohibited,"",$value);
		$$key = @trim($value);
	}
}

	if($paymode == "0908174" && $voucher_code == ""){
	//  $msg = "Voucher Code is required";
	//  $status = "error";
	echo "voucher_required";

	}
	$description = "scholarship application";
	
	$gatewayUrl = 'https://smartpaygh.com/api/';
    
	$apiKey = 'sGca9d32waed25kesd95dwfws';
    $secretKey = 's95wdasass5qfkbs8dkawd403';
    
    $action='makepayment';
    
	$params=array("apiKey"=>$apiKey,
		"secretKey"=>$secretKey,
		"action"=>$action,
		// "usercode"=>$usercode,
		"paymode"=>$paymode,
		"payaccountno"=>$payaccountno,
		"payamount"=>$amount,
		"description"=>$description,
		"currency"=>"GHS"

    );
    
	$response = curlMain($params, $gatewayUrl,false);
	// var_dump($response);exit;
	$status = $response['status'];
    $token = $response['response']['token'];
    
	if($status == "success"){
        //LOG YOUR TRANSACTION
		// $YOURFUNCTION->LOGTRANSACTION($paycode,$packname,$cash,$amount,$credit,$vendor,$pay_success,$payaccountno,$payaccounttype,$paydate);
			$msg = "transaction successful.";
			$status = "success";
			$activity = $description;
			// $engine->setEventLog("020",$activity);
	}
    
    function curlMain($params, $url) {
		$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);
			$response = json_decode ( $result, true );
			return ($response);
	}