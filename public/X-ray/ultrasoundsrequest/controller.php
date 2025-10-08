<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 8/8/2017
 * Time: 5:14 PM
 */
 
 
$crypt = new cryptCls();
$actorid = $session->get("userid");
$actorname = $engine->getActorName();
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$objdtls = $engine->getFacilityDetails();
$facilityalias = $objdtls->FACI_ALIAS ;
$faccode = $objdtls->FACI_CODE ;
$patientCls = new patientClass();
$doctors = new doctorClass();



include SPATH_LIBRARIES.DS."upload.Class.php";



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


	case 'attached':

	//	$visitcode=  $session->get('visitcode');
		
		if( !empty($keys) && !empty($_FILES['file']['name'][0])){
		$attachresult= new upload();
		$filename=$_FILES['file']['name'];

	//	$attchfile=$attachresult->attachfile("file");
		$attchfile=$attachresult->attachfilescans("file");
	//	die($attchfile);
	//	$key=explode('@@',$keys);
		
	//	$remarks = $encaes->encrypt($remark);

		$day = date('Y-m-d');

		$atcode =  uniqid();

		$stmtattached = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_xraytest_files (XTMI_ID,XTMI_PACKAGECODE,XTMI_VISITCODE,XTMI_DATE,XTMI_PATIENTNUM,XTMI_PATIENTCODE,XTMI_LTCODE,XTMI_FILENAME) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').")"),array($atcode,$packagecode,$visitcode,$day,$patientnum,$patientnum,$requestcode,$attchfile));
		print $sql->Errormsg();
		
			
		$stmtlist = $sql->Execute($sql->Prepare("SELECT XT_ID,XT_PATIENTNUM,XT_PATIENTCODE,XT_ACTORCODE,XT_PATIENTNAME FROM hms_patient_xraytest WHERE XT_CODE = ".$sql->Param('2')." "),array($requestcode));
		$obj1=$stmtlist->FetchNextObject();
		$getinserted=$obj1->XT_ID;
		$patientno=$obj1->XT_PATIENTNUM;
		$getcode=$obj1->XT_ACTORCODE;
		$patientname=$obj1->XT_PATIENTNAME;
		print $sql->ErrorMsg();

	
		$msg = "Success! Scan Result has been Attached successfully";
		$status = "success";
		$view ='results';	

		$activity = "Scan result attached by ".$actorname ;
		$engine->setEventLog("030",$activity);
		
       	$engine->ClearNotification('0023',$getinserted);

		$description = 'Lab Result is ready for patient ' .$patientname;
		$notification=$engine->setNotification("027",$description,"0066",$getinserted,$getcode,$faccode);

	}else{

	    $msg = "Sorry! Fields can't be empty";
		$status = "error";
		$view ='results';	
		
		}
	
	break;

	
	case 'saveresults':

		$visitcode=  $session->get('visitcode');
		
		if( !empty($keys)){
		$remarks = $encaes->encrypt($remark);

		$day = date('Y-m-d');

	//	

	$stmtcheck = $sql->execute($sql->Prepare("SELECT XTMI_ID FROM hms_patient_xraytest_files WHERE XTMI_LTCODE = ".$sql->Param('1')."  "),array($requestcode));
	print $sql->Errormsg();

	if($stmtcheck->Recordcount()> 0){
		
		$stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_xraytest SET XT_RMK =".$sql->Param('1').",XT_STATUS='6' WHERE XT_CODE=".$sql->Param('5')." "),array($remarks,$requestcode));
		print $sql->ErrorMsg();

	
		$stmtlist = $sql->Execute($sql->Prepare("SELECT XT_ID,XT_PATIENTNUM,XT_PATIENTCODE,XT_ACTORCODE,XT_PATIENTNAME FROM hms_patient_xraytest WHERE XT_CODE = ".$sql->Param('2')." "),array($requestcode));
		$obj1=$stmtlist->FetchNextObject();
		$getinserted=$obj1->XT_ID;
		$patientno=$obj1->XT_PATIENTNUM;
		$getcode=$obj1->XT_ACTORCODE;
		$patientname=$obj1->XT_PATIENTNAME;
		print $sql->ErrorMsg();

	
		$msg = "Success! Result has been save successfully";
		$status = "success";
		$view ='details';	

		$activity = "Lab result attached by ".$actorname ;
		$engine->setEventLog("030",$activity);
		
       	$engine->ClearNotification('0023',$getinserted);

		$description = 'Result is ready for patient ' .$patientname;
		$notification=$engine->setNotification("027",$description,"0066",$getinserted,$getcode,$faccode);

	}else{

	    $msg = "Sorry! Fields can't be empty";
		$status = "error";
		$view ='results';	
		
		}
	}else{

	    $msg = "Sorry! Fields can't be empty";
		$status = "error";
		$view ='results';	
		
		}	
	
	break;


	case 'removeresults':

		
		if( !empty($cde)){

		$stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_xraytest_files SET XTMI_STATUS='0' WHERE XTMI_ID=".$sql->Param('1')." "),array($cde));
		print $sql->ErrorMsg();

		$msg = "Success! Ultrasound Result has been Removed successfully";
		$status = "success";
		$view ='results';	

		
	}else{

	    $msg = "Sorry! Fields can't be empty";
		$status = "error";
		$view ='results';	
		
		
		}	
	
	break;



    case 'reset':

        $fdsearch = '';
     
	break;









	case 'sampledone':

		if(!empty($packagecode) || !empty($requestcode) ){

		$stmtcheck = $sql->execute($sql->Prepare("SELECT LT_ID FROM hms_patient_labtest WHERE LT_PACKAGECODE = ".$sql->Param('1')." and LT_STATUS = ".$sql->Param('1')." "),array($packagecode,'3'));
		print $sql->Errormsg();

		if($stmtcheck->Recordcount() == 0){

			$stmtlabmain = $sql->Execute($sql->Prepare("Update hms_patient_labtest_main set LTM_STATUS = ".$sql->Param('2')." , LTM_SAMPLESTATE = ".$sql->Param('2')." where LTM_PACKAGECODE = ".$sql->Param('2')." "),array('4','1',$packagecode));
			
		
			$msg = "Success! Sample has been save successfully";
			$status = "success";
			$view ='';	

			$activity = "Lab Sample Taken by ".$actorname ;
			$engine->setEventLog("030",$activity);

		//	$getupdated=$sql->UPDATE_ID();
		
       		$engine->ClearNotification('0021',$getupdated);

			$description = 'Lab Sample is ready for patient ' .$patientname;
			$notification=$engine->setNotification("045",$description,"0022",$packagecode,$getupdated,$faccode);

		}else{

			$msg = "Failed! Pending Sample";
			$status = "error";
			$view ='labsample';	

		}
		}else{

			$msg = "Failed! Required Fields can't be empty";
			$status = "error";
			$view ='labsample';	

		}


	break;
	
	
	
	// 14 FEB 2019
	case "savesample":
	if(empty($vkey)  || empty($sample) || empty($label) || empty($volume)  ){

		$msg = "Failed. Required field(s) can't be empty!.";
		$status = "error";
		$view ='takesample';
		
	}else{

		$sp = explode('@@@' , $sample);
		$scode = $sp['0'];
		$sname = $sp['1'];
		$scodes = $encaes->encrypt($scode);
		$snames = $encaes->encrypt($sname);
		$startdate = date('Y-m-d');
		$dt = Date("Y-m-d", strtotime(str_replace('/','-', $startdate)));
		
		$stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_labtest SET LT_SPECIMEN =".$sql->Param('1').", LT_SPECIMENCODE =".$sql->Param('2')." ,LT_SPECIMENLABEL  =".$sql->Param('3')." ,LT_SPECIMENVOLUME =".$sql->Param('4')." ,LT_SPECIMENDATE =".$sql->Param('5')." ,LT_STATUS =".$sql->Param('6').", LT_SPECIMENACTOR =".$sql->Param('7').", LT_SPECIMENACTORCODE =".$sql->Param('8')." , LT_SPECIMENSTATE =".$sql->Param('8')." WHERE LT_CODE=".$sql->Param('10')." "),array($snames,$scodes,$label,$volume,$dt,'4',$actorid,$actorname,'1',$vkey));
		print $sql->ErrorMsg();

		$msg = "Success! Sample has been save successfully";
		$status = "success";
		$view ='labsample';

	}
	
	break;
	

	
	
	case "takesample":

		$stmt = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_CODE = ".$sql->Param('1')."   "),array($vkey));
		print $sql->Errormsg();
			
		if($stmt->Recordcount() > 0){

			$obj = $stmt->FetchNextObject();
			$requestcode = $obj->LT_CODE;
			$testname = $encaes->decrypt($obj->LT_TESTNAME);
			$packagecode = $obj->LT_PACKAGECODE;
			$discpline = $obj->LT_DISCPLINENAME;

		}

	break;
	
	
	
	
	case 'resultdone':

	if(!empty($packagecode) || !empty($requestcode) ){

	$stmtcheck = $sql->execute($sql->Prepare("SELECT XT_ID FROM hms_patient_xraytest WHERE XT_PACKAGECODE = ".$sql->Param('1')." and XT_STATUS = ".$sql->Param('1')." "),array($packagecode,'3'));
	print $sql->Errormsg();

	if($stmtcheck->Recordcount() == 0){

		$stmtlabmain = $sql->Execute($sql->Prepare("Update hms_patient_xraytest_main set XTM_STATUS = ".$sql->Param('2')." where XTM_PACKAGECODE = ".$sql->Param('2')." "),array('6',$packagecode));
		
	
		$msg = "Success! Ultrasound Result has been save successfully";
		$status = "success";
		$view ='';	

	}else{

		$msg = "Failed! Pending Ultrasound Result";
		$status = "error";
		$view ='labdetails';	

	}
	}else{

		$msg = "Failed! Required Fields can't be empty";
		$status = "error";
		$view ='labdetails';	

	}


	break;
	
	

	
	}

		if(!empty($fdsearch)){

 			$query = "SELECT XTM_VISITCODE,XTM_DATE,XTM_PATIENTNUM,XTM_PATIENTCODE,XTM_PATIENTNAME,XTM_ACTORCODE,XTM_ACTORNAME,XTM_INSTCODE,XTM_TOTAL_AMOUNT,XTM_PACKAGECODE FROM hms_patient_xraytest_main WHERE  XTM_LABCODE = ".$sql->Param('a')." and XTM_STATUS = ".$sql->Param('b')." AND XTM_TYPE  = ".$sql->Param('b')." AND   (XTM_PATIENTNAME LIKE ".$sql->Param('c')." OR XTM_PATIENTNUM LIKE ".$sql->Param('d')."  ) ";
			$input = array($faccode,'3','2','%'.$fdsearch.'%','%'.$fdsearch.'%');
	
		}else {

			//echo $faccode;
    		$query = "SELECT XTM_VISITCODE,XTM_DATE,XTM_PATIENTNUM,XTM_PATIENTCODE,XTM_PATIENTNAME,XTM_ACTORCODE,XTM_ACTORNAME,XTM_INSTCODE,XTM_TOTAL_AMOUNT,XTM_PACKAGECODE FROM hms_patient_xraytest_main WHERE XTM_STATUS = ".$sql->Param('a')." AND XTM_TYPE  = ".$sql->Param('b')." AND XTM_LABCODE = ".$sql->Param('b')." ";
			$input = array('3','2',$faccode);
	
		}

		$stmtlisttestdetails = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_xraytest WHERE XT_PACKAGECODE = ".$sql->Param('1')." and  XT_STATUS IN ('3','6','8')   "),array($keys));
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
			$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=e684d8eeee72ed2583865b78e8d3f57a&option=85401ead437783774ed80a3807ed532a&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);

			//Get all positions
			$stmtpos2 = $engine->getUserPosition();
			//include 'model/js.php';
