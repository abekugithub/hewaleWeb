<?php
include('../../../../config.php');
include SPATH_LIBRARIES.DS.'engine.Class.php';
$engine = new engineClass();
$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);

$chatdate = date('Y-m-d H:m:s');

	if(!empty($chatmsg)){
		$chatmsg = $encaes->encrypt($chatmsg);
		$stmt = $sql->Execute("INSERT INTO hms_chat (CH_SENDER_CODE,CH_RECEIVER_CODE,CH_MSG,CH_SEND_STATUS,CH_VIEW_STATUS,CH_DATE,CH_STATUS) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').")",array($sendercode,$patientcode,$chatmsg,'1','0',$chatdate,'1'));
		
		if($stmt){
			 $chatboat[] = array("chatmsg"=>$chatmsg);
			
			}
	}
	echo json_encode($chatboat);