<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 8/8/2017
 * Time: 5:14 PM
 */
 
// var_dump($_POST);
$crypt = new cryptCls();
$actorid = $session->get("userid");
$actorname = $engine->getActorName();
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$objdtls = $engine->getFacilityDetails();
$facilityalias = $objdtls->FACI_ALIAS ;
$faccode = $objdtls->FACI_CODE ;
$memberdetails=new patientClass();

//echo $keys;
switch ($viewpage){
	case 'signoff':
	if(!empty($keys)){
$stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_labtest SET LT_STATUS='7' WHERE LT_CODE=".$sql->Param('5')." "),array($keys));
    print $sql->ErrorMsg();
	
	$stmtlist = $sql->Execute($sql->Prepare("SELECT LT_ID,LT_PATIENTNUM,LT_PATIENTCODE FROM hms_patient_labtest WHERE LT_CODE = ".$sql->Param('2')." "),array($keys));
	 print $sql->ErrorMsg();
$obj1=$stmtlist->FetchNextObject();
$getinserted=$obj1->LT_ID;
$patientno=$obj1->LT_PATIENTNUM;
$getcode=$obj1->LT_PATIENTCODE;
   
	
	    $msg = "Success! Lab Result has been successfully signed off";
		$status = "success";
		$viewpage ='';	
		$activity = "Lab result signed off by ".$actorname ;
		$engine->setEventLog("063",$activity);
       
		$description='Lab Result is ready for patient with No.' .$patientno;
		$notification=$engine->setNotification("010",$description,"0010",$getinserted,$getcode,$faccode);
	}
	
	break;

    case 'reset':
        $fdsearch = '';
        $view = '';
    break;
}
		
if(isset($action_search) && $action_search == "search"){
    if(!empty($fdsearch)){
	
    $query = "SELECT * FROM hms_patient_labtest WHERE LT_STATUS = '3' AND (LT_PATIENTNUM = ".$sql->Param('a')." OR ( LT_TESTNAME LIKE ".$sql->Param('b')." OR LT_PATIENTNAME LIKE ".$sql->Param('c')." OR LT_TEST LIKE ".$sql->Param('d')." OR LT_ACTORNAME = ".$sql->Param('e')." OR LT_DISCPLINENAME LIKE ".$sql->Param('e').")) ORDER BY LT_INPUTEDDATE DESC";
    $input = array($fdsearch,$fdsearch.'%',$fdsearch.'%',$fdsearch.'%',$fdsearch,$fdsearch.'%');
		
    }
}else{

    $query = "SELECT * FROM hms_patient_labtest WHERE LT_STATUS = ".$sql->Param('1')." AND LT_LABCODE = ".$sql->Param('2')." ORDER BY LT_INPUTEDDATE DESC";
    $input = array('4',$faccode);
	//echo $faccode;
	
//	$stmtspecimenlov = $sql->Execute($sql->prepare("SELECT * from hms_lab_specimen where SP_STATUS = ".$sql->Param('a').""),array('1'));
	
}

	//Fetch services 
   if ($viewpage == 'fdsearch'){
	$stmtlist = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_labtest where LT_STATUS = ".$sql->Param('1')." AND LT_LABCODE = ".$sql->Param('2')." "),array('4',$faccode));
    print $sql->ErrorMsg();
	
   }else{
	   
   $stmtlist = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_labtest where LT_STATUS = '4' AND LT_LABCODE = ".$sql->Param('a')."  "),array($faccode));	
 print $sql->ErrorMsg();
	}

if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=e684d8eeee72ed2583865b78e8d3f57a&option=29b2eb4e9498262f90a3afafc3955b54#',$input);
include("model/js.php");

