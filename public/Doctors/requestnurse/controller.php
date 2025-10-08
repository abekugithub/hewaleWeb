<?php
// Get Doctor Code
$actor_id = $engine->getActorCode();
// Get Doctor Facility Code
$actor = $engine->getActorDetails();
$actorname = $engine->getActorName();
$facility_code = $actor->USR_FACICODE;
$actudate = date("Y-m-d");


switch ($viewpage){
    case 'reset':
        $fdsearch = '';
        $view = '';
    break;

    case 'viewpatient':
        if (!empty($keys)){
            $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hmsb_vitals_post WHERE VP_USRCODE = ".$sql->Param('a').""),array($keys));
            print $sql->ErrorMsg();
            if ($stmt){
                $nurse = $stmt->FetchNextObject();
                $nursename = $nurse->VP_OTHERNAME.' '.$nurse->VP_SURNAME;
                $patientdob = $nurse->PATIENT_DOB;
                $nurseemail = $nurse->VP_EMAIL;
                $nursephone = $nurse->VP_PHONENO;
                $nurselicense = $nurse->VP_MEDLICENSENO;
                $nursetowncity = $nurse->VP_TOWNCITY;
                $nursepostaladdress = $nurse->VP_POSTALADDRESS;
				$patientnum = $nurse->PATIENT_PATIENTNUM;
                $patientcode = $nurse->PATIENT_PATIENTCODE;
                $patientmar_status = $nurse->PATIENT_MARITAL_STATUS;
                $nursephoto = SHOST_PASSPORT.$nurse->VP_PHOTO;
                $nursenationality = $nurse->VP_NATIONALITY;
                $nursecountryofresidence = $nurse->VP_COUNTRY_OF_RESIDENCE;
                $nursedob = $nurse->VP_DOB;
                $nursemaritalstatus = $nurse->VP_MARITAL_STATUS;
                $nursesummary = $nurse->VP_SUMMARY;
                $nursegender = $nurse->VP_GENDER;
				$nurseplaceofpractice = $nurse->VP_PLACE_OF_PRACTICE;
				$nursecode = $nurse->VP_USRCODE;
            }
        }
    break;
	
	case "savenurserequest":
	$postkey = $session->get("postkey");
    if($postkey != $microtime){
        $session->set("postkey",$microtime);
	    if(!empty($keys)){
	   //Get last visit code
	   $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_nurse_request WHERE NRQ_DOCTOR_CODE = ".$sql->Param('a')." AND NRQ_NURSE_CODE = ".$sql->Param('b')." AND NRQ_STATUS != ".$sql->Param('c')),array($actor_id,$keys,'-1'));
	   print $sql->ErrorMsg();
	   if ($stmt->RecordCount() < 1){
	       $stmt_doc = $sql->Execute($sql->Prepare("SELECT * FROM hmsb_med_prac WHERE MP_USRCODE = ".$sql->Param('1')),array($actor_id));
	       $doc = $stmt_doc->FetchNextObject();
	       $doc_specialty = $doc->MP_SPECIALISATION;
	       $doc_license = $doc->MP_MEDLICENSENO;
	       $stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_nurse_request (NRQ_NURSE_CODE, NRQ_NURSE_NAME, NRQ_DOCTOR_CODE, NRQ_DOCTOR_NAM, NRQ_STATUS, NRQ_SUMMARY, NRQ_DOCTOR_MEDLICENSE, NRQ_DOCTOR_SPECIALTY, NRQ_DATE) VALUES (".$sql->Param('1').", ".$sql->Param('2').", ".$sql->Param('3').", ".$sql->Param('4').", ".$sql->Param('5').", ".$sql->Param('6').", ".$sql->Param('7').", ".$sql->Param('8').", ".$sql->Param('9').")"),array($keys, $nursename, $actor_id, $actorname, '1', '', $doc_license, $doc_specialty, $actudate));
	       print $sql->ErrorMsg();
	       if ($stmt){
	           //Notification
               $desc = "Dr. {$actorname} has requested for Nurse {$nursename} with Code {$nursecode} to be His/Her Nurse for Premium Service.";
               $tablerowid = $sql->insert_Id();
               $engine->setNotification('041',$desc,'0146',$tablerowid,$keys,$facility_code);

	           //Event Log
               $activity = "Dr. {$actorname} has requested for Nurse {$nursename} to be a Nurse on His/Her Premium Service.";
               $engine->setEventLog('118',$activity);

               $msg = "You have successfully requested for Nurse {$nursename} to become your Nurse.";
               $status = "success";
           }else{
	           $msg = "You request for Nurse {$nursename} to become your Nurse was unsuccessful.";
	           $status = 'error';
           }
       }else{
	       $msg = "You have already requested for this Nurse.";
	       $status = 'error';
       }
	}else{
	        $msg = "Error: This Nurse is not a registered Nurse on Hewale.";
	        $status = "error";
	    }
    }
	break;
	
	case "mailexcuseduty":
	if(!empty($visitcode)){
		$objexcdetails = $patientCls->getExcuseDutyDetails($visitcode);
		$to = $objexcdetails->EXCD_PATIENTEMAIL;
		$cc = $objexcdetails->EXCD_INSTITUTIONEMAIL;
		$subject = "Hewale Social Health - Excuse Duty For ".$patientname;
		
		$content = $objexcdetails->EXCD_CONTENT;

		//Send email
		$headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= "From:no-reply@hewale.net" . "\r\n" .
"CC: ".$cc;


        //detect & prevent header injections
        $checkit = "/(content-type|bcc:|cc:|to:)/i";
        foreach ( $_POST as $key => $val ) {
        if ( preg_match( $checkit, $val ) ) {
         exit;
         }
        }

         if (empty($to)) {
			 
           $msg = "Error: Recepient email not well defined.";
	       $status = "Error";
	       $view ='summmaryduty'; 
         } else {
	   
         mail($to,$subject,$content,$headers);
		 if(!empty($cc)){
		 mail($cc,$subject,$content,$headers);
		 }
		 //Update status of send excuse duty
		 $sql->Execute("UPDATE hms_patient_excuseduty SET EXCD_STATUS = '1' WHERE EXCD_VISITCODE = ".$sql->Param('a')." ",array($visitcode));

         //Set event log
		  $activity = 'Excuse Duty mail to : '.$to.' for patient : '.$patientname.' ('.$patientnum.') by Dr.: '.$actorname.'. Mail Content : '.$content ;
	   print $sql->ErrorMsg();
       $engine->setEventLog('060',$activity);  
	   
	   $msg = "Successful. Excuse duty mail successfully.";
	   $status = "success";
	   $view =''; 
}
		
	}
	break;
	
	case "printexcuseduty":
		if(!empty($visitcode)){
		$objexcdetails = $patientCls->getExcuseDutyDetails($visitcode);
		$content = $objexcdetails->EXCD_CONTENT;
		
		 //Update status of send excuse duty
		 $sql->Execute("UPDATE hms_patient_excuseduty SET EXCD_STATUS = '1' WHERE EXCD_VISITCODE = ".$sql->Param('a')." ",array($visitcode));

         //Set event log
		  $activity = 'Excuse Duty printed for patient : '.$patientname.' ('.$patientnum.') by Dr.: '.$actorname.'. Content : '.$content ;
	   print $sql->ErrorMsg();
       $engine->setEventLog('061',$activity);  
	   
	   $msg = "Successful. Excuse duty mail successfully.";
	   $status = "success";
	   $view =''; 
	   $printpath = "public/Doctors/mypatient/views/printexuseduty.php?content=".$content."&patientnum=".$patientnum."&verifcode=".md5($visitcode);
	echo '<iframe allowtransparency="1" frameborder="0" src="'.$printpath.'" id="printframe" name="printframe" style="display:none"></iframe>';   
	echo "<script type='text/javascript' >
	       clicktoPrint();
	 </script>";
	}
	break;
	
	case "searchpatlist":
	
		if (!empty ($startdate)) {
		
		$stmtpat = $sql->Execute($sql->Prepare("SELECT * FROM hms_consultation WHERE CONS_DOCTORNAME LIKE ".$sql->Param('a')."  "),array('%'.$startdate.'%'));
		
		}
		
		
		 if (!empty($keys)){
            $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient WHERE PATIENT_PATIENTNUM=".$sql->Param('a')." "),array($keys));
            print $sql->ErrorMsg();
            if ($stmt){
                $patient = $stmt->FetchNextObject();
                $patientname = $patient->PATIENT_FNAME.' '.$patient->PATIENT_MNAME.' '.$patient->PATIENT_LNAME;
                $patientdob = $patient->PATIENT_DOB;
                $patientemail = $patient->PATIENT_EMAIL;
                $patientphone = $patient->PATIENT_PHONENUM;
                $patientaddress = $patient->PATIENT_ADDRESS;
                $patientcode = $patient->PATIENT_PATIENTNUM;
                $patientmar_status = $patient->PATIENT_MARITAL_STATUS;
                $patientphoto = SHOST_PASSPORT.$patient->PATIENT_IMAGE;
                $patientnation = $patient->PATIENT_NATIONALITY;
                $patientbloodgrp = $patient->PATIENT_BLOODGROUP;
                $patientalergy = $patient->PATIENT_ALLERGIES;
                $patientchronic = $patient->PATIENT_CHRONIC_CONDITION;
                $patientgender = $patient->PATIENT_GENDER;
				$patientheight = $patient->PATIENT_HEIGHT;
				$patientweight = $patient->PATIENT_WEIGHT;
            }
			
			 /*$stmtpat = $sql->Execute($sql->Prepare("SELECT * FROM hms_consultation WHERE CONS_PATIENTNUM=".$sql->Param('a')." ORDER BY CONS_CODE DESC LIMIT 5"),array($keys));*/
			
			 $stmtpat = $sql->Execute($sql->Prepare("SELECT * FROM hms_consultation WHERE CONS_PATIENTNUM=".$sql->Param('a')."  "),array($keys));
    print $sql->ErrorMsg();
    if ($stmtpat){
        return $stmtpat;
    }
			
			
        }
	
	
	
	break;
	
	
	case 'viewpatientback':
		//echo $actor_id;exit;
	
        if (!empty($keys)){
            $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient WHERE PATIENT_PATIENTNUM=".$sql->Param('a').""),array($newkeys));
            print $sql->ErrorMsg();
            if ($stmt){
                $patient = $stmt->FetchNextObject();
                $patientname = $patient->PATIENT_FNAME.' '.$patient->PATIENT_MNAME.' '.$patient->PATIENT_LNAME;
                $patientdob = $patient->PATIENT_DOB;
                $patientemail = $patient->PATIENT_EMAIL;
                $patientphone = $patient->PATIENT_PHONENUM;
                $patientaddress = $patient->PATIENT_ADDRESS;
                $patientcode = $patient->PATIENT_PATIENTNUM;
                $patientmar_status = $patient->PATIENT_MARITAL_STATUS;
                $patientphoto = SHOST_PASSPORT.$patient->PATIENT_IMAGE;
                $patientnation = $patient->PATIENT_NATIONALITY;
                $patientbloodgrp = $patient->PATIENT_BLOODGROUP;
                $patientalergy = $patient->PATIENT_ALLERGIES;
                $patientchronic = $patient->PATIENT_CHRONIC_CONDITION;
                $patientgender = $patient->PATIENT_GENDER;
				$patientheight = $patient->PATIENT_HEIGHT;
				$patientweight = $patient->PATIENT_WEIGHT;
            }
			
			 /*$stmtpat = $sql->Execute($sql->Prepare("SELECT * FROM hms_consultation WHERE CONS_PATIENTNUM=".$sql->Param('a')." ORDER BY CONS_CODE DESC LIMIT 5"),array($keys));*/
		
			 $stmtpat = $sql->Execute($sql->Prepare("SELECT * FROM hms_consultation WHERE CONS_PATIENTNUM=".$sql->Param('a')." AND CONS_DOCTORCODE=".$sql->Param('b')." "),array($newkeys, $actor_id));
    print $sql->ErrorMsg();
    if ($stmtpat){
        return $stmtpat;
    }
			
			
        }
    break;
	
	
	case "viewmedicals":
	
		$stmtdiagnosis = $sql->Execute($sql->Prepare("SELECT DIA_DIAGNOSIS from hms_patient_diagnosis WHERE DIA_VISITCODE=".$sql->Param('a')."  "),array($newkeys));
    print $sql->ErrorMsg();
	$pathistory = $stmtdiagnosis->FetchNextObject();
	$diagnosishes = $pathistory->DIA_DIAGNOSIS;
		
	$stmtlab = $sql->Execute($sql->Prepare("SELECT LT_TESTNAME from hms_patient_labtest WHERE LT_VISITCODE=".$sql->Param('a')."  "),array($newkeys));
    print $sql->ErrorMsg();
	$patlab = $stmtlab->FetchNextObject();
	$labshes = $patlab->LT_TESTNAME;
	
	$stmtpres = $sql->Execute($sql->Prepare("SELECT PRESC_DRUG from hms_patient_prescription WHERE PRESC_VISITCODE=".$sql->Param('a')."  "),array($newkeys));
    print $sql->ErrorMsg();
	$patpres = $stmtpres->FetchNextObject();
	$patpresc = $patpres->PRESC_DRUG;
	
	
	
	$stmtpat = $sql->Execute($sql->Prepare("SELECT * FROM hms_consultation WHERE CONS_PATIENTNUM=".$sql->Param('a')." AND CONS_DOCTORCODE=".$sql->Param('b')." "),array($newkeys, $actor_id));
    print $sql->ErrorMsg();
    if ($stmtpat){
        return $stmtpat;
    }
		
	
	break;
	
	case "searchpatlist":

	$stmtpat = $sql->Execute($sql->Prepare("SELECT * FROM hms_consultation WHERE CONS_PATIENTNUM=".$sql->Param('a')." AND CONS_DOCTORCODE=".$sql->Param('b')." "),array($newkeys, $actor_id));
    print $sql->ErrorMsg();
    if ($stmtpat){
        return $stmtpat;
    }
	
	
	
	
	break;
	
	
}

if(isset($action_search) && $action_search == "search"){
    if(!empty($fdsearch)){
        $query = "SELECT USR_CODE,CONCAT(USR_SURNAME,' ',USR_OTHERNAME) USR_FULLNAME,USR_PHONENO,VP_LOCATION,VP_RESIDENCEADDRESS,VP_PLACE_OF_PRACTICE,VP_GENDER,VP_USRCODE,VP_MEDLICENSENO FROM hms_users JOIN hmsb_vitals_post ON USR_CODE=VP_USRCODE WHERE USR_STATUS = ".$sql->Param('a')." AND USR_TYPE = ".$sql->Param('b')." AND ( USR_SURNAME LIKE ".$sql->Param('c')." OR USR_OTHERNAME LIKE ".$sql->Param('d')." OR USR_PHONENO LIKE ".$sql->Param('e')." ) ";
        $input = array('1','6','%'.$fdsearch.'%',$fdsearch.'%',$fdsearch.'%');
    }
}else {

    $query = "SELECT USR_CODE,CONCAT(USR_SURNAME,' ',USR_OTHERNAME) USR_FULLNAME,USR_PHONENO,VP_LOCATION,VP_RESIDENCEADDRESS,VP_PLACE_OF_PRACTICE,VP_GENDER,VP_USRCODE,VP_MEDLICENSENO FROM hms_users JOIN hmsb_vitals_post ON USR_CODE=VP_USRCODE WHERE USR_STATUS = ".$sql->Param('a')." AND USR_TYPE = ".$sql->Param('a')." ";
    $input = array('1','6');
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