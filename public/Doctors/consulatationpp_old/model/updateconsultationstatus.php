<?php
include('../../../../config.php');
include SPATH_LIBRARIES.DS.'engine.Class.php';
$engine = new engineClass();
$actordetails = $engine->getActorDetails();
$usrcode = $actordetails->USR_CODE;

		
   $stmt = $sql->Execute("UPDATE hms_users SET USR_CONSULTING_STATUS = '0' WHERE USR_CODE = ".$sql->Param('a')." ",array($usrcode));

   $sql->Execute($sql->Prepare("UPDATE hms_consultation SET CONS_INCONSULTATION = '0' WHERE CONS_DOCTORCODE = ".$sql->Param('a')." "),array($usrcode));

?>