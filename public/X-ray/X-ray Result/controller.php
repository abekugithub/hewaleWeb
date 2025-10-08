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

//include SPATH_LIBRARIES.DS."upload.Class.php";

$import = new importClass();

switch ($viewpage){
    case 'patientdetails':
        if (!empty($keys)){
            $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_xraytest JOIN hms_patient ON XT_PATIENTCODE=PATIENT_PATIENTCODE WHERE XT_CODE = ".$sql->Param('a')),array($keys));
            print $sql->ErrorMsg();
            if ($stmt){
                $obj = $stmt->FetchNextObject();
                $patientname = $obj->XT_PATIENTNAME;
                $hewalenum = $obj->XT_PATIENTNUM;
                $code = $obj->XT_CODE;
                $visitcode = $obj->XT_VISITCODE;
                $patientdob = $sql->UserDate($obj->PATIENT_DOB,'d-m-Y');
                $testname = $encaes->decrypt($obj->XT_TESTNAME);
                $email = $obj->PATIENT_EMAIL;
                $phonenum = $obj->PATIENT_PHONENUM;
            }
        }
    break;

	case 'savexrayresult':
//        print_r($_FILES['xrayimage']);
        if (isset($keys) && !empty($keys)){
            if (!empty($_FILES['xrayimage']['name'])){
	            $xrayresult = $import->uploadImage($_FILES['xrayimage'],SHOST_XRAYRESULT);
                $stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_xraytest SET XT_LABRESULT=".$sql->Param('a').", XT_LABREMARK=".$sql->Param('a').", XT_STATUS=".$sql->Param('a')." WHERE XT_CODE=".$sql->Param('a')),array($xrayresult,$comment,'4',$keys));
                print $sql->ErrorMsg();

                if ($stmt){
                    $insert_id = $sql->Insert_Id();
                    //  Event log
                    $eventype = '108';
                    $activity = 'X-ray Result for Patient with x-ray code '.$keys.' has been uploaded by facility with facility code '.$faccode;
                    $engine->setEventLog($eventype,$activity);

                    // Notification
                    $code = '036';
                    $desc = 'Patient X-ray Result Ready, awaiting Sign-off';
                    $engine->setNotification($code,$desc,'071',$insert_id,$faccode,$faccode);

                    $msg = 'X-ray Result saved successfully.';
                    $status = 'success';
                }else{
                    $msg = 'There was an trying to save patient\'s x-ray result';
                    $status = 'error';
                }
            }else{
	            $msg = 'Select an X-ray Result or Image to upload.';
	            $status = 'error';
            }
        }else{
            $msg = 'Keys is empty.';
            $status = 'error';
        }
	break;

    case 'reset':
        $fdsearch = '';
        $view = '';
    break;
}
		
if(isset($action_search) && $action_search == "search"){
    if(!empty($fdsearch)){
    $query = "SELECT * FROM hms_patient_xraytest WHERE XT_STATUS = '3' AND (XT_PATIENTNUM = ".$sql->Param('a')." OR XT_TESTNAME LIKE ".$sql->Param('b')." OR XT_PATIENTNAME LIKE ".$sql->Param('c')." OR XT_TEST LIKE ".$sql->Param('d')." OR XT_ACTORNAME = ".$sql->Param('e').") ORDER BY XT_INPUTEDDATE DESC";
    $input = array($fdsearch,'%'.$fdsearch.'%',$fdsearch.'%',$fdsearch.'%',$fdsearch,);
    }
}else{
    $query = "SELECT * FROM hms_patient_xraytest where XT_STATUS = ".$sql->Param('1')." AND XT_LABCODE = ".$sql->Param('2');
    $input = array('3',$faccode);
}

if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=ad2376beebecdcf7846ba973fa1a005b&option=6831b98f85019ddb98bd98d44bdbac40#',$input);