<?php
include('../../../../config.php');
include SPATH_LIBRARIES.DS.'engine.Class.php';
$engine = new engineClass();
$actordetails = $engine->getActorDetails();
$usrcode = $actordetails->USR_CODE;

	if(!empty($selfEasyrtcid)){
		
   $stmt = $sql->Execute("UPDATE hms_users SET USR_EASYRTCCODE = ".$sql->Param('a')." WHERE USR_CODE = ".$sql->Param('b')." AND USR_STATUS = '1' ",array($selfEasyrtcid,$usrcode));
	}
	echo json_encode(1);