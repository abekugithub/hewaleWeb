<?php
include('../../../../config.php');
include SPATH_LIBRARIES.DS.'engine.Class.php';
$engine = new engineClass();
$actordetails = $engine->getActorDetails();
$usrcode = $actordetails->USR_CODE;

	if(!empty($patientcode)){
        //Get patient details
        $stmt = $sql->Execute($sql->Prepare("SELECT PATCON_PLAYERID FROM hms_patient_connect WHERE PATCON_PATIENTCODE = ".$sql->Param('a')." "),array($patientcode));
        $obj = $stmt->FetchNextObject() ;
        $playerid = $obj->PATCON_PLAYERID;
        //$playerid = 'c8affb47-23de-44f0-8321-794917ae1a3b';
        $title = 'Upcoming call';
        $message = 'You are receiving a call from your doctor.';
        $type = 'Awake App';

        $engine->notify($title,$message,$playerid,$type);
		
	}
	echo json_encode(1);