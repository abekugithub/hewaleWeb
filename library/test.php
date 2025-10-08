<?php
include(SPATH_LIBRARIES."/smsgateway.php");
$sms = new smsgetway();

$pmessage = 'Sending message from Hewale';
$patientphoneno = $sms->validateNumber('0262022933','+233');
$sms->sendSms($patientphoneno,$pmessage);
?>