<?php

include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
//include SPATH_LIBRARIES.DS."doctors.Class.php";
//$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);

$engine = new engineClass();
//$doc = new doctorClass();
$date = Date("Y-m-d H:i:s");
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();
$actor = $engine->getActorDetails();
$activeinstitution = $actor->USR_FACICODE;
//$managementcode = '000';

if (!empty($dischargearea)){
    //$managementcode = $doc->getManagementCode();
	//$txtarea = $encaes->encrypt($txtarea);

    
	$stmtd = $sql->Execute($sql->Prepare("INSERT INTO hms_emergency_discharge (DIS_EMERCODE,DIS_VISITCODE,DIS_DETAILS,DIS_PATIENTNUM,DIS_PATIENTCODE,DIS_ACTOR,DIS_ACTORID,DIS_FACICODE,DIS_DATE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').")"),array($emergencycode,$visitcode,$dischargearea,$patientnum,$patientcode,$usrname,$usrcode,$faccode,$date));
    print $sql->ErrorMsg();
    if ($stmtd){
		
		$stmt = $sql->Execute($sql->Prepare("UPDATE hms_emergency SET EMER_STATUS = '4' WHERE EMER_CODE=".$sql->Param('1')),array($emergencycode));
		
		}
}