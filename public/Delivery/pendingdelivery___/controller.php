<?php
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$userCourier = $engine->getActorCourier();
$ccode = $engine->getparcelcode();
switch($viewpage){
	
	case "edit":
	//echo $keys;exit;
		$stmt = $sql->Execute($sql->Prepare("SELECT PRESC_CODE,PRESC_PATIENT, PRESC_PATIENTCODE,PRESC_DATE,PRESC_PHARMNAME,PRESC_PHARMLOC,PRESC_DRUG,PRESC_DOSAGENAME,PRESC_STATUS, PRESC_PATIENTCONTACT,PRESC_QUANTITY, PRESC_VISITCODE,PRESC_PICKUPCODE FROM hms_patient_prescription  WHERE PRESC_PICKUPCODE  = ".$sql->Param('a')." "),array($keys));
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
			$pickupcode = $obj->PRESC_PICKUPCODE;

//            $stmtpris = [];
//            while($obj = $stmt->FetchNextObject()){
//                $stmtpris = ['drug'=>$obj->PRESC_DRUG,'quantity'=>$obj->PRESC_QUANTITY,'dosagename'=>$obj->PRESC_DOSAGENAME];
//            }

	    }
		
		$stmtpris = $sql->Execute($sql->Prepare("SELECT PRESC_CODE,PRESC_PATIENT, PRESC_PATIENTCODE,PRESC_DATE,PRESC_PHARMNAME,PRESC_PHARMLOC,PRESC_DRUG,PRESC_DOSAGENAME,PRESC_STATUS, PRESC_PATIENTCONTACT,PRESC_QUANTITY, PRESC_VISITCODE,PRESC_PICKUPCODE FROM hms_patient_prescription  WHERE PRESC_PICKUPCODE = ".$sql->Param('a')." "),array($keys));
		 
	break;
	
	
	
	case "updatedelivery":

	$responses = "Parcel is in Delivered. Thank you for doing Business with us.";
	
	$stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_prescription SET PRESC_STATUS='6' WHERE PRESC_CODE=".$sql->Param('a')),array($keys));
	
	$stmtp = $sql->Execute($sql->Prepare("UPDATE hms_notifications SET NOT_DETAILS=".$sql->Param('a').", NOT_STATUS='0' WHERE NOT_CODE=".$sql->Param('a')),array($responses,$keys));
		
		
        $msg = "Priscription Delivered Successfully.";
	    $status = "success";
        $activity = "Priscription Delivered Successfully.";
		$engine->setEventLog("012",$activity);
	
	
	break;

    case 'reset':
        $fdsearch = '';
        $view = '';
    break;
	
}

if(!empty($fdsearch)){
    $query = "SELECT PRESC_PICKUPCODE,PRESC_PATIENT, PRESC_PHARMNAME,PRESC_PHARMLOC,PRESC_STATUS, PRESC_VISITCODE,PRESC_DATE FROM hms_patient_prescription join hmsb_allfacilities ON hms_patient_prescription.PRESC_FACICODE = hmsb_allfacilities.FACI_CODE WHERE (PRESC_PATIENT LIKE ".$sql->Param('a')." OR PRESC_PHARMNAME LIKE ".$sql->Param('b')." OR PRESC_PHARMLOC LIKE ".$sql->Param('c').") AND PRESC_STATUS= '4' OR PRESC_STATUS= '5' AND PRESC_DEL_STATUS='1' AND PRESC_COUR_CODE=".$sql->Param('d')." ";
    $input = array('%'.$fdsearch.'%','%'.$fdsearch.'%','%'.$fdsearch.'%',$userCourier);
}else {

    $query = "SELECT DISTINCT PRESC_PICKUPCODE,PRESC_PATIENT, PRESC_PHARMNAME,PRESC_PHARMLOC,PRESC_STATUS, PRESC_VISITCODE,PRESC_DATE FROM hms_patient_prescription join hmsb_allfacilities ON hms_patient_prescription.PRESC_FACICODE = hmsb_allfacilities.FACI_CODE WHERE PRESC_STATUS= '4' OR PRESC_STATUS= '5' AND PRESC_DEL_STATUS='1' AND PRESC_COUR_CODE=".$sql->Param('a')." ";
    $input = array($userCourier);
}

$stmtagents = $sql->Execute($sql->Prepare("SELECT COU_CODE,COU_FNAME, COU_SURNAME from hms_courieragents where COU_STATUS AND COU_INSTCODE=".$sql->Param('a')."  "), array($userCourier));


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