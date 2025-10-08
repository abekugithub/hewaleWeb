<?php
$patientCls = new patientClass();
// Get Doctor Code
$actor_id = $engine->getActorCode();
// Get Doctor Facility Code
$actor = $engine->getActorDetails();
$actorname = $engine->getActorName();
$facility_code = $actor->USR_FACICODE;
$vhgroupcode = $actor->USR_VHGP_CODE;
$usertype = $actor->USR_TYPE; 
$actudate = date("Y-m-d");

switch ($viewpage){
	  case 'patientdetails':
        if (!empty($keys)){
            $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_xraytest JOIN hms_patient ON XT_PATIENTCODE=PATIENT_PATIENTCODE WHERE XT_CODE = ".$sql->Param('a')),array($vkey));
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

    case 'details':
        $stmt = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_xraytest_main WHERE XTM_VISITCODE = ".$sql->Param('1')." AND XTM_STATUS != ".$sql->Param('2')." "),array($keys,'0'));
        print $sql->Errormsg();


        if($stmt->Recordcount() > 0){

            $obj = $stmt->FetchNextObject();
            $patient = $obj->XTM_PATIENTNAME;
            $patientnum = $obj->XTM_PATIENTNUM;
            $patientcode = $obj->XTM_PATIENTCODE;
            $packagecode = $obj->XTM_PACKAGECODE;
            $patientdate = $obj->XTM_DATE;
            $medic = $obj->XTM_ACTORNAME;
            $labname =$obj->XTM_LABNAME;
            $Total  = $obj->XTM_TOTAL_AMOUNT;
            $patientdob = $patientCls->getPatientDetails($patientnum)->PATIENT_DOB;
            $patientcontact = $patientCls->getPatientDetails($patientnum)->PATIENT_PHONENUM;
            $patientage = $engine->calculateAge($patientdob);
            $patientgender = !empty($patientCls->getPatientDetails($patientnum)->PATIENT_GENDER)?($patientCls->getPatientDetails($patientnum)->PATIENT_GENDER == 'M' || $patientCls->getPatientDetails($patientnum)->PATIENT_GENDER == 'Male')?'Male':'Female':'N/A';
        }
        $stmtlisttestdetails = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_xraytest WHERE XT_VISITCODE = ".$sql->Param('1')." AND XT_STATUS != ".$sql->Param('2')." "),array($keys,'0'));
        print $sql->Errormsg();

    break;


    case "savexrayresult":
	if(!empty($keys) && !empty($comment)){
	
		$sql->Execute("UPDATE hms_patient_xraytest SET XT_DOC_COMMENT = ".$sql->Param('a')." WHERE XT_ID = ".$sql->Param('b')." ",array($comment,$keys));
		print $sql->ErrorMsg();
	    $msg = "X-Ray analysis saved Successfully.";
	    $status = "success";
		$engine->ClearNotification('0131',$keys);
        $activity = "X-Ray analysis entered by doctor ".$actorname;
		$engine->setEventLog("112",$activity);
	}
	break;
	
	 case 'reset':
        $fdsearch = '';
        $view = '';
    break;
	
}

if(isset($action_search) && $action_search == "search"){
    if(!empty($fdsearch)){
        if($usertype == 7){ 
            $query = "SELECT * FROM hms_patient_xraytest_main JOIN hmsb_vhealthunit ON XTM_INSTCODE = VHSUBDET_FACICODE WHERE VHSUBDET_MENUGPCODE = ".$sql->Param('a')." AND ( XTM_PATIENTNAME LIKE ".$sql->Param('c')." OR XTM_PATIENTNUM LIKE ".$sql->Param('d')." ) ";
            $input = array($vhgroupcode,'%'.$fdsearch.'%',$fdsearch.'%');
        }else{
        $query = "SELECT * FROM hms_patient_xraytest_main WHERE XTM_ACTORCODE = ".$sql->Param('a')." AND XTM_INSTCODE = ".$sql->Param('b')." AND (XTM_PATIENTNAME LIKE ".$sql->Param('c')." OR XTM_PATIENTNUM LIKE ".$sql->Param('d')." ) ";
        $input = array($actor_id,$facility_code,'%'.$fdsearch.'%',$fdsearch.'%');
        }
    }
}else {
    if($usertype == 7){ 
        $query = "SELECT * FROM hms_patient_xraytest_main JOIN hmsb_vhealthunit ON XTM_INSTCODE = VHSUBDET_FACICODE WHERE VHSUBDET_MENUGPCODE = ".$sql->Param('a')." AND XTM_STATUS <> '0'";
        $input = array($vhgroupcode);
    }else{
    $query = "SELECT * FROM hms_patient_xraytest_main WHERE XTM_ACTORCODE = ".$sql->Param('a')." AND XTM_INSTCODE = ".$sql->Param('b')." AND XTM_STATUS <> '0'";
    $input = array($actor_id,$facility_code);
    }
}


if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=f77ccbdb203c19d3d52b12a85f33faf5&option=426e56edae3068a1337fc71a897eb4ab&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);