<?php
$crypt = new cryptCls();
$actorid = $session->get("userid");
$actorname = $engine->getActorName();
$actorgroup = $engine->getUsergroup();
$patientCls = new patientClass();

$actudate = date("Y-m-d H:m:s");
$objdtls = $engine->getFacilityDetails();
$facilityalias = $objdtls->FACI_ALIAS ;
$actorcode = $engine->getActorCode();

switch($viewpage){
	case "confirmbooking":
	$duplicatekeeper = $session->get("post_key");
	if($microtime != $duplicatekeeper){
		if(isset($keys) && !empty($keys)){
			  //$startdate = $sql->BindDate($engine->getDateFormat($startdate));
			  //Get request details
			  $objrequst = $patientCls->getServRequestDetail($keys);
			  //Get Consultation Code
			  $consltcode = $patientCls->getConsultCode($activeinstitution);
			  //Generate visit code
			  //$visitcode = $patientCls->getVisitCode($activeinstitution,$objrequst->REQU_PATIENTNUM);
			  
			  //get the default service if private pratitioner
			  if($objrequst->REQU_FACI_CODE == 1){
			  $objsrv = $engine->getDefaultService();
			  }
		      //Insert value in consultation table
			  $sql->Execute("INSERT INTO hms_consultation(CONS_CODE,CONS_REQUCONFIRMDATE,CONS_PATIENTNUM,CONS_PATIENTNAME,CONS_REQUCODE,CONS_DOCTORNAME,CONS_DOCTORCODE,CONS_FACICODE,CONS_VISITCODE,CONS_SERVICENAME,CONS_SERVICECODE,CONS_SCHEDULEDATE,CONS_SCHEDULETIME,CONS_PATIENTCODE,CONS_PAYSTATE,CONS_DATE) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('j').",".$sql->Param('k').",".$sql->Param('l').",".$sql->Param('m').",".$sql->Param('n').",".$sql->Param('o').",".$sql->Param('p').") ",array($consltcode,$actudate,$objrequst->REQU_PATIENTNUM,$objrequst->REQU_PATIENT_FULLNAME,$objrequst->REQU_CODE,$objrequst->REQU_DOCTORNAME,$objrequst->REQU_DOCTORCODE,$objrequst->REQU_FACI_CODE,$objrequst->REQU_VISITCODE,$objrequst->REQU_SERVICENAME,$objrequst->REQU_SERVICECODE,$objrequst->REQU_APPOINTDATE,$objrequst->REQU_APPOINTTIME,$objrequst->REQU_PATIENTCODE,'2',date('Y-m-d')));	
			  print $sql->ErrorMsg();
			  
			  //$newtablerowid = $sql->Insert_ID();
			  
			   $newtablerowid = '';
			  
			  //Update service request
			 $sql->Execute("UPDATE hms_service_request SET REQU_CONFIRMDATE = ".$sql->Param('a').",REQU_STATUS ='2',REQU_APPOINTDATE = ".$sql->Param('b').",REQU_APPOINTTIME = ".$sql->Param('c')." WHERE REQU_CODE = ".$sql->Param('d')." ",array($actudate,$startdate,$inputtime,$keys));
			  
			 $activity = 'Patient confirm for consultation. The details are : Patient Name '.$objrequst->REQU_PATIENT_FULLNAME.' Patient Number '.$objrequst->REQU_PATIENTNUM.' Doctor Code : '.$objrequst->REQU_DOCTORCODE.' Visit Code : '.$objrequst->REQU_VISITCODE.' Date '.$actudate;
             $engine->setEventLog('004',$activity);
			 
		     $msg = "Success: Patient confirmed for consultation.";
	         $status = "success";
	         $view ='';
			 
			//Clear notification
		    $menudetailscode = '0244';
		    $tablerowid = $objrequst->REQU_ID;
			
		    $engine->ClearNotification($menudetailscode,$tablerowid);
			
			//Set Notification
			$code = '021';
		    $menudetailscodenew = '0005';
			$desc = "Dear ".$objrequst->REQU_PATIENT_FULLNAME." your consultation was confirmed for ".$objrequst->REQU_APPOINTDATE." at ".$objrequst->REQU_APPOINTTIME;
			$sentto = $objrequst->REQU_DOCTORCODE;
			$engine->setNotification($code,$desc,$menudetailscodenew,$newtablerowid,$sentto);
			
			     //Push notification
				 $patientobj = $patientCls->getPatientDetails($objrequst->REQU_PATIENTNUM);
				 $playerid = $patientobj->PATCON_PLAYERID;
		         $ptitle = push_notif_title; 
				 $pmessage = $engine->getPushMessage($code);
				 $pmessage = $pmessage.' on '.$objrequst->REQU_APPOINTDATE.' at '.$objrequst->REQU_APPOINTTIME;
				 $engine->broadcastIndividualMessage($ptitle,$pmessage,$playerid,$code,'',$largimg='',$bigimg='');
				 //sms to patient
				 $patientphoneno = $sms->validateNumber($patientobj->PATCON_PHONENUM,'+233');
				 $sms->sendSms($patientphoneno,$desc);
		         //End push notification
				
		}
	}
    break;
	case "consult":
	
	$duplicatekeeper = $session->get("post_key");
	if($microtime != $duplicatekeeper){
		if(isset($keys) && !empty($keys)){
			  //Get request details
			  $objrequst = $patientCls->getServRequestDetail($keys);
			  //Get Consultation Code
			  $consltcode = $patientCls->getConsultCode($activeinstitution);
			  
			  if(empty($startdate)){
				$startdate = $objrequst->REQU_APPOINTDATE ;
				$inputtime = $objrequst->REQU_APPOINTTIME ;
			  }else{
				  $startdate = $sql->BindDate($engine->getDateFormat($startdate));
			  }

			  //Generate visit code
			  //$visitcode = $patientCls->getVisitCode($activeinstitution,$objrequst->REQU_PATIENTNUM);
			  
			  //get the default service if private pratitioner
			  if($objrequst->REQU_FACI_CODE == 1){
			  $objsrv = $engine->getDefaultService();
			  }
		      //Insert value in consultation table
			 $sql->Execute("INSERT INTO hms_consultation(CONS_CODE,CONS_REQUCONFIRMDATE,CONS_PATIENTNUM,CONS_PATIENTNAME,CONS_REQUCODE,CONS_DOCTORNAME,CONS_DOCTORCODE,CONS_FACICODE,CONS_VISITCODE,CONS_SERVICENAME,CONS_SERVICECODE,CONS_SCHEDULEDATE,CONS_SCHEDULETIME,CONS_PATIENTCODE,CONS_PAYSTATE,CONS_DATE) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('j').",".$sql->Param('k').",".$sql->Param('l').",".$sql->Param('m').",".$sql->Param('n').",".$sql->Param('o').",".$sql->Param('p').") ",array($consltcode,$actudate,$objrequst->REQU_PATIENTNUM,$objrequst->REQU_PATIENT_FULLNAME,$objrequst->REQU_CODE,$objrequst->REQU_DOCTORNAME,$objrequst->REQU_DOCTORCODE,$objrequst->REQU_FACI_CODE,$objrequst->REQU_VISITCODE,$objrequst->REQU_SERVICENAME,$objrequst->REQU_SERVICECODE,$startdate,$inputtime,$objrequst->REQU_PATIENTCODE,'2',date('Y-m-d')));	
			  print $sql->ErrorMsg();
			  
			  //$newtablerowid = $sql->Insert_ID();
			  
			   $newtablerowid = '';
		
			  //Update service request
			 $sql->Execute("UPDATE hms_service_request SET REQU_CONFIRMDATE = ".$sql->Param('a').",REQU_STATUS ='2',REQU_APPOINTDATE = ".$sql->Param('b').",REQU_APPOINTTIME = ".$sql->Param('c')." WHERE REQU_CODE = ".$sql->Param('d')." ",array($actudate,$startdate,$inputtime,$keys));
			 print $sql->ErrorMsg();
			  
			 $activity = 'Patient confirm for consultation. The details are : Patient Name '.$objrequst->REQU_PATIENT_FULLNAME.' Patient Number '.$objrequst->REQU_PATIENTNUM.' Doctor Code : '.$objrequst->REQU_DOCTORCODE.' Visit Code : '.$objrequst->REQU_VISITCODE.' Date '.$actudate;
             $engine->setEventLog('004',$activity);
			 
		     $msg = "Success: Patient confirmed for consultation.";
	         $status = "success";
	         $view ='';
			 
			//Clear notification
		    $menudetailscode = '0244';
		    $tablerowid = $objrequst->REQU_ID;
			
		    $engine->ClearNotification($menudetailscode,$tablerowid);
			
			//Set Notification
			$code = '021';
		    $menudetailscodenew = '0005';
			$desc = "You have been scheduled for consultation on $startdate at $inputtime.' by Dr.  '.$objrequst->REQU_DOCTORNAME ";
			$sentto = $objrequst->REQU_DOCTORCODE;
			$engine->setNotification($code,$desc,$menudetailscodenew,$newtablerowid,$sentto);
			
			
			     //Push notification
				 $patientobj = $patientCls->getPatientDetails($objrequst->REQU_PATIENTNUM);
				 $playerid = $patientobj->PATCON_PLAYERID;
		         $ptitle = push_notif_title; 
				 $pmessage = $engine->getPushMessage($code);
				 $pmessage = $pmessage.' on '.$startdate.' at '.$inputtime;
				 $engine->broadcastIndividualMessage($ptitle,$pmessage,$playerid,$code,'',$largimg='',$bigimg='');
				 //sms to patient
				 $patientphoneno = $sms->validateNumber($patientobj->PATCON_PHONENUM,'+233');
				 $sms->sendSms($patientphoneno,$pmessage);
		         //End push notification
				
		}
	}
	break;


	case "patientdetails":
	
	$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_service_request JOIN hms_patient ON REQU_PATIENTNUM=PATIENT_PATIENTNUM WHERE REQU_PATIENTNUM = " . $sql->Param('a') . " AND REQU_STATUS IN ('6','5','4','3','2','1','7') "), array($keys));
    print $sql->ErrorMsg();
    if ($stmt) {
        while ($obj = $stmt->FetchNextObj()) {
			
			
			
            $patientname = $obj->REQU_PATIENT_FULLNAME;
            $dob = $obj->PATIENT_DOB;
            $email = $obj->PATIENT_EMAIL;
            $phonenumber = $obj->PATIENT_PHONENUM;
            $postaladdress=$obj->PATIENT_POSTALADDRESS;
            $residential = $obj->PATIENT_ADDRESS;
            $allegy     = $obj->PATIENT_ALLERGIES;
            $chronic_condition = $obj->PATIENT_CHRONIC_CONDITION;
            $patientphoto = SHOST_PASSPORT.$obj->PATIENT_IMAGE;

        }
    }
$stmtpat = $sql->Execute($sql->Prepare("SELECT * FROM hms_consultation WHERE CONS_PATIENTNUM=".$sql->Param('a')." ORDER BY 
	CONS_CODE DESC LIMIT 5"),array($keys));
	
	break;
	
	
	case "viewmedicals":
	
	$stmtdiagnosis = $sql->Execute($sql->Prepare("SELECT DIA_DIAGNOSIS from hms_patient_diagnosis WHERE DIA_VISITCODE=".$sql->Param('a')."  "),array($keys));
    print $sql->ErrorMsg();
	$pathistory = $stmtdiagnosis->FetchNextObject();
	$diagnosishes = $pathistory->DIA_DIAGNOSIS;
		
	$stmtlab = $sql->Execute($sql->Prepare("SELECT LT_TESTNAME from hms_patient_labtest WHERE LT_VISITCODE=".$sql->Param('a')."  "),array($keys));
    print $sql->ErrorMsg();
	$patlab = $stmtlab->FetchNextObject();
	$labshes = $patlab->LT_TESTNAME;
	
	$stmtpres = $sql->Execute($sql->Prepare("SELECT PRESC_DRUG from hms_patient_prescription WHERE PRESC_VISITCODE=".$sql->Param('a')."  "),array($keys));
    print $sql->ErrorMsg();
	$patpres = $stmtpres->FetchNextObject();
	$patpresc = $patpres->PRESC_DRUG;
	
	break;

	
	case "resetpwd":
	if(isset($keys) && !empty($keys))
	{}
	break;
	
	case "deleteuser":
	  if(isset($keys) && !empty($keys)){}
	break;
	
	case "reset":
	   $fdsearch = $action_search = "";
	break;
}

if(isset($action_search) && $action_search == "search"){
	if(!empty($fdsearch)){
    $query = "SELECT * FROM hms_service_request WHERE REQU_FACI_CODE = ".$sql->Param('a')." AND REQU_DOCTORCODE = ".$sql->Param('a')." AND REQU_STATUS = '1' AND ( REQU_PATIENT_FULLNAME LIKE ".$sql->Param('b')." OR REQU_PATIENTNUM LIKE ".$sql->Param('c')." )";
    $input = array($activeinstitution,$actorcode,'%'.$fdsearch.'%',$fdsearch.'%');
	}
}else { 
    $query = "SELECT * FROM hms_service_request WHERE REQU_FACI_CODE = ".$sql->Param('a')." AND REQU_DOCTORCODE = ".$sql->Param('a')." AND REQU_STATUS = '1' ";
    $input = array($activeinstitution,$actorcode);
}
if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=f77ccbdb203c19d3d52b12a85f33faf5&option=f6383c07b345b6560d170c5e09bea356&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);

//Get all positions
$stmtpos2 = $engine->getUserPosition();
?>