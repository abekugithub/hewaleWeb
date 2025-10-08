<?php
$actor = $engine->getActorDetails();
$usrcode = $engine->getActorCode();
$activeinstitution = $actor->USR_FACICODE;
//print_r ($_POST);
//echo $activeinstitution;


switch($viewpage){
	
	case "report":
	if (!empty($datefrom)&&!empty($dateto)){
		$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hmsb_allfacilities WHERE FACI_CODE =".$sql->Param('a').""),array($activeinstitution));
		$obj = $stmt->FetchNextObject(); 
		$report_comp_logo = "media/img/".$obj->FACI_LOGO_UNINAME;
    	$report_comp_name = $obj->FACI_NAME;
    	$report_title = "Delivery Report";
    	$report_comp_location = $obj->FACI_LOCATION;
    	$report_phone_number = $obj->FACI_PHONENUM;
    	//$report_content = '';
		include("model/js.php");
	}else{
		$view ="";
	}
	break;
	default:
$stmtcheck=$sql->Execute($sql->Prepare("SELECT COU_ID from hms_courieragents WHERE COU_CODE=".$sql->Param('a')." AND COU_INSTCODE=".$sql->Param('b').""),array($usrcode,$activeinstitution));
		if ($stmtcheck->RecordCount()>0){
			$courieragent='Yes';
		}else{
			$courieragent='No';
		}
		$agent_list = $sql->Execute($sql->Prepare(" SELECT COU_CODE,CONCAT(COU_FNAME,' ',COU_SURNAME) COU_NAME FROM hms_courieragents WHERE COU_STATUS ='1' AND COU_INSTCODE=".$sql->Param('a')." "),array($activeinstitution));
	break;
	
}


?>