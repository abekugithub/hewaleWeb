<?php
ob_start();
include('../../../config.php');
include SPATH_LIBRARIES.DS.'engine.Class.php';
include SPATH_LIBRARIES.DS."doctors.Class.php";
$engine = new engineClass();
$doctors = new doctorClass();

$usrcode = $engine->getActorCode();
$usrdetails = $engine->getActorDetails();
$docname = $usrdetails->USR_OTHERNAME.' '.$usrdetails->USR_SURNAME;
$currentdate = date('Y-m-d ');
$currenttime = date('Y-m-d H:i:s');

//$sessiononlinestate = $session->get('sessiononlinestate');

if(!empty($roomid)){
		$stmt = $sql->Execute($sql->Prepare("SELECT USR_ROOM_STATUS FROM hms_users WHERE USR_CODE = ".$sql->Param('a')." "),array($usrcode));
		
		if($stmt){
			if($stmt->RecordCount() > 0){
			 $obj = $stmt->FetchNextObject();
	
			 $sql->Execute("UPDATE hms_users SET USR_ROOM_STATUS = '1' WHERE USR_CODE = ".$sql->Param('a')." ",array($usrcode));
            
             //Set previous entry into room table as empty
             $sql->Execute("UPDATE hms_consultation_rooms SET CONSROOM_DOCTORCODE = '',CONSROOM_DOCTORNAME = '' WHERE CONSROOM_DOCTORCODE = ".$sql->Param('a')." ",array($usrcode));

             //Update room table
             $sql->Execute("UPDATE hms_consultation_rooms SET CONSROOM_DOCTORCODE = ".$sql->Param('a').",CONSROOM_DOCTORNAME = ".$sql->Param('b')." WHERE CONSROOM_ID = ".$sql->Param('a')." ",array($usrcode,$docname,$roomid));
				
			 }else{
				 
				  }
            }

            echo json_encode(1);
        }else{
            echo json_encode(0);
        }
?>