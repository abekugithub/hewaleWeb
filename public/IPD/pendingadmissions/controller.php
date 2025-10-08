<?php
$patientCls = new patientClass();
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();

$objdtls = $engine->getFacilityDetails();
$facilityalias = $objdtls->FACI_ALIAS ;
$faccode = $objdtls->FACI_CODE ;


$day = Date("Y-m-d");
switch($viewpage){

case "cancelrequest":
	$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_service_request WHERE REQU_CODE = ".$sql->Param('a')." "),array($keys));
            $client = $stmt->FetchNextObject();
			$patientcode= $client->REQU_PATIENTNUM;
			$session->set('tablerowid',$client->REQU_ID);
	$stmt = $sql->Execute($sql->Prepare("UPDATE hms_service_request SET REQU_STATUS ='13', REQU_CANCEL_REASON=".$sql->Param('a')." WHERE REQU_CODE=".$sql->Param('d').""),array($canceldata,$keys));
	print $sql->ErrorMsg();
	
	
	$msg = "Patient Admission request has been cancelled Successfully.";
	    $status = "success";
		$engine->ClearNotification('0055',$client->REQU_ID);
        $activity = "Patient Admission request cancelled.";
		$engine->setEventLog("102",$activity);
	break;

case 'saveassignbed':

if(empty($startdate) || empty($bed)  || empty($patientnum) || empty($patient) || empty($faccode)  || empty($visitcode)  || empty($keycode) ){

$msg = "Failed. Required field(s) can't be empty!.";
$status = "error";
$view ='admdetails';

}else{


$wardbed = explode('@@@', $bed);
$bedcode = $wardbed[0];
$bedname = $wardbed[1];
$wardcode = $wardbed[2];
$wardname = $wardbed[3];


$sql->Execute($sql->Prepare("UPDATE hms_service_request SET REQU_STATUS  = ".$sql->Param('a')." WHERE REQU_CODE = ".$sql->Param('b').""),array('14',$keycode));
print $sql->ErrorMsg();


$adcode = $engine->getadmissionCode();
$dt = date("Y-m-d", strtotime(str_replace('/','-', $startdate))); 
$sql->Execute($sql->Prepare("INSERT INTO hms_patient_admissions (ADMIN_CODE,ADMIN_SERVCODE,ADMIN_PATIENTNO,ADMIN_PATIENT,ADMIN_DATE,ADMIN_VISITCODE,ADMIN_WARDID,ADMIN_WARD,ADMIN_BEDID,ADMIN_BED,ADMIN_FACICODE,ADMIN_PRESCRIBERCODE,ADMIN_PRESCRIBER,ADMIN_USERCODE,ADMIN_USERFULLNAME,ADMIN_STATUS) VALUES(".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').")"),
array($adcode,$session->get('servicecode'),$patientnum,$patient,$dt,$visitcode,$wardcode,$wardname,$bedcode,$bedname,$faccode,$prescribercode,$prescriber,$usrcode,$usrname,'1'));
print $sql->ErrorMsg();
$tablerowid=$sql->Insert_ID();
$sql->Execute($sql->Prepare("UPDATE hms_st_wardbed SET BED_STATUS  = ".$sql->Param('a')." WHERE BED_CODE = ".$sql->Param('b').""),array('1',$bedcode));
print $sql->ErrorMsg();
$sentto=$usrcode;
$engine->setNotification('003',"Patient has been assigned a bed",'0054',$tablerowid,$sentto,$faccode);
$engine->ClearNotification('0055',$session->get('tablerowid'));
$msg = "Saved successfully.";
$status = "success";
$view ='';

}

break;

  case 'admdetails':
	
	if(empty($keys)){
	
	$msg = "Failed. Required field(s) can't be empty!.";
	$status = "error";
	$view ='';
	
	}else{
	
	$stmt = $sql->execute($sql->Prepare("SELECT * FROM hms_service_request WHERE REQU_CODE = ".$sql->Param('1')." and REQU_STATUS = ".$sql->Param('2')." and REQU_FACI_CODE = ".$sql->Param('a')."  "),array($keys,'4',$faccode));
	print $sql->Errormsg();
	
	if($stmt->Recordcount() > 0 ){
	
	$obj = $stmt->FetchNextObject();
	
	$patient = $obj->REQU_PATIENT_FULLNAME;
	$patientnum= $obj->REQU_PATIENTNUM;
	$visitcode= $obj->REQU_VISITCODE;
	$faccode = $obj->REQU_FACI_CODE;
	$keycode = $obj->REQU_CODE;
	$prescriber = $obj->REQU_DOCTORNAME;
	$prescribercode = $obj->REQU_DOCTORCODE;
	$servicecode=$obj->REQU_SERVICECODE;
	$tablerowid=$obj->REQU_ID;
	$session->set('servicecode',$servicecode);
	$session->set('tablerowid',$tablerowid);
	
	
	}
	
	$stmtlist = $sql->execute($sql->Prepare("SELECT * FROM hms_service_request  WHERE REQU_CODE = ".$sql->Param('1')." and REQU_STATUS = ".$sql->Param('2')."  "),array($keys, '1'));
	print $sql->Errormsg();
	
	}
	
	
	break;
	
	
    
    
	case "reset":
	$fdsearch = "";
	break;
    
}


if(!empty($fdsearch)){
//	$query = "SELECT * FROM hms_patient_prescription WHERE PRESC_FACICODE = ".$sql->Param('a')."  AND AND PRESC_STATUS = ".$sql->Param('a').") And (PRESC_PATIENT LIKE ".$sql->Param('1')." or PRESC_PATIENTNUM LIKE ".$sql->Param('2')." OR PRESC_DRUG LIKE ".$sql->Param('3').") ";
	$query = "SELECT * FROM hms_service_request WHERE  REQU_PATIENT_FULLNAME LIKE ".$sql->Param('1')." or REQU_PATIENTNUM LIKE ".$sql->Param('2')."  AND REQU_FACI_CODE = ".$sql->Param('a')." ";
	
	print $sql->ErrorMsg();
    $input = array('%'.$fdsearch.'%','%'.$fdsearch.'%',$faccode);
//	$input = array($faccode,'1','%'.$fdsearch.'%','%'.$fdsearch.'%','%'.$fdsearch.'%');
}else {

    $query = "SELECT * FROM hms_service_request WHERE REQU_FACI_CODE = ".$sql->Param('1')."  AND REQU_STATUS =  ".$sql->Param('2')." AND REQU_SERVICECODE =  ".$sql->Param('3')." or REQU_SERVICECODE =  ".$sql->Param('4')."   ";
    $input = array($faccode,'4','SER0005','SER0006');
}

$stmtward   = $sql->Execute($sql->Prepare("SELECT * FROM hms_st_ward where  WARD_STATUS = '1' AND WARD_EMPTY!='0' ORDER BY WARD_NAME  "));
$stmtbedlov   = $sql->Execute($sql->Prepare("SELECT * FROM hms_st_wardbed where  BED_STATUS = '0' ORDER BY BED_NAME "));

if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=f77ccbdb203c19d3d52b12a85f33faf5&option=6bf17fe4762ece7a82410014d090d322&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);

include("model/js.php");

?>