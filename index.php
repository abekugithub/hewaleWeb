<?php 
include "config.php";
include SPATH_LIBRARIES.DS."engine.Class.php";
include SPATH_LIBRARIES.DS."login.Class.php";
include SPATH_LIBRARIES.DS."menufactory.Class.php";
include SPATH_LIBRARIES.DS."doctors.Class.php";
include SPATH_LIBRARIES.DS."price.Class.php";
include SPATH_LIBRARIES.DS."setting.Class.php";
include SPATH_LIBRARIES.DS."codes.Class.php";
include SPATH_LIBRARIES.DS."import.Class.php";
include SPATH_LIBRARIES.DS."smsgateway.class.php";

$engine = new engineClass();
$doctors = new doctorClass();
$clprice = new priceClass();
$coder = new codesClass();
$sett = new settingClass();
$sms = new smsgetway();

$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);

$menus = new MenuClass();
/*
$pmessage = 'Sending message from Hewale';
$patientphoneno = $sms->validateNumber('0503711681','+233');
$sms->sendSms($patientphoneno,$pmessage);
*/ 
if(isset($action) && strtolower($action) == 'login'){
	
// The function below loads the appropriate login page
// if institution is defined

if(isset($inst) && !empty($inst)){
 $instdetails = $engine->getLogingPage($inst);
 $instname = $instdetails->FACI_NAME;
 $instlogo = $instdetails->FACI_LOGO_UNINAME;
 $instalias = $instdetails->FACI_ALIAS;
}
include('public/login/login.php');
	die();
}

$log = new Login();

if(isset($action) && strtolower($action) == 'logout'){
$log->logout();
}


if(isset($doLogin) && $doLogin == 'systemPingPass'){
	
	header('Location: index.php?action=index&pg=dashboard');
	die('Please wait...redirecting page');
	
}

ini_set('display_errors', 1);

$actordetails = $engine->getActorDetails();

$eventcode = '001';
$eventdesc = 'This is a test';

//$engine->setParaEventLog($eventcode, $eventdesc);

//$currentusercode = $actordetails->USR_CODE;
//$currentuserspeciality = $doctors->getDoctorSpeciality($usrcode);
//This code needs to be review later
/* 
if($actordetails->USR_PASSWORD_CHANGE =='1'){
	$pg = md5('Change Password');
	$forcepass =1;
}  */ 
include("public/platform.php");
?>
