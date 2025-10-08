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
$memberdetails=new patientClass();
$engine->getTotalNotification('071',$faccode);

switch ($viewpage){
    case 'signoff':
        if(!empty($keys)){
            $stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_xraytest SET XT_STATUS='7' WHERE XT_CODE=".$sql->Param('5')." "),array($keys));
            print $sql->ErrorMsg();

            $stmtlist = $sql->Execute($sql->Prepare("SELECT XT_ID,XT_PATIENTNUM,XT_PATIENTCODE,XT_TEST FROM hms_patient_xraytest WHERE XT_CODE = ".$sql->Param('2')." "),array($keys));
            print $sql->ErrorMsg();
            $obj1=$stmtlist->FetchNextObject();
            $getinserted=$obj1->XT_ID;
            $patientno=$obj1->XT_PATIENTNUM;
            $patient_code=$obj1->XT_PATIENTCODE;
            $prescriber_code=$obj1->XT_ACTORCODE;
            $testcode = $encaes->decrypt($obj1->XT_TEST);

            //  Get Prescribers Facility Code
            $stmt_prescriber = $sql->Execute($sql->Prepare("SELECT USR_FACICODE FROM hms_users WHERE USR_CODE=".$sql->Param('a')),array($prescriber_code));
            if ($stmt_prescriber){
                $prescriber_facicode = $stmt_prescriber->FetchNextObject()->USR_FACICODE;
            }else{
                $prescriber_facicode = '';
            }

            // Get Test Amount
            $stmt_amount = $sql->Execute($sql->Prepare("SELECT XP_PRICE FROM hms_xray_testprice WHERE XP_TESTCODE=".$sql->Param('a')." AND XP_FACICODE=".$sql->Param('b')),array($testcode,$faccode));
            print $sql->ErrorMsg();
            if ($stmt_amount){
                $amount = $stmt_amount->FetchNextObject()->XP_PRICE;
            }else{
                $amount = '';
            }

            $msg = "Success! X-ray Result has been successfully signed off";
            $status = "success";
            $viewpage ='';
            $activity = "X-ray result signed off by ".$actorname ;
            $engine->setEventLog("111",$activity);

            //  Notification to Prescriber (Doctor)
            $description='Patient X-ray Result ready for patient with Hewale No.' .$patientno;
            $engine->setNotification("036",$description,"0131",$getinserted,$prescriber_code,$prescriber_facicode);

            //  Notification to Patient
            $description='Your X-ray Result is ready.';
            $engine->setNotification("036",$description,'0126',$getinserted,$patient_code,'');

            // Receive Payment
            $engine->getFacilityPercentage($patient_code,$amount,$faccode);
        }

        break;

     case 'patientdetails':
        if (!empty($keys)){
            $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_xraytest JOIN hms_patient ON XT_PATIENTCODE=PATIENT_PATIENTCODE WHERE XT_CODE = ".$sql->Param('a')),array($keys));
            print $sql->ErrorMsg();
            if ($stmt){
                $obj = $stmt->FetchNextObject();
                $patientname = $obj->XT_PATIENTNAME;
                $hewalenum = $obj->XT_PATIENTNUM;
                $code = $obj->XT_CODE;
				$xrayid = $obj->XT_ID;
                $visitcode = $obj->XT_VISITCODE;
                $patientdob = $sql->UserDate($obj->PATIENT_DOB,'d-m-Y');
                $testname = $encaes->decrypt($obj->XT_TESTNAME);
                $email = $obj->PATIENT_EMAIL;
                $phonenum = $obj->PATIENT_PHONENUM;
				$xtcode = $obj->XT_CODE;
				$comment = $obj->XT_DOC_COMMENT;
				
				 //Ifram path
				 $printpath="public/dcomviewer/viewer.php?visitcode=".$visitcode.'&keys='.$xtcode;
            }
			
			   $stmtcons = $sql->Execute($sql->Prepare("SELECT CONS_CODE FROM hms_consultation WHERE CONS_VISITCODE = ".$sql->Param('a')),array($visitcode));
			   $objcons = $stmtcons->FetchNextObject();
			   $consultcode = $objcons->CONS_CODE;
            print $sql->ErrorMsg();
        }
    break;
	
    case 'reset':
        $fdsearch = '';
        $view = '';
    break;
}

if(isset($action_search) && $action_search == "search"){
    if(!empty($fdsearch)){

        $query = "SELECT * FROM hms_patient_xraytest WHERE XT_STATUS = '4' AND (XT_PATIENTNUM = ".$sql->Param('a')." OR ( XT_TESTNAME LIKE ".$sql->Param('b')." OR XT_PATIENTNAME LIKE ".$sql->Param('c')." OR XT_TEST LIKE ".$sql->Param('d')." OR XT_ACTORNAME = ".$sql->Param('e').")) ORDER BY XT_INPUTEDDATE DESC";
        $input = array($fdsearch,$fdsearch.'%',$fdsearch.'%',$fdsearch.'%',$fdsearch);

    }
}else{
    $query = "SELECT * FROM hms_patient_xraytest WHERE XT_STATUS = ".$sql->Param('1')." AND XT_LABCODE = ".$sql->Param('2');
    $input = array('4',$faccode);
}
if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=e684d8eeee72ed2583865b78e8d3f57a&option=29b2eb4e9498262f90a3afafc3955b54#',$input);
//include("model/js.php");