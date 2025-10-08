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
			 
	$stmtpat = $sql->Execute($sql->Prepare("SELECT * FROM hms_consultation WHERE CONS_PATIENTNUM=".$sql->Param('a')." AND CONS_DOCTORCODE=".$sql->Param('b')." ORDER BY CONS_ID DESC "),array($keys, $actor_id));
    print $sql->ErrorMsg();

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
	   $sql->Execute("INSERT INTO hms_patient_excuseduty(EXCD_USRCODE,EXCD_PATIENTCODE,EXCD_TREATTYPE,EXCD_LEAVEDURATION,EXCD_REVIEWDATE,EXCD_VISITCODE,EXCD_CONTENT,EXCD_PATIENTEMAIL,EXCD_INSTITUTIONEMAIL,EXCD_DATE,EXCD_VERIFICATIONCODE) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('j').",".$sql->Param('k').") ",array($actor_id,$patientcode,$treatment,$sickleave,$startdate,$visitcode,$content,$patientemail,$institutionemail,$actudate,md5($visitcode)));
	   print $sql->ErrorMsg();
	   
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
	
	
	case "acceptpatient":
	if(!empty($keys)){
	   $sql->Execute("UPDATE hms_patient_premium SET PREMSERV_STATUS = '1' WHERE PREMSERV_PATIENTNUM = ".$sql->Param('a')." AND PREMSERV_DOCTORCODE = ".$sql->Param('b')." ",array($keys,$actor_id));	
	}
			   
	        //Push notification
			$code = '039';
		    $patientobj = $patientCls->getPatientDetails($keys);
		    $playerid = $patientobj->PATCON_PLAYERID;
			$sentto = $patientobj->PATCON_PATIENTCODE;
		    $ptitle = push_notif_title; 
		    $pmessage = $engine->getPushMessage($code); 
		    $engine->broadcastIndividualMessage($ptitle,$pmessage,$playerid,$code,'',$largimg='',$bigimg='');
		    //End push notification
			
			//Send notification
			$tablerowid = $rowid;
			$desc = "Your premium service was approved by Dr. ".$actorname;
			$menudetailscode = '0144';
			$engine->setNotification($code,$desc,$menudetailscode,$tablerowid,$sentto);
			
			$activity = "Premium patient with code ".$sentto." approved by Dr. ".$actorname." with doctor code ".$actor_id;
	        $engine->setEventLog('113',$activity);  
	        $msg = "Successful. Premium service approved successfully.";
	        $status = "success";
				
	        $view =''; 
	break;
	
	
 case "rejectpatient":
	if(!empty($keys)){
	   $sql->Execute("UPDATE hms_patient_premium SET PREMSERV_STATUS = '2' WHERE PREMSERV_PATIENTNUM = ".$sql->Param('a')." AND PREMSERV_DOCTORCODE = ".$sql->Param('b')." ",array($keys,$actor_id));	
	}
			   
	        //Push notification
			$code = '040';
		    $patientobj = $patientCls->getPatientDetails($keys);
		    $playerid = $patientobj->PATCON_PLAYERID;
			$sentto = $patientobj->PATCON_PATIENTCODE;
		    $ptitle = push_notif_title; 
		    $pmessage = $engine->getPushMessage($code); 
		    $engine->broadcastIndividualMessage($ptitle,$pmessage,$playerid,$code,'',$largimg='',$bigimg='');
		    //End push notification
			
			//Send notification
			$tablerowid = $rowid;
			$desc = "Your premium service is not approved by Dr. ".$actorname;
			$menudetailscode = '0144';
			$engine->setNotification($code,$desc,$menudetailscode,$tablerowid,$sentto);
			
			$activity = "Premium patient with code ".$sentto." rejected by Dr. ".$actorname." with doctor code ".$actor_id;
	        $engine->setEventLog('113',$activity);  
	        $msg = "Successful. Premium service rejected successfully.";
	        $status = "success";
				
	        $view =''; 
	break;
	
	case "getpatientgeolocation":
	if(!empty($keys)){
		   $stmt = $sql->Execute($sql->Prepare("SELECT PATCON_HOMELATITUDE, PATCON_HOMELONGITUDE FROM hms_patient_connect WHERE PATCON_PATIENTCODE = ".$sql->Param('a')." "),array($keys));
		   if($stmt->RecordCount() > 0){
			   $obj = $stmt->FetchNextObject();
			   $end = "'".$obj->PATCON_HOMELATITUDE.','.$obj->PATCON_HOMELONGITUDE."'";
			}
		}
	break;
	
	
}

if(isset($action_search) && $action_search == "search"){
    if(!empty($fdsearch)){
        $query = "SELECT PREMSERV_PATIENTNUM,PREMSERV_STATUS,PREMSERV_PATIENTCODE,PREMSERV_ID FROM hms_patient JOIN hms_patient_premium ON PATIENT_PATIENTCODE = PREMSERV_PATIENTCODE WHERE PATIENT_STATUS = '1' AND PREMSERV_STATUS IN ('0','1') AND PREMSERV_DOCTORCODE = ".$sql->Param('a')." AND ( PATIENT_FNAME LIKE ".$sql->Param('b')." OR PATIENT_MNAME LIKE ".$sql->Param('c')." OR PATIENT_LNAME LIKE ".$sql->Param('d')." OR PREMSERV_PATIENTNUM LIKE ".$sql->Param('e')." ) ";
        $input = array($actor_id,'%'.$fdsearch.'%',$fdsearch.'%',$fdsearch.'%',$fdsearch.'%');
    }
}else {

    $query = "SELECT PREMSERV_PATIENTNUM,PREMSERV_STATUS,PREMSERV_PATIENTCODE,PREMSERV_ID FROM hms_patient JOIN hms_patient_premium ON PATIENT_PATIENTCODE = PREMSERV_PATIENTCODE WHERE PATIENT_STATUS = '1' AND PREMSERV_STATUS IN ('0','1') AND PREMSERV_DOCTORCODE = ".$sql->Param('a')." ORDER BY PREMSERV_STATUS DESC";
    $input = array($actor_id);
}


if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=f77ccbdb203c19d3d52b12a85f33faf5&option=cdb9a09a6429a0527750cd6b6f0d3f42&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);