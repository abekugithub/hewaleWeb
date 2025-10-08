<?php

ob_start();
include("../../../../config.php");
require SPATH_PLUGINS.DS."smartpaysdk/config.php";

use GuzzleHttp\Client;
use SmartpaySDK\checkout;


include SPATH_LIBRARIES.DS."engine.Class.php";
include SPATH_LIBRARIES.DS."smartpay.Class.php";

$engine= new engineClass();
$smartpay = new SmartpayClass(new Client());

$actor_id = $engine->getActorCode();
$userInfo= $engine->getActorDetails();
$facilitycode = $engine->getFacilityDetails();
$actor_facilitycode =!empty($facilitycode->FACI_CODE)?$facilitycode->FACI_CODE:$actor_id;

// $smartpay = new checkout();




// var_dump($_POST); 
// die();
$bal=$_POST['bal'];
$amount=$_POST['amount'];
$phone=$_POST['phone'];
$modetype=$_POST['paymode'];
$perc=$_POST['perc'];
$originalFacicode=$_POST['originalFacicode'];
$voucher_code = '0001';
$mode_type=explode("@#@",$modetype );
// var_dump($mode_type);
$modetype = $mode_type[0];
$network = $mode_type[1];
// var_dump($network);
$description = "movement of funds into facility account";
if(!empty($modetype) && !empty($phone) && !empty($amount)){
	//$totamtper=$amount *$perc + $totamtper;
	$totamt=$amount ;
	// echo $totamtper.' '.$totamt;
	
	
	if($bal >= $totamt){
		
		// $result  = (array) json_decode($smartpay->momo_payment($modetype,$phone,$amount,$network,$description,$voucher_code));
		$params = array(
			'apiKey' => SMART_API_KEY, //from your tools/token
			'secretKey' => SMART_SECRET_KEY, //from your tools/token
			"payaccountno" => $phone, //the mobile number of the customer
			'payamount' => $amount, //the amount to deduct from the customer
			'currency' => 'ghs', 
			'paycategory' => 'mobilemoney',
			'paymode' => $network, //the network of the mobile number
			'description' => $description, //a short comment on this transaction
			'action' => 'send',
			'countrycode' => 'gh' //the countrycode of the phone.
		);  
		
		//connect to the gateway and get a response array
		// $response = $smartpay->connect($params, $url);
		// var_dump($params,SMART_API_URL);
		// die('dying heree');
		$result  = $smartpay->smartConnect($params, SMART_API_URL);
		// var_dump($result);
		// die(' $result ');
		
		$describe='An amount ' .$amount. '.00  was moved from social health wallet on  '.date('Y-m-d H:i:s'). ' to momo account';
		
		$usertype=$engine->getWalletDetails($actor_facilitycode)->HRMSWAL_USERTYPE;
		$walletcode=$engine->getWalletDetails($originalFacicode)->HRMSWAL_CODE;
		
		$transcode=$engine->getTransCode();
		
		// echo $transcode.'<br> '.$walletcode.'<br> '.$usertype;
		// die();
		// die(var_dump());1827ef0a8638
		// $result['status']=='success';
		// $result='success';
		
		// var_dump($result);
		// die(' $result ');

		if($result['status']=='success'){
			
			$token1 =($result['response']);
			$token1 = $token1->token;
			// $token1='1827ef0a8638';
			
			//matt: updating Balance
			$new_balance  = $bal - $totamt;
			$stmt = $sql->Execute($sql->Prepare("UPDATE hms_wallets SET HRMSWAL_BALANCE = ".$sql->Param('a')." WHERE HRMSWAL_CODE=".$sql->Param('a')." "),[$new_balance, $walletcode]);
			print   $errormsg = $sql->ErrorMsg(); 
			//matt
			
			/**
			* `HRMSTRANS_ID`, `HRMSTRANS_CODE`, `HRMSTRANS_WALCODE`, `HRMSTRANS_USERCODE`, `HRMSTRANS_USERTYPE`, `HRMSTRANS_AMOUNT`, `HRMSTRANS_DATE`, `HRMSTRANS_RECEIVER`, `HRMSTRANS_STATUS`, `HRMSTRANS_TYPE`, `HRMSTRANS_DESCRIPTION`, `HRMSTRANS_INPUTDATE`, `HRMSTRANS_CONFIRM_STATUS`, `HRMSTRANS_TRANS_TOKEN`, `HRMSTRANS_TRANS_ACC`, `HRMSTRANS_DEDU_AMOUNT`, `HRMSTRANS_COURIER_AMOUNT`, `HRMSTRANS_COURIER_NAME`, `HRMSTRANS_COURIER_CODE`, `HRMSTRANS_SUCCESS_ACTION`, `HRMSTRANS_SUCCESS_DATA`, `HRMSTRANS_SUCCESS_TOKEN`, `HRMSTRANS_PACKAGECODE`
			* 
			*/
			
			$stmt = $sql->Execute("INSERT INTO hms_wallet_transaction (HRMSTRANS_CODE,HRMSTRANS_WALCODE,HRMSTRANS_USERCODE,HRMSTRANS_USERTYPE,HRMSTRANS_AMOUNT,HRMSTRANS_DATE,HRMSTRANS_RECEIVER,HRMSTRANS_STATUS,HRMSTRANS_TYPE,HRMSTRANS_DESCRIPTION,HRMSTRANS_TRANS_TOKEN,HRMSTRANS_TRANS_ACC) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('f').",".$sql->Param('f').",".$sql->Param('f').",".$sql->Param('f').",".$sql->Param('f').",".$sql->Param('f').")",array($transcode, $walletcode,$originalFacicode,$usertype,$amount,date('Y-m-d H:i:s'),$actor_facilitycode,'2','3',$describe,$token1,$phone));
			print $sql->ErrorMsg();
			// var_dump($stmt);
			$eventype = '097';
			$activity = 'facility  with ID. '.$actor_facilitycode.'moved this amount ' .$amount. '.00 from social health wallet on  '.date('Y-m-d H:i:s'). ' to smartpay';
			$msg = "Successful Transfer of fund"; 
			$status = "success";
			$newbal = $engine->getWalletDetails($actor_facilitycode)->HRMSWAL_BALANCE;
		}else{
			$msg = "Transfer failed. Try again"; 
			$status = "error";	
			$eventype = '123';
			$activity = 'Fund Transfer failed for facility with ID. '.$actor_facilitycode.' for amount of ' .$amount. '.00 from social health wallet on  '.date('Y-m-d H:i:s');
		}
		
	}else{
		$msg = "Insufficient funds"; $status = "error";	
	}
	
}else{
	$msg = "All fields with * are required"; $status = "error"; 
	
}
echo $engine->msgBox($msg,$status).'#@#'.$newbal;
?>