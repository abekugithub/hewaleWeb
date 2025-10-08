<?php
ob_start();
include '../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";

$engine = new engineClass();
$actor = $engine->getActorDetails();
$activeinstitution = $actor->USR_FACICODE;

if (!empty($latitude) && !empty($longitude)){
	
        $stmt = $sql->Execute("UPDATE hmsb_allfacilities SET FACI_LATITUDE = ".$sql->Param('a')." ,FACI_LONGITUDE = ".$sql->Param('b')." WHERE FACI_CODE = ".$sql->Param('c')." ",array($latitude,$longitude,$activeinstitution));
        print $sql->ErrorMsg();
}
?>