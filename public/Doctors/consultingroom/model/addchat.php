<?php
ob_start();
include('../../../../config.php');
include SPATH_LIBRARIES.DS.'engine.Class.php';
$engine = new engineClass();
$patientCls = new patientClass();
$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);

$chatdate = date('Y-m-d H:i:s');

	if(!empty($message)){
                //Update unread message
                $sql->Execute("UPDATE hms_chatvh SET CHT_VIEW_STATUS = '1' WHERE  CHT_VIEW_STATUS = '0' AND CHT_RECEIVER_CODE = ".$sql->Param('a')." AND CHT_SENDER_CODE = ".$sql->Param('a')." ",array($doctorcode,$roomid));
		

		$chatmsg = $encaes->encrypt($message);
		$stmt = $sql->Execute("INSERT INTO hms_chatvh (CH_SENDER_CODE,CH_RECEIVER_CODE,CH_MSG,CH_SEND_STATUS,CH_VIEW_STATUS,CH_DATE,CH_STATUS,CH_ENCRYPTKEY) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').")",array($doctorcode,$roomid,$chatmsg,'1','0',$chatdate,'1',$activekey));
		
		if($stmt){
			 $chatboat[] = array("chatmsg"=>$chatmsg);
			
			}
	}
	echo json_encode($chatboat);