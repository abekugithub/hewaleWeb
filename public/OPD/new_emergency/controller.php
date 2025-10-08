<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 9/18/2017
 * Time: 4:36 PM
 */
//print_r($_POST);
$actorname = $engine->getActorName();

$patientCls = new patientClass();
$sms = new smsgetway();
$import = new importClass();
$actorcode= $engine->getActorCode();
$faccode = $engine->getActorDetails()->USR_FACICODE;
$crtdate= date("Y-m-d H:m:s");

switch ($viewpage){
	case "manage":
	break;
	
	
	
	case "vitals":
		
		$postkey = $session->get("postkey");
		if($postkey != $microtime){
		$session->set("postkey",$microtime);
		//DECODE THE JASON ARRAY
			$newdata = json_decode($data);
			$vitaldetcode = uniqid();
			if(is_array($newdata) && count($newdata) > 0){
			$stmtdata = $sql->Execute($sql->Prepare("INSERT INTO hms_emergency_vitals(VIT_VITALSTYPE, VIT_VITALSVALUE,VIT_VISITCODE,  VIT_DATEADDED, VIT_PATIENTCODE,VIT_PATIENTNUM,VIT_EMERCODE,VIT_FACICODE,VIT_ACTOR)VALUES(".$sql->Param('a').",".$sql->Param('b').", ".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').")"),$newdata);
			print $sql->ErrorMsg();
			if ($stmtdata==TRUE){
				$doctor=!empty($doctor)?explode('@@@',$doctor):'';
                $doctorcode=(is_array($doctor) && count($doctor) >0 )?$doctor[0]:'';
                $doctorname=(is_array($doctor) && count($doctor) >0 )?$doctor[1]:'';
			$stmt=$sql->Execute($sql->Prepare("INSERT INTO hms_emergency_activity(ACV_EMERCODE, ACV_VISITCODE,ACV_TRIAGE, ACV_PRESENT_CONDITION, ACV_BED, ACV_PATIENTNUM, ACV_PATIENTCODE, ACV_ACTOR, ACV_STATUS, ACV_FACICODE,ACV_DOCTORCODE,ACV_DOCTORNAME)VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('j').",".$sql->Param('k').",".$sql->Param('l').")"),array($v,$keys,$triage,$condition,$availablebed,$patientnum,$patkey,$actorname,'1',$faccode,$doctorcode,$doctorname));
			if ($stmt==TRUE){
				$stmup =$sql->Execute($sql->Prepare("UPDATE hms_emergency SET EMER_STATUS=".$sql->Param('a')." WHERE EMER_FACICODE=".$sql->Param('b')." AND EMER_VISITCODE=".$sql->Param('c')." AND EMER_PATIENTCODE=".$sql->Param('e').""),array('2',$faccode,$keys,$patkey));
		$msg = "Patient with patient number $patientnum details have been captured successfully and sent to emergency.";
	    $status = "success";
		$views ="list";
        $activity = "Patient $patientnum Details captured Successfully and sent to emergency.";
		$engine->setEventLog("013",$activity);
		$tablerowid =$session->get('tablerowid');
			}else{
		$msg = "Patient Vitals could not be captured.";
	    $status = "error";
		$views ="add";	
			}
			}else{
		$msg = "Patient Vitals could not be captured.";
	    $status = "error";
		$views ="add";
        	
			
			}
		
			$engine->ClearNotification('0004',$tablerowid);
			}else{
		$msg = "Sorry! No Patient Vital captured.";
	    $status = "error";
		
				}
			
		}
		
	break;	
	case "janedoe":
$postkey = $session->get("postkey");
		if($postkey != $microtime){
		$session->set("postkey",$microtime);
		//DECODE THE JASON ARRAY
		//insert into emergency table
		$emergcode = $patientCls->getEmergCode($activeinstitution);
		$actudate = date("Y-m-d H:m:s");
		$startdate= date("Y-m-d");
		$inputtime=date("H:m");
		        	
		$sql->Execute("INSERT INTO hms_emergency(EMER_CODE,EMER_PATIENTCODE,EMER_REQUCONFIRMDATE,EMER_PATIENTNUM,EMER_PATIENTNAME,EMER_REQUCODE,EMER_FACICODE,EMER_VISITCODE,EMER_SERVICENAME,EMER_SERVICECODE,EMER_SCHEDULEDATE,EMER_SCHEDULETIME,EMER_STATUS) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('j').",".$sql->Param('k').",".$sql->Param('l').",".$sql->Param('m').") ",array($emergcode,$patkey,$actudate,$unkpatientnum,'UNKNOWN','UNKNOWN',$faccode,'UNKNOWN','EMERGENCY','SER0010',$startdate,$inputtime,'2'));	
			 $tablerowid=$sql->Insert_ID(); 
			 print $sql->ErrorMsg();
			$newdata = json_decode($data);
			$vitaldetcode = uniqid();
			if(is_array($newdata) && count($newdata) > 0){
			$stmtdata = $sql->Execute($sql->Prepare("INSERT INTO hms_emergency_vitals(VIT_VITALSTYPE, VIT_VITALSVALUE,VIT_VISITCODE,  VIT_DATEADDED, VIT_PATIENTCODE,VIT_PATIENTNUM,VIT_EMERCODE,VIT_FACICODE,VIT_ACTOR)VALUES(".$sql->Param('a').",".$sql->Param('b').", ".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').")"),$newdata);
			print $sql->ErrorMsg();
			if ($stmtdata==TRUE){
				$doctor=!empty($doctor)?explode('@@@',$doctor):'';
                $doctorcode=(is_array($doctor) && count($doctor) >0 )?$doctor[0]:'';
                $doctorname=(is_array($doctor) && count($doctor) >0 )?$doctor[1]:'';
			$stmt=$sql->Execute($sql->Prepare("INSERT INTO hms_emergency_activity(ACV_EMERCODE, ACV_VISITCODE,ACV_TRIAGE, ACV_PRESENT_CONDITION, ACV_BED, ACV_PATIENTNUM, ACV_PATIENTCODE, ACV_ACTOR, ACV_STATUS, ACV_FACICODE,ACV_DOCTORCODE,ACV_DOCTORNAME)VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('j').",".$sql->Param('k').",".$sql->Param('l').")"),array($v,$keys,$triage,$condition,$availablebed,$unkpatientnum,$patkey,$actorname,'1',$faccode,$doctorcode,$doctorname));
			if ($stmt==TRUE){
				$stmup =$sql->Execute($sql->Prepare("UPDATE hms_emergency SET EMER_STATUS=".$sql->Param('a')." WHERE EMER_FACICODE=".$sql->Param('b')." AND EMER_VISITCODE=".$sql->Param('c')." AND EMER_PATIENTCODE=".$sql->Param('e').""),array('2',$faccode,$keys,$patkey));
		$msg = "Patient with patient number $unkpatientnum details have been captured successfully and sent to emergency.";
	    $status = "success";
		$views ="list";
        $activity = "Patient $unkpatientnum Details captured Successfully and sent to emergency.";
		$engine->setEventLog("013",$activity);
		$tablerowid =$session->get('tablerowid');
			}else{
		$msg = "Patient Vitals could not be captured.";
	    $status = "error";
		$views ="add";	
			}
			}else{
		$msg = "Patient Vitals could not be captured.";
	    $status = "error";
		$views ="add";
        	
			
			}
		
			$engine->ClearNotification('0004',$tablerowid);
			}else{
		$msg = "Sorry! No Patient Vital captured.";
	    $status = "error";
		
				}
			
		}
	break;
}


switch ($views){
	case "add":
	//patient details
	$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_service_request JOIN hms_patient ON REQU_PATIENTCODE=PATIENT_PATIENTCODE WHERE REQU_PATIENTCODE = ".$sql->Param('a')." AND REQU_VISITCODE=".$sql->Param('b')." AND REQU_FACI_CODE=".$sql->Param('c').""),array($patkey,$keys,$faccode));
            $client = $stmt->FetchNextObject();
			$patientcode= $client->REQU_PATIENTNUM;
			$session->set('tablerowid',$client->REQU_ID);
			$session->set('visitcode',$client->REQU_VISITCODE);
             $stmtp = $sql->Execute($sql->Prepare("SELECT PATIENT_IMAGE,TIMESTAMPDIFF(YEAR,PATIENT_DOB, NOW())AS AGE FROM hms_patient WHERE PATIENT_PATIENTCODE = ".$sql->Param('a')." "),array($patkey));
            $obj = $stmtp->FetchNextObject(); 
			$image=$obj->PATIENT_IMAGE;
			$patientage= $obj->AGE;
		
$stmtoptions = $sql->Execute($sql->Prepare("SELECT * from hms_vitaloptions where VIT_STATU='1' "));	
	break;
	case "add_janedoe":
		$uniq =date('YmdHis').$faccode.rand(1,200).$actorcode;
		//echo $uniq; die();
		$patkey='UNK'.$uniq;
		$unkpatientnum='UNKNOWN'.$uniq;
		//echo $patkey;
$stmtoptions = $sql->Execute($sql->Prepare("SELECT * from hms_vitaloptions where VIT_STATU='1' "));		
	break;	
}

//Get countries
include 'model/js.php';
//   Months Array
$months = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December');
//   Days Array
$days = array();
for ($i=01; $i<32; $i++){
    array_push($days,$i);
}
//   Years Array
$years = array();
for ($i=date('Y'); $i>=1920; $i--){
    array_push($years,$i);
}

if(isset($action_search) && $action_search == "search"){
    if(!empty($fdsearch)){

        $query = "SELECT * FROM hms_emergency JOIN hms_patient ON EMER_PATIENTCODE=PATIENT_PATIENTCODE WHERE EMER_STATUS = '1' AND EMER_FACICODE=".$sql->Param('2')." AND (EMER_PATIENTNUM = ".$sql->Param('a')." OR EMER_PATIENTNAME LIKE ".$sql->Param('b').") ORDER BY EMER_INPUTDATE DESC";
        $input = array($faccode,$fdsearch,'%'.$fdsearch.'%');

    }
}else{

    $query = "SELECT * FROM hms_emergency JOIN hms_patient ON EMER_PATIENTCODE=PATIENT_PATIENTCODE WHERE EMER_STATUS = ".$sql->Param('1')." AND EMER_FACICODE=".$sql->Param('2')." ORDER BY EMER_INPUTDATE DESC";
    $input = array('1',$faccode);

}


if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=ad2376beebecdcf7846ba973fa1a005b&option=6831b98f85019ddb98bd98d44bdbac40#',$input);

$stmtprescriber=$sql->Execute($sql->Prepare("SELECT USR_CODE,CONCAT(USR_SURNAME,' ',USR_OTHERNAME) USR_FULLNAME,USR_ONLINE_STATUS FROM hms_users WHERE USR_FACICODE= ".$sql->Param('a')." AND USR_TYPE=".$sql->Param('b').""),array($faccode,'1'));

?>