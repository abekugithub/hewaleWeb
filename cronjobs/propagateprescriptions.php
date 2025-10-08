<?php
ob_start();
include "../config.php";
include SPATH_LIBRARIES.DS."engine.Class.php";
//include SPATH_LIBRARIES.DS."smsgateway.class.php";

$sms = new smsgetway();
$engine = new engineClass();
//$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
$date = date("Y-m-d");
$notifycode = "011";
$menuecode ="0150";
$tablerowid = "";

//Fetch all pending prescriptions broadcasted to pharmacies
$stmtpp = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_prescription_main WHERE PRESCM_STATUS = '2'"),array());
if($stmtpp->RecordCount() > 0 ){
while($objpp = $stmtpp->FetchNextObject()){

    $visitcode = $objpp->PRESCM_VISITCODE;
	$patientcode = $objpp->PRESCM_PATIENTCODE;
	$prescriptioncode = $objpp->PRESCM_PACKAGECODE;

    /*
     * This query looks through the broadcast table 
     * and re-broadcast prescription if not attended
     */
$stmtbroa =  $sql->Execute($sql->Prepare("SELECT * FROM hms_broadcast_prescription WHERE BRO_STATUS = '2' AND BRO_VISITCODE = ".$sql->Param('a')." AND BRO_PATIENTCODE = ".$sql->Param('b')." AND BRO_PRESCCODE = ".$sql->Param('c')." "),array($visitcode,$patientcode,$prescriptioncode));
if($stmtbroa->RecordCount() > 0 ){}else{ 
	$stmtbro =  $sql->Execute($sql->Prepare("SELECT * FROM hms_broadcast_prescription WHERE BRO_VISITCODE = ".$sql->Param('a')." AND BRO_PATIENTCODE = ".$sql->Param('b')." AND BRO_PRESCCODE = ".$sql->Param('c')." "),array($visitcode,$patientcode,$prescriptioncode));

    $objbro = $stmtbro->FetchNextObject();
    $latitude = $objbro->BRO_LATITUDE;
	$longitude = $objbro->BRO_LONGITUDE;

	$bdcastpharcode = $objbro->BRO_PHARMACYCODE;
	
if(!empty($visitcode) && !empty($patientcode)){
	//Get pharmacies near
	$stmtp = $sql->Execute($sql->Prepare("SELECT *, ( 3959 * acos( cos( radians(" . $sql->Param('a') . ") ) * cos( radians( FACI_LATITUDE ) ) * cos( radians( FACI_LONGITUDE ) - radians(" . $sql->Param('b') . ") ) + sin( radians(" . $sql->Param('c') . ") ) * sin( radians( FACI_LATITUDE ) ) ) ) AS distance FROM hmsb_allfacilities WHERE FACI_STATUS = '1' AND FACI_TYPE = 'P' AND FACI_CODE IN ('P0019','P0037','P0011','P0023','P0038') AND FACI_CODE NOT IN (SELECT BRO_PHARMACYCODE FROM hms_broadcast_prescription WHERE BRO_VISITCODE = ".$sql->Param('d')." AND BRO_PATIENTCODE = ".$sql->Param('e')." AND BRO_PRESCCODE = ".$sql->Param('f').") HAVING distance < 10  "),array($latitude,$longitude,$latitude,$visitcode,$patientcode,$prescriptioncode));
	//print $sql->ErrorMsg();
	
	if ($stmtp->RecordCount() > 0){
		while($objp = $stmtp->FetchNextObject()){
			$pharmacy_name = $objp->FACI_NAME;
			$pharmacy_location = $objp->FACI_LOCATION;
			$facicode = $objp->FACI_CODE;
			$faciphone = $objp->FACI_PHONENUM;
			$facicountry = $objp->FACI_COUNTRY_ID;

				$Code = $engine->getBroadcastPrescriptionCode();
				$prescode = $objpp->PRESCM_PACKAGECODE;
				$prespatient = $objpp->PRESCM_PATIENT;
				$prespatcode = $objpp->PRESCM_PATIENTCODE;
				$prespatnum = $objpp->PRESCM_PATIENTNUM;
				$presdate = $objpp->PRESCM_DATE;
				$presvicitcode = $objpp->PRESCM_VISITCODE;
				$presstate = $objpp->PRESCM_STATE;
				$presstatus = $objpp->PRESCM_STATUS;
				$pressource = $objpp->PRESCM_SOURCE;
				$presinscode = $objpp->PRESCM_INSTCODE;
				$presactorname = $objpp->PRESCM_ACTORNAME;
				$presactorcode = $objpp->PRESCM_ACTORCODE;
				$prestime = $objpp->PRESCM_TIME;
				$prespatcontact = $objpp->PRESCM_PATIENTCONTACT;
				$tablerowid = $objpp->PRESCM_PACKAGECODE;

				$stmtb=$sql->Execute($sql->Prepare("INSERT INTO hms_broadcast_prescription (BRO_CODE, BRO_PRESCCODE, BRO_VISITCODE, BRO_PATIENTNAME, BRO_PATIENTCODE, BRO_PATIENTNUM, BRO_PATIENTCONTACT, BRO_PHARMACYNAME, BRO_PHARMACYCODE, BRO_DATE, BRO_LONGITUDE, BRO_LATITUDE,BRO_STATE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').")"),array($Code, $prescode, $presvicitcode, $prespatient, $prespatcode, $prespatnum, $prespatcontact, $pharmacy_name, $facicode, $date,$longitude,$latitude,$pressource));
				print $sql->ErrorMsg();
                
				if($stmtb){
					//Onesignal
					$playerid = array();
					$stmt = $sql->Execute($sql->Prepare("SELECT USR_CODE,USR_PLAYERID FROM hms_users WHERE USR_FACICODE =".$sql->Param('a').""),array($facicode));

					if($stmt->RecordCount() > 0){
						while($obj = $stmt->FetchNextObject()){
						$playerid[] = $obj->USR_PLAYERID;
					}
					
					$appid ="7552392c-4d7d-4e4d-a672-56509c316478";
					$contents ="Prescription. \nNew request to buy medication(s).";
					$type ='';
					if(!empty($playerid)){
						foreach ($playerid as $key => $pid){
							$engine->notify($appid,$contents,$pid,$type);
						}
					}

					//sms
					$msg = 'New request to buy medication(s).';
					$prefix = $engine->getcountryphoneprefix($facicountry);
					$phone = $sms->validateNumber($faciphone,$prefix);
					$results = $sms->sendSms($phone,$msg);
					//end of sms

					//Notification
					$requestreason = 'Patient request to buy medication from pharmacy';
					$engine->setNotificationLikePhone($patientcode,$notifycode,$requestreason,$menuecode,$tablerowid,$sentto="",$facicode);
					//End of notification
				}
			}

			$eventype = '049';
			$activity = 'Pharmacy Request escalated. Patient with patient code '.$patientcode.' has requested for pharmacy.';
			$engine->setEventLog($eventype,$activity);
	}
	
		
	}
	
}

}}
}
?>