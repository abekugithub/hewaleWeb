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
	
			 $sql->Execute("UPDATE hms_users SET USR_ROOM_STATUS = '0' WHERE USR_CODE = ".$sql->Param('a')." ",array($usrcode));
            
             //Set previous entry into room table as empty
             $sql->Execute("UPDATE hms_consultation_rooms SET CONSROOM_DOCTORCODE = '',CONSROOM_DOCTORNAME = '' WHERE CONSROOM_DOCTORCODE = ".$sql->Param('a')." ",array($usrcode));

            echo json_encode(1);
        
?>