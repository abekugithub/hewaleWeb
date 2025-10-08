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
		$stmt = $sql->Execute("INSERT INTO hms_chat (CH_CODE,CH_SENDER_CODE,CH_RECEIVER_CODE,CH_MSG,CH_SEND_STATUS,CH_VIEW_STATUS,CH_DATE,CH_STATUS,CH_ENCRYPTKEY) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').")",array($visitcode,$sendercode,$patientcode,$chatmsg,'1','0',$chatdate,'1',$activekey));

		$sql->Execute("UPDATE hms_consultation SET CONS_LASTMODIFIED = ".$sql->Param('a')." WHERE CONS_PATIENTCODE = ".$sql->Param('b')." AND   CONS_VISITCODE = ".$sql->Param('c')." ",array($chatdate,$patientcode,$visitcode));
		
		//Send push notification
		$stmtp = $sql->Execute($sql->Prepare("SELECT PATCON_PLAYERID FROM hms_patient_connect WHERE PATCON_PATIENTCODE = ".$sql->Param('a')." "),array($patientcode));
		$objp = $stmtp->FetchNextObject();
		$playerid = $objp->PATCON_PLAYERID;

		//Check if user in chat room with the doctor
		$stmtrqt = $sql->Execute($sql->Prepare("SELECT USR_CHATSTATE FROM hms_users WHERE USR_CODE = ".$sql->Param('a')." AND  USR_CHATSTATE = ".$sql->Param('b')." "),array($sendercode,$patientcode));
		
		if($stmtrqt->RecordCount() > 0){}else{
	   $sql->Execute("UPDATE hms_users SET USR_CHATSTATE = ".$sql->Param('a')." WHERE USR_CODE = ".$sql->Param('b')." ",array($patientcode,$sendercode));
        //Get consultation details
		
        $stmtcslt = $sql->Execute($sql->Prepare("SELECT CONS_DOCTORNAME FROM hms_consultation WHERE CONS_VISITCODE = ".$sql->Param('a')." "),array($visitcode));
		print $sql->ErrorMsg();
		$objcslt = $stmtcslt->FetchNextObject();

		$ptitle = push_notif_title; 
		$code = '048';
		$pmessage = $engine->getPushMessage($code);
		$data = array('visitcode'=>$visitcode,'doctorcode'=>$sendercode,'doctorname'=>$objcslt->CONS_DOCTORNAME);
		
		$engine->broadcastIndividualMessage($ptitle,$pmessage,$playerid,$code,$data,$largimg='',$bigimg='');

	

		}
		
		if($stmt){
			 $chatboat[] = array("chatmsg"=>$chatmsg);
			
			}
	}
	echo json_encode($chatboat);