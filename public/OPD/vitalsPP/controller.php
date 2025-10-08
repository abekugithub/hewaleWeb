<?php
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$userCourier = $engine->getActorCourier();
$patient=new patientClass();
$usertype= $engine->getUsertype();
$actor_id = $session->get("userid");
$usrname = $engine->getActorName();


switch($viewpage){
	case'searchvitalh':
	 $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_vitals WHERE VITALS_STATUS = '1' AND VITALS_FACILITYCODE=".$sql->Param('a')." AND VITALS_PATIENTNO=".$sql->Param('a').""),array($activeinstitution,$fdsearch));
	$view='vitalhistory';
	break;
	case 'vitalhistory':
	
	 $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_vitals WHERE VITALS_STATUS = '1' AND VITALS_FACILITYCODE=".$sql->Param('a')." LIMIT 20 "),array($activeinstitution));
	
	break;
	
	case 'vitalview':
	$value=explode('@@',$keys);
	 $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_vitals_details WHERE VITDET_VISITCODE = ".$sql->Param('a')." "),array($value[0]));
	 $requestdetails=$patient->getServRequestDetail($value[1]);
	 //$photourl=$patient->getPassPicture();
	
	break;
	
	
	case 'getclientdetails':
    //var_dump($keys); die();
        if($keys){
  $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_service_request WHERE REQU_CODE = ".$sql->Param('a')." "),array($keys));
            $client = $stmt->FetchNextObject();
			$patientcode= $client->REQU_PATIENTNUM;
			$session->set('tablerowid',$client->REQU_ID);
			$session->set('visitcode',$client->REQU_VISITCODE);
             $stmtp = $sql->Execute($sql->Prepare("SELECT PATIENT_IMAGE,TIMESTAMPDIFF(YEAR,PATIENT_DOB, NOW())AS AGE FROM hms_patient WHERE PATIENT_PATIENTNUM = ".$sql->Param('a')." "),array($patientcode));
            $obj = $stmtp->FetchNextObject(); 
			$image=$obj->PATIENT_IMAGE;
			$patientage= $obj->AGE;
			
        }
        include "model/js.php";
    break;
	
    case 'savevitals':
		$postkey = $session->get("postkey");
		if($postkey != $microtime){
		$session->set("postkey",$microtime);
		//DECODE THE JASON ARRAY
			$newdata = json_decode($data);
			$vitaldetcode = uniqid();
		
			if(is_array($newdata)){
			/*print_r($newdata);
			exit;*/
			$stmtdata = $sql->Execute($sql->Prepare("INSERT INTO hms_vitals_details (VITDET_VITALSTYPE, VITDET_VITALSVALUE,VITDET_VISITCODE,  VITDET_DATE, VITDET_PATIENTID,VITDET_PATIENTNO)VALUES(".$sql->Param('a').",".$sql->Param('b').", ".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').")"),$newdata);
			
			
		
		$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_vitals (VITALS_CODE, VITALS_VISITCODE, VITALS_REQUCODE, VITALS_PATIENTID, VITALS_SERVICE,VITALS_FACILITYCODE,VITALS_PAYMENT,VITALS_PATIENTNO,VITALS_ACTOR,VITALS_DATE,VITALS_ACTOR_NAME)VALUES(".$sql->Param('a').",".$sql->Param('b').", ".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('g').",".$sql->Param('g').",".$sql->Param('g').",".$sql->Param('g').")"), array($vitaldetcode,$visitcode,$regcode,$patientcode, $servicename,$activeinstitution, $paymenttype,$patientno,$actor_id,date('Y-m-d'),$usrname));
		
			
			$stmtp = $sql->Execute($sql->Prepare("UPDATE hms_service_request SET REQU_STATUS='2' WHERE REQU_CODE=".$sql->Param('b')),array($keys));
			
			$stmtc = $sql->Execute($sql->Prepare("UPDATE hms_consultation SET CONS_SERVCODE='SER0001' WHERE CONS_VISITCODE=".$sql->Param('b')),array($session->get('visitcode')));
			
		
		$msg = "Patient Vitals has been captured Successfully.";
	    $status = "success";
		
        $activity = "Patient Vitals captured Successfully.";
		$engine->setEventLog("013",$activity);
		$tablerowid =$session->get('tablerowid');
		
			$engine->ClearNotification('0004',$tablerowid);
			}else{
		$msg = "Sorry! No Patient Vital captured.";
	    $status = "error";
		
				}
			
		}

    break;
}
//echo $usertype;
if($usertype!=5){
if(!empty($fdsearch)){
 $query = "SELECT REQU_INPUTEDDATE,REQU_CODE,REQU_PATIENTNUM,REQU_VISITCODE,REQU_PATIENT_FULLNAME,REQU_SERVICENAME,REQU_DATE,REQU_STATUS FROM hms_service_request WHERE REQU_STATUS = '8' AND REQU_PATIENT_FULLNAME LIKE ".$sql->Param('a')." OR REQU_PATIENTNUM = ".$sql->Param('b')." AND REQU_FACI_CODE=".$sql->Param('c')." ORDER BY REQU_DATE DESC";
        $input = array('%'.$fdsearch.'%',$fdsearch,$activeinstitution);
		
}else {
	 $query = "SELECT REQU_INPUTEDDATE,REQU_CODE,REQU_PATIENTNUM,REQU_VISITCODE,REQU_PATIENT_FULLNAME,REQU_SERVICENAME,REQU_DATE,REQU_STATUS FROM hms_service_request WHERE REQU_STATUS = '8' AND REQU_FACI_CODE=".$sql->Param('a');
        $input = array($activeinstitution);
	
}
}else{
	if(!empty($fdsearch)){
 $query = "SELECT REQU_INPUTEDDATE,REQU_CODE,REQU_PATIENTNUM,REQU_VISITCODE,REQU_PATIENT_FULLNAME,REQU_SERVICENAME,REQU_DATE,REQU_STATUS FROM hms_service_request WHERE REQU_STATUS = '8' AND REQU_PATIENT_FULLNAME LIKE ".$sql->Param('a')." OR REQU_PATIENTNUM = ".$sql->Param('b')." AND REQU_FACI_CODE=".$sql->Param('c')." ORDER BY REQU_DATE DESC";
        $input = array('%'.$fdsearch.'%',$fdsearch,$activeinstitution);
		
}else {
	 $query = "SELECT REQU_INPUTEDDATE,REQU_CODE,REQU_PATIENTNUM,REQU_VISITCODE,REQU_PATIENT_FULLNAME,REQU_SERVICENAME,REQU_DATE,REQU_STATUS FROM hms_service_request WHERE REQU_STATUS = '8' AND REQU_FACI_CODE=".$sql->Param('a');
        $input = array($activeinst);
	
}
	}
$stmtoptions = $sql->Execute($sql->Prepare("SELECT * from hms_vitaloptions where VIT_STATU='1' "));


if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=9f964da2cba334e69413194da722e7b0&option=0753d7196f21820365b1daf960453855&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);



?>