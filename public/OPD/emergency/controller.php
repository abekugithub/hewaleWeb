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
$faccode = $engine->getActorDetails()->USR_FACICODE;
$crtdate= date("Y-m-d H:m:s");

switch ($viewpage){
	case "manage":

		$stmtpres = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_STATUS='1' AND PRESC_VISITCODE=".$sql->Param('a')." AND (PRESC_PATIENTNUM=".$sql->Param('b')." OR PRESC_PATIENTCODE=".$sql->Param('b').") ORDER BY PRESC_ID DESC"),array($visitcode,$patientnum,$patientcode));
            print $sql->ErrorMsg();
			
			$stmtlabs = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_STATUS IN ('1','6') AND LT_VISITCODE=".$sql->Param('a')." AND (LT_PATIENTNUM=".$sql->Param('b')." OR LT_PATIENTCODE=".$sql->Param('b').") ORDER BY LT_ID DESC"),array($visitcode,$patientnum,$patientcode));
            print $sql->ErrorMsg();
			
			$stmtdrugslov = $sql->Execute($sql->Prepare("SELECT * from hmsb_st_phdrugs order by DR_NAME ")) ;
			
			$stmttestlov = $sql->Execute($sql->Prepare("SELECT * from hmsb_st_labtest order by LTT_NAME ")) ;
			
			$stmtxray = $sql->Execute($sql->Prepare("SELECT * from hmsb_st_xray order by X_ID DESC ")) ;
			
			$stmtx = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_xraytest WHERE XT_STATUS IN ('1','6') AND XT_VISITCODE=".$sql->Param('a')." AND (XT_PATIENTNUM=".$sql->Param('b')." OR XT_PATIENTCODE=".$sql->Param('b').") ORDER BY XT_ID DESC"),array($visitcode,$patientnum,$patientcode));
            print $sql->ErrorMsg();
	
	break;
	
	
	
	case "vitals":
		/*
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
		$msg = "Patient Vitals has been captured Successfully.";
	    $status = "success";
		$views ="add";
        $activity = "Patient Vitals captured Successfully.";
		$engine->setEventLog("013",$activity);
		$tablerowid =$session->get('tablerowid');
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
		*/ 
	break;	
	
	
	
	
	case "activities":
		$postkey = $session->get("postkey");
		if($postkey != $microtime){
		$session->set("postkey",$microtime);
	$stmt=$sql->Execute($sql->Prepare("INSERT INTO hms_emergency_activity(ACV_EMERCODE, ACV_VISITCODE,ACV_TRIAGE, ACV_PRESENT_CONDITION, ACV_BED, ACV_PATIENTNUM, ACV_PATIENTCODE, ACV_ACTOR, ACV_STATUS, ACV_FACICODE)VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('j').")"),array($v,$keys,$triage,$condition,$availablebed,$patientnum,$patkey,$actorname,'1',$faccode));
	if ($stmt==TRUE){
	$msg = "Patient activities have been captured Successfully.";
	$status = "success";	
	$views='add';
	}else{
	$msg = "Patient activities could not be captured, please try again.";
	$status = "error";	
	$view='add';
	}
		}
	break;
	
	
	
	
	
	case "consumables":
		$postkey = $session->get("postkey");
		if($postkey != $microtime){
		$session->set("postkey",$microtime);
	$stmt=$sql->Execute($sql->Prepare("INSERT INTO hms_emergency_consumables(CON_EMERCODE, CON_VISITCODE,CON_ITEMNAME, CON_QUANTITY,CON_PATIENTNUM,CON_PATIENTCODE,CON_ACTOR,CON_STATUS, CON_FACICODE)VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').")"),array($v,$keys,$product,$quantity,$patientnum,$patkey,$actorname,'1',$faccode));
	if ($stmt==TRUE){
	$msg = "Patient consumable have been captured Successfully.";
	$status = "success";
	$views='add';
	}else{
	$msg = "Patient consumable could not be captured, please try again.";
	$status = "success";	
	$views='add';
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
			
        	
		
	//drop table for vitals
	$stmtvitals=$sql->Execute($sql->Prepare("SELECT * from hms_emergency_vitals WHERE VIT_STATUS=".$sql->Param('a')." AND VIT_FACICODE=".$sql->Param('b')." AND VIT_VISITCODE=".$sql->Param('c')." AND VIT_PATIENTCODE=".$sql->Param('e')." "),array('1',$faccode,$keys,$patkey));
	if ($stmtvitals->RecordCount()>0){
		while ($obj=$stmtvitals->FetchNextObject()){
		$vitals_array[]=array('VITALS_ID'=>$obj->VIT_ID,'VITALS_EMERGENCY'=>$obj->VIT_EMERCODE, 'VITALS_VISITCODE'=>$obj->VIT_VISITCODE, 'VITALS_VALUE'=>$obj->VIT_VITALSVALUE,'VITALS_TYPE'=> $obj->VIT_VITALSTYPE, 'VITALS_PATIENT_NUMBER'=>$obj->VIT_PATIENTNUM,'VITALS_PATIENT_CODE'=>$obj->VIT_PATIENTCODE,'VITALS_ACTOR'=>$obj->VIT_ACTOR,'VITALS_STATUS'=>$obj->VIT_STATUS,'VITALS_FACILITY_CODE'=>$obj->VIT_FACICODE,'VITALS_DATE'=>$obj->VIT_INPUTDATE);
		}
	}else{
	$vitals_array='';
	}
	
	$stmtvital="";
	//drop table for activities
	$stmtactivities=$sql->Execute($sql->Prepare("SELECT * from hms_emergency_activity WHERE ACV_STATUS=".$sql->Param('a')." AND ACV_FACICODE=".$sql->Param('b')." AND ACV_VISITCODE=".$sql->Param('c')." AND ACV_PATIENTCODE=".$sql->Param('e')." "),array('1',$faccode,$keys,$patkey));
	if ($stmtactivities->RecordCount()>0){
		while ($obj=$stmtactivities->FetchNextObject()){
		$activity_array[]=array('ACTIVITY_ID'=>$obj->ACV_ID,'ACTIVITY_EMERGENCY'=>$obj->ACV_EMERCODE, 'ACTIVITY_VISITCODE'=>$obj->ACV_VISITCODE,'ACTIVITY_TRIAGE'=>$obj->ACV_TRIAGE, 'ACTIVITY_PRESENT_CONDITION'=>$obj->ACV_PRESENT_CONDITION,'ACTIVITY_BED'=> $obj->ACV_BED, 'ACTIVITY_PATIENT_NUMBER'=>$obj->ACV_PATIENTNUM,'ACTIVITY_PATIENT_CODE'=>$obj->ACV_PATIENTCODE,'ACTIVITY_ACTOR'=>$obj->ACV_ACTOR,'ACTIVITY_STATUS'=>$obj->ACV_STATUS,'ACTIVITY_FACILITY_CODE'=>$obj->ACV_FACICODE,'ACTIVITY_DATE'=>$obj->ACV_INPUTDATE);
		}
	}else{
	$activity_array='';
	}
	
	//drop table for consumables
$stmtconsumables=$sql->Execute($sql->Prepare("SELECT * from hms_emergency_consumables WHERE CON_STATUS=".$sql->Param('a')." AND CON_FACICODE=".$sql->Param('b')." AND CON_VISITCODE=".$sql->Param('c')." AND CON_PATIENTCODE=".$sql->Param('e')." "),array('1',$faccode,$keys,$patkey));
	if ($stmtconsumables->RecordCount()>0){
		while ($obj=$stmtconsumables->FetchNextObject()){
		$consumbles_array[]=array('CONSUMABLE_ID'=>$obj->CON_ID,'CONSUMABLE_EMERGENCY'=>$obj->CON_EMERCODE, 'CONSUMABLE_VISITCODE'=>$obj->CON_VISITCODE, 'CONSUMBALE_QUANTITY'=>$obj->CON_QUANTITY,'CONSUMABLE_ITEM'=> $obj->CON_ITEMNAME, 'CONSUMABLE_PATIENT_NUMBER'=>$obj->CON_PATIENTNUM,'CONSUMABLE_PATIENT_CODE'=>$obj->CON_PATIENTCODE,'CONSUMABLE_ACTOR'=>$obj->CON_ACTOR,'CONSUMABLE_STATUS'=>$obj->CON_STATUS,'CONSUMABLE_FACILITY_CODE'=>$obj->CON_FACICODE,'CONSUMABLE_DATE'=>$obj->CON_INPUTDATE);
		}
	}else{
	$consumbles_array='';
	}
	
	//drop table for  reports
$stmtreports=$sql->Execute($sql->Prepare("SELECT * from hms_emergency_reports WHERE REP_STATUS=".$sql->Param('a')." AND REP_FACICODE=".$sql->Param('b')." AND REP_VISITCODE=".$sql->Param('c')." AND REP_PATIENTCODE=".$sql->Param('e')." "),array('1',$faccode,$keys,$patkey));
	if ($stmtreports->RecordCount()>0){
		while ($obj=$stmtreports->FetchNextObject()){
		$reports_array[]=array('REPORT_ID'=>$obj->REP_ID,'REPORT_EMERGENCY'=>$obj->REP_EMERCODE, 'REPORT_VISITCODE'=>$obj->REP_VISITCODE, 'REPORT_DETAILS'=>$obj->REP_DETAILS,'REPORT_PATIENT_NUMBER'=>$obj->REP_PATIENTNUM,'REPORT_PATIENT_CODE'=>$obj->REP_PATIENTCODE,'REPORT_ACTOR'=>$obj->REP_ACTOR,'REPORT_STATUS'=>$obj->REP_STATUS,'REPORT_FACILITY_CODE'=>$obj->REP_FACICODE,'REPORT_DATE'=>$obj->REP_INPUTDATE);
		}
	}else{
	$reports_array='';
	}
	
//drop table for  discharge
$stmtdischarge=$sql->Execute($sql->Prepare("SELECT * from hms_emergency_discharge WHERE DIS_STATUS=".$sql->Param('a')." AND DIS_FACICODE=".$sql->Param('b')." AND DIS_VISITCODE=".$sql->Param('c')." AND DIS_PATIENTCODE=".$sql->Param('e')." "),array('1',$faccode,$keys,$patkey));
	if ($stmtdischarge->RecordCount()>0){
		while ($obj=$stmtdischarge->FetchNextObject()){
		$discharge_array[]=array('DISCHARGE_ID'=>$obj->DIS_ID,'DISCHARGE_EMERGENCY'=>$obj->DIS_EMERCODE, 'DISCHARGE_VISITCODE'=>$obj->DIS_VISITCODE, 'DISCHARGE_DETAILS'=>$obj->DIS_DETAILS,'DISCHARGE_PATIENT_NUMBER'=>$obj->DIS_PATIENTNUM,'DISCHARGE_PATIENT_CODE'=>$obj->DIS_PATIENTCODE,'DISCHARGE_ACTOR'=>$obj->DIS_ACTOR,'DISCHARGE_STATUS'=>$obj->DIS_STATUS,'DISCHARGE_FACILITY_CODE'=>$obj->DIS_FACICODE,'DISCHARGE_DATE'=>$obj->DIS_INPUTDATE);
		}
	}else{
	$discharge_array='';
	}
	
$stmtoptions = $sql->Execute($sql->Prepare("SELECT * from hms_vitaloptions where VIT_STATU='1' "));	
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

        $query = "SELECT * FROM hms_emergency JOIN hms_patient ON EMER_PATIENTCODE=PATIENT_PATIENTCODE WHERE EMER_STATUS = '2' AND EMER_FACICODE=".$sql->Param('2')." AND (EMER_PATIENTNUM = ".$sql->Param('a')." OR EMER_PATIENTNAME LIKE ".$sql->Param('b').") ORDER BY EMER_INPUTDATE DESC";
        $input = array($faccode,$fdsearch,'%'.$fdsearch.'%');

    }
}else{

    $query = "SELECT * FROM hms_emergency JOIN hms_patient ON EMER_PATIENTCODE=PATIENT_PATIENTCODE WHERE EMER_STATUS = ".$sql->Param('1')." AND EMER_FACICODE=".$sql->Param('2')." ORDER BY EMER_INPUTDATE DESC";
    $input = array('2',$faccode);

}


if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=ad2376beebecdcf7846ba973fa1a005b&option=6831b98f85019ddb98bd98d44bdbac40#',$input);

include("model/rndjs.php");
?>