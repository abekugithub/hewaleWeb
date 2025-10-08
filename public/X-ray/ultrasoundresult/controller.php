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
$patientCls = new patientClass();

//echo $keys;
switch ($viewpage){

	case "details":

		$stmt = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_xraytest_main WHERE XTM_PACKAGECODE = ".$sql->Param('1')."   "),array($keys));
		print $sql->Errormsg();

			
		if($stmt->Recordcount() > 0){

			$obj = $stmt->FetchNextObject();
			$patient = $obj->XTM_PATIENTNAME;
			$patientnum = $obj->XTM_PATIENTNUM;
			$patientcode = $obj->XTM_PATIENTCODE;
			$packagecode = $obj->XTM_PACKAGECODE;
			$patientdate = $obj->XTM_DATE;
			$medic = $obj->XTM_ACTORNAME;
			$Total  = $obj->XTM_TOTAL_AMOUNT;
			$visitcode  = $obj->XTM_VISITCODE;
		
			$patientcontact = $patientCls->getPatientDetails($patientnum)->PATIENT_PHONENUM ;
			$patientgender = $patientCls->getPatientDetails($patientnum)->PATIENT_GENDER ;
			$patientage = $patientCls->getPatientDetails($patientnum)->PATIENT_GENDER ;
		
		}

		

		$stmtlisttestdetails = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_xraytest WHERE XT_PACKAGECODE = ".$sql->Param('1')." and  XT_STATUS IN ('3','6','8')   "),array($keys));
		print $sql->Errormsg();
        

	break;

	case "result":

		$stmt = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_xraytest WHERE XT_CODE = ".$sql->Param('1')."   "),array($vkey));
		print $sql->Errormsg();

		
			
		if($stmt->Recordcount() > 0){

			$obj = $stmt->FetchNextObject();
			$requestcode = $obj->XT_CODE;
			$testname = $encaes->decrypt($obj->XT_TESTNAME);
			$packagecode = $obj->XT_PACKAGECODE;
		//	$discpline = $obj->LT_DISCPLINENAME;
			$visitcode  = $obj->XT_VISITCODE;

			
		}


	break;

	
	
	
	
	case "reject":
		
			
		IF(empty($_POST["syscheckbox"]) || empty($packagecode)){
	       
            $msg = "Failed. Required field(s) can't be empty!.";
			$status = "error";
			$view ='labdetails';
			
			$stmtlisttestdetails = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_PACKAGECODE = ".$sql->Param('1')." and  LT_STATUS IN ('6','4','7','8')   "),array($keys));
		print $sql->Errormsg();
        
		    
	    }else{
              
		foreach($_POST["syscheckbox"] as $keysd){			
			
			$stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_labtest SET LT_STATUS =".$sql->Param('a')."  WHERE LT_CODE=".$sql->Param('5')." "),array('8',$keysd));
			print $sql->ErrorMsg();	
		
			$stmtlabmain = $sql->Execute($sql->Prepare("Update hms_patient_labtest_main set LTM_STATUS = ".$sql->Param('2')." where LTM_PACKAGECODE = ".$sql->Param('2')." "),array('3',$packagecode));
		
			$stmtlabresult = $sql->Execute($sql->Prepare("Update hms_patient_labresult_files set LTMI_STATUS = ".$sql->Param('2')." where LTMI_LTCODE = ".$sql->Param('2')." "),array('0',$keysd));
		
		
			$stmtlisttestdetails = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_PACKAGECODE = ".$sql->Param('1')." and  LT_STATUS IN ('6','4','7','8')   "),array($keys));
			print $sql->Errormsg();
			
			$msg = "The Lab Results was Rejected ";
			$status = "success";
			$view = 'labdetails';
			$activity = "Lab result disapproved by ".$actorname ;

			$engine->setEventLog("063",$activity);       
	    	$engine->ClearNotification('0067',$getinserted);
			
		}

        }	
		
	break;

	
/*
	case "res":

		$stmt = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_CODE = ".$sql->Param('1')."   "),array($vkey));
		print $sql->Errormsg();
			
		if($stmt->Recordcount() > 0){

			$obj = $stmt->FetchNextObject();
			$requestcode = $obj->LT_CODE;
			$testname = $encaes->decrypt($obj->LT_TESTNAME);
			$packagecode = $obj->LT_PACKAGECODE;
			$discpline = $obj->LT_DISCPLINENAME;
			$visitcode  = $obj->LT_VISITCODE;
		}


	break;
	
	*/


	case "signoff":

		IF(empty($_POST["syscheckbox"]) || empty($packagecode)){

			$msg = "Failed. Required field(s) can't be empty!.";
			$status = "error";
			$view ='details';

		//	$stmtlisttestdetails = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_xraytest join hms_patient_xraytest_files on XTMI_PACKAGECODE =  WHERE XT_PACKAGECODE = ".$sql->Param('1')." and  XT_STATUS IN ('6','4','7','8')   "),array($keys));
		//	print $sql->Errormsg();
        		    
	    }else{


		foreach($_POST["syscheckbox"] as $keysd){
			
			
			$stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_xraytest SET XT_STATUS =".$sql->Param('a')."  WHERE XT_CODE=".$sql->Param('5')." "),array('7',$keysd));
			print $sql->ErrorMsg();


			$stmtcheck = $sql->execute($sql->Prepare("SELECT XT_ID FROM hms_patient_xraytest WHERE XT_PACKAGECODE = ".$sql->Param('1')." and XT_STATUS  IN ('6','8') "),array($packagecode));
			print $sql->Errormsg();
			

			if($stmtcheck->Recordcount() == 0){

			//	die('tested the things');

				$stmtlabmain = $sql->Execute($sql->Prepare("Update hms_patient_xraytest_main set XTM_STATUS = ".$sql->Param('1')." where XTM_PACKAGECODE = ".$sql->Param('2')." "),array('7',$packagecode));
				print $sql->Errormsg();			
			
			}
			
//			$stmtlisttestdetails = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_xraytest WHERE XT_PACKAGECODE = ".$sql->Param('1')." and  XT_STATUS IN ('6','4','7','8')   "),array($keys));
//			print $sql->Errormsg();

			$msg = "The  Results was Approve successfully ";
			$status = "success";
			$view = 'details';
			$activity = "Lab result approved by ".$actorname ;

			$engine->setEventLog("063",$activity);       
	    	$engine->ClearNotification('0067',$getinserted);
		}

		}

			
	break;
	

	case "testdetails":

		$stmt = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest_main WHERE LTM_PACKAGECODE = ".$sql->Param('1')."   "),array($keys));
		print $sql->Errormsg();

			
		if($stmt->Recordcount() > 0){

			$obj = $stmt->FetchNextObject();
			$patient = $obj->LTM_PATIENTNAME;
			$patientnum = $obj->LTM_PATIENTNUM;
			$patientcode = $obj->LTM_PATIENTCODE;
			$packagecode = $obj->LTM_PACKAGECODE;
			$patientdate = $obj->LTM_DATE;
			$medic = $obj->LTM_ACTORNAME;
			$Total  = $obj->LTM_TOTAL_AMOUNT;

			$patientcontact = $patientCls->getPatientDetails($patientnum)->PATIENT_PHONENUM ;
			$patientgender = $patientCls->getPatientDetails($patientnum)->PATIENT_GENDER ;
		//	$patientage = $patientCls->getPatientDetails($patientnum)->PATIENT_DOB ;
	
		}

		$stmtlisttestdetails = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_PACKAGECODE = ".$sql->Param('1')." and  LT_STATUS IN ('6','4','7','8')   "),array($keys));
		print $sql->Errormsg();
        

	break;



/*
	case 'signoff':
	if(!empty($keys)){
$stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_labtest SET LT_STATUS='7' WHERE LT_CODE=".$sql->Param('5')." "),array($keys));
    print $sql->ErrorMsg();
	
	$stmtlist = $sql->Execute($sql->Prepare("SELECT LT_ID,LT_PATIENTNUM,LT_PATIENTCODE,LT_ACTORCODE FROM hms_patient_labtest WHERE LT_CODE = ".$sql->Param('2')." "),array($keys));
	 print $sql->ErrorMsg();
$obj1=$stmtlist->FetchNextObject();
$getinserted=$obj1->LT_ID;
$patientno=$obj1->LT_PATIENTNUM;
$getcode=$obj1->LT_ACTORCODE;
   
	
	    $msg = "Success! Lab Result has been successfully signed off";
		$status = "success";
		$viewpage ='';	
		$activity = "Lab result signed off by ".$actorname ;
		$engine->setEventLog("063",$activity);
       
	    $engine->ClearNotification('0067',$getinserted);
		
		$description='Lab Result is ready for patient with No.' .$patientno;
		$notification=$engine->setNotification("010",$description,"0063",$getinserted,$getcode,$faccode);
	}
	
	break;
*/
    case 'reset':
        $fdsearch = '';
        $view = '';
    break;
}
		
if(!empty($fdsearch)){

	$query = "SELECT XTM_VISITCODE,XTM_DATE,XTM_PATIENTNUM,XTM_PATIENTCODE,XTM_PATIENTNAME,XTM_ACTORCODE,XTM_ACTORNAME,XTM_INSTCODE,XTM_TOTAL_AMOUNT,XTM_PACKAGECODE FROM hms_patient_xraytest_main WHERE  XTM_LABCODE = ".$sql->Param('a')." and XTM_STATUS = ".$sql->Param('b')." AND XTM_TYPE  = ".$sql->Param('b')." AND   (XTM_PATIENTNAME LIKE ".$sql->Param('c')." OR XTM_PATIENTNUM LIKE ".$sql->Param('d')."  ) ";
   $input = array($faccode,'7','2','%'.$fdsearch.'%','%'.$fdsearch.'%');

}else {

   //echo $faccode;
   $query = "SELECT XTM_VISITCODE,XTM_DATE,XTM_PATIENTNUM,XTM_PATIENTCODE,XTM_PATIENTNAME,XTM_ACTORCODE,XTM_ACTORNAME,XTM_INSTCODE,XTM_TOTAL_AMOUNT,XTM_PACKAGECODE FROM hms_patient_xraytest_main WHERE XTM_STATUS = ".$sql->Param('a')." AND XTM_TYPE  = ".$sql->Param('b')." AND XTM_LABCODE = ".$sql->Param('b')." ";
   $input = array('7','2',$faccode);

}
$stmtlisttestdetails = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_xraytest WHERE XT_PACKAGECODE = ".$sql->Param('1')." and  XT_STATUS IN ('7','6','8')   "),array($keys));
print $sql->Errormsg();



$stmtlisttestresults = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_xraytest_files WHERE XTMI_LTCODE = ".$sql->Param('1')." and XTMI_STATUS = ".$sql->Param('2')." "),array($requestcode,'1'));
		print $sql->Errormsg();
		    

if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=e684d8eeee72ed2583865b78e8d3f57a&option=29b2eb4e9498262f90a3afafc3955b54#',$input);
include("model/js.php");

