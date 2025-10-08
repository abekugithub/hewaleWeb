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


//echo $keys;
switch ($viewpage){

	case 'add':
	
	if(empty($keys)){
	
	$msg = 'Required Field cannot be empty ';
	$status = 'error';
	$view = 'add';
	}else{
	
	$stmt = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_CODE = ".$sql->Param('1').""),array($keys));
	print $sql->ErrorMsg();
	if($stmt->Recordcount() > 0){
	
	$obj = $stmt->FetchNextObject();
	
	$ddt = $obj->LT_DATE;
	$indexnum = $obj->LT_PATIENTNUM;
	$names = $obj->LT_PATIENTNAME;
	$test = $obj->LT_TESTNAME;
	$displine = $obj->LT_DISCPLINENAME;
	$rmk = $obj->LT_RMK;
	
	}
	
	}
	
	
	break;

	case 'savespecimen':
	
	if(empty($keys) ||  empty($startdate) || empty($specimen) || empty($label) || empty($vol)  ){

		$msg = "Failed. Required field(s) can't be empty!.";
		$status = "error";
		$view ='add';
		
	}else {
	
	$sp = explode('@@@' , $specimen);
	$scode = $sp['0'];
	$sname = $sp['1'];
	$dt = Date("Y-m-d", strtotime(str_replace('/','-', $startdate)));
	$stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_labtest SET LT_SPECIMEN =".$sql->Param('1').", LT_SPECIMENCODE =".$sql->Param('2')." ,LT_SPECIMENLABEL  =".$sql->Param('3')." ,LT_SPECIMENVOLUME =".$sql->Param('4')." ,LT_SPECIMENDATE =".$sql->Param('5')." ,LT_STATUS =".$sql->Param('6')." WHERE LT_CODE=".$sql->Param('5')." "),array($sname,$scode,$label,$vol,$dt,'3',$keys));
    print $sql->ErrorMsg();
	
	$msg = 'Specimen Saved';
    $status = 'success';
	$view = '';

	}
	
	break;
	
	
    case 'reject#':
        if (!empty($keys)){
            $stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_labtest SET LT_STATUS='2' WHERE LT_CODE=".$sql->Param('a').""),array($keys));
            print $sql->ErrorMsg();

            if ($stmt){
                $msg = 'You have successfully rejected a lab. request for patient';
                $status = 'success';
            }
        }else{
            $msg = 'There is no such lab request in the system';
            $status = 'error';
        }
    break;

    case 'reset':
        $fdsearch = '';
        $view = '';
    break;
}
include 'model/js.php';

		$stmtspecimenlov = $sql->Execute($sql->prepare("SELECT * from hms_lab_specimen where SP_STATUS = ".$sql->Param('a').""),array('1'));
		$spec=array();
		while($obj=$stmtspecimenlov->FetchNextObject()){
		$spec[] = $obj;
		}
		
		$sl = array();
		$sl[] = $slabel_.''.$i;
	//	var_dump($spec);
		$stmtspecimen = $sql->Execute($sql->prepare("SELECT * from hms_lab_specimen where SP_STATUS = ".$sql->Param('a').""),array('1'));
		
if(isset($action_search) && $action_search == "search"){
    if(!empty($fdsearch)){
	
    $query = "SELECT * FROM hms_patient_labtest WHERE LT_STATUS = '2' AND (LT_PATIENTNUM = ".$sql->Param('a')." OR ( LT_TESTNAME LIKE ".$sql->Param('b')." OR LT_PATIENTNAME LIKE ".$sql->Param('c')." OR LT_TEST LIKE ".$sql->Param('d')." OR LT_ACTORNAME = ".$sql->Param('e')." OR LT_DISCPLINENAME LIKE ".$sql->Param('e').")) ORDER BY LT_INPUTEDDATE DESC";
    $input = array($fdsearch,$fdsearch.'%',$fdsearch.'%',$fdsearch.'%',$fdsearch,$fdsearch.'%');
		
    }
}else{

    $query = "SELECT * FROM hms_patient_labtest WHERE LT_LABCODE = ".$sql->Param('2')." and LT_STATUS = ".$sql->Param('1')." or LT_STATUS = ".$sql->Param('1')." ORDER BY LT_INPUTEDDATE DESC";
    $input = array($faccode,'2','3');
	
//	$stmtspecimenlov = $sql->Execute($sql->prepare("SELECT * from hms_lab_specimen where SP_STATUS = ".$sql->Param('a').""),array('1'));
	
}

	//Fetch services 
   if ($viewpage == 'fdsearch'){
	$stmtlist = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_labtest where LT_STATUS = ".$sql->Param('1')." AND LT_LABCODE = ".$sql->Param('2')." OR( LT_PATIENTNUM = ".$sql->Param('a').")  "),array('2',$faccode,'%'.$fdsearch.'%'));
    print $sql->ErrorMsg();
	
   }else{

   $stmtlist = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_labtest where LT_LABCODE = ".$sql->Param('1')." AND LT_STATUS = ".$sql->Param('2')."  "),array($faccode,'2'));	
   print $sql->ErrorMsg();
	
	}
		 



if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=ad2376beebecdcf7846ba973fa1a005b&option=6831b98f85019ddb98bd98d44bdbac40#',$input);

//Get all positions
$stmtpos2 = $engine->getUserPosition();

