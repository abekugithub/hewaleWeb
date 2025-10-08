<?php
$crypt = new cryptCls();
$actorid = $session->get("userid");
$actorname = $engine->getActorName();
$actorgroup = $engine->getUsergroup();
$patientCls = new patientClass();
$usrcode = $engine->getActorCode();

$actudate = date("Y-m-d H:m:s");
$objdtls = $engine->getFacilityDetails();
$facilityalias = $objdtls->FACI_ALIAS ;
$actorcode = $engine->getActorCode();

switch($viewpage){
	case "endsession":
		//to search the meduim of consultation charge
		$stmt = $sql->Execute($sql->Prepare("SELECT MP_QCONSULT_CHARGES,MP_QCONSULT_TYPE FROM hmsb_med_prac WHERE MP_USRCODE =".$sql->Param('a')." "),array($usrcode));
		 if ($stmt ->RecordCount()>0){
		 	while ($obj= $stmt->FetchNextObject()){
		 		$consultcharge = $obj->MP_QCONSULT_CHARGES;
		 		$consulttype=$obj->MP_QCONSULT_TYPE;
		 	}
		 }else{
		 	$consultcharge='';
		 	$consulttype='';
		 }
		 //if consult type is 1 then it is per character
		 if ($consulttype=='1'){
		 	//get the amount in the temporary table
		 	$stmamount = $sql->Execute($sql->Prepare("SELECT WAL_BALANCE from hms_wallets_transit WHERE WAL_DOCTORCODE =  ".$sql->Param('a')." AND WAL_PATIENTCODE=".$sql->Param('b')." AND WAL_STATUS=".$sql->Param('c')." LIMIT 1"),array($usrcode,$patientcode,'0'));
		 	    if ($stmamount->RecordCount()>0){
		 	    	$objamount = $stmamount->FetchNextObject();
		 	    	$amount =$objamount->WAL_BALANCE;
		 	    }else{
		 	    	$amount = '0';
		 	    }
		 	    //if really a chat has gone on unbilled
		 	    if ($amount>0){
		 	    	//update the doctor and institutiion account balance
		 	    	$doctorpercentage = $engine->getQuickConsultPercentage($usrcode); //percentage meant for doctor
					$doctorpercentage = (!empty($doctorpercentage)?$doctorpercentage:'0'); 
					$doctorpercentage = $doctorpercentage/100 * $amount;
					$institutionpercentage =$amount - $doctorpercentage; //amount meant for institution
					
					
								//add deducted amount from patient wallet to doctor and institution wallet
					$stmt = $sql->Execute($sql->Prepare("UPDATE hms_wallets SET HRMSWAL_BALANCE = HRMSWAL_BALANCE + ".$sql->Param('a').",HRMSWAL_INST_BALANCE=HRMSWAL_INST_BALANCE+ ".$sql->Param('b')." WHERE HRMSWAL_USERCODE =  ".$sql->Param('a').""),array($doctorpercentage,$institutionpercentage,$usrcode));	
		 	    	
					
					if($stmt ==TRUE)//if deduction is done, set the temporary table row to paid
		 	    	{
		 	    	$sql->Execute($sql->Prepare("UPDATE hms_wallets_transit SET WAL_STATUS =".$sql->Param('a')." WHERE    WAL_DOCTORCODE =  ".$sql->Param('a')." AND WAL_PATIENTCODE=".$sql->Param('b')." AND WAL_STATUS=".$sql->Param('c')." "),array('1',$usrcode,$patientcode,'0'));
		 	    	
		 	    		
		 	    	//set all the messages to paid to avoid multiple charging
					 $sql->Execute($sql->Prepare("UPDATE hms_chatmarket SET CHT_PAY_STATUS =".$sql->Param('a')." WHERE    (CHT_RECEIVER_CODE=".$sql->Param('b')." AND CHT_SENDER_CODE =  ".$sql->Param('a').") OR (CHT_RECEIVER_CODE=".$sql->Param('b')." AND CHT_SENDER_CODE =  ".$sql->Param('a').")  "),array('1',$usrcode,$patientcode,$patientcode,$usrcode));
					 //event log
					 $activity = "The amount of $amount has been debited from user with id $patientcode and credited to user with id $usrcode for quick consultation";	
					$engine->setEventLog('097',$activity);
					$msg ="Session ended.";
					$status="success";
					$view=''; 
		 	    	}
		 	    }
		 	
		 }
		 /**
		 ELSE IF IT IS PAID BY SESSION::
		 **/
		 //if consult type is 2 then it is per session
		 elseif ($consulttype=='2'){
		 	// to charge based on session
		 	$amount= $consultcharge;
		 	$doctorpercentage = $engine->getQuickConsultPercentage($usrcode); //percentage meant for doctor
			$doctorpercentage = (!empty($doctorpercentage)?$doctorpercentage:'0'); 
			$doctorpercentage = $doctorpercentage/100 * $amount;
			$institutionpercentage =$amount - $doctorpercentage; //amount meant for institution
			//deduct amount from patient wallet
			$stmtpay = $sql->Execute($sql->Prepare("UPDATE hms_wallets SET HRMSWAL_BALANCE = HRMSWAL_BALANCE - ".$sql->Param('a')." WHERE HRMSWAL_USERCODE =".$sql->Param('a')." "),array($amount,$patientcode));
			
			
			//add deducted amount from patient wallet to doctor and institution wallet
					if ($stmtpay ==TRUE){
					$stmt = $sql->Execute($sql->Prepare("UPDATE hms_wallets SET HRMSWAL_BALANCE = HRMSWAL_BALANCE + ".$sql->Param('a').",HRMSWAL_INST_BALANCE=HRMSWAL_INST_BALANCE+ ".$sql->Param('b')." WHERE HRMSWAL_USERCODE =  ".$sql->Param('a').""),array($doctorpercentage,$institutionpercentage,$usrcode));
					

		   //set all messages to paid so they won't be charged multiple times
					if ($stmt==TRUE){
						//set all the messages to paid
					 $sql->Execute($sql->Prepare("UPDATE hms_chatmarket SET CHT_PAY_STATUS =".$sql->Param('a')." WHERE    (CHT_RECEIVER_CODE=".$sql->Param('b')." AND CHT_SENDER_CODE =  ".$sql->Param('a').") OR (CHT_RECEIVER_CODE=".$sql->Param('b')." AND CHT_SENDER_CODE =  ".$sql->Param('a').")  "),array('1',$usrcode,$patientcode,$patientcode,$usrcode));
					 //event log
					 $activity = "The amount of $amount has been debited from user with id $patientcode and credited to user with id $usrcode for quick consultation";	
					$engine->setEventLog('097',$activity);
					$msg ="Session ended.";
					$status="success";
					$view=''; 
					}
								   			}
		 
								   	}
	
	//Empty USR_CHATSTATE Column in hms_user_table
	$sql->Execute("UPDATE hms_users SET USR_CHATSTATE = '' WHERE USR_CODE = ".$sql->Param('a')." ",array($usrcode));

	
	break;		
	case "uploadfile":  //  Bulk Patient Registration; File Format: Excel file
        $file = $_FILES['patientupload'];
        if (isset($file)&&!empty($file)){
            if (file_exists($file['tmp_name'])) {
                $num = 0;
                //upload of exce file in the pending termination table

                //open and read the excel file

                $fichierACharger = $file["tmp_name"];
                $fichierType = PHPExcel_IOFactory::identify($fichierACharger);
                $objetALire = PHPExcel_IOFactory::createReader($fichierType);
                $objetALire->setReadDataOnly(true);
                $objPHPExcel = $objetALire->load($fichierACharger);

                $feuille = $objPHPExcel->getSheet(0);
                $highestRow = $feuille->getHighestRow();
                $highestCol = $feuille->getHighestColumn();
                $indexCol = PHPExcel_Cell::columnIndexFromString($highestCol);

                for ($row = 2;$row <= $highestRow; $row++) {
                    $firstname = $feuille->getCellByColumnAndRow(0, $row)->getValue();
                    $middlename = $feuille->getCellByColumnAndRow(1, $row)->getValue();
                    $lastname = $feuille->getCellByColumnAndRow(2, $row)->getValue();
                    $patientdob = $feuille->getCellByColumnAndRow(3, $row)->getValue();
                    $gender = $feuille->getCellByColumnAndRow(4, $row)->getValue();
                    $nationality = $feuille->getCellByColumnAndRow(5, $row)->getValue();
                    $countryofresidence = $feuille->getCellByColumnAndRow(6, $row)->getValue();
                    $maritalstatus = $feuille->getCellByColumnAndRow(7, $row)->getValue();
                    $address = $feuille->getCellByColumnAndRow(8, $row)->getValue();
                    $phonenumber = $feuille->getCellByColumnAndRow(9, $row)->getValue();
                    $email = $feuille->getCellByColumnAndRow(10, $row)->getValue();
                    $detcode = uniqid();

                    if (!empty($firstname)&&!empty($lastname)&&!empty($phonenumber)){
                        $middle = "";
                        $first = $firstname[0];
                        $last = $lastname[0];

                        if (!empty($middlename)){
                            $middle = $middlename[0];
                        }

                        $initial = strtoupper($first.$middle.$last);
                        $pn_code = $patientCls->getPatientNum($initial);

                        $patientnum = $pn_code;
                        $patientcode = $patientCls->getPatientCode();
                        $patientdate = date("Y-m-d");

                        $checkquery = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient WHERE PATIENT_STATUS='1' AND PATIENT_PATIENTNUM = ".$sql->Param('a')." AND PATIENT_PATIENTCODE = ".$sql->Param('a').""),array($patientnum,$patientcode));
                        print $sql->ErrorMsg();

                        if ($checkquery->RecordCount()>0){
                            $msg = "Failed, Patient exist already!";
                            $status = "error";
                            $views ='upload';
                        }else{
                            $form_date = explode('/',$patientdob);
                            $dob_year = $form_date[2];
                            $dob_month = $form_date[1];
                            $dob_day = $form_date[0];


                            $stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_patient (PATIENT_PATIENTNUM,PATIENT_PATIENTCODE,PATIENT_DATE,PATIENT_FNAME,PATIENT_MNAME,PATIENT_LNAME,PATIENT_DOB,PATIENT_GENDER,PATIENT_PHONENUM,PATIENT_ADDRESS,PATIENT_EMAIL,PATIENT_FACILITYCODE,PATIENT_SOURCE,PATIENT_NATIONALITY,PATIENT_COUNTRY_RESIDENT,PATIENT_MARITAL_STATUS) VALUES (".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('j').",".$sql->Param('k').",".$sql->Param('l').",".$sql->Param('m').",".$sql->Param('n').",".$sql->Param('o').",".$sql->Param('p').")"),array($patientnum, $patientcode, $patientdate, $firstname, $middlename, $lastname, strftime('%Y-%m-%d',date($patientdob)), $gender, $phonenumber,  $address, $email, $faccode, '2',$nationality,$countryofresidence,$maritalstatus));
                            print $sql->ErrorMsg();

                            if ($stmt){
                                $msg = "Patient bulk upload was Successfully.";
                                $status = "success";

                                $activity = 'Patient Registration with full name: '.$fname.' '.$middlename.' '.$lastname.' patient code: '.$patientcode.' by '.$actorname;
                                $engine->setEventLog('005',$activity);
                            }else{
                                $msg = "Patient Registration failed.";
                                $status = "error";
                            }
                        }
                    }else{
                        $msg = "Make sure all necessary fields are filled before submitting";
                        $status = "error";
                    }
                }
            }else{
                $msg = "The file name you entered or selected does not exist";
                $status = "error";
            }
        }else{
            $msg = "Select an appropriate file";
            $status = "error";
        }

    break;
case "reset":
	   $fdsearch = $action_search = "";
	break;
}

switch ($view){
	case "chat":
	
if(isset($keys) && !empty($keys)){
		$ptdetails = $patientCls->getPatientDetails($keys);
		$patientname = $ptdetails->PATIENT_FNAME.' '.$ptdetails->PATIENT_MNAME.' '.$ptdetails->PATIENT_LNAME;
		$patientnum = $ptdetails->PATIENT_PATIENTNUM;
		$onlinestate = $ptdetails->PATCON_ONLINE_STATUS;
		$patientcode = $ptdetails->PATIENT_PATIENTCODE;
		$easyrtcid = $ptdetails->PATCON_EASYRTCCODE;
		//get passport picture
		$picname = $patientCls->getPassPicture($patientnum);
		$photourl = SHOST_PASSPORT.$picname;
		$photourl = (strpos($photourl,'.')===false?'media/img/avatar.png':$photourl);
		
		//To be delete: for experience
		$msgdetails = $doctors->getMarketChatPerPatient($patientcode,$usrcode);
		
			 }
	break;
}



	if(!empty($fdsearch)){
   	$query ="SELECT DISTINCT(CHT_SENDER_CODE) CHP_PATIENTCODE FROM hms_chatmarket WHERE CHT_RECEIVER_CODE =".$sql->Param('a')." ORDER BY CHT_VIEW_STATUS ASC";
   	$input=array($actorcode);
		// $query = "SELECT CHP_DOCTORCODE,CHP_PATIENTCODE,PATIENT_PATIENTCODE,PATIENT_PATIENTNUM,CONCAT(PATIENT_FNAME,' ',PATIENT_LNAME) PATIENT_FULLNAME,PATIENT_GENDER,TIMESTAMPDIFF(YEAR,PATIENT_DOB,NOW()) AS PATIENT_AGE FROM hms_chatmarket_paddy JOIN hms_patient ON PATIENT_PATIENTCODE=CHP_PATIENTCODE WHERE CHP_DOCTORCODE = ".$sql->Param('a')." AND (PATIENT_FNAME LIKE ".$sql->Param('b')." OR PATIENT_MNAME LIKE ".$sql->Param('c')." OR PATIENT_LNAME LIKE ".$sql->Param('c')." OR PATIENT_PATIENTNUM LIKE ".$sql->Param('c').")";
    //$input = array($actorcode,'%'.$fdsearch.'%',$fdsearch.'%','%'.$fdsearch.'%',$fdsearch.'%');
	
}else {
	//echo $action_search; die();
    //$query = "SELECT CHP_DOCTORCODE,CHP_PATIENTCODE,PATIENT_PATIENTCODE,PATIENT_PATIENTNUM,CONCAT(PATIENT_FNAME,' ',PATIENT_LNAME) PATIENT_FULLNAME,PATIENT_GENDER,TIMESTAMPDIFF(YEAR,PATIENT_DOB,NOW()) AS PATIENT_AGE FROM hms_chatmarket_paddy JOIN hms_patient ON PATIENT_PATIENTCODE=CHP_PATIENTCODE WHERE CHP_DOCTORCODE = ".$sql->Param('a')."";
    $query ="SELECT DISTINCT(CHT_SENDER_CODE) CHP_PATIENTCODE FROM hms_chatmarket WHERE CHT_RECEIVER_CODE =".$sql->Param('a')." ORDER BY CHT_VIEW_STATUS ASC";
    $input = array($actorcode);
}
if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=f77ccbdb203c19d3d52b12a85f33faf5&option=f6383c07b345b6560d170c5e09bea356&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);
//include("model/js.php");
include("model/js.php");
//Get all positions
//$stmtpos2 = $engine->getUserPosition();
?>