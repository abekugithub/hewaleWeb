<?php
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$userCourier = $engine->getActorCourier();
$usertype= $engine->getUsertype();
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();
switch($viewpage){
	case "cancelrequest":
	$stmt = $sql->Execute($sql->Prepare("SELECT REQU_ID FROM hms_service_request WHERE REQU_CODE = ".$sql->Param('a')." "),array($keys));
            $client = $stmt->FetchNextObject();
	$stmt = $sql->Execute($sql->Prepare("UPDATE hms_service_request SET REQU_STATUS ='13', REQU_CANCEL_REASON=".$sql->Param('a')." WHERE REQU_CODE=".$sql->Param('d').""),array($canceldata,$keys));
	print $sql->ErrorMsg();
	
	
	$msg = "Patient First Aid request has been cancelled Successfully.";
	    $status = "success";
		$engine->ClearNotification('0004',$client->REQU_ID);
        $activity = "Patient First Aid request cancelled.";
		$engine->setEventLog("100",$activity);
	break;
	case 'getclientdetails':
    //var_dump($keys); die();
        if($keys){
             $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_service_request WHERE REQU_CODE = ".$sql->Param('a')." "),array($keys));
            $client = $stmt->FetchNextObject();
			$patientcode= $client->REQU_PATIENTNUM;
			
            $stmtp = $sql->Execute($sql->Prepare("SELECT PATIENT_IMAGE,TIMESTAMPDIFF(YEAR,PATIENT_DOB, NOW())AS AGE FROM hms_patient WHERE PATIENT_PATIENTNUM = ".$sql->Param('a')." "),array($patientcode));
            $obj = $stmtp->FetchNextObject(); 
			$image=$obj->PATIENT_IMAGE;
			$patientage= $obj->AGE;
        }
        //include "model/js.php";
    break;
    case 'insertaid':
		$postkey = $session->get("postkey");
		if($postkey != $microtime){
		$session->set("postkey",$microtime);
			$vitaldetcode = uniqid();
			if(!empty($reportaid)){
			
		$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_firstaid (FIR_CODE, FIR_VISITCODE, FIR_REQUCODE, FIR_PATIENTID, FIR_SERVICE,  FIR_FACILITYCODE,FIR_PAYMENT,FIR_REPORT,FIR_DATE,FIR_ACTOR,FIR_ACTOR_NAME)VALUES(".$sql->Param('a').",".$sql->Param('b').", ".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('j').",".$sql->Param('k').")"), array($vitaldetcode,$visitcode,$regcode,$patientcode, $servicename,$activeinstitution, $paymenttype,$reportaid,date('Y-m-d'),$usrcode,$usrname));
			
			$stmtp = $sql->Execute($sql->Prepare("UPDATE hms_service_request SET REQU_STATUS='2' WHERE REQU_CODE=".$sql->Param('b')),array($keys));
			
		$msg = "Patient First Aid Inserted Successfully.";
	    $status = "success";
		
        $activity = "Patient First Aid Inserted Successfully.";
		$engine->setEventLog("013",$activity);
			
	}else{
		$msg = "Sorry! First Aid Report is not captured.";
	    $status = "error";
		}
}
break;
}
if($usertype!=5){
if(!empty($fdsearch)){
 $query = "SELECT REQU_CODE,REQU_PATIENTNUM,REQU_VISITCODE,REQU_PATIENT_FULLNAME,REQU_SERVICENAME,REQU_DATE,REQU_STATUS FROM hms_service_request WHERE REQU_STATUS = '7' AND REQU_PATIENT_FULLNAME LIKE ".$sql->Param('a')." OR REQU_PATIENTNUM LIKE ".$sql->Param('b')." AND REQU_FACI_CODE=".$sql->Param('c')." ORDER BY REQU_DATE DESC";
        $input = array('%'.$fdsearch.'%','%'.$fdsearch.'%',$activeinstitution);
}else {
    //echo $activeinstitution;
	 $query = "SELECT * FROM hms_service_request WHERE REQU_STATUS='7' AND REQU_FACI_CODE=".$sql->Param('a')." ORDER BY REQU_DATE DESC";
        $input = array($activeinstitution);
	
}
}else{
	if(!empty($fdsearch)){
 $query = "SELECT REQU_CODE,REQU_PATIENTNUM,REQU_VISITCODE,REQU_PATIENT_FULLNAME,REQU_SERVICENAME,REQU_DATE,REQU_STATUS FROM hms_service_request WHERE REQU_STATUS = '7' AND REQU_PATIENT_FULLNAME LIKE ".$sql->Param('a')." OR REQU_PATIENTNUM LIKE ".$sql->Param('b')." AND REQU_FACI_CODE=".$sql->Param('c')." ORDER BY REQU_DATE ASC";
        $input = array('%'.$fdsearch.'%','%'.$fdsearch.'%',$activeinstitution);
}else {
    //echo $activeinstitution;
	 $query = "SELECT * FROM hms_service_request WHERE REQU_STATUS='7' AND REQU_FACI_CODE=".$sql->Param('a')." ORDER BY REQU_DATE ASC";
        $input = array($activeinstitution);
	

}
	}

if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=50d37588e936ebb72d2716e6944a490c&option=0753d7196f21820365b1daf960453855',$input);


include("model/js.php");
?>