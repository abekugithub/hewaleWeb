<?php
include('../../../config.php');
include SPATH_LIBRARIES.DS.'engine.Class.php';
$engine = new engineClass();
$usrcode = $engine->getActorCode();
$sql->Execute("UPDATE hms_users SET USR_PLAYERID = ".$sql->Param('a')." WHERE USR_CODE = ".$sql->Param('b')." ",array($userId,$usrcode));
print $sql->ErrorMsg();		
?>