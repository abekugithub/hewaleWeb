<?php
ob_start();
include('../../../../config.php');
include SPATH_LIBRARIES.DS.'engine.Class.php';
$engine = new engineClass();
	
		$stmt = $sql->Execute($sql->Prepare("SELECT USR_EASYRTCCODE FROM hms_users WHERE USR_CODE = ".$sql->Param('a')." "),array($doctorcode));
		
		if($stmt){
			if($stmt->RecordCount() > 0){
			 $obj = $stmt->FetchNextObject();
			 $connectify = array('easyrtcid'=>$obj->USR_EASYRTCCODE);
		
			 echo json_encode($connectify);
				
			 }else{
				     return 0;
				  }
			}else{
				     return 0;
				  }