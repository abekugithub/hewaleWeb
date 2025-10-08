<?php
include('../../../../config.php');
include SPATH_LIBRARIES.DS.'engine.Class.php';
$engine = new engineClass();
$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
		
		$stmt = $sql->Execute($sql->Prepare("SELECT CHT_MSG,CHT_ID FROM hms_chatmarket WHERE CHT_RECEIVER_CODE = ".$sql->Param('a')." AND CHT_SENDER_CODE = ".$sql->Param('b')." AND CHT_VIEW_STATUS = '0' LIMIT 1"),array($senderid,$patientcode));
		
		if($stmt){
			if($stmt->RecordCount() > 0){
			 $obj = $stmt->FetchNextObject();
			 $chatmsg = $encaes->decrypt($obj->CHT_MSG);
			 $chatboat = array('chatmsg'=>$chatmsg);
			 
			 $stmt = $sql->Execute("UPDATE hms_chatmarket SET CHT_VIEW_STATUS = '1' WHERE  CHT_ID = ".$sql->Param('a')." ",array($obj->CHT_ID));
			 
			 	echo json_encode($chatboat);
				
			 }else{
				 
				  }
			}