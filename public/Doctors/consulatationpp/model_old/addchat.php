<?php
ob_start();
include('../../../../config.php');
include SPATH_LIBRARIES.DS.'engine.Class.php';
$engine = new engineClass();
$patientCls = new patientClass();
$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);

$chatdate = date('Y-m-d H:i:s');

	if(!empty($chatmsg)){
                //Update unread message
                $sql->Execute("UPDATE hms_chat SET CHT_VIEW_STATUS = '1' WHERE  CHT_VIEW_STATUS = '0' AND CHT_RECEIVER_CODE = ".$sql->Param('a')." AND CHT_SENDER_CODE = ".$sql->Param('a')." ",array($sendercode,$patientcode));
		

		$chatmsg = $encaes->encrypt($chatmsg);
		$stmt = $sql->Execute("INSERT INTO hms_chat (CH_SENDER_CODE,CH_RECEIVER_CODE,CH_MSG,CH_SEND_STATUS,CH_VIEW_STATUS,CH_DATE,CH_STATUS,CH_ENCRYPTKEY) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').")",array($sendercode,$patientcode,$chatmsg,'1','0',$chatdate,'1',$activekey));
		
		//Send push notification
		$stmtp = $sql->Execute($sql->Prepare("SELECT PATCON_PLAYERID FROM hms_patient_connect WHERE PATCON_PATIENTCODE = ".$sql->Param('a')." "),array($patientcode));
		$objp = $stmtp->FetchNextObject();
		$playerid = $objp->PATCON_PLAYERID;

                
		$ptitle = push_notif_title; 
		$code = '048';
		$pmessage = $engine->getPushMessage($code);
		$engine->broadcastIndividualMessage($ptitle,$pmessage,$playerid,$code,'',$largimg='',$bigimg='');
                

		if($stmt){
			 $chatboat[] = array("chatmsg"=>$chatmsg);
			
			}
	}
	echo json_encode($chatboat);