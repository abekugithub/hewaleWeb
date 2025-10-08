<?php
$patientCls = new patientClass();
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
            $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient WHERE PATIENT_PATIENTNUM = ".$sql->Param('a').""),array($keys));
            print $sql->ErrorMsg();
            if ($stmt){
                $patient = $stmt->FetchNextObject();
                $patientname = $patient->PATIENT_FNAME.' '.$patient->PATIENT_MNAME.' '.$patient->PATIENT_LNAME;
                $patientdob = $patient->PATIENT_DOB;
                $patientemail = $patient->PATIENT_EMAIL;
                $patientphone = $patient->PATIENT_PHONENUM;
                $patientaddress = $patient->PATIENT_ADDRESS;
				$patientnum = $patient->PATIENT_PATIENTNUM;
                $patientcode = $patient->PATIENT_PATIENTCODE;
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
			
/*
		 
	$stmtpat = $sql->Execute($sql->Prepare("SELECT * FROM hms_consultation WHERE CONS_PATIENTNUM=".$sql->Param('a')." AND CONS_DOCTORCODE=".$sql->Param('b')." "),array($keys, $actor_id));
    print $sql->ErrorMsg();
  
	/*
	 * Check if there was a pending excuse duty
	 */	
	/* $stmtduty = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_excuseduty WHERE EXCD_PATIENTCODE=".$sql->Param('a')." AND EXCD_USRCODE = ".$sql->Param('b')." AND EXCD_STATUS = '0' "),array($patientcode, $actor_id));
	 print $sql->ErrorMsg();
	 if($stmtduty->RecordCount() > 0){
		$objduty = $stmtduty->FetchNextObject();
		$treatment = $objduty->EXCD_TREATTYPE;
		$sickleave = $objduty->EXCD_LEAVEDURATION;
		$startdate = date("d/m/Y",strtotime($objduty->EXCD_REVIEWDATE));
		$patientemail = $objduty->EXCD_PATIENTEMAIL;
		$institutionemail = $objduty->EXCD_INSTITUTIONEMAIL;
	  }
	 //End checking excuse duty			
		*/	
     }
    break;
	
	case "saveduty":
	$postkey = $session->get("postkey");
    if($postkey != $microtime){
	$session->set("postkey",$microtime);
	if(!empty($treatment)){
	   //Get last visit code
	   $stmtcons = $sql->Execute($sql->Prepare("SELECT * FROM hms_consultation WHERE CONS_PATIENTCODE = ".$sql->Param('a')." AND CONS_DOCTORCODE = ".$sql->Param('b')." ORDER BY CONS_ID DESC LIMIT 1 "),array($patientcode,$actor_id));
	   print $sql->ErrorMsg();
	   $objcons = $stmtcons->FetchNextObject();
	   $visitcode = $objcons->CONS_VISITCODE;
	   
	   $startdate = $sql->BindDate($engine->getDateFormat($startdate));
	   
	   $content = "
	   <p><div align='center'><b>EXCUSE DUTY</b></div></p> <br /><br />
	   
	   <p>Ref Mr/Mrs <b>".$patientname."</b>
	   <p>I have examined the above patient today and started him/her on treatment for <b>".$treatment."</b>.</p>
	   <p>Recommended sick leave for ..<strong>".$sickleave."</strong>.. .</p>
	   
	   <p>He/She should report for review on <b>".(!empty($startdate)?date("d/m/Y", strtotime($startdate)):'')."</b>.</p>
	   
	  
	   
	   <p> Yours faithfully, </p>
	   
	   <p><b>Dr. ".$actorname."</b></p>
	   ";
	   
	    $stmtduties = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_excuseduty WHERE EXCD_VISITCODE=".$sql->Param('a')." AND EXCD_STATUS = '0' "),array($visitcode));
		
		if($stmtduties->RecordCount() == 0){
	   //Details Insertion
	   $sql->Execute("INSERT INTO hms_patient_excuseduty(EXCD_USRCODE,EXCD_PATIENTCODE,EXCD_TREATTYPE,EXCD_LEAVEDURATION,EXCD_REVIEWDATE,EXCD_VISITCODE,EXCD_CONTENT,EXCD_PATIENTEMAIL,EXCD_INSTITUTIONEMAIL,EXCD_DATE) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('j').") ",array($actor_id,$patientcode,$treatment,$sickleave,$startdate,$visitcode,$content,$patientemail,$institutionemail,$actudate));
	   
	   //Save Activity
	   $pdetails = $patientCls->getPatientDetails($patientnum); 
	   $activity = 'Excuse Duty Captured for : '.$pdetails->PATIENT_FNAME.' '.$pdetails->PATIENT_MNAME.' '.$pdetails->PATIENT_LNAME.' Code : '.$patientcode.' by Dr.: '.$actorname.' Code : '.$actor_id.' for the following treatment : '.$treatment.' For '.$sickleave. ' days, done on '.$actudate ;
	   print $sql->ErrorMsg();
       $engine->setEventLog('058',$activity);
			 
		}else{
			
			 $sql->Execute("UPDATE hms_patient_excuseduty SET EXCD_TREATTYPE = ".$sql->Param('a')." ,EXCD_LEAVEDURATION = ".$sql->Param('b').",EXCD_REVIEWDATE = ".$sql->Param('d')." ,EXCD_CONTENT  = ".$sql->Param('e')." ,EXCD_PATIENTEMAIL = ".$sql->Param('f')." ,EXCD_INSTITUTIONEMAIL = ".$sql->Param('g')."  WHERE EXCD_VISITCODE = ".$sql->Param('a')." ",array($treatment,$sickleave,$startdate,$content,$patientemail,$institutionemail,$visitcode));
			 
	   //Save Activity
	   $pdetails = $patientCls->getPatientDetails($patientnum); 
	   $activity = 'Excuse Duty updated for : '.$pdetails->PATIENT_FNAME.' '.$pdetails->PATIENT_MNAME.' '.$pdetails->PATIENT_LNAME.' Code : '.$patientcode.' by Dr.: '.$actorname.' Code : '.$actor_id.' for the following treatment : '.$treatment.' For '.$sickleave. ' days, done on '.$actudate ;
	   print $sql->ErrorMsg();
       $engine->setEventLog('058',$activity); 
			
			 }
	  }else{
		   $msg = "Error: Treatment type cannot be left blank.";
	       $status = "Error";
	       $view ='excuseduty';
		  
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
	   $printpath = "public/Doctors/mypatient/views/printexuseduty.php?content=".$content."&patientnum=".$patientnum;
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
        $query = "SELECT * FROM hms_consultation JOIN hms_patient ON CONS_PATIENTNUM=PATIENT_PATIENTNUM WHERE CONS_DOCTORCODE = ".$sql->Param('a')." AND CONS_FACICODE = ".$sql->Param('a')." AND CONS_STATUS IN ('0','8','7','6','5','4','3','2','1') AND ( CONS_PATIENTNAME LIKE ".$sql->Param('b')." OR CONS_PATIENTNUM LIKE ".$sql->Param('c')." ) GROUP BY CONS_PATIENTNUM ORDER BY CONS_INPUTDATE";
        $input = array($actor_id,$facility_code,'%'.$fdsearch.'%',$fdsearch.'%');
    }
}else {

    $query = "SELECT * FROM hms_consultation JOIN hms_patient ON CONS_PATIENTCODE = PATIENT_PATIENTCODE WHERE CONS_DOCTORCODE = ".$sql->Param('a')." AND CONS_FACICODE = ".$sql->Param('a')." AND CONS_STATUS IN ('0','8','7','6','5','4','3','2','1') GROUP BY PATIENT_PATIENTCODE ORDER BY CONS_INPUTDATE";
    $input = array($actor_id,$facility_code);
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