<?php
require '../../../../vendor/autoload.php';
use GuzzleHttp\Client;

error_reporting(1);
include("../../../../config.php");
include SPATH_LIBRARIES.DS."engine.Class.php";
include SPATH_LIBRARIES.DS."smartpay.Class.php";
$engine= new engineClass();

$actor_id = $engine->getActorCode();
$userInfo= $engine->getActorDetails();
$facilitycode = $engine->getFacilityDetails();
$actor_facilitycode =!empty($facilitycode->FACI_CODE)?$facilitycode->FACI_CODE:$actor_id;

$smartpay = new SmartpayClass(new Client());
ob_start();




// var_dump($_POST); 
// die();
$bal=$_POST['bal'];
$amount=$_POST['amount'];
$phone=$_POST['phone'];
$modetype=$_POST['paymode'];
$perc=$_POST['perc'];

$modetype=explode("@#@",$modetype );
		$modetype=$modetype[0];
			if(!empty($modetype) && !empty($phone) && !empty($amount)){
		//$totamtper=$amount *$perc + $totamtper;
		$totamt=$amount ;
		// echo $totamtper.' '.$totamt;
		
		
		if($bal >= $totamt){
			
			$result  = (array) json_decode($smartpay->checkoutWallet($modetype,$phone,$amount));

			$describe='An amount ' .$amount. '.00  was moved from social health wallet on  '.date('Y-m-d H:i:s'). ' to momo account';

 	$usertype=$engine->getWalletDetails($actor_facilitycode)->HRMSWAL_USERTYPE;
 	$walletcode=$engine->getWalletDetails($actor_facilitycode)->HRMSWAL_CODE;

$transcode=$engine->getTransCode();

// echo $transcode.'<br> '.$walletcode.'<br> '.$usertype;
// die();
// die(var_dump());1827ef0a8638
// $result['status']=='success';
// $result='success';
		 if($result['status']=='success'){

	$token1 =($result['response']);
	$token1 = $token1->token;
	 // $token1='1827ef0a8638';




						
							//matt: updating Balance
						
		                    $new_balance  = $bal - $totamt;
							$stmt = $sql->Execute($sql->Prepare("UPDATE hms_wallets SET HRMSWAL_BALANCE = ".$sql->Param('a')." WHERE HRMSWAL_CODE=".$sql->Param('a')." "),[$new_balance, $walletcode]);
							print   $errormsg = $sql->ErrorMsg(); 
							//matt


$stmt = $sql->Execute("INSERT INTO hms_wallet_transaction(HRMSTRANS_CODE,HRMSTRANS_WALCODE,HRMSTRANS_USERCODE,HRMSTRANS_USERTYPE,HRMSTRANS_AMOUNT,HRMSTRANS_DATE,HRMSTRANS_STATUS,HRMSTRANS_RECEIVER,HRMSTRANS_TRANS_TOKEN,HRMSTRANS_TYPE,HRMSTRANS_DESCRIPTION,HRMSTRANS_TRANS_ACC) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('f').",".$sql->Param('f').",".$sql->Param('f').",".$sql->Param('f').",".$sql->Param('f').",".$sql->Param('f').")",array($transcode,$walletcode,$actor_id,$usertype,$amount,date('Y-m-d H:i:s'),'2',$actor_facilitycode,$token1,'3',$describe,$phone));
		print $sql->ErrorMsg();
// var_dump($stmt);
		$eventype = '097';
		$activity = 'facility  with ID. '.$actor_facilitycode.'moved this amount ' .$amount. '.00 from social health wallet on  '.date('Y-m-d H:i:s'). ' to smartpay';
		$msg = "Successful Transfer of fund"; 
		$status = "success";	
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
	 $engine->msgBox($msg,$status);
?>