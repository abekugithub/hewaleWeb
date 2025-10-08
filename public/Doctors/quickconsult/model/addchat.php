<?php
ob_start();
include('../../../../config.php');
include SPATH_LIBRARIES.DS.'engine.Class.php';
$engine = new engineClass();
$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);

$chatdate = date('Y-m-d H:m:s');

	if(!empty($chatmsg)){
		$chatmsg = $encaes->encrypt($chatmsg);

                //Update unread message
                $sql->Execute("UPDATE hms_chatmarket SET CHT_VIEW_STATUS = '1' WHERE  CHT_VIEW_STATUS = '0' AND CHT_RECEIVER_CODE = ".$sql->Param('a')." AND CHT_SENDER_CODE = ".$sql->Param('a')." ",array($sendercode,$patientcode));
			 
		$stmt = $sql->Execute("INSERT INTO hms_chatmarket (CHT_SENDER_CODE,CHT_RECEIVER_CODE,CHT_MSG,CHT_SEND_STATUS,CHT_VIEW_STATUS,CHT_DATE,CHT_STATUS,CHT_ENCRYPTKEY) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').")",array($sendercode,$patientcode,$chatmsg,'1','0',$chatdate,'1',$activekey));
		
		//Send push notification
		$stmtp = $sql->Execute($sql->Prepare("SELECT PATCON_PLAYERID FROM hms_patient_connect WHERE PATCON_PATIENTCODE = ".$sql->Param('a')." "),array($patientcode));
		$objp = $stmtp->FetchNextObject();
		$playerid = $objp->PATCON_PLAYERID;

		$ptitle = push_notif_title; 
		$code = '049';
		$pmessage = $engine->getPushMessage($code);
		$engine->broadcastIndividualMessage($ptitle,$pmessage,$playerid,$code,'',$largimg='',$bigimg='');

		if($stmt){
			 $chatboat[] = array("chatmsg"=>$chatmsg);
			
			}
	}
	echo json_encode($chatboat);