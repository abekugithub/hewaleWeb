<?php
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$userCourier = $engine->getActorCourier();
$patient=new patientClass();
$usertype= $engine->getUsertype();
$actor_id = $session->get("userid");
$usrname = $engine->getActorName();
$facidetails = $engine->getFacilityDetails();
$facitype = $facidetails->FACI_TYPE;


switch($viewpage){
	case "cancelrequest":
	$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_service_request WHERE REQU_CODE = ".$sql->Param('a')." "),array($keys));
            $client = $stmt->FetchNextObject();
			$patientcode= $client->REQU_PATIENTNUM;
			//$session->set('tablerowid',$client->REQU_ID);
	$stmt = $sql->Execute($sql->Prepare("UPDATE hms_service_request SET REQU_STATUS ='13', REQU_CANCEL_REASON=".$sql->Param('a')." WHERE REQU_CODE=".$sql->Param('d').""),array($canceldata,$keys));
	print $sql->ErrorMsg();
	
	
	$msg = "Patient Vitals request has been cancelled Successfully.";
	    $status = "success";
		$engine->ClearNotification('0004',$client->REQU_ID);
        $activity = "Patient Vitals request cancelled.";
		$engine->setEventLog("101",$activity);
	break;
	
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
      
    break;
	
    case 'savevitals':
		$postkey = $session->get("postkey");
		if($postkey != $microtime){
		$session->set("postkey",$microtime);
		//DECODE THE JASON ARRAY
			$newdata = json_decode($data);
			$vitaldetcode = uniqid();
		
			if(is_array($newdata)){
		//print_r($newdata);
			//exit;
			$stmtdata = $sql->Execute($sql->Prepare("INSERT INTO hms_vitals_details (VITDET_VITALSTYPE, VITDET_VITALSVALUE,VITDET_VISITCODE,  VITDET_DATE, VITDET_PATIENTID,VITDET_PATIENTNO)VALUES(".$sql->Param('a').",".$sql->Param('b').", ".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').")"),$newdata);
			
			
		
		$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_vitals (VITALS_CODE, VITALS_VISITCODE, VITALS_REQUCODE, VITALS_PATIENTID, VITALS_SERVICE,VITALS_FACILITYCODE,VITALS_PAYMENT,VITALS_PATIENTNO,VITALS_ACTOR,VITALS_DATE,VITALS_ACTOR_NAME)VALUES(".$sql->Param('a').",".$sql->Param('b').", ".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('g').",".$sql->Param('g').",".$sql->Param('g').",".$sql->Param('g').")"), array($vitaldetcode,$visitcod,$regcode,$patientcode, $servicename,$activeinstitution, $paymenttype,$patientno,$actor_id,date('Y-m-d'),$usrname));
		
			
			$stmtp = $sql->Execute($sql->Prepare("UPDATE hms_service_request SET REQU_STATUS='2' WHERE REQU_CODE=".$sql->Param('b')),array($keys));
			
//			$stmtc = $sql->Execute($sql->Prepare("UPDATE hms_consultation SET CONS_SERVCODE='SER0001' WHERE CONS_VISITCODE=".$sql->Param('b')),array($session->get('visitcode')));
                if (!empty($prescriber)){
                    $prescriber = explode('@@@',$prescriber);
                    $doctorcode = $prescriber[0];
                    $doctorname = $prescriber[1];
                    $consultationcode = $patient->getConsultCode($activeinstitution);
                    $stmtc = $sql->Execute($sql->Prepare("INSERT INTO hms_consultation (CONS_CODE, CONS_DATE, CONS_PATIENTNUM, CONS_PATIENTNAME, CONS_REQUCODE, CONS_VISITCODE, CONS_SERVICECODE, CONS_SERVICENAME, CONS_DOCTORNAME, CONS_DOCTORCODE, CONS_SCHEDULEDATE, CONS_FACICODE, CONS_SCHEDULETIME, CONS_SERVCODE, CONS_PATIENTCODE, CONS_PAYMETHCODE, CONS_PAYMETH)  VALUES (".$sql->Param('1').", ".$sql->Param('2').", ".$sql->Param('3').", ".$sql->Param('4').", ".$sql->Param('5').", ".$sql->Param('6').", ".$sql->Param('7').", ".$sql->Param('8').", ".$sql->Param('9').", ".$sql->Param('10').", ".$sql->Param('11').", ".$sql->Param('12').", ".$sql->Param('13').", ".$sql->Param('14').", ".$sql->Param('15').", ".$sql->Param('16').", ".$sql->Param('17').")"),array($consultationcode,$startdate,$patientno,$patientname,$regcode,$session->get('visitcode'),'SER0001','CONSULTATION',$doctorname,$doctorcode,$startdate,$activeinstitution,date('H:i:s',strtotime($startdate)),'SER0001',$patientcode,$paymenttype,$paymenttype));
                }

		
		$msg = "Patient Vitals has been captured Successfully.";
	    $status = "success";
		
        $activity = "Patient Vitals captured Successfully.";
		$engine->setEventLog("013",$activity);
		   $tablerowid =$session->get('tablerowid');
		
			$engine->ClearNotification('0002',$tablerowid);
			}else{
		$msg = "Sorry! No Patient Vital captured.";
	    $status = "error";
		
				}
			
		}

    break;

    case 'reset':
        $fdsearch = '';
    break;
}
//echo $usertype;
//if($usertype!=5){
//if(!empty($fdsearch)){
// $query = "SELECT REQU_INPUTEDDATE,REQU_CODE,REQU_PATIENTNUM,REQU_VISITCODE,REQU_PATIENT_FULLNAME,REQU_SERVICENAME,REQU_DATE,REQU_STATUS FROM hms_service_request WHERE REQU_STATUS = '8' AND REQU_PATIENT_FULLNAME LIKE ".$sql->Param('a')." OR REQU_PATIENTNUM = ".$sql->Param('b')." AND REQU_FACI_CODE=".$sql->Param('c')." ORDER BY REQU_DATE DESC";
//        $input = array('%'.$fdsearch.'%',$fdsearch,$activeinstitution);
//
//}else {
//	 $query = "SELECT REQU_INPUTEDDATE,REQU_CODE,REQU_PATIENTNUM,REQU_VISITCODE,REQU_PATIENT_FULLNAME,REQU_SERVICENAME,REQU_DATE,REQU_STATUS FROM hms_service_request WHERE REQU_STATUS = '8' AND REQU_FACI_CODE=".$sql->Param('a')." ORDER BY REQU_DATE DESC";
//        $input = array($activeinstitution);
//
//}
//}else{
//	if(!empty($fdsearch)){
//// $query = "SELECT REQU_INPUTEDDATE,REQU_CODE,REQU_PATIENTNUM,REQU_VISITCODE,REQU_PATIENT_FULLNAME,REQU_SERVICENAME,REQU_DATE,REQU_STATUS FROM hms_service_request WHERE REQU_STATUS = '8' AND REQU_PATIENT_FULLNAME LIKE ".$sql->Param('a')." OR REQU_PATIENTNUM = ".$sql->Param('b')." AND REQU_FACI_CODE=".$sql->Param('c')." ORDER BY REQU_DATE DESC";
////        $input = array('%'.$fdsearch.'%',$fdsearch,$activeinstitution);
//
//        $query = "SELECT  FROM hms_patient WHERE PATIENT_STATUS = '1' AND PATIENT_DELETESTATUS = '1' AND (PATIENT_FNAME LIKE ".$sql->Param('a')." OR PATIENT_MNAME LIKE ".$sql->Param('a')." OR PATIENT_LNAME LIKE ".$sql->Param('a')." OR PATIENT_PATIENTNUM = ".$sql->Param('b')." AND PATIENT_PATIENTCODE=".$sql->Param('c').") ORDER BY PATIENT_INPUTEDDATE DESC";
//        $input = array('%'.$fdsearch.'%','%'.$fdsearch.'%','%'.$fdsearch.'%',$fdsearch,$fdsearch);
//
//}else {
//	 $query = "SELECT REQU_INPUTEDDATE,REQU_CODE,REQU_PATIENTNUM,REQU_VISITCODE,REQU_PATIENT_FULLNAME,REQU_SERVICENAME,REQU_DATE,REQU_STATUS FROM hms_service_request WHERE REQU_STATUS = '8' AND REQU_FACI_CODE=".$sql->Param('a')." ORDER BY REQU_DATE DESC";
//        $input = array($activeinst);
//
//}
//	}

$gender_array = array('M'=>'Male','F'=>'Female');

$stmtprescriber=$sql->Execute($sql->Prepare("SELECT USR_CODE,CONCAT(USR_SURNAME,' ',USR_OTHERNAME) USR_FULLNAME,USR_ONLINE_STATUS FROM hms_users WHERE USR_FACICODE= ".$sql->Param('a')." AND USR_TYPE=".$sql->Param('b').""),array($activeinstitution,'1'));

if($facitype != 'H'){
if (!empty($fdsearch)){
	$query = "SELECT * FROM hms_service_request WHERE REQU_STATUS = '8' AND (REQU_PATIENT_FULLNAME LIKE ".$sql->Param('b')." OR REQU_PATIENTNUM = ".$sql->Param('c').") ORDER BY REQU_ID ";
   // $query = "SELECT * FROM hms_patient WHERE PATIENT_STATUS = '1' AND PATIENT_DELETESTATUS = '1' AND (CONCAT(PATIENT_FNAME,' ',PATIENT_MNAME,' ',PATIENT_LNAME) LIKE ".$sql->Param('a')." OR PATIENT_PATIENTNUM = ".$sql->Param('b')." OR PATIENT_PHONENUM = ".$sql->Param('c')." ) ORDER BY PATIENT_ID";
    $input = array('%'.$fdsearch.'%',$fdsearch);
}
}else{

	if (!empty($fdsearch)){
	$query = "SELECT * FROM hms_service_request WHERE REQU_STATUS = '8' AND REQU_FACI_CODE = ".$sql->Param('a')." AND (REQU_PATIENT_FULLNAME LIKE ".$sql->Param('b')." OR REQU_PATIENTNUM = ".$sql->Param('c').") ORDER BY REQU_ID ";
		$input = array($activeinstitution,'%'.$fdsearch.'%',$fdsearch);
	}else{
		$query = "SELECT * FROM hms_service_request WHERE REQU_STATUS = '8' AND REQU_FACI_CODE = ".$sql->Param('a')."  ORDER BY REQU_ID ";
		$input = array($activeinstitution);
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

  include "model/js.php";

?>