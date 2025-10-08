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
	$delverystatus = $deliverystate;

 	$stmt = $sql->Execute($sql->Prepare("SELECT PEND_PRESC_CODE,PRESC_VISITCODE,PRESC_DRUGID,PRESC_DRUG,PRESC_QUANTITY,PRESC_DOSAGENAME,PRESC_QUANTITY,'HEWALE' AS PRESC_METHOD,PRESC_TOTAL,PEND_TOTAL,PEND_UNITPRICE,PRESC_UNITPRICE,PRESC_PATIENT,PRESC_PATIENTNUM,PRESC_PICKUPCODE,PRESC_DEL_STATUS,PEND_QUANTITY,PRESC_DATE,PEND_COUR_NAME,PRESC_PACKAGECODE,PRESC_REMARKS,PEND_TOTALCOMMISSION,PEND_PERCENTAGE,PEND_GRAND_TOTAL FROM hms_patient_prescription LEFT JOIN hms_pending_prescription ON PRESC_PACKAGECODE=PEND_PACKAGECODE AND PRESC_CODE=PEND_PRESC_CODE WHERE PRESC_PACKAGECODE = ".$sql->Param('a')." AND PRESC_FACICODE=".$sql->Param('a')." "),array($keys,$faccode));
 	 if ($stmt->RecordCount()>0){
 	 	while($obj=$stmt->FetchNextObject()){
 	 		$drugs = $encaes->decrypt($obj->PRESC_DRUG);
			$drugid = $encaes->decrypt($obj->PRESC_DRUGID);
			$pickupcode = $obj->PRESC_PICKUPCODE;
			$visitcode=$obj->PRESC_VISITCODE;
			$presdate = $obj->PRESC_DATE;
			$couriername = $obj->PEND_COUR_NAME;
			$deliverystatus=$obj->PRESC_DEL_STATUS;
			$prescripcode = $obj->PRESC_PACKAGECODE;
			$deliverycode = $obj->PRESC_RECIVERCODE;
			$instructions = $obj->PRESC_REMARKS;
			$servicecharge = $obj->PEND_PERCENTAGE;
			$grandtotal = $obj->PEND_GRAND_TOTAL;
			$servicechargeval = $obj->PEND_TOTALCOMMISSION;
			$cart[$obj->PRESC_DRUGID]=array('CODE'=>$drugid,'NAME'=>$drugs,'DOSAGE'=>$obj->PRESC_DOSAGENAME,'COST'=>$obj->PEND_UNITPRICE,'QUANTITY'=>$obj->PEND_QUANTITY,'METHOD'=>$obj->PRESC_METHOD);
		  }
		  
		  $stmtm = $sql->Execute($sql->Prepare("SELECT PRESCM_STATUS,PRESCM_IMAGE,PRESCM_SOURCE  FROM hms_patient_prescription_main WHERE PRESCM_PACKAGECODE = ".$sql->Param('a')." "),array($prescripcode));
		  print $sql->ErrorMsg();
		  $objm =  $stmtm->FetchNextObject();

		  if ($objm->PRESCM_STATUS == 1){$delstatus = 'Pending Request';}elseif($objm->PRESCM_STATUS == 2){$delstatus = 'Pending Payment';}elseif($objm->PRESCM_STATUS == 3){$delstatus = 'Paid - Awaiting Collection';}elseif($objm->PRESCM_STATUS == 4){$delstatus = 'Ready for dispatch';}elseif($objm->PRESCM_STATUS == 5){$delstatus = 'Collected - In Transit';}elseif($objm->PRESCM_STATUS == 6){$delstatus = 'Dispatched to Courier';}elseif($objm->PRESCM_STATUS == 7){$delstatus = 'Delivered to Client';}

		  $imagename =$objm->PRESCM_IMAGE;
		  $prescrsource = $objm->PRESCM_SOURCE;


 	 }
 	break;

	case "reset":
	$fdsearch = "";
	break;
	
}


if(!empty($fdsearch)){
	$query = "SELECT PRESCM_VISITCODE,PRESCM_PATIENT,PRESCM_PATIENTNUM,DATE(PRESCM_DATE) AS PRESCM_DATE,PRESCM_STATUS,PRESCM_PICKUPCODE,PRESCM_DEL_STATUS,PRESCM_COUR_NAME,PRESCM_STATE,PRESCM_PACKAGECODE,PRESCM_FACICODE FROM hms_patient_prescription_main WHERE PRESCM_FACICODE = ".$sql->Param('a')." AND PRESCM_STATUS != '0' AND (PRESCM_PICKUPCODE = ".$sql->Param('b')." OR PRESCM_PATIENT = ".$sql->Param('c')." OR PRESCM_PACKAGECODE LIKE ".$sql->Param('d')." OR PRESCM_PATIENT LIKE ".$sql->Param('e')." ) "; 
	$input = array($faccode,$fdsearch,$fdsearch,$fdsearch.'%',$fdsearch.'%');
	print $sql->ErrorMsg(); 
}else {//1=> Pending Preparation, 2=>Prepared , 3=>Purchase, 4=>Completed
    $query = "SELECT PRESCM_VISITCODE,PRESCM_PATIENT,PRESCM_PATIENTNUM,DATE(PRESCM_DATE) AS PRESCM_DATE,PRESCM_STATUS,PRESCM_PICKUPCODE,PRESCM_DEL_STATUS,PRESCM_COUR_NAME,PRESCM_STATE,PRESCM_PACKAGECODE,PRESCM_FACICODE FROM hms_patient_prescription_main WHERE PRESCM_FACICODE = ".$sql->Param('a')." AND PRESCM_STATUS != '0' " ;
    $input = array($faccode);
}

if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=ed7e1ee00cb1d63d34073e5c1126dc77&option=c6ba9d2a20fa9b005c521a57c522f01f&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);
?>