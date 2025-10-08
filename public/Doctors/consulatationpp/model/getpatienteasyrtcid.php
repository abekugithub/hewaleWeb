<?php
ob_start();
include('../../../../config.php');
include SPATH_LIBRARIES.DS.'engine.Class.php';
$engine = new engineClass();
$actordetails = $engine->getActorDetails();
$usrcode = $actordetails->USR_CODE;
		
		$stmt = $sql->Execute($sql->Prepare("SELECT PATCON_EASYRTCCODE FROM hms_patient_connect WHERE PATCON_PATIENTCODE = ".$sql->Param('a')." "),array($patientcode));
		
		if(!empty($easyrtctype)){
		$sql->Execute("UPDATE hms_users SET USR_CALLTYPE = ".$sql->Param('a')." WHERE USR_CODE = ".$sql->Param('b')." ",array($easyrtctype,$usrcode));
		print $sql->ErrorMsg();
		}
		if($stmt){
			if($stmt->RecordCount() > 0){
			 $obj = $stmt->FetchNextObject();
			 $connectify = array('easyrtcid'=>$obj->PATCON_EASYRTCCODE);
		
			 echo json_encode($connectify);
				
			 }else{
				     return 0;
				  }
			}else{
				     return 0;
				  }