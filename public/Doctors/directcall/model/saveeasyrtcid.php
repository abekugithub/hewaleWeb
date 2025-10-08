<?php
include('../../../../config.php');
include SPATH_LIBRARIES.DS.'engine.Class.php';
$engine = new engineClass();

	if(!empty($selfEasyrtcid) && !empty($sendercode)){
		
   $stmt = $sql->Execute("UPDATE hms_users SET USR_EASYRTCCODE = ".$sql->Param('a')." WHERE USR_CODE = ".$sql->Param('b')." ",array($selfEasyrtcid,$sendercode));
	}
	echo json_encode(1);