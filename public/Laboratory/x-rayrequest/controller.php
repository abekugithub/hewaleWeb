<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 8/8/2017
 * Time: 5:14 PM
 */

$crypt = new cryptCls();
//$encaes = new encAESClass();
$actorid = $session->get("userid");
$actorname = $engine->getActorName();
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$objdtls = $engine->getFacilityDetails();
$facilityalias = $objdtls->FACI_ALIAS ;
$faccode = $objdtls->FACI_CODE ;

//echo $keys;
switch ($viewpage){
	
	case "takespacimen":
	$stmt = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_xraytest WHERE XT_CODE = ".$sql->Param('1')." and XT_STATUS = ".$sql->Param('2')." "),array($vkey,'6'));
	print $sql->Errormsg();
	
	if($stmt->Recordcount() > 0 ){
	
	$obj = $stmt->FetchNextObject();
	
	$patient = $obj->XT_PATIENTNAME;
	$patientnum= $obj->XT_PATIENTNUM;
	$test= $encaes->decrypt($obj->XT_TESTNAME);
	
	
	}
    break;
	case 'testdetails':
        if(empty($keys)){

            $msg = "Failed. Required field(s) can't be empty!.";
            $status = "error";
            $view ='';

        }else{
            $stmt = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_xraytest WHERE XT_VISITCODE = ".$sql->Param('1')." and XT_STATUS IN ('1','6')"),array($keys));
            print $sql->Errormsg();

            if($stmt->Recordcount() > 0 ){
                $obj = $stmt->FetchNextObject();
                $patient = $obj->XT_PATIENTNAME;
                $patientnum= $obj->XT_PATIENTNUM;
                $visitcode= $obj->XT_VISITCODE;
                $test= $obj->XT_TESTNAME;
            }

            $stmtlist = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_xraytest WHERE XT_VISITCODE = ".$sql->Param('1')." and XT_STATUS IN ('1','6')"),array($keys));
            print $sql->Errormsg();

        }
	break;
	
	case "savespecimen":
	if(empty($vkeys) ||  empty($startdate) || empty($specimen) || empty($label) || empty($vol)  ){

		$msg = "Failed. Required field(s) can't be empty!.";
		$status = "error";
		$view ='add';
		
	}else {
	$sp = explode('@@@' , $specimen);
	$scode = $sp['0'];
	$sname = $sp['1'];
	$scodes = $encaes->encrypt($scode);
	$snames = $encaes->encrypt($sname);
	$dt = Date("Y-m-d", strtotime(str_replace('/','-', $startdate)));
	$stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_labtest SET LT_SPECIMEN =".$sql->Param('1').", LT_SPECIMENCODE =".$sql->Param('2')." ,LT_SPECIMENLABEL  =".$sql->Param('3')." ,LT_SPECIMENVOLUME =".$sql->Param('4')." ,LT_SPECIMENDATE =".$sql->Param('5')." ,LT_STATUS =".$sql->Param('6')." WHERE LT_CODE=".$sql->Param('5')." "),array($snames,$scodes,$label,$vol,$dt,'3',$vkey));
    print $sql->ErrorMsg();

	$msg = 'Specimen has been taken successfully';
    $status = 'success';
	$view = 'details';
	 $activity = "Patient Specimen captured Successfully.";
	 $engine->setEventLog("065",$activity);
	
	$stmt = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_VISITCODE = ".$sql->Param('1')." AND LT_STATUS = ".$sql->Param('2')."   "),array($keys,'6'));
	print $sql->Errormsg();
	
	if($stmt->Recordcount() > 0 ){
	
	$obj = $stmt->FetchNextObject();
	
	$patient = $obj->LT_PATIENTNAME;
	$patientnum= $obj->LT_PATIENTNUM;
	$visitcode= $obj->LT_VISITCODE;
	
	}
	
	$stmtlist = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_VISITCODE = ".$sql->Param('1')." and LT_STATUS = ".$sql->Param('2')."  "),array($keys, '6'));
	print $sql->Errormsg();
	
	

	}
	
	break;
	
	case 'accept':
        
		/*if(empty($_POST["syscheckbox"])){
	       
            $msg = "Failed. Required field(s) can't be empty!.";
			$status = "error";
			$view ='labdetails';
			
			$stmtlist = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_VISITCODE = ".$sql->Param('1')." and LT_STATUS = ".$sql->Param('2')."   "),array($keys,'1'));
			print $sql->Errormsg();
	       
	    }else{
              
       foreach($_POST["syscheckbox"] as $keys ){
	   
	    $stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_labtest SET LT_STATUS='2' WHERE LT_CODE=".$sql->Param('a').""),array($keys));
		print $sql->ErrorMsg();
		
		}

		$msg = 'You have accepted to perform the lab. request for patient';
        $status = 'success';
		$view ='labdetails';
		
		$stmtlist = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_VISITCODE = ".$sql->Param('1')." and LT_STATUS = ".$sql->Param('2')."   "),array($keys,'1'));
		print $sql->Errormsg();
		
		$activity = "Lab request accepted Successfully by ".$actorname ;
		$engine->setEventLog("028",$activity);
		
		}*/
		
    break;

    case 'reject':
	
		/*if(empty($_POST["syscheckbox"])){
	       
            $msg = "Failed. Required field(s) can't be empty!.";
			$status = "error";
			$view ='labdetails';
			$stmtlist = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_VISITCODE = ".$sql->Param('1')." and LT_STATUS = ".$sql->Param('2')."   "),array($keys,'1'));
			print $sql->Errormsg();
	       
	    }else{
              
       foreach($_POST["syscheckbox"] as $keys ){
       
            $stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_labtest SET LT_STATUS='1', LT_LABCODE = '' WHERE LT_CODE=".$sql->Param('a').""),array($keys));
            print $sql->ErrorMsg();
			
			}
            $msg = 'You have successfully rejected a lab. request for patient';
            $status = 'success';
			$view ='labdetails';
			$stmtlist = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_VISITCODE = ".$sql->Param('1')." and LT_STATUS = ".$sql->Param('2')."   "),array($keys,'1'));
			print $sql->Errormsg();
        
        }*/
    break;

    case 'reset':
        $fdsearch = '';
    break;
}

if(!empty($fdsearch)){
 $query = "SELECT DISTINCT XT_VISITCODE, XT_PATIENTNUM, XT_PATIENTNAME, XT_DATE,XT_ACTORNAME FROM hms_patient_xraytest WHERE  XT_LABCODE = ".$sql->Param('a')." and XT_STATUS IN ('1','6') AND (XT_PATIENTNAME LIKE ".$sql->Param('c')." OR XT_PATIENTNUM LIKE ".$sql->Param('d')."  ) ";
    $input = array($faccode,'%'.$fdsearch.'%','%'.$fdsearch.'%');
}else {
	//echo $faccode;
    $query = "SELECT DISTINCT XT_VISITCODE, XT_PATIENTNUM, XT_PATIENTNAME, XT_DATE, XT_ACTORNAME FROM hms_patient_xraytest WHERE XT_STATUS IN ('1','6') AND XT_LABCODE = ".$sql->Param('b')." ORDER BY XT_INPUTEDDATE DESC";
    $input = array($faccode);
}

$stmtspecimen = $sql->Execute($sql->prepare("SELECT * from hmsb_st_labspecimen where SP_STATUS = ".$sql->Param('a').""),array('1'));

if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=e684d8eeee72ed2583865b78e8d3f57a&option=85401ead437783774ed80a3807ed532a&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);

//Get all positions
$stmtpos2 = $engine->getUserPosition();
//include 'model/js.php';
