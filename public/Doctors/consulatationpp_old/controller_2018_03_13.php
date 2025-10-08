<?php
//include SPATH_PLUGINS.DS."XMPPHP/BOSH.php";
$patientCls = new patientClass();
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();
$prescountry = $engine->getActorDetails()->MP_DRUGCOUNTRYREGISTER;
$usrtype = $actordetails->USR_TYPE;
$patientCls = new patientClass();

$day = Date("Y-m-d");
switch($viewpage){
	
case "cancelrequest":
$key=explode('@@@',$keys);

$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_consultation WHERE CONS_CODE = ".$sql->Param('a')." "),array($key[0]));
            $cons = $stmt->FetchNextObject();
			//$reqcode= $cons->REQU_CODE;
			$session->set('tablerowid',$cons->CONS_ID);
	$stmt = $sql->Execute($sql->Prepare("UPDATE hms_service_request SET REQU_STATUS ='13', REQU_CANCEL_REASON=".$sql->Param('a')." WHERE REQU_VISITCODE=".$sql->Param('d').""),array($canceldata,$key[1]));
	print $sql->ErrorMsg();
	
	$stmt = $sql->Execute($sql->Prepare("UPDATE hms_consultation SET CONS_STATUS ='0', CONS_CANCEL_REASON=".$sql->Param('a')." WHERE CONS_CODE=".$sql->Param('d').""),array($canceldata,$key[0]));
	print $sql->ErrorMsg();
	
	
	$msg = "Patient Consultation request has been cancelled Successfully.";
	    $status = "success";
		$engine->ClearNotification('0005',$cons->CONS_ID);
        $activity = "Patient Consultation request cancelled.";
		$engine->setEventLog("103",$activity);
	break;
	
	case "saveconsultation":
			if(empty($patientnum)){
            $msg = "Failed. Required field(s) canno be empty!.";
            $status = "error";
            $view ='consulting';
        }else{
			$consstatus = explode('_',$actiontype);	
			
			/*
			 * This code checks if there is a pending xray
			 * or lab awaiting, vital then prevent setting the action to complete
			 */
			 $noncompletion = 1;
			 if($consstatus[0] == 'SER0015'){
			 // Case: 1 Check for pending lab
			 $stmtrrl = $sql->Execute($sql->Prepare("SELECT COUNT(LT_ID) AS TOTALLAB FROM hms_patient_labtest WHERE LT_VISITCODE = ".$sql->Param('a')." AND LT_STATUS != '7' "),array($visitcode));
			 $objrrl = $stmtrrl->FetchNextObject();
			 if($objrrl->TOTALLAB > 0){ $noncompletion = 0;}
			 
			  // Case: 2 Check for xray
			 $stmtrrx = $sql->Execute($sql->Prepare("SELECT COUNT(XT_ID) AS TOTALXRAY FROM hms_patient_xraytest WHERE XT_VISITCODE = ".$sql->Param('a')." AND XT_STATUS != '7' "),array($visitcode));
			 $objrrx = $stmtrrx->FetchNextObject();
			 if($objrrx->TOTALXRAY > 0){ $noncompletion = 0; }
			 
			 // Case: 3 Check for vital
			 $stmtrrt = $sql->Execute($sql->Prepare("SELECT COUNT(VITALS_ID) AS TOTALVITAL FROM hms_vitals WHERE VITALS_VISITCODE = ".$sql->Param('a')." AND VITALS_STATUS = '0' "),array($visitcode));
			 $objrrt = $stmtrrt->FetchNextObject();
			 if($objrrt->TOTALVITAL > 0){ $noncompletion = 0; }
			 }
			 
			 
			 //End checking validity of action
			 if($noncompletion == 1){
        	//for audio
		       $audio_name = $session->get('audioname');
        	if (!empty($audio_name)){
        		$audetails = $patientCls->getConsultationDetails($keys);
				$audpatientname = $audetails->CONS_PATIENTNAME;
				$audpatientnum = $audetails->CONS_PATIENTNUM;
		        $audvisitcode = $audetails->CONS_VISITCODE;
				$audconsultcode = $audetails->CONS_CODE;
				$audpatientcode = $audetails->CONS_PATIENTCODE;
				$audio_name = $session->get('audioname');
				$stmtaudio=$sql->Execute("INSERT INTO hms_patient_audio
				(AUD_CODE ,AUD_PATIENTCODE ,AUD_PATIENTNUM ,AUD_PATIENTNAME,AUD_VISITCODE ,AUD_FACICODE ,AUD_DOCTORNAME ,AUD_DOCTORCODE)VALUES
				(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').")",array($audio_name,$audpatientcode,$audpatientnum,$audpatientname,$audvisitcode,$activeinstitution,$usrname,$usrcode));
        		if ($stmtaudio==TRUE){
        			$session->del('audioname');
        		}else{
        			print $sql->ErrorMsg();
        		}
        		
        	}
			//echo $consstatus[0].''.$consstatus[1];		 
			$sql->Execute("UPDATE hms_consultation SET CONS_SERVCODE = ".$sql->Param('a').", CONS_STATUS = ".$sql->Param('b')." WHERE CONS_VISITCODE = ".$sql->Param('c')." ",array($consstatus[0],$consstatus[1],$visitcode));
			print $sql->ErrorMsg();
			//echo 'status '.$consstatus[1];
			//Update service request table
			$requstatus = $patientCls->getRequestStatus($consstatus[0]);
			
			//Get srvice name
			$servicedetails = $engine->getServiceDetails($consstatus[0]);
			$servicename = $servicedetails->SERV_NAME;
			$sql->Execute("UPDATE hms_service_request SET REQU_SERVICECODE = ".$sql->Param('a').", REQU_STATUS = ".$sql->Param('b').",REQU_SERVICENAME = ".$sql->Param('c').",REQU_ADMITINGNOTE = ".$sql->Param('d')." WHERE REQU_VISITCODE = ".$sql->Param('e')." ",array($consstatus[0],$requstatus,$servicename,$admittingnote,$visitcode));
	
	        //Clear notification
			$ptdetails = $patientCls->getConsultationDetails($consultcode);
		    $menudetailscode = '0005';
		    $tablerowid = $ptdetails->CONS_ID;
		    $engine->ClearNotification($menudetailscode,$tablerowid);
		    if (!empty($consstatus)){
                //Send Notification
                if($consstatus[0] == 'SER0004'){    //Vitals
                    $code = '015';
                    $desc = "You are requested to take your vital at the nearest vital post as soon as possible for doctor review.";
					$menudetailscode = '0002';
                }elseif($consstatus[0] == 'SER0015'){   //Complete
                    $code = '006';
                    $desc = "Your consultation was completed successfully. Refer to your prescriptions module if any.";
					$menudetailscode = '0000'; //No notification to other module
                }elseif($consstatus[0] == 'SER0016'){   //Incomplete
                    $code = '016' ;
                    $desc = "Your consultation was incomplete. Refer to your prescription list to see any prescribed medication.";
					$menudetailscode = '0000'; //No notification to other module
                }elseif($consstatus[0] == 'SER0002'){   //First Aid
                    $code = '020' ;
                    $desc = "You are requested to go for First Aid.";
					$menudetailscode = '0001'; //No notification to other module
                }elseif($consstatus[0] == 'SER0005'){   //ADMISSION
                    $code = '025' ;
                    $desc = "Patient sent to Admission. Refer to IPD for ward assignment.";
					$menudetailscode = '0055'; //No notification to other module
                }elseif($consstatus[0] == 'SER0006'){   //DETAIN
                    $code = '026' ;
                    $desc = "Patient has been Detained. Refer to IPD for ward assignment.";
					$menudetailscode = '0055'; //No notification to other module
                }elseif($consstatus[0] == 'SER0007'){   //REFERAL INTERNAL
                    $code = '031' ;
                    $desc = "Patient has been Referred. Internal Referral.";
					$menudetailscode = '0000'; //No notification to other module
                }elseif($consstatus[0] == 'SER0008'){   //REFERAL EXTERNAL
                    $code = '032' ;
                    $desc = "Patient has been Referred. External Referral.";
                }elseif($consstatus[0] == 'SER0009'){   //CONSULTATION REVIEW
                    $code = '003' ;
                    $desc = "Patient has been scheduled for Consultation Review.";
					$menudetailscode = '0000'; //No notification to other module
                }elseif($consstatus[0] == 'SER0010'){   //EMERGENCY
                    $code = '028' ;
                    $desc = "Patient sent to Emergency Department.";
					$menudetailscode = '0059'; 
                }elseif($consstatus[0] == 'SER0011'){   //ANTI NATAL
                    $code = '033' ;
                    $desc = "Patient has been sent to Anti Natal.";
					$menudetailscode = '0000'; //No notification to other module
                }elseif($consstatus[0] == 'SER0012'){   //SURGICAL PROCEDURES
                    $code = '029' ;
                    $desc = "Patient booked for Surgical Procedure.";
					$menudetailscode = '0000'; //No notification to other module
                }elseif($consstatus[0] == 'SER0013'){   //POST NATAL
                    $code = '026' ;
                    $desc = "Patient has been Detained. Refer to IPD for ward assignment.";
					$menudetailscode = '0000'; //No notification to other module
                }elseif($consstatus[0] == 'SER0014'){   //NEO NATAL
                    $code = '026' ;
                    $desc = "Patient has been sent to Post Natal.";
					$menudetailscode = '0000'; //No notification to other module
                }elseif($consstatus[0] == 'SER0018'){   //SURGERY
                    $code = '029' ;
                    $desc = "Patient has been scheduled for Surgery.";
					$menudetailscode = '0000'; //No notification to other module
                }
                
                //Get row id
				
                $smtrequstdetails = $patientCls->getServRequestInfo($visitcode);
                $tablerowid = $smtrequstdetails->REQU_ID;
                $sentto = $patientcode;
				
                $engine->setNotification($code,$desc,$menudetailscode,$tablerowid,$sentto);
				/*
		         * This code snippet below update doctor session and set him
		         * as inactive for new or pending patient
		         * Author: Acker
		         */	 
		         $sql->Execute($sql->Prepare("UPDATE hms_users SET USR_CONSULTING_STATUS = '0' WHERE USR_STATUS = '1' AND USR_CODE = ".$sql->Param('a')." "),array($usrcode));

		        //End update for active consultation set
				
			   
            }

			$activity = "Consultation saved successfully for patient with number: ".$patientnum." visit code: ".$visitcode." by doctor : ".$usrname." with user code ".$usrcode;
		    $engine->setEventLog("017",$activity);
		
			$msg = "Successful: Consultation details saved Successfully.";
            $status = "success";
            $view ='';
			
			//Set Current user to be in session
		    $sql->Execute("UPDATE hms_docsession SET DOCSES_STATUS = '2' WHERE DOCSES_USRCODE = ".$sql->Param('a')." AND DOCSES_PATIENTCODE = ".$sql->Param('b')." ",array($usrcode,$patientcode));
			
		   /*
		    * This code snippet below update doctor session and set him
		    * as busy in session with an active patient
		    * Author: Acker
		    */	 
		    $sql->Execute($sql->Prepare("UPDATE hms_users SET USR_CONSULTING_STATUS = '0' WHERE USR_STATUS = '1' AND USR_CODE = ".$sql->Param('a')." "),array($usrcode));

		   //End update for active consultation set
		   
		        //Push notification
				if($code == '015' || $code == '020' || $code == '003'){
				 $patientobj = $patientCls->getPatientDetails($patientnum);
				 $playerid = $patientobj->PATCON_PLAYERID;
		         $ptitle = push_notif_title; 
		         $pmessage = $engine->getPushMessage($code); 
		         $engine->broadcastIndividualMessage($ptitle,$pmessage,$playerid,$code,'',$largimg='',$bigimg='');
		         //End push notification
				}
				
			 }else{
				     	 $msg = "Fail: Consulatation cannot be completed, awaiting labs, xray or vital's results.";
                         $status = "error";
                         $view ='consulting';
						 				 
		/*
		 * This code snippet below update doctor session and set him
		 * as busy in session with an active patient
		 * Author: Acker
		 */	 
		 //End update for active consultation set
		$ptdetails = $patientCls->getConsultationDetails($consultcode);
		$patientname = $ptdetails->CONS_PATIENTNAME;
		$patientnum = $ptdetails->CONS_PATIENTNUM;
		$consultcode = $ptdetails->CONS_CODE;
		$ptsubdetails = $patientCls->getPatientDetails($patientnum);
		$patientcode = $ptdetails->CONS_PATIENTCODE;
		$onlinestate = $ptsubdetails->PATCON_ONLINE_STATUS;
		$easyrtcid = $ptsubdetails->PATCON_EASYRTCCODE;

		//get passport picture
		$picname = $patientCls->getPassPicture($patientnum);
		$photourl = SHOST_PASSPORT.$picname;
		$photourl = (strpos($photourl,'.')===false?'media/img/avatar.png':$photourl);
		
		//To be delete: for experience
		$msgdetails = $doctors->getChatPerPatient($patientcode,$usrcode);

	    if (!empty($patientcode) && !empty($visitcode)){
            $stmtcomplain = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_complains WHERE PC_STATUS='1' AND PC_VISITCODE=".$sql->Param('a')." AND PC_PATIENTCODE=".$sql->Param('b')." ORDER BY PC_ID DESC"),array($visitcode,$patientcode));
            print $sql->ErrorMsg();

            $stmtpres = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_STATUS='1' AND PRESC_VISITCODE=".$sql->Param('a')." AND (PRESC_PATIENTNUM=".$sql->Param('b')." OR PRESC_PATIENTCODE=".$sql->Param('b').") ORDER BY PRESC_ID DESC"),array($visitcode,$patientnum,$patientcode));
            print $sql->ErrorMsg();

            $stmtdiag = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_diagnosis WHERE DIA_STATUS='1' AND DIA_VISITCODE=".$sql->Param('a')." AND (DIA_PATIENTNUM=".$sql->Param('b')." OR DIA_PATIENTCODE=".$sql->Param('b').") ORDER BY DIA_ID DESC"),array($visitcode,$patientnum,$patientcode));
            print $sql->ErrorMsg();

            $stmtlabs = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_STATUS IN ('1','6') AND LT_VISITCODE=".$sql->Param('a')." AND (LT_PATIENTNUM=".$sql->Param('b')." OR LT_PATIENTCODE=".$sql->Param('b').") ORDER BY LT_ID DESC"),array($visitcode,$patientnum,$patientcode));
            print $sql->ErrorMsg();

            $stmtx = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_xraytest WHERE XT_STATUS IN ('1','6') AND XT_VISITCODE=".$sql->Param('a')." AND (XT_PATIENTNUM=".$sql->Param('b')." OR XT_PATIENTCODE=".$sql->Param('b').") ORDER BY XT_ID DESC"),array($visitcode,$patientnum,$patientcode));
            print $sql->ErrorMsg();
            
        }
	      }
		}
	break;
	
 /*   case 'savecomplain':
        if(empty($patientnum)){
            $msg = "Failed. Required field(s) can't be empty!.";
            $status = "error";
            $view ='consulting';
        }else{
            if(!empty($complain)){
                $comcode = $engine->getcomplainCode();
                $sql->Execute($sql->Prepare("INSERT INTO hms_patientcomplains (PC_CODE,PC_PATIENTNUM,PC_VISITCODE,PC_DATE,PC_COMPLAINCODE,PC_COMPLAIN,PC_INSTCODE,PC_ACTORCODE,PC_ACTORNAME) VALUES(".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').")"),array($comcode,$patientnum,$visitcode,$day,$subid,$complain,$activeinstitution,$usrcode,$usrname));
                print $sql->ErrorMsg();
            }

            if(!empty($test)){
                $lqcode = $engine->getlabtestCode();
                $lt = explode('@@@', $test);
                $lcode = $lt['0'];
                $ltest = $lt['1'];
                $dcode = $lt['2'];
                $ddis = $lt['3'];

                $sql->Execute($sql->Prepare("INSERT INTO hms_lab_test (LT_CODE,LT_VISITCODE,LT_DATE,LT_PATIENTNUM,LT_PATIENTNAME,LT_TEST,LT_TESTNAME,LT_DISCIPLINE,LT_DISCPLINENAME,LT_RMK,LT_ACTORCODE,LT_ACTORNAME,LT_INSTCODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').")"),array($lqcode,$visitcode,$day,$patientnum,$patient,$lcode,$ltest,$dcode,$ddis,$crmk,$usrcode,$usrname,$activeinstitution));
                print $sql->ErrorMsg();
            }

            if(!empty($dia)){
                $diacode = $engine->getdiagnosisCode();
                $di = explode('@@@', $dia);
                $dicode = $di['0'];
                $diname = $di['1'];

                $sql->Execute($sql->Prepare("INSERT INTO hms_diagnosis (DIA_CODE,DIA_VISITCODE,DIA_DATE,DIA_PATIENTNUM,DIA_DIA,DIA_DIAGNOSIS,DIA_RMK,DIA_ACTORNAME,DIA_ACTORCODE,DIA_INSTCODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('9').")"),array($diacode,$visitcode,$day,$patientnum,$dicode,$diname,$drmk,$usrname,$usrcode,$activeinstitution));
                print $sql->ErrorMsg();
            }

            if(!empty($drug)){
                $precode = $engine->getprescriptionCode();

                $pre = explode('@@@', $drug);
                $drcode = $pre['0'];
                $drname = $pre['1'];
                $dscode = $pre['2'];
                $dsname = $pre['3'];
                $qty = $frequency * $days * $times ;

                $sql->Execute($sql->Prepare("INSERT INTO hms_ph_prescription (PRESC_CODE,PRESC_PATIENT,PRESC_PATIENTNUM,PRESC_DATE,PRESC_VISITCODE,PRESC_DRUGID,PRESC_DRUG,PRESC_QUANTITY,PRESC_DOSAGENAME,PRESC_DOSAGECODE,PRESC_FREQ,PRESC_DAYS,PRESC_TIMES,PRESC_ACTORNAME,PRESC_ACTORCODE,PRESC_INSTCODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').")"),array($precode,$patient,$patientnum,$day,$visitcode,$drcode,$drname,$qty,$dsname,$dscode,$frequency,$days,$times,$usrname,$usrcode,$activeinstitution));
                print $sql->ErrorMsg();
            }

            $msg = "Saved successfully.";
            $status = "success";
            $view ='consulting';
        }

        //die('hard ');
    break;
*/
    // 20 NOV 2015, JOSEPH ADORBOE, SAVE THE SYMTOMS.
    case "saveconsultation#":
        if(empty($complains) || empty($patientnum) || empty($visitcode)) {

            $msg = "Failed. Required field(s) can't be empty!.";
            $status = "error";
            $view ='consultation';

        }else {
//INSERT INTO symtoms TABLE
            $stmt = $sql->Execute($sql->Prepare("SELECT SYM_ID FROM hmis_symtons WHERE  SYM_INDEXNUM = ".$sql->Param('a')." and SYM_ITEM = ".$sql->Param('b')." and SYM_VISITCODE = ".$sql->Param('c')." and SYM_STATUS = ".$sql->Param('c')." "),array($indexnum,$sym,$visitcode,'1'));
            print $sql->ErrorMsg();

            if($stmt->RecordCount()>0){
                $msg = "Failed, Symtoms exist already!";
                $status = "error";
                $view ='syms';
                $sym ='';

            }else{
                $scode = $codes->getsymtomscode();
                $symt = explode('@@@',$sym);
                $sym = $symt[0];
                $sy = $symt[1];
//      $sy = $lovn->getsymtoms($sym);
                $sql->Execute($sql->Prepare("INSERT INTO hmis_symtons (SYM_CODE,SYM_DATE,SYM_INDEXNUM,SYM_VISITCODE,SYM_ITEM,SYM_COMPID,SYM_ACTOR,SYM_USER,SYM_SYMTOMS) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('h').")"),array($scode,$dt,$patientnum,$visitcode,$sym,$instcode,$currentusercode,$currentuser,$sy));
                print $sql->ErrorMsg();

                $msg = "Symtoms been saved successfully.";
                $status = "success";


// userlog event
                $activity= "OPD PATIENT SYSMTOMS ADDED PATIENT : ".$names." , NUMBER  ".$indexnum.", VISITCODE:".$visitcode.", SYMTON:".$sy." ";
                $engine->setEventLog("162",$activity);

                $view ='syms';
                $sym ='';
            }
        }
        break;

	case 'consult':
	if(isset($keys) && !empty($keys)){
		/*
		 * This code snippet below update doctor session and set him
		 * as busy in session with an active patient
		 * Author: Acker
		 */	 
		  $sql->Execute($sql->Prepare("UPDATE hms_users SET USR_CONSULTING_STATUS = '1' WHERE USR_STATUS = '1' AND USR_CODE = ".$sql->Param('a')." "),array($usrcode));

		 //End update for active consultation set
		$ptdetails = $patientCls->getConsultationDetails($keys);
		$patientname = $ptdetails->CONS_PATIENTNAME;
		$patientnum = $ptdetails->CONS_PATIENTNUM;
        $visitcode = $ptdetails->CONS_VISITCODE;
		$consultcode = $ptdetails->CONS_CODE;
		$ptsubdetails = $patientCls->getPatientDetails($patientnum);
		$patientcode = $ptdetails->CONS_PATIENTCODE;
		$onlinestate = $ptsubdetails->PATCON_ONLINE_STATUS;
		$easyrtcid = $ptsubdetails->PATCON_EASYRTCCODE;

		//get passport picture
		$picname = $patientCls->getPassPicture($patientnum);
		$photourl = SHOST_PASSPORT.$picname;
		$photourl = (strpos($photourl,'.')===false?'media/img/avatar.png':$photourl);
		
		//To be delete: for experience
		$msgdetails = $doctors->getChatPerPatient($patientcode,$usrcode);
		
		//Update consulting session
	    $doctors->setDoctorConsultSession($usrcode,$patientcode);

	    if (!empty($patientcode) && !empty($visitcode)){
            $stmtcomplain = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_complains WHERE PC_STATUS='1' AND PC_VISITCODE=".$sql->Param('a')." AND PC_PATIENTCODE=".$sql->Param('b')." ORDER BY PC_ID DESC"),array($visitcode,$patientcode));
            print $sql->ErrorMsg();

            $stmtpres = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_STATUS='1' AND PRESC_VISITCODE=".$sql->Param('a')." AND (PRESC_PATIENTNUM=".$sql->Param('b')." OR PRESC_PATIENTCODE=".$sql->Param('b').") ORDER BY PRESC_ID DESC"),array($visitcode,$patientnum,$patientcode));
            print $sql->ErrorMsg();

            $stmtdiag = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_diagnosis WHERE DIA_STATUS='1' AND DIA_VISITCODE=".$sql->Param('a')." AND (DIA_PATIENTNUM=".$sql->Param('b')." OR DIA_PATIENTCODE=".$sql->Param('b').") ORDER BY DIA_ID DESC"),array($visitcode,$patientnum,$patientcode));
            print $sql->ErrorMsg();

            $stmtlabs = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_STATUS IN ('1','2','3','4','5','6','7') AND LT_VISITCODE=".$sql->Param('a')." AND (LT_PATIENTNUM=".$sql->Param('b')." OR LT_PATIENTCODE=".$sql->Param('b').") ORDER BY LT_ID DESC"),array($visitcode,$patientnum,$patientcode));
            print $sql->ErrorMsg();

            $stmtx = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_xraytest WHERE XT_STATUS IN ('1','2','3','4','5','6','7') AND XT_VISITCODE=".$sql->Param('a')." AND (XT_PATIENTNUM=".$sql->Param('b')." OR XT_PATIENTCODE=".$sql->Param('b').") ORDER BY XT_ID DESC"),array($visitcode,$patientnum,$patientcode));
            print $sql->ErrorMsg();
            
            

        }
		
	}
	
    break;
	
	
    case 'savevitals':
        die($patient.' ,'.$reqdate.', '.$doctor.', '.$actor.', '.$paymenttype.', '.$servicename.', '.$data);
    break;
	
	
	case "history":
	
	 if (!empty($keys)){
            $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient WHERE PATIENT_PATIENTNUM=".$sql->Param('a')." "),array($keys));
            print $sql->ErrorMsg();
            if ($stmt){
                $patient = $stmt->FetchNextObject();
                $patientname = $patient->PATIENT_FNAME.' '.$patient->PATIENT_MNAME.' '.$patient->PATIENT_LNAME;
                $patientdob = $patient->PATIENT_DOB;
                $patienemail = $patient->PATIENT_EMAIL;
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
	
	
	case "historyback":
	
	 if (!empty($keys)){
            $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient WHERE PATIENT_PATIENTNUM=".$sql->Param('a')." "),array($keys));
            print $sql->ErrorMsg();
            if ($stmt){
                $patient = $stmt->FetchNextObject();
                $patientname = $patient->PATIENT_FNAME.' '.$patient->PATIENT_MNAME.' '.$patient->PATIENT_LNAME;
                $patientdob = $patient->PATIENT_DOB;
                $patienemail = $patient->PATIENT_EMAIL;
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
	
	
	
	
	case "historylist":
		$stmthl = $sql->Execute($sql->Prepare("SELECT * FROM hms_consultation WHERE CONS_PATIENTNUM=".$sql->Param('a')." ORDER BY CONS_ID DESC LIMIT 5 "),array($keys));
		
	break;
	
	case "historydetails":
	
		$stmtpc = $sql->Execute($sql->Prepare("SELECT PC_ACTORNAME, PC_COMPLAIN, PC_DATE, PC_PATIENTNUM, PC_VISITCODE FROM hms_patient_complains WHERE PC_VISITCODE = ".$sql->Param('a')." AND PC_PATIENTNUM = ".$sql->Param('b').""),array($keys,$newkeys));
		
		$stmtlt = $sql->Execute($sql->Prepare("SELECT LT_ACTORNAME, LT_DATE, LT_TESTNAME, LT_RMK FROM hms_patient_labtest WHERE LT_VISITCODE = ".$sql->Param('a')." AND LT_PATIENTNUM = ".$sql->Param('b')." "),array($keys,$newkeys));
		
		$stmtdia = $sql->Execute($sql->Prepare("SELECT DIA_ACTORNAME, DIA_DATE, DIA_DIAGNOSIS, DIA_RMK FROM hms_patient_diagnosis WHERE DIA_VISITCODE = ".$sql->Param('a')." AND DIA_PATIENTNUM = ".$sql->Param('b')." "),array($keys,$newkeys));
		
		$stmtp = $sql->Execute($sql->Prepare("SELECT PRESC_ACTORNAME, PRESC_DATE, PRESC_DRUG, PRESC_DAYS, PRESC_FREQ, PRESC_TIMES FROM hms_patient_prescription WHERE PRESC_VISITCODE = ".$sql->Param('a')." AND PRESC_PATIENTNUM = ".$sql->Param('b')." AND PRESC_STATUS != '0'"),array($keys,$newkeys));
		
		$stmtaud = $sql->Execute($sql->Prepare("SELECT AUD_CODE FROM hms_patient_audio WHERE AUD_STATUS='1' AND AUD_VISITCODE=".$sql->Param('a')." AND AUD_PATIENTNUM=".$sql->Param('b').""),array($keys,$newkeys));
            print $sql->ErrorMsg();
		
	break;
	
	case "vitallist":
	$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient WHERE PATIENT_PATIENTCODE=".$sql->Param('a')." "),array($patientcode));
            print $sql->ErrorMsg();
            if ($stmt){
                $patient = $stmt->FetchNextObject();
                $patientname = $patient->PATIENT_FNAME.' '.$patient->PATIENT_MNAME.' '.$patient->PATIENT_LNAME;
                $patientdob = $patient->PATIENT_DOB;
                $patienemail = $patient->PATIENT_EMAIL;
                $patientphone = $patient->PATIENT_PHONENUM;
                $patientaddress = $patient->PATIENT_ADDRESS;
                $patientnum = $patient->PATIENT_PATIENTNUM;
                $patientmar_status = $patient->PATIENT_MARITAL_STATUS;
                $patientnation = $patient->PATIENT_NATIONALITY;
                $patientgender = $patient->PATIENT_GENDER;
				
			}
		$stmtv = $sql->Execute($sql->Prepare("SELECT * FROM hms_vitals_details WHERE VITDET_VISITCODE=".$sql->Param('a')." "),array($visitcode));
		
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
	
	break;
	
	case "searchitem":
	
	if (!empty ($fdhistory)) {
		
		$stmtpat = $sql->Execute($sql->Prepare("SELECT * FROM hms_consultation WHERE CONS_DOCTORNAME LIKE ".$sql->Param('a')."  "),array('%'.$fdhistory.'%'));
		
		}
		
		
		 if (!empty($keys)){
            $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient WHERE PATIENT_PATIENTNUM=".$sql->Param('a')." "),array($keys));
            print $sql->ErrorMsg();
            if ($stmt){
                $patient = $stmt->FetchNextObject();
                $patientname = $patient->PATIENT_FNAME.' '.$patient->PATIENT_MNAME.' '.$patient->PATIENT_LNAME;
                $patientdob = $patient->PATIENT_DOB;
                $patienemail = $patient->PATIENT_EMAIL;
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

    case "rescheduleconsult":
        if (!empty($keys)){
            //Update Consultation
            $sql->Execute("UPDATE hms_consultation SET CONS_SCHEDULEDATE = ".$sql->Param('a').",CONS_STATUS ='1',CONS_SCHEDULETIME = ".$sql->Param('b')." WHERE CONS_CODE = ".$sql->Param('d')." ",array(strftime('%Y-%m-%d',$startdate),$inputtime,$keys));

            $activity = 'Patient request for consultation has been rescheduled. The details are : Patient Name '.$patient_name.' Patient Number '.$hewale_number.' Doctor Code : '.$usrcode.' Visit Code : '.$visitcode.' Date '.$day;
            $engine->setEventLog('087',$activity);

            $msg = "Success: Patient request for consultation has been rescheduled.";
            $status = "success";
            $view ='';

            //Clear notification
            $menudetailscode = '0017';
            $tablerowid = $objrequst->REQU_ID;
            $engine->ClearNotification($menudetailscode,$tablerowid);

            //Set Notification
            $code = '030';
            $menudetailscodenew = '0005';
            $desc = "Patient consultation rescheduled.";
            $sentto = $hewale_number;
            $newtablerowid = $patientCls->getPatientDetails($hewale_number)->PATIENT_ID;
            $engine->setNotification($code,$desc,$menudetailscodenew,$newtablerowid,$sentto);
        }
    break;


    case "reset":
	$fdsearch = "";
	break;
}

$stmtroute = $sql->Execute($sql->Prepare("SELECT RT_CODE,RT_NAME FROM hmsb_st_route"));
print $sql->ErrorMsg();

//echo $usrcode;
if(!empty($fdsearch)){
 $query = "SELECT * FROM hms_consultation WHERE CONS_FACICODE = ".$sql->Param('a')." AND CONS_DOCTORCODE = ".$sql->Param('b')." AND CONS_STATUS IN ('1','2') AND (CONS_PATIENTNUM = ".$sql->Param('c')." OR CONS_PATIENTNAME LIKE ".$sql->Param('d').") ORDER BY CONS_INPUTDATE DESC";
    $input = array($activeinstitution,$usrcode,$fdsearch,'%'.$fdsearch.'%');
}else {
    $query = "SELECT * FROM hms_consultation WHERE CONS_FACICODE = ".$sql->Param('a')." AND CONS_DOCTORCODE = ".$sql->Param('b')." AND CONS_STATUS IN ('1','2') ORDER BY CONS_INPUTDATE DESC";
    $input = array($activeinstitution,$usrcode);
   
	
}
if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=f77ccbdb203c19d3d52b12a85f33faf5&option=6bf17fe4762ece7a82410014d090d322&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);

$usp = $doctors->getuserSpeciality($usrcode);
$stmttestlov = $sql->Execute($sql->Prepare("SELECT * from hmsb_st_labtest order by LTT_NAME ")) ;
$stmtdiagnosislov = $sql->Execute($sql->Prepare("SELECT * from hmsb_st_disease order by DIS_NAME ")) ;
$stmtxray = $sql->Execute($sql->Prepare("SELECT * from hmsb_st_xray order by X_ID DESC ")) ;
$ex_country = explode(',',$prescountry);
$stmtdrugslov = $sql->Execute($sql->Prepare("SELECT * from hmsb_st_phdrugs order by DR_NAME ")) ;
$stmtphysicalexams = $sql->Execute($sql->Prepare("SELECT * FROM hmsb_st_physicalexamination order by PHYEX_ID ASC ")) ;

include("model/js.php");
include("model/managementjs.php");
?>