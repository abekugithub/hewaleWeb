<?php
ob_start();
include('../../../../config.php');
include SPATH_LIBRARIES.DS.'engine.Class.php';
$engine = new engineClass();
$actordetails = $engine->getActorDetails();
$usrcode = $actordetails->USR_CODE;
$docname = $actordetails->USR_SURNAME;

		$stmt = $sql->Execute($sql->Prepare("SELECT PATCON_PLAYERID FROM hms_patient_connect WHERE PATCON_PATIENTCODE = ".$sql->Param('a')." "),array($patientcode));
        print $sql->ErrorMsg();
        $obj = $stmt->FetchNextObject() ;
        $playerid = $obj->PATCON_PLAYERID;
		$pmessage = 'You received a message from Dr. '.$docname;  
		if(!empty($playerid)){

            $code = '055';
            $ptitle = push_notif_title;
           
            $data = array('requestCode'=>$visitcode, 'doctorCode'=>$usrcode, 'doctorName'=>$docname) ;
            
            $engine->broadcastIndividualMessage($ptitle,$pmessage,$playerid,$code,$data,$largimg='',$bigimg=''); 

		}
		