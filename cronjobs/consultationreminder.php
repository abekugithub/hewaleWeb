<?php
/*
 * Get all pending consultation and send a reminder to 
 * patients, 30 min before consultation begins
 */
include "../config.php";
include SPATH_LIBRARIES.DS."engine.Class.php";
include SPATH_LIBRARIES.DS."doctors.Class.php";

$engine = new engineClass();
$doctors = new doctorClass();
$sms = new smsgetway();

$currentdate = date('Y-m-d');

$stmt = $sql->Execute($sql->Prepare("SELECT CONS_PATIENTNUM,CONS_PATIENTNAME,PATCON_PHONENUM,PATCON_PLAYERID,CONS_SCHEDULETIME,CONS_VISITCODE,CONS_DOCTORNAME,CONS_DOCTORCODE FROM hms_consultation JOIN hms_patient_connect ON CONS_PATIENTCODE = PATCON_PATIENTCODE WHERE CONS_SCHEDULEDATE = ".$sql->Param('a')." AND TIMEDIFF(CONCAT(CONS_SCHEDULEDATE,' ',CONS_SCHEDULETIME),NOW()) <= '00:30:00' AND CONS_PATIENTREMINDERSTATE = '0' " ),array($currentdate));
print $sql->ErrorMsg();


while($obj = $stmt->FetchNextObject()){
//echo $obj->MYTIME.' '.$obj->CURTIME;
//echo $obj->CONS_PATIENTNUM.' @@@@@ '.$obj->PATCON_PHONENUM.' @@@@@@ '.$obj->CONS_PATIENTNAME ;

//Get Doctor details
$stmtdoc = $sql->Execute($sql->Prepare("SELECT MP_SURNAME,MP_PHONENO FROM hmsb_med_prac WHERE MP_USRCODE = ".$sql->Param('a')." "),array($obj->CONS_DOCTORCODE));
$objdoc = $stmtdoc->FetchNextObject();

//Push notification
$code = '043';
$playerid = $obj->PATCON_PLAYERID;
$ptitle = 'HEWALE - REMINDER';
$pmessage = 'Dear '.$obj->CONS_PATIENTNAME.' ,this is to remind you that your consultation with Doctor '.$obj->CONS_DOCTORNAME.' will start at '.$obj->CONS_SCHEDULETIME;
$engine->broadcastIndividualMessage($ptitle,$pmessage,$playerid,$code,'',$largimg='',$bigimg='');
//sms to patient
$patientphoneno = $sms->validateNumber($obj->PATCON_PHONENUM,'+233');
$sms->sendSms($patientphoneno,$pmessage);
//End push notification

//Send message to doctor
$dmessage = 'Dear Dr. '.$objdoc->MP_SURNAME.' , this is a consultation reminder with '.$obj->CONS_PATIENTNAME.' at '.$obj->CONS_SCHEDULETIME;
$doctorphoneno = $sms->validateNumber($objdoc->MP_PHONENO,'+233');
$sms->sendSms($doctorphoneno,$dmessage);

//Update reminder status
$sql->Execute("UPDATE hms_consultation SET  CONS_PATIENTREMINDERSTATE = '1' WHERE CONS_VISITCODE = ".$sql->Param('a')." ",array($obj->CONS_VISITCODE));
}
?>