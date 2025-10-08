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

	case 'updateprice':
		if(!empty($packagecode) || !empty($requestcode) ){

			$stmtcheck = $sql->execute($sql->Prepare("SELECT LTM_ID FROM hms_patient_labtest_main WHERE LTM_PACKAGECODE = ".$sql->Param('1')." AND LTM_STATUS = ".$sql->Param('2')." "),array($packagecode,'2'));
			print $sql->Errormsg();

			if($stmtcheck->Recordcount() > 0){
				$percentageapplied = 10;
				$duehewale = (10 / 100) * $totalamounts;
				$duelab = $totalamounts - $duehewale;
				// Set price for labmain
				$stmtlabmain = $sql->Execute($sql->Prepare("UPDATE hms_patient_labtest_main SET LTM_TOTAL_AMOUNT = ".$sql->Param('2')." , LTM_TOTALDUE_LAB = ".$sql->Param('2')." , LTM_TOTALDUE_HEWALE = ".$sql->Param('2')." , LTM_PERCENTAGE_APPLIED = ".$sql->Param('2')." WHERE LTM_PACKAGECODE = ".$sql->Param('2')." "),array($totalamounts,$duelab,$duehewale,$percentageapplied,$packagecode));

				// Set price for lab
				// $stmtlab = $sql->Execute($sql->Prepare("UPDATE hms_patient_labtest SET LT_TOTAL_AMOUNT = ".$sql->Param('2')." , LTM_TOTALDUE_LAB = ".$sql->Param('2')." , LTM_TOTALDUE_HEWALE = ".$sql->Param('2')." , LTM_PERCENTAGE_APPLIED = ".$sql->Param('2')." , LTM_STATUS = ".$sql->Param('2')." WHERE LTM_PACKAGECODE = ".$sql->Param('2')." "),array('4','1',$packagecode));

				// Send push notification to patient app prompting payment
			
				$msg = "Success! Lab Price has been saved successfully.";
				$status = "success";
				$view ='';	

				$activity = "Lab Price entered by ".$actorname ;
				$engine->setEventLog("030",$activity);

			//	$getupdated=$sql->UPDATE_ID();
			
				$engine->ClearNotification('0021',$getupdated);

				$description = 'Lab Price is set for patient ' .$patientname;
				$notification=$engine->setNotification("045",$description,"0022",$packagecode,$getupdated,$faccode);

			} else {

				$msg = "Failed! Unrecognised Lab.";
				$status = "error";
				$view ='labsample';	

			}
		}else{

			$msg = "Failed! Required Fields can't be empty";
			$status = "error";
			$view ='labsample';	

		}
	break;
	
	case 'cashpayment':
		if(!empty($packagecode) || !empty($requestcode)) {

			$stmtcheck = $sql->execute($sql->Prepare("SELECT LTM_ID FROM hms_patient_labtest_main WHERE LTM_PACKAGECODE = ".$sql->Param('1')." AND LTM_STATUS = ".$sql->Param('2')),array($packagecode,'2'));
			print $sql->Errormsg();

			if($stmtcheck->Recordcount() > 0){				
				// Set price for labmain
				$stmtlabmain = $sql->Execute($sql->Prepare("UPDATE hms_patient_labtest_main SET LTM_STATUS = ".$sql->Param('1')." , LTM_PAYMENTSTATUS = ".$sql->Param('2')." , LTM_PAYMENTDATE = ".$sql->Param('3')." WHERE LTM_PACKAGECODE = ".$sql->Param('4')), array('3','2',$startdate,$packagecode));
				
				// Set price for lab
				$stmtlab = $sql->Execute($sql->Prepare("UPDATE hms_patient_labtest SET LT_STATUS = ".$sql->Param('1')." WHERE LT_PACKAGECODE = ".$sql->Param('2')), array('3',$packagecode));

				// Send push notification to patient app prompting payment
			
				$msg = "Success! Lab Payment has been received successfully.";
				$status = "success";
				$view ='';	

				$activity = "Lab Payment received by ".$actorname ;
				$engine->setEventLog("030",$activity);

			//	$getupdated=$sql->UPDATE_ID();
			
				$engine->ClearNotification('0021',$getupdated);

				$description = 'Lab Payment for patient ' .$patientname.' lab test has been received';
				$notification=$engine->setNotification("045",$description,"0022",$packagecode,$getupdated,$faccode);

			} else {

				$msg = "Failed! Unrecognised Lab.";
				$status = "error";
				$view ='labsample';	

			}
		}else{

			$msg = "Failed! Required Fields can't be empty";
			$status = "error";
			$view ='labsample';	

		}
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

	$stmtcheck = $sql->execute($sql->Prepare("SELECT LT_ID FROM hms_patient_labtest WHERE LT_PACKAGECODE = ".$sql->Param('1')." and LT_STATUS = ".$sql->Param('1')." "),array($packagecode,'3'));
	print $sql->Errormsg();

	if($stmtcheck->Recordcount() == 0){

		$stmtlabmain = $sql->Execute($sql->Prepare("Update hms_patient_labtest_main set LTM_STATUS = ".$sql->Param('2')." where LTM_PACKAGECODE = ".$sql->Param('2')." "),array('6',$packagecode));
		
	
		$msg = "Success! Lab Result has been save successfully";
		$status = "success";
		$view ='';	

	}else{

		$msg = "Failed! Pending lab Result";
		$status = "error";
		$view ='labdetails';	

	}
	}else{

		$msg = "Failed! Required Fields can't be empty";
		$status = "error";
		$view ='labdetails';	

	}


	break;
	
	case 'attached':

	//	$visitcode=  $session->get('visitcode');
		
		if( !empty($keys) && !empty($_FILES['file']['name'][0])){
		$attachresult= new upload();
		$filename=$_FILES['file']['name'];
		$attchfile=$attachresult->attachfile("file");
		$key=explode('@@',$keys);
		
	//	$remarks = $encaes->encrypt($remark);

		$day = date('Y-m-d');

		$atcode =  uniqid();

		$stmtattached = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_labresult_files (LTMI_ID,LTMI_PACKAGECODE,LTMI_VISITCODE,LTMI_DATE,LTMI_PATIENTNUM,LTMI_PATIENTCODE,LTMI_LTCODE,LTMI_FILENAME) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').")"),array($atcode,$packagecode,$visitcode,$day,$patientnum,$patientnum,$requestcode,$attchfile));
		print $sql->Errormsg();
		
			
		$stmtlist = $sql->Execute($sql->Prepare("SELECT LT_ID,LT_PATIENTNUM,LT_PATIENTCODE,LT_ACTORCODE,LT_PATIENTNAME FROM hms_patient_labtest WHERE LT_CODE = ".$sql->Param('2')." "),array($requestcode));
		$obj1=$stmtlist->FetchNextObject();
		$getinserted=$obj1->LT_ID;
		$patientno=$obj1->LT_PATIENTNUM;
		$getcode=$obj1->LT_ACTORCODE;
		$patientname=$obj1->LT_PATIENTNAME;
		print $sql->ErrorMsg();

	
		$msg = "Success! Lab Result has been Attached successfully";
		$status = "success";
		$view ='results';	

		$activity = "Lab result attached by ".$actorname ;
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
	//	$attachresult= new upload();
	//	$filename=$_FILES['file']['name'];
		
	//	$attchfile=$attachresult->attachfile("file");
	//	$key=explode('@@',$keys);
		
	//	$getinserted=$sql->Insert_ID();
		$remarks = $encaes->encrypt($remark);

		$day = date('Y-m-d');

	//	

	$stmtcheck = $sql->execute($sql->Prepare("SELECT LTMI_ID FROM hms_patient_labresult_files WHERE LTMI_LTCODE = ".$sql->Param('1')."  "),array($requestcode));
	print $sql->Errormsg();

	if($stmtcheck->Recordcount()> 0){
		
		$stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_labtest SET LT_LABREMARK =".$sql->Param('1').",LT_STATUS='6' WHERE LT_CODE=".$sql->Param('5')." "),array($remarks,$requestcode));
		print $sql->ErrorMsg();

	
		$stmtlist = $sql->Execute($sql->Prepare("SELECT LT_ID,LT_PATIENTNUM,LT_PATIENTCODE,LT_ACTORCODE,LT_PATIENTNAME FROM hms_patient_labtest WHERE LT_CODE = ".$sql->Param('2')." "),array($requestcode));
		$obj1=$stmtlist->FetchNextObject();
		$getinserted=$obj1->LT_ID;
		$patientno=$obj1->LT_PATIENTNUM;
		$getcode=$obj1->LT_ACTORCODE;
		$patientname=$obj1->LT_PATIENTNAME;
		print $sql->ErrorMsg();

	
		$msg = "Success! Lab Result has been save successfully";
		$status = "success";
		$view ='labdetails';	

		$activity = "Lab result attached by ".$actorname ;
		$engine->setEventLog("030",$activity);
		
       	$engine->ClearNotification('0023',$getinserted);

		$description = 'Lab Result is ready for patient ' .$patientname;
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

		$stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_labresult_files SET LTMI_STATUS='0' WHERE LTMI_ID=".$sql->Param('1')." "),array($cde));
		print $sql->ErrorMsg();

		$msg = "Success! Lab Result has been Removed successfully";
		$status = "success";
		$view ='results';	

		
	}else{

	    $msg = "Sorry! Fields can't be empty";
		$status = "error";
		$view ='results';	
		
		
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
			$total  = $obj->LTM_TOTAL_AMOUNT;
			$visitcode  = $obj->LTM_VISITCODE;
			$homeservicestatus  = $obj->LTM_HOMESERVICE;
			$patientlocation  = $obj->LTM_PATIENT_LOCATION;
			$source  = $obj->LTM_SOURCE;

			$patientcontact = $patientCls->getPatientDetails($patientnum)->PATIENT_PHONENUM ;
			$patientgender = $patientCls->getPatientDetails($patientnum)->PATIENT_GENDER ;
	
		}

		$stmtlisttestdetails = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_PACKAGECODE = ".$sql->Param('1')." AND LT_STATUS IN ('1','2','3','4','8')   "),array($keys));
		print $sql->Errormsg();
        

	break;




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
	
	

    case 'reset':

        $fdsearch = '';
     
	break;
	
	}

if(!empty($fdsearch)){

	$query = "SELECT LTM_VISITCODE,LTM_DATE,LTM_PATIENTNUM,LTM_PATIENTCODE,LTM_PATIENTNAME,LTM_RMK,LTM_ACTORCODE,LTM_ACTORNAME,LTM_INSTCODE,LTM_TOTAL_AMOUNT,LTM_PACKAGECODE,LTM_HOMESERVICE,LTM_STATUS FROM hms_patient_labtest_main WHERE  LTM_LABCODE = ".$sql->Param('a')." AND LTM_STATUS IN ('1','2')  AND LTM_HOMESERVICE IN ('1','2') AND (LTM_PATIENTNAME LIKE ".$sql->Param('c')." OR LTM_PATIENTNUM LIKE ".$sql->Param('d')."  ) ";
	$input = array($faccode,'%'.$fdsearch.'%','%'.$fdsearch.'%');

}else {
	//echo $faccode;
	$query = "SELECT LTM_VISITCODE,LTM_DATE,LTM_PATIENTNUM,LTM_PATIENTCODE,LTM_PATIENTNAME,LTM_RMK,LTM_ACTORCODE,LTM_ACTORNAME,LTM_INSTCODE,LTM_TOTAL_AMOUNT,LTM_PACKAGECODE, CASE (LTM_HOMESERVICE) WHEN '0' THEN 'Walk-in' WHEN '1' THEN 'Home Service' WHEN '2' THEN 'Home Service' END LTM_HOMESERVICE,LTM_STATUS FROM hms_patient_labtest_main WHERE LTM_STATUS IN ('1','2') AND LTM_HOMESERVICE IN ('1','2') AND LTM_LABCODE = ".$sql->Param('b')." ";
	$input = array($faccode);
}

$statusdesc = ['1'=>'Unassigned', '2'=>'Pending', '3'=>'Paid', '4'=>'Specimen Taken', '5'=>'Processing', '6'=>'Result Ready', '7'=>'Result Signoff'];


$stmtlisttestdetails = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_PACKAGECODE = ".$sql->Param('1')." and  LT_STATUS IN ('2','3','6','8')   "),array($keys));
print $sql->Errormsg();

$stmtlisttestsampledetails = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_PACKAGECODE = ".$sql->Param('1')." and  LT_STATUS IN ('2','3','4','8')   "),array($keys));
print $sql->Errormsg();

$stmtlisttestresults = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labresult_files WHERE LTMI_LTCODE = ".$sql->Param('1')." and LTMI_STATUS = ".$sql->Param('2')." "),array($requestcode,'1'));
print $sql->Errormsg();
       

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
