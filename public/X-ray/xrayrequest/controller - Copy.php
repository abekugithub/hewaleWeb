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

include SPATH_LIBRARIES.DS."upload.Class.php";



//echo $keys;
switch ($viewpage){


	case 'sampledone':

		if(!empty($packagecode) || !empty($requestcode) ){

		$stmtcheck = $sql->execute($sql->Prepare("SELECT LT_ID FROM hms_patient_labtest WHERE LT_PACKAGECODE = ".$sql->Param('1')." and LT_STATUS = ".$sql->Param('1')." "),array($packagecode,'3'));
		print $sql->Errormsg();

		if($stmtcheck->Recordcount() == 0){

			$stmtlabmain = $sql->Execute($sql->Prepare("Update hms_patient_labtest_main set LTM_STATUS = ".$sql->Param('2')." where LTM_PACKAGECODE = ".$sql->Param('2')." "),array('4',$packagecode));
			
		//	$stmtlab = $sql->Execute($sql->Prepare("Update hms_patient_labtest set LT_STATUS = ".$sql->Param('1')." where LT_CODE = ".$sql->Param('2')." "),array('6',$requestcode));

			$msg = "Success! Sample has been save successfully";
			$status = "success";
			$view ='';	

			$activity = "Lab Sample Taken by ".$actorname ;
			$engine->setEventLog("030",$activity);
		
       		$engine->ClearNotification('0023',$getinserted);

			$description = 'Lab Sample is ready for patient ' .$patientname;
			$notification=$engine->setNotification("045",$description,"0022",$packagecode,$packagecode,$faccode);

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
		
		$stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_labtest SET LT_SPECIMEN =".$sql->Param('1').", LT_SPECIMENCODE =".$sql->Param('2')." ,LT_SPECIMENLABEL  =".$sql->Param('3')." ,LT_SPECIMENVOLUME =".$sql->Param('4')." ,LT_SPECIMENDATE =".$sql->Param('5')." ,LT_STATUS =".$sql->Param('6').", LT_SPECIMENACTOR =".$sql->Param('7').", LT_SPECIMENACTORCODE =".$sql->Param('8')." WHERE LT_CODE=".$sql->Param('10')." "),array($snames,$scodes,$label,$volume,$dt,'4',$actorid,$actorname,$vkey));
		print $sql->ErrorMsg();

		$msg = "Success! Sample has been save successfully";
		$status = "success";
		$view ='labsample';
	}
	
	break;
	
	/*	// Get Lab. Test Price
    $stmt_testprice = $sql->Execute($sql->Prepare("SELECT LL_PRICE FROM hms_lab_testprice WHERE LL_TESTCODE=".$sql->Param('a')." AND LL_FACICODE=".$sql->Param('b')),array($testcode,$faccode));
    print $sql->ErrorMsg();
    if ($stmt_testprice->RecordCount()=='1'){
        $test_price = $stmt_testprice->FetchNextObject()->LL_PRICE;
//        echo $price;
        // Transfer Money to Laboratory's account when specimen is taken
        $engine->getFacilityPercentage($patientcode,$test_price,$faccode);
        $msg = 'Specimen has been taken successfully '.$test_price;
    }


        $status = 'success';
	$view = 'labdetails';
	 $activity = "Patient Specimen captured Successfully.";
	 $engine->setEventLog("065",$activity);
	 
	
	 $stmtlist = $sql->Execute($sql->Prepare("SELECT LT_ID,LT_PATIENTNUM,LT_PATIENTCODE,LT_ACTORCODE,LT_VISITCODE,LT_PATIENTNAME FROM hms_patient_labtest WHERE LT_CODE = ".$sql->Param('2')." "),array($vkey));
	 print $sql->ErrorMsg();
		$obj1=$stmtlist->FetchNextObject();
		$getinserted=$obj1->LT_ID;
		$patientno=$obj1->LT_PATIENTNUM;
		$getcode=$obj1->LT_ACTORCODE;
		$visitcode=$obj1->LT_VISITCODE;
		$patientname=$obj1->LT_PATIENTNAME;


 $stmt = $sql->Execute($sql->Prepare("SELECT REQU_ID FROM hms_service_request WHERE REQU_VISITCODE = ".$sql->Param('a')." "),array($visitcode));
            $client = $stmt->FetchNextObject();
			$tablerowid= $client->REQU_ID;

			//0008 => old menudetailscode before change
	 $engine->ClearNotification('0021',$tablerowid);

	 $description='Lab Specimen ready for Patient ' .$patientname;
	 //0010 => old menudetailscode before change
    $notification=$engine->setNotification("010",$description,"0023",$getinserted,$getcode,$faccode);
		
	
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
	
	*/

	
	
	case "takesample":

		$stmt = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_CODE = ".$sql->Param('1')."   "),array($vkey));
		print $sql->Errormsg();
			
		if($stmt->Recordcount() > 0){

			$obj = $stmt->FetchNextObject();
			$requestcode = $obj->LT_CODE;
			$testname = $encaes->decrypt($obj->LT_TESTNAME);
			$packagecode = $obj->LT_PACKAGECODE;
			$discpline = $obj->LT_DISCPLINENAME;

		/*	$patientcode = $obj->LTM_PATIENTCODE;
			
			$medic = $obj->LTM_ACTORNAME;
			$Total  = $obj->LTM_TOTAL_AMOUNT;
	*/
		}

	//	$stmtlisttestdetails = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_PACKAGECODE = ".$sql->Param('1')." and  LT_STATUS = ".$sql->Param('2')."   "),array($keys,'1'));
		print $sql->Errormsg();
        

	break;
	
	
	
	
	case 'resultdone':

	if(!empty($packagecode) || !empty($requestcode) ){

	$stmtcheck = $sql->execute($sql->Prepare("SELECT LT_ID FROM hms_patient_labtest WHERE LT_PACKAGECODE = ".$sql->Param('1')." and LT_STATUS = ".$sql->Param('1')." "),array($packagecode,'3'));
	print $sql->Errormsg();

	if($stmtcheck->Recordcount() == 0){

		$stmtlabmain = $sql->Execute($sql->Prepare("Update hms_patient_labtest_main set LTM_STATUS = ".$sql->Param('2')." where LTM_PACKAGECODE = ".$sql->Param('2')." "),array('6',$packagecode));
		
	//	$stmtlab = $sql->Execute($sql->Prepare("Update hms_patient_labtest set LT_STATUS = ".$sql->Param('1')." where LT_CODE = ".$sql->Param('2')." "),array('6',$requestcode));

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
	
	case 'saveresults':

		$visitcode=  $session->get('visitcode');
		if( !empty($keys) && !empty($_FILES['file']['name'][0])){
		$attachresult= new upload();
		$filename=$_FILES['file']['name'];
		$attchfile=$attachresult->attachfile("file");
		$key=explode('@@',$keys);
		
		/*$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_labresult (LTP_LABCODE,LTP_VISITCODE,LTP_LABFILE) VALUES (".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').") "),array($key[0],$visitcode,$attchfile));	
		$getinserted=$sql->Insert_ID();*/
		$remarks = $encaes->encrypt($remark);
		
		$stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_labtest SET LT_LABREMARK =".$sql->Param('1').",LT_LABRESULT =".$sql->Param('1').",LT_STATUS='6' WHERE LT_CODE=".$sql->Param('5')." "),array($remarks,$attchfile,$requestcode));
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

		$stmtlisttestdetails = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_PACKAGECODE = ".$sql->Param('1')." and  LT_STATUS IN ('3','4','8')   "),array($keys));
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

		/*	$patientcode = $obj->LTM_PATIENTCODE;
			
			$medic = $obj->LTM_ACTORNAME;
			$Total  = $obj->LTM_TOTAL_AMOUNT;
	*/
		}

	//	$stmtlisttestdetails = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_PACKAGECODE = ".$sql->Param('1')." and  LT_STATUS = ".$sql->Param('2')."   "),array($keys,'1'));
		print $sql->Errormsg();
        

	break;
	
	

	
	case "takespacimen":
	$stmt = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_CODE = ".$sql->Param('1')." and LT_STATUS = ".$sql->Param('2')."   "),array($vkey,'6'));
	print $sql->Errormsg();
	
	if($stmt->Recordcount() > 0 ){
	
	$obj = $stmt->FetchNextObject();
	
	$patient = $obj->LT_PATIENTNAME;
	$patientnum= $obj->LT_PATIENTNUM;
	$patientcode= $obj->LT_PATIENTCODE;
	$test= $obj->LT_TESTNAME;
	$testcode= $encaes->decrypt($obj->LT_TEST);

	
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
       
		/*$stmt = $sql->execute($sql->Prepare("SELECT DISTINCT LT_VISITCODE, LT_PATIENTNUM, LT_PATIENTNAME, LT_DATE,LT_ACTORNAME FROM hms_patient_labtest WHERE LT_STATUS = ".$sql->Param('a')." AND LT_LABCODE = ".$sql->Param('b')." ORDER BY LT_INPUTEDDATE DESC"),array('6',$faccode));
	print $sql->Errormsg();
	
	if($stmt->Recordcount() > 0 ){
	
	$obj = $stmt->FetchNextObject();
	
	$patient = $obj->LT_PATIENTNAME;
	$patientnum= $obj->LT_PATIENTNUM;
	$visitcode= $obj->LT_VISITCODE;
	}
	
	$stmtlist = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_VISITCODE = ".$sql->Param('1')." and LT_STATUS = ".$sql->Param('2')."  "),array($keys, '6'));
	print $sql->Errormsg();*/
	
	break;
	

		}


		if(!empty($fdsearch)){

 			$query = "SELECT LTM_VISITCODE,LTM_DATE,LTM_PATIENTNUM,LTM_PATIENTCODE,LTM_PATIENTNAME,LTM_RMK,LTM_ACTORCODE,LTM_ACTORNAME,LTM_INSTCODE,LTM_TOTAL_AMOUNT,LTM_PACKAGECODE FROM hms_patient_labtest_main WHERE  LTM_LABCODE = ".$sql->Param('a')." and LTM_STATUS = ".$sql->Param('b')." AND (LTM_PATIENTNAME LIKE ".$sql->Param('c')." OR LTM_PATIENTNUM LIKE ".$sql->Param('d')."  ) ";
			$input = array($faccode,'3','%'.$fdsearch.'%','%'.$fdsearch.'%');
	
		}else {

			//echo $faccode;
    		$query = "SELECT LTM_VISITCODE,LTM_DATE,LTM_PATIENTNUM,LTM_PATIENTCODE,LTM_PATIENTNAME,LTM_RMK,LTM_ACTORCODE,LTM_ACTORNAME,LTM_INSTCODE,LTM_TOTAL_AMOUNT,LTM_PACKAGECODE FROM hms_patient_labtest_main WHERE LTM_STATUS = ".$sql->Param('a')." AND LTM_LABCODE = ".$sql->Param('b')." ";
			$input = array('3',$faccode);
	
		}
		$stmtlisttestdetails = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_PACKAGECODE = ".$sql->Param('1')." and  LT_STATUS IN ('3','6','8')   "),array($keys));
		print $sql->Errormsg();

		$stmtlisttestsampledetails = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_PACKAGECODE = ".$sql->Param('1')." and  LT_STATUS IN ('3','4','8')   "),array($keys));
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
