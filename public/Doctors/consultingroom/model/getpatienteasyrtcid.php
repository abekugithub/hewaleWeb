<?php
ob_start();
include('../../../../config.php');
include SPATH_LIBRARIES.DS.'engine.Class.php';
$engine = new engineClass();
$actordetails = $engine->getActorDetails();
$usrcode = $actordetails->USR_CODE;
		
		$stmt = $sql->Execute($sql->Prepare("SELECT CONSROOM_EASYRTCID FROM hms_consultation_rooms WHERE CONSROOM_CODE = ".$sql->Param('a')." AND CONSROOM_DOCTORCODE = ".$sql->Param('b')." "),array($roomid,$usrcode));
		print $sql->ErrorMsg();
		if($stmt){
			if($stmt->RecordCount() > 0){
			 $obj = $stmt->FetchNextObject();
			 $connectify = array('easyrtcid'=>$obj->CONSROOM_EASYRTCID);
		
			 echo json_encode($connectify);
				
			 }else{
				     return 0;
				  }
			}else{
				     return 0;
				  }