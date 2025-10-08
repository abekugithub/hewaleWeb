<?php
include('../../../../config.php');
include SPATH_LIBRARIES.DS.'engine.Class.php';
$engine = new engineClass();
$actordetails = $engine->getActorDetails();
$usrcode = $actordetails->USR_CODE;

		$stmt = $sql->Execute($sql->Prepare("SELECT PATCON_EASYRTCCODE FROM hms_patient_connect WHERE PATCON_PATIENTCODE = ".$sql->Param('a')." "),array($patientcode));
		
		if($stmt){
			if($stmt->RecordCount() > 0){
			 $obj = $stmt->FetchNextObject();
			 
			 $patienteasycode = array('patienteasycode'=>$obj->PATCON_EASYRTCCODE);
			 
			 echo json_encode($patienteasycode);
				
			 }else{
				 
				  }
			}