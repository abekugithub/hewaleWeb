<?php
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$userCourier = $engine->getActorCourier();
switch($viewpage){
	
	case "edit":
	//echo $keys;exit;
		$stmt = $sql->Execute($sql->Prepare("SELECT PRESC_CODE,PRESC_PATIENT, PRESC_PATIENTCODE,PRESC_DATE,PRESC_PHARMNAME,PRESC_PHARMLOC,PRESC_DRUG,PRESC_DOSAGENAME,PRESC_STATUS, PRESC_PATIENTCONTACT,PRESC_QUANTITY, PRESC_VISITCODE,PRESC_PICKUPCODE,FACI_PHONENUM,PRESC_PACKDELCODE FROM hms_patient_prescription join hmsb_allfacilities ON hms_patient_prescription.PRESC_FACICODE = hmsb_allfacilities.FACI_CODE  WHERE PRESC_PICKUPCODE  = ".$sql->Param('a')." "),array($keys)); 
		print $sql->ErrorMsg();
		if($stmt->RecordCount() > 0){
			$obj = $stmt->FetchNextObject();
			$patientname = $obj->PRESC_PATIENT;
			$patientcontact = $obj->PRESC_PATIENTCONTACT;
			$pharmname = $obj->PRESC_PHARMNAME;
			$pharmloc = $obj->PRESC_PHARMLOC;
			$pharmdate = $obj->PRESC_DATE;
			$delstatus = $obj->PRESC_STATUS;
			$patcode = $obj->PRESC_PATIENTCODE;
			$presccode = $obj->PRESC_CODE;
			$pickupcode = $obj->PRESC_PICKUPCODE;
			$visitcode = $obj->PRESC_VISITCODE;
			$contactno = $obj->FACI_PHONENUM;
			$pickdelcode = $obj->PRESC_PACKDELCODE;
			
	    }
		
		$stmtpris = $sql->Execute($sql->Prepare("SELECT PRESC_CODE,PRESC_PATIENT, PRESC_PATIENTCODE,PRESC_DATE,PRESC_PHARMNAME,PRESC_PHARMLOC,PRESC_DRUG,PRESC_DOSAGENAME,PRESC_STATUS, PRESC_PATIENTCONTACT,PRESC_QUANTITY, PRESC_VISITCODE,PRESC_PICKUPCODE,FACI_PHONENUM FROM hms_patient_prescription join hmsb_allfacilities ON hms_patient_prescription.PRESC_FACICODE = hmsb_allfacilities.FACI_CODE  WHERE PRESC_PICKUPCODE = ".$sql->Param('a')." "),array($keys));
		 
	break;
	
	
	
	
	case "updateprocessing":
	

		if(!empty($settime)){
			
			date_default_timezone_set("Africa/Accra");
	$newsettime = date("h:i:sa",strtotime($settime));
			
		$stmt = $sql->Execute($sql->Prepare("UPDATE hms_ph_prescriptionorder SET PRESCORD_TIME=".$sql->Param('a').", PRESCORD_DEL_STATUS='3' WHERE PRESCORD_CODE=".$sql->Param('b')),array($newsettime,$keys));
		
		
        $msg = "Processing Initiated Successfully.";
	    $status = "success";
        $activity = "Processing Initiated Successfully.";
		$engine->setEventLog("011",$activity);
		}
	
	break;
	
	case "updatedelivery":

	
	$stmt = $sql->Execute($sql->Prepare("UPDATE hms_ph_prescriptionorder SET PRESCORD_DEL_STATUS='4' WHERE PRESCORD_CODE=".$sql->Param('a')),array($keys));
		
		
        $msg = "Priscription Delivered Successfully.";
	    $status = "success";
        $activity = "Priscription Delivered Successfully.";
		$engine->setEventLog("012",$activity);
	
	
	break;
	
}

if(!empty($fdsearch)){
	$query = "SELECT DISTINCT PRESC_VISITCODE,PRESC_PATIENT, PRESC_PATIENTCODE,PRESC_PHARMNAME,PRESC_PHARMLOC,PRESC_STATUS,PRESC_PICKUPCODE FROM hms_patient_prescription WHERE PRESC_STATUS='5' AND PRESC_DEL_STATUS='1' AND PRESC_COUR_CODE=".$sql->Param('a')." AND (PRESC_PATIENT LIKE ".$sql->Param('b').") ";
 $input = array($userCourier,$fdsearch.'%');

}else {

    $query = "SELECT DISTINCT PRESC_VISITCODE,PRESC_PATIENT, PRESC_PATIENTCODE,PRESC_PHARMNAME,PRESC_PHARMLOC,PRESC_STATUS,PRESC_PICKUPCODE FROM hms_patient_prescription WHERE PRESC_STATUS ='6'  AND PRESC_COUR_CODE=".$sql->Param('a')."  "; $input = array($userCourier);
}
if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=065ab3a28ca4f16f55f103adc7d0226f&option=1ac3d3b7e44de2f0ad6280c012e3825c&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);

//Get all positions
$stmtpos = $engine->getUserPosition();

?>