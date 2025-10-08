<?php
//include SPATH_PLUGINS.DS."XMPPHP/BOSH.php";
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();
$prescountry = $engine->getActorDetails()->MP_DRUGCOUNTRYREGISTER;
$directoratecode = $engine->getActorDetails()->USR_VHGP_CODE ;
$usrtype = $actordetails->USR_TYPE;
$patientCls = new patientClass();

$day = Date("Y-m-d");
switch($viewpage){
	

    case 'calling':
	if(isset($keys) && !empty($keys)){ 

		$docdetails = $engine->geAllUsersDetails($keys);
        $receivername = $docdetails->USR_OTHERNAME.' '.$docdetails->USR_SURNAME;
        $receivercode = $docdetails->USR_CODE;
        $receivereasyrtcid = $docdetails->USR_EASYRTCCODE;
		//Fetch Chat
		$msgdetails = $doctors->getChatPerDoctor($usrcode,$receivercode);
	
	}
	
    break;
	
    case "reset":
	$fdsearch = "";
	break;
}

$stmtroute = $sql->Execute($sql->Prepare("SELECT RT_CODE,RT_NAME FROM hmsb_st_route"));
print $sql->ErrorMsg();

//echo $usrcode;
if(!empty($fdsearch)){
 $query = "SELECT * FROM hms_consultation_rooms WHERE CONSROOM_FACICODE = ".$sql->Param('a')." AND CONSROOM_STATUS = '1' AND (CONSROOM_NAME = ".$sql->Param('b')." OR CONSROOM_DOCTORNAME LIKE ".$sql->Param('d').") ";
    $input = array($activeinstitution,$fdsearch,'%'.$fdsearch.'%');
}else {
    $query = "SELECT * FROM hms_users WHERE USR_VHGP_CODE = ".$sql->Param('a')."  AND USR_STATUS = '1' AND USR_CODE != ".$sql->Param('a')." ";
    $input = array($directoratecode,$usrcode);
   
	
}
if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'pg=f77ccbdb203c19d3d52b12a85f33faf5&option=03a3fe07ff40b4d22d3f444ee4434cfd&uiid=c7e0e599d2520ee7fda7a45375e0e1b5#',$input);

$usp = $doctors->getuserSpeciality($usrcode);
$stmttestlov = $sql->Execute($sql->Prepare("SELECT * from hmsb_st_labtest order by LTT_NAME ")) ;
$stmtdiagnosislov = $sql->Execute($sql->Prepare("SELECT * from hmsb_st_disease order by DIS_NAME ")) ;
$stmtxray = $sql->Execute($sql->Prepare("SELECT * from hmsb_st_xray order by X_ID DESC ")) ;
$ex_country = explode(',',$prescountry);
$stmtdrugslov = $sql->Execute($sql->Prepare("SELECT * from hmsb_st_phdrugs order by DR_NAME ")) ;
$stmtphysicalexams = $sql->Execute($sql->Prepare("SELECT * FROM hmsb_st_physicalexamination order by PHYEX_ID ASC ")) ;

$specialistdetail = $sql->Execute($sql->Prepare("SELECT * FROM hmsb_med_prac JOIN hms_users ON USR_CODE = MP_USRCODE WHERE USR_TYPE = '2' AND USR_STATUS = '1' AND MP_STATUS = '1' ")) ;


include("model/js.php");
?>