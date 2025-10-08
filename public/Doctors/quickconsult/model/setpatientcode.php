<?php
include('../../../../config.php');
include SPATH_LIBRARIES.DS.'engine.Class.php';
$engine = new engineClass();
$actordetails = $engine->getActorDetails();
$usrcode = $actordetails->USR_CODE;
		
		//Set Patient code to be in quick consult with the doctor
		$sql->Execute("UPDATE hms_users SET USR_CHATSTATE = ".$sql->Param('a')." WHERE USR_CODE = ".$sql->Param('a')." ",array($patientcode,$usrcode));
		