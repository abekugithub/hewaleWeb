<?php
// echo 'USED';
ob_start(); 
include("../config.php");

include SPATH_LIBRARIES.DS."engine.Class.php";
$engine= new engineClass();
$logic = file_get_contents('php://input');
$data = json_decode($logic, true);
$trans_code = uniqid();
$trans_code1 = uniqid();
$trans_code2 = uniqid();
$date=date('Y-m-d H:i:s');
if(is_array($data) && isset($data['trans_token']) && isset($data['trans_status'])){
	$trans_token = $data['trans_token'];
	$trans_status = $data['trans_status'];
	// echo $trans_status .' '.$trans_token;
	
	$stmt=$sql->Execute($sql->Prepare("SELECT * FROM hms_wallet_transaction WHERE HRMSTRANS_TRANS_TOKEN=".$sql->Param('a')." AND HRMSTRANS_CONFIRM_STATUS='0' "),array($trans_token));
// 	 var_dump($stmt);
// die();
	$obj= $stmt->FetchNextObject();
	// var_dump($obj);
	// die();
	$walletcode=$obj->HRMSTRANS_WALCODE;
	$usercode=$obj->HRMSTRANS_USERCODE;
	$amount=$obj->HRMSTRANS_AMOUNT;
	$status=$obj->HRMSTRANS_CONFIRM_STATUS;
	$recvercode=$obj->HRMSTRANS_RECEIVER;
	$percentage=$engine->userPercentage($recvercode);
	$transcode=$obj->HRMSTRANS_CODE;
	// echo $percentage;
	// $amount=1;

	
	// echo $totamt.'amount'.$amount;
	 // 
	// echo $amount.'<br>'.$percentagetot.'<br>'.$totamt;
	 //391//34.00// 0001

	$stmttd=$sql->Execute($sql->Prepare("SELECT POL_VALUE  FROM hmsb_policy_settings WHERE POL_OWNER_CODE=".$sql->Param('a')." AND POL_STATUS='1' AND POL_NAME=".$sql->Param('a')." "),array($recvercode,'momo_out'));
	// var_dump($stmttd);
// if ($stmttd->RecordCount() > 0) {
	# code... OPENING / CLOSING

	$objexe=$stmttd->FetchNextObject();
	$percentagetot=$objexe->POL_VALUE;
	 $peramt=$percentagetot / 100;
// echo $peramt;
if($peramt==0){

	
	$stdmd=$sql->Execute($sql->Prepare("SELECT POL_VALUE  FROM hmsb_policy_settings WHERE POL_OWNER_CODE=".$sql->Param('a')." AND POL_STATUS='1' AND POL_NAME=".$sql->Param('a')."  "),array('1','momo_out'));
	// var_dump($stdmd);
	$objexx=$stdmd->FetchNextObject();
	$percentagetot2=$objexx->POL_VALUE;
	$alllper=$percentagetot2 / 100;
}

// }else{

//  var_dump($stdmd);

// }

	// die("asdsadas");
	if ($status=='0') {
		# code... $

		$percentall=!empty($peramt)?$peramt:$alllper;
		$percentagetot3= $percentall * $amount;
		$totamt= $amount + $percentagetot3;
	// echo $totamt.'amount'.$amount;
	// die("akos");900.33// 391.65
		$pharmacc=$engine->checkbalance($recvercode);
            $hewaleacc=$engine->checkbalance('AD1012');


		$stmtd=$sql->Execute($sql->Prepare("UPDATE hms_wallet_transaction SET HRMSTRANS_CONFIRM_STATUS=".$sql->Param('a')." WHERE HRMSTRANS_TRANS_TOKEN=".$sql->Param('a')." "),array('1',$trans_token));
		if ($stmtd==true) {
			// echo
			# code...
			$engine->getUserBalded($recvercode,$totamt);
	 $engine->setDeduateAmount($recvercode,$percentagetot3);
	 $closibalpr=$pharmacc -  $totamt;
            $closibalhewale=$hewaleacc +  $percentagetot3;
	 //hewale wallets
	 $stmdd=$sql->Execute($sql->Prepare("UPDATE hms_wallets SET HRMSWAL_BALANCE=HRMSWAL_BALANCE + ".$sql->Param('a').", HRMSWAL_INST_BALANCE= HRMSWAL_INST_BALANCE + ".$sql->Param('a')." WHERE HRMSWAL_USERCODE=".$sql->Param('c')."  "),array($percentagetot3,$percentagetot3,'AD1012'));
	// 		$engine->getUserBalded($usercode,$totamt);
	// $engine->setDeduateAmount($usercode,$percentagetot);
	// echo 'gone';

    $std =$sql->Execute($sql->Prepare("INSERT INTO hms_wallet_transaction_details(HRMSTRANSDETAILS_CODE,HRMSTRANSDETAILS_TRANSCODE,HRMSTRANSDETAILS_AMOUNT,HRMSTRANSDETAILS_TYPE,HRMSTRANSDETAILS_USERCODE,HRMSTRANSDETAILS_DESC,HRMSTRANSDETAILS_DATE,HRMSTRANSDETAILS_OPENING_BAL,HRMSTRANSDETAILS_CLOSING_BAL) VALUES(".$sql->Param('a').",".$sql->Param('a').",".$sql->Param('a').",".$sql->Param('a').",".$sql->Param('a').",".$sql->Param('a').",".$sql->Param('a').",".$sql->Param('a').",".$sql->Param('a').")"),array($trans_code,$transcode,$totamt,'1',$recvercode,'credit account ',$date,$pharmacc,$closibalpr));

		 $stdd =$sql->Execute($sql->Prepare("INSERT INTO hms_wallet_transaction_details(HRMSTRANSDETAILS_CODE,HRMSTRANSDETAILS_TRANSCODE,HRMSTRANSDETAILS_AMOUNT,HRMSTRANSDETAILS_TYPE,HRMSTRANSDETAILS_USERCODE,HRMSTRANSDETAILS_DESC,HRMSTRANSDETAILS_DATE,HRMSTRANSDETAILS_OPENING_BAL,HRMSTRANSDETAILS_CLOSING_BAL) VALUES(".$sql->Param('a').",".$sql->Param('a').",".$sql->Param('a').",".$sql->Param('a').",".$sql->Param('a').",".$sql->Param('a').",".$sql->Param('a').",".$sql->Param('a').",".$sql->Param('a').")"),array($trans_code1,$transcode,$percentagetot3,'1','AD1012','credit account',$date,$hewaleacc,$closibalhewale));

		}
	
	}else{
			echo 'USED';
	}
	



}else{

}

?>