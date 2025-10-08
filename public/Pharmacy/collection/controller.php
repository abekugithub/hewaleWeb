<?php
//$sms = new smsgatewayClass();
include ('model/js.php');
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$patientCls = new patientClass();
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();
$objdtls = $engine->getFacilityDetails();
$facilityalias = $objdtls->FACI_ALIAS ;
$faciname=$objdtls->FACI_NAME;
$faccode = $objdtls->FACI_CODE ;
//echo $faccode;die();
$engine = new engineClass();
$patientCls = new patientClass();
$sms = new smsgetway();

switch($viewpage){

case 'savedispatch':
 
     if(!empty($prescripcode)){

		if($deliverystatus == 0){
		$stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_prescription_main SET PRESCM_STATUS = '7' WHERE PRESCM_PACKAGECODE = ".$sql->Param('2').""),array($prescripcode));

		$stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_prescription SET PRESC_STATUS = '7' WHERE PRESC_PACKAGECODE = ".$sql->Param('2').""),array($prescripcode));
		}else{ 
			$stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_prescription_main SET PRESCM_STATUS = '6' WHERE PRESCM_PACKAGECODE = ".$sql->Param('2').""),array($prescripcode));

			$stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_prescription SET PRESC_STATUS = '6' WHERE PRESC_PACKAGECODE = ".$sql->Param('2').""),array($prescripcode));

			$stmt = $sql->Execute($sql->Prepare("UPDATE hmsb_courier_basket SET COB_STATUS = '3' WHERE COB_PRESCRIPTIONCODE = ".$sql->Param('2').""),array($prescripcode));

			$patientphoneno = $sms->validateNumber($phone,'+233');
		//	$patientphoneno = '233507319178';
		//	$patientphoneno = '233249676616';
		    if($patientphoneno){
		    //sms to patient
		//    $message = "Your drug with prescription code ".$prescripcode." and delivery code ".$deliverycode." is in transit.";
			$message = "Description:Medication delivery \nPrescription Code: ".$prescripcode." \nStatus: In transit \nDelivery Code: ".$deliverycode." \nFor Assistance call 0203618205 ";
			
			$sms->sendSms($patientphoneno,$message);
		}
		}
		print $sql->ErrorMsg();

	 }
              
		$msg = 'Medication Dispatched successfully.';
		$status = 'success';
		
		$activity = "Drug with prescription code ".$prescripcode." dispatched successfully to patient/courier. Details are: Patient Number ".$hewalenumber." Visit code: ".$visitcode;
		$engine->setEventLog("120",$activity);
		
break;

 
 case 'sales':  
	//Get Patient details
	$objpt = $patientCls->getPatientDetails($hewale_number);
	$customername=$objpt->PATCON_FULLNAME;
	$hewalenumber=$objpt->PATCON_PATIENTNUM;
	$gender=$objpt->PATCON_GENDER;
	$allergies = $objpt->PATIENT_ALLERGIES;
	$phone = $objpt->PATIENT_PHONENUM;
	$date1 = (empty($objpt->PATIENT_DOB)?'':date("Y",strtotime($objpt->PATIENT_DOB)));
	$date2 = date('Y');
	$age = (empty($date1)?'':floor($date2 - $date1));
	

	$stmtr = $sql->Execute($sql->Prepare("SELECT PEND_PRESC_CODE,PEND_DRUGID,PEND_DRUG,PEND_QUANTITY,PEND_DOSAGENAME,PEND_TOTAL,PEND_TOTAL,PEND_UNITPRICE,PEND_TOTALCOMMISSION,PEND_PERCENTAGE,PEND_GRAND_TOTAL FROM  hms_pending_prescription WHERE PEND_PACKAGECODE=".$sql->Param('a')." AND PEND_FACICODE=".$sql->Param('b')." AND PEND_DRUGID != '' "),array($keys,$faccode));
	print $sql->ErrorMsg();
	//$obj = $stmtr->FetchNextObject();
	//$servicecharge = $obj->PEND_PERCENTAGE;
	//$grandtotal = $obj->PEND_GRAND_TOTAL; 
	//$servicechargeval = $obj->PEND_TOTALCOMMISSION;
	  
	  //Get image name
	  $stmtimg = $sql->Execute($sql->Prepare("SELECT PRESCM_IMAGE,PRESCM_SOURCE,PRESCM_PACKAGECODE,PRESCM_PICKUPCODE,PRESCM_COUR_NAME,PRESCM_DATE,PRESCM_VISITCODE,PRESCM_DEL_STATUS,PRESCM_RECIVERCODE,PRESCM_REMARKS FROM hms_patient_prescription_main WHERE PRESCM_PACKAGECODE = ".$sql->Param('a')." AND PRESCM_FACICODE = ".$sql->Param('a')." "),array($keys,$faccode));
      $objimg = $stmtimg->FetchNextObject();
	  $imagename =$objimg->PRESCM_IMAGE;
	  $prescrsource = $objimg->PRESCM_SOURCE;
	  $prescripcode = $objimg->PRESCM_PACKAGECODE;
	  $pickupcode = $objimg->PRESCM_PICKUPCODE;
	  $visitcode = $objimg->PRESCM_VISITCODE;
	  $presdate = $objimg->PRESCM_DATE;
	  $couriername = $objimg->PRESCM_COUR_NAME;
	  $deliverystatus = $objimg->PRESCM_DEL_STATUS;
	  $deliverycode = $objimg->PRESCM_RECIVERCODE;
	  $instructions = $objimg->PRESCM_REMARKS;
 	break;


	
	case "reset":
	$fdsearch = "";
	break;
	
}


if(!empty($fdsearch)){
	$query = "SELECT PRESCM_VISITCODE,PRESCM_PATIENT,PRESCM_PATIENTNUM,DATE(PRESCM_DATE) AS PRESCM_DATE,PRESCM_STATUS,PRESCM_PICKUPCODE,PRESCM_DEL_STATUS,PRESCM_COUR_NAME,PRESCM_STATE,PRESCM_PACKAGECODE,PRESCM_FACICODE FROM hms_patient_prescription_main WHERE PRESCM_FACICODE = ".$sql->Param('a')." AND PRESCM_STATUS IN ('4','5') AND (PRESCM_PICKUPCODE = ".$sql->Param('b')." OR PRESCM_PATIENT = ".$sql->Param('c')." OR PRESCM_PACKAGECODE LIKE ".$sql->Param('d')." OR PRESCM_PATIENT LIKE ".$sql->Param('e')." ) "; 
	$input = array($faccode,$fdsearch,$fdsearch,$fdsearch.'%',$fdsearch.'%');
	print $sql->ErrorMsg(); 
}else {//1=> Pending Preparation, 2=>Prepared , 3=>Purchase, 4=>Completed
    $query = "SELECT PRESCM_VISITCODE,PRESCM_PATIENT,PRESCM_PATIENTNUM,DATE(PRESCM_DATE) AS PRESCM_DATE,PRESCM_STATUS,PRESCM_PICKUPCODE,PRESCM_DEL_STATUS,PRESCM_COUR_NAME,PRESCM_STATE,PRESCM_PACKAGECODE,PRESCM_FACICODE FROM hms_patient_prescription_main WHERE PRESCM_FACICODE = ".$sql->Param('a')." AND PRESCM_STATUS IN ('4','5') " ;
    $input = array($faccode);
}
if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=ed7e1ee00cb1d63d34073e5c1126dc77&option=0925798cf574af1e496ea01a31a201d7&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);

?>