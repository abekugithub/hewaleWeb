<?php
include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
include SPATH_LIBRARIES.DS."doctors.Class.php";

$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
$engine = new engineClass();
$doc = new doctorClass();
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();
$actor = $engine->getActorDetails();
$activeinstitution = $actor->USR_FACICODE;
$usertype=$actor->USR_TYPE;
 $fddate = $engine->getDate_Format($fddate);

if (!empty($fplan)&&!empty($fddate)&&!empty($fdtime)){
$plan=explode('@@@',$fplan);
$stmtdata = $sql->Execute($sql->Prepare("Update hmis_daily_fluid set DF_TIMEINTAKE=".$sql->Param('b').",DT_DTINTAKE=".$sql->Param('c')." WHERE DF_ID=".$sql->Param('d').""),array($fdtime,$fddate,$plan[2]));
        print $sql->ErrorMsg();
		     
   $msg = 'Daily fluid intake has been captured Successfully.';
    		$status = "success";
		
        $activity = "Daily fluid intake captured Successfully.";
	 $engine->setEventLog("082",$activity);
    }else{
    $msg = "All fields required";
    $status = "error";
		}

echo json_encode ($msg);
