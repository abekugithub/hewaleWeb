<?php
include('../../../../config.php');
include SPATH_LIBRARIES.DS.'engine.Class.php';
$engine = new engineClass();
		
		$stmt = $sql->Execute($sql->Prepare("SELECT CH_MSG,CH_ID FROM hms_chat WHERE CH_RECEIVER_CODE = ".$sql->Param('a')." AND CH_SENDER_CODE = ".$sql->Param('b')." AND CH_VIEW_STATUS = '0' LIMIT 1"),array($senderid,$patientcode));
		
		if($stmt){
			if($stmt->RecordCount() > 0){
			 $obj = $stmt->FetchNextObject();
			 $chatboat = array('chatmsg'=>$obj->CH_MSG);
			 
			 $stmt = $sql->Execute("UPDATE hms_chat SET CH_VIEW_STATUS = '1' WHERE  CH_ID = ".$sql->Param('a')." ",array($obj->CH_ID));
			 
			 	echo json_encode($chatboat);
				
			 }else{
				 
				  }
			}