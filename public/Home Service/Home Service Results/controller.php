<?php 

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
$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);

switch ($viewpage){
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

			$patientcontact = $patientCls->getPatientDetails($patientnum)->PATIENT_PHONENUM ;
			$patientgender = $patientCls->getPatientDetails($patientnum)->PATIENT_GENDER ;
	
		}

		$stmtlisttestdetails = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_PACKAGECODE = ".$sql->Param('1')." and LT_STATUS IN ('3','4','5','6','8') "),array($keys));
		print $sql->Errormsg();   

	break;

    case 'resultdone':
        if(!empty($keys)){
            $stmtcheck = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest_main WHERE LTM_PACKAGECODE = ".$sql->Param('1').""), array($packagecode));
            print $sql->Errormsg();

            if($stmtcheck->Recordcount() > 0){

                $stmtlabmain = $sql->Execute($sql->Prepare("UPDATE hms_patient_labtest_main SET LTM_STATUS = ".$sql->Param('a').", LTM_TOTAL_AMOUNT = ".$sql->Param('b')." WHERE LTM_PACKAGECODE = ".$sql->Param('c')." "),array('2', $totalamounts, $packagecode));
                
                $stmtlab = $sql->Execute($sql->Prepare("UPDATE hms_patient_labtest SET LT_STATUS = ".$sql->Param('a')." WHERE LT_PACKAGECODE = ".$sql->Param('b')." "),array('2', $packagecode));

                if($stmtlabmain && $stmtlab){
                    $msg = "Success! Lab Result has been save successfully";
                    $status = "success";
                    $view ='';	
                } else {
                    $msg = $sql->Errormsg();
                    $status = "error";
                    $view ='';	
                }
            } else {

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
		
		if( !empty($keys) && !empty($_FILES['file']['name'])){
            $attachresult = new upload();
            $filename = $_FILES['file']['name'];
            $attchfile = $attachresult->attachfile('file', $_FILES['file']['name'], $_FILES['file']['size']);
            // $key = explode('@@',$keys);
            
        //	$remarks = $encaes->encrypt($remark);

            $day = date('Y-m-d');

            $atcode =  uniqid();
            
            $stmtlist = $sql->Execute($sql->Prepare("SELECT LT_ID,LT_CODE,LT_PATIENTNUM,LT_PATIENTCODE,LT_ACTORCODE,LT_PATIENTNAME FROM hms_patient_labtest WHERE LT_PACKAGECODE = ".$sql->Param('2')." LIMIT 1 "),array($packagecode));
            print $sql->ErrorMsg();
            if ($stmtlist->RecordCount() > 0){
                $obj1 = $stmtlist->FetchNextObject();
                $requestcode = $obj1->LT_CODE;
                $getinserted = $obj1->LT_ID;
                $patientno = $obj1->LT_PATIENTNUM;
                $getcode = $obj1->LT_ACTORCODE;
                $patientname = $obj1->LT_PATIENTNAME;
                
                $stmtattached = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_labresult_files (LTMI_ID,LTMI_PACKAGECODE,LTMI_VISITCODE,LTMI_DATE,LTMI_PATIENTNUM,LTMI_PATIENTCODE,LTMI_LTCODE,LTMI_FILENAME,LTMI_COUNTRYCODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').")"),array($atcode,$packagecode,$visitcode,$day,$patientnum,$patientcode,$requestcode,$attchfile,'GH'));
                print $sql->Errormsg();

                if ($stmtattached){
                    // update lab main
                    $stmtattachedmain = $sql->Execute($sql->Prepare("UPDATE hms_patient_labtest_main SET LTM_STATUS = ".$sql->Param('a')." WHERE LTM_PACKAGECODE = ".$sql->Param('b')),array('7', $packagecode));
                    print $sql->Errormsg();

                    // update lab 
                    $stmtattached = $sql->Execute($sql->Prepare("UPDATE hms_patient_labtest SET LT_STATUS = ".$sql->Param('a')." WHERE LT_PACKAGECODE = ".$sql->Param('b')),array('7', $packagecode));
                    print $sql->Errormsg();

                    $msg = "Success! Lab Result has been Attached successfully";
                    $status = "success";
                    // $view ='results';	
        
                    $activity = "Lab result attached by ".$actorname ;
                    $engine->setEventLog("030",$activity);
                    
                    $engine->ClearNotification('0023',$getinserted);
        
                    $description = 'Lab Result is ready for patient ' .$patientname;
                    $notification=$engine->setNotification("027",$description,"0066",$getinserted,$getcode,$faccode);

                    // push notifications
                    $code = '043';
                    $playerid = $obj->PATCON_PLAYERID;
                    $ptitle = 'HEWALE - LAB. RESULTS';
                    $pmessage = 'Dear '.$patientname.', your laboratory test result is ready.';
                    $engine->broadcastIndividualMessage($ptitle,$pmessage,$playerid,$code,'',$largimg='',$bigimg='');
                }
            }

        
            
                

        }else{

            $msg = "Sorry! Fields can't be empty";
            $status = "error";
            $view ='results';	
		
		}
	
	break;

    case 'saveresults':

		$visitcode = $session->get('visitcode');

        print_r($_POST);
        print_r($_FILES);exit;
		
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
                
                $stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_labtest SET LT_LABREMARK =".$sql->Param('1').",LT_STATUS='7' WHERE LT_CODE=".$sql->Param('5')." "),array($remarks,$requestcode));
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
                // $view ='labdetails';	

                $activity = "Lab result attached by ".$actorname ;
                $engine->setEventLog("030",$activity);
                
                $engine->ClearNotification('0023',$getinserted);

                $description = 'Lab Result is ready for patient ' .$patientname;
                $notification=$engine->setNotification("027",$description,"0066",$getinserted,$getcode,$faccode);

            }else{

                $msg = "Sorry! Fields can't be empty";
                $status = "error";
                // $view ='labdetails';	
                
            }
        }else{

            $msg = "Sorry! Fields can't be empty";
            $status = "error";
            // $view ='results';	          
		}	
	
	break;
}


// $stmtlisttestdetails = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_PACKAGECODE = ".$sql->Param('1')." and  LT_STATUS IN ('3','6','8')   "),array($keys));
// print $sql->Errormsg();

$stmtlisttestsampledetails = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_PACKAGECODE = ".$sql->Param('1')." and  LT_STATUS IN ('3','4','8')   "),array($keys));
print $sql->Errormsg();

$stmtlisttestresults = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labresult_files WHERE LTMI_LTCODE = ".$sql->Param('1')." and LTMI_STATUS = ".$sql->Param('2')." "),array($requestcode,'1'));
print $sql->Errormsg();


$stmtspecimen = $sql->Execute($sql->prepare("SELECT * from hmsb_st_labspecimen where SP_STATUS = ".$sql->Param('a').""),array('1'));


if(!empty($fdsearch)){
    $query = "SELECT LTM_VISITCODE,LTM_DATE,LTM_PATIENTNUM,LTM_PATIENTCODE,LTM_PATIENTNAME,LTM_RMK,LTM_ACTORCODE,LTM_ACTORNAME,LTM_INSTCODE,LTM_TOTAL_AMOUNT,LTM_PACKAGECODE FROM hms_patient_labtest_main WHERE LTM_LABCODE = ".$sql->Param('a')." AND LTM_STATUS IN ('3','4','5','6') AND LTM_PAYMENTSTATUS = ".$sql->Param('b')." AND LTM_HOMESERVICE IN ('1','2') AND (LTM_PATIENTNAME LIKE ".$sql->Param('c')." OR LTM_PATIENTNUM LIKE ".$sql->Param('d')." ) ";
    $input = array($faccode, '2','%'.$fdsearch.'%','%'.$fdsearch.'%');
} else {
    $query = "SELECT LTM_VISITCODE,LTM_DATE,LTM_PATIENTNUM,LTM_PATIENTCODE,LTM_PATIENTNAME,LTM_RMK,LTM_ACTORCODE,LTM_ACTORNAME,LTM_INSTCODE,LTM_TOTAL_AMOUNT,LTM_PACKAGECODE FROM hms_patient_labtest_main WHERE LTM_STATUS IN ('3','4','5','6') AND LTM_PAYMENTSTATUS = ".$sql->Param('a')." AND LTM_HOMESERVICE IN ('1','2') AND LTM_LABCODE = ".$sql->Param('b')." ";
    $input = array('2', $faccode);
}


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

?>