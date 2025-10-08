<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 8/25/2017
 * Time: 11:59 AM
 */
include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
//include SPATH_LIBRARIES.DS."patient.Class.php";

$engine = new engineClass();
$patientCls = new patientClass();


$day = Date("Y-m-d H:i:s");
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();
$actor = $engine->getActorDetails();
$activeinstitution = $actor->USR_FACICODE;

if (!empty($vitals_type)&&!empty($vitals_value)){
	
	 //$result = $vitals_type.'--'.$vitals_value.'--'.$visitcode.'--'.$day.'--'.$patientcode.'--'.$patientnum.'--'.$emergencycode.'--'.$faccode.'--'.$actor;
	 //$result = $actor;
	 echo 'HI';
	//die();
	$stmtdata = $sql->Execute($sql->Prepare("INSERT INTO hms_emergency_vitals(VIT_VITALSTYPE, VIT_VITALSVALUE,VIT_VISITCODE,VIT_DATEADDED,VIT_PATIENTCODE,VIT_PATIENTNUM,VIT_EMERCODE,VIT_FACICODE,VIT_ACTOR,VIT_ACTORCODE)VALUES(".$sql->Param('a').",".$sql->Param('b').", ".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('i').")"),array($vitals_type,$vitals_value,$visitcode,$day,$patientcode,$patientnum,$emergencycode,$faccode,$usrname,$usrcode));
	
			print $sql->ErrorMsg();
			
			if ($stmtdata==TRUE){
		
        $activity = "Patient Vitals captured Successfully.";
		$engine->setEventLog("013",$activity);
		$tablerowid =$session->get('tablerowid');
			}
			
    echo json_encode($result);
}