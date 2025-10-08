<?php
ob_start();
include('../../../../config.php');
include SPATH_LIBRARIES.DS.'engine.Class.php';
$engine = new engineClass();
$actordetails = $engine->getActorDetails();
$activecc = $actordetails->USR_ACTIVECC ;
$countrycode = $actordetails->USR_COUNTRYCODE;
$usrcode = $engine->getActorCode();
$day = Date("Y-m-d");

if($actordetails->USR_TYPE == '2'){

//get pending appointment in queue
$swingtime = date('Y-m-d H:m:s');
$stmtappt = $sql->Execute($sql->Prepare("SELECT COUNT(*) AS TOTALPATIENT FROM hms_service_request WHERE REQU_DOCTORCODE = ".$sql->Param('a')." AND REQU_STATUS = '1' AND (REQU_APPOINTDATE = ".$sql->Param('b')." OR (abs(TIMESTAMPDIFF(minute, REQU_STARTDATETIME, ".$sql->Param('c').")) <= 30  OR REQU_STARTDATETIME <= ".$sql->Param('d')." )) AND REQU_PAYMENTSTATUS = ".$sql->Param('c')." "),array($usrcode,$day,$swingtime,$swingtime,'2'));  
//$stmtappt = $sql->Execute($sql->Prepare("SELECT COUNT(*) AS TOTALPATIENT FROM hms_service_request WHERE REQU_DOCTORCODE = ".$sql->Param('a')." AND REQU_STATUS = '1' AND REQU_APPOINTDATE <= ".$sql->Param('b')."  AND REQU_PAYMENTSTATUS = ".$sql->Param('c').""),array($usrcode,$swingtime,'2')); 
print $sql->ErrorMsg();
if($stmtappt->RecordCount() > 0){
$objappt = $stmtappt->FetchNextObject();
$totalappointmt = $objappt->TOTALPATIENT;
}else{
    $totalappointmt = '0';
}

//$consult = array();

$result = '
<button type="button" title="Attend to next patient in appointment" id="" onclick="document.getElementById(\'viewpage\').value=\'loadqueuedpatientappt\';document.getElementById(\'view\').value=\'consulting\';document.myform.submit();" class="btn btn-danger"><i class="fa fa-medkit"></i> Next Appointment  <span><font color="#fff" size="-10">'.(($totalappointmt > 0)?'<span class="badgepa">'.$totalappointmt.'</span>':'<span class="badgepa">0</span>').'</font></span> </button>
';
}

echo json_encode($result); 
