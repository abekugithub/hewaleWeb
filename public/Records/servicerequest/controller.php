<?php
$actorname = $engine->getActorName();
$actorcode= $engine->getActorCode();
$patientCls = new patientClass();
$sms = new smsgetway();
$import = new importClass();
$price = new priceClass();
$faccode = $engine->getActorDetails()->USR_FACICODE;
$actordept=$engine->getUserAssignedDepartment($actorcode,$faccode);
$paysett = $sett->getpaybeforesetting($faccode);
//echo $keys.'hello world';
/** echo "BOOOOOOOOOOOOOOOOOOOOOOOOM $actordept"; die();
$reg_list = base64_encode(serialize($_POST['syscheckbox']));
				$sql_reg_list = implode("','",$_POST['syscheckbox']);
				$sql_reg_list = "'".$sql_reg_list."'";
**/
$actordept = (!empty($actordept)?$actordept:'');
$actordept = (!empty($actordept)?explode(',',$actordept):'');
$actordept = (is_array($actordept)?implode("','",$actordept):'');
$actordept = (!empty($actordept)?"'".$actordept."'":'1');
//echo $actordept; die();
//echo $faccode; die();

$crtdate= date("Y-m-d H:m:s");
//print_r($_POST);

switch($viewpages){
case "patientdetails":
        if (isset($patkey) && !empty($patkey)){
            $stmt = $sql->Execute($sql->Prepare("SELECT REQU_CODE,PATIENT_PATIENTNUM,PATIENT_PATIENTCODE, PATIENT_FNAME,PATIENT_MNAME,PATIENT_LNAME,TIMESTAMPDIFF(YEAR,PATIENT_DOB,NOW()) AS PATIENT_DOB,PATIENT_GENDER,PATIENT_PHONENUM,PATIENT_EMAIL,PATIENT_EMERGNAME1,PATIENT_WEIGHT,PATIENT_HEIGHT,PATIENT_BLOODGROUP,PATIENT_IMAGE FROM hms_patient LEFT JOIN hms_service_request ON PATIENT_PATIENTCODE=REQU_PATIENTCODE WHERE PATIENT_PATIENTCODE = ".$sql->Param('a')." AND PATIENT_STATUS = '1'"),array($patkey));
            print $sql->ErrorMsg();

            if ($stmt->RecordCount()>0){
                while ($obj = $stmt->FetchNextObject()){
                	$requestcode=$obj->REQU_CODE;
                    $patientnum = $obj->PATIENT_PATIENTNUM;
                    $patientcode = $obj->PATIENT_PATIENTCODE;
                    $patient_fullname = $obj->PATIENT_FNAME.' '.$obj->PATIENT_MNAME.' '.$obj->PATIENT_LNAME;
                    $patientdob = $obj->PATIENT_DOB;
                    $patientgender = $obj->PATIENT_GENDER;
                    $patientphonenum = $obj->PATIENT_PHONENUM;
                    $patientemail = $obj->PATIENT_EMAIL;
                    $patientemergnum = $obj->PATIENT_EMERGNAME1;
                    $patientweight = $obj->PATIENT_WEIGHT;
                    $patientheight = $obj->PATIENT_HEIGHT;
                    $patientbloodgrp = $obj->PATIENT_BLOODGROUP;
                    $patientphoto = $obj->PATIENT_IMAGE;
                }
            }
        }
    break;
	
	
    case "requestqueue":
    			$stmt= $sql->Execute($sql->Prepare("SELECT REQU_CODE,PATIENT_PATIENTCODE,PATIENT_FNAME,PATIENT_MNAME,PATIENT_LNAME,PATIENT_PATIENTNUM,PATIENT_PHONENUM,PATIENT_GENDER,PATIENT_MARITAL_STATUS,PATIENT_INPUTEDDATE,TIMESTAMPDIFF(YEAR,PATIENT_DOB,NOW()) AS PATIENT_DOB,PATIENT_BLOODGROUP,PATIENT_IMAGE,PATIENT_HEIGHT,PATIENT_WEIGHT,PATIENT_EMERGNAME1,PATIENT_EMAIL,PATIENT_PHONENUM FROM hms_patient LEFT JOIN hms_service_request ON PATIENT_PATIENTCODE=REQU_PATIENTCODE WHERE PATIENT_STATUS = ".$sql->Param('b')." AND PATIENT_FACILITYCODE=".$sql->Param('a')." AND REQU_STATUS=".$sql->Param('b')."ORDER BY PATIENT_INPUTEDDATE DESC LIMIT 1"),array('1',$faccode,'1'));
    			if ($stmt->RecordCount()>0){
    				while ($obj=$stmt->FetchNextObject()){
    				$requestcode=$obj->REQU_CODE;
                    $patientnum = $obj->PATIENT_PATIENTNUM;
                    $patientcode = $obj->PATIENT_PATIENTCODE;
                    $patient_fullname = $obj->PATIENT_FNAME.' '.$obj->PATIENT_MNAME.' '.$obj->PATIENT_LNAME;
                    $patientdob = $obj->PATIENT_DOB;
                    $patientgender = $obj->PATIENT_GENDER;
                    $patientphonenum = $obj->PATIENT_PHONENUM;
                    $patientemail = $obj->PATIENT_EMAIL;
                    $patientemergnum = $obj->PATIENT_EMERGNAME1;
                    $patientweight = $obj->PATIENT_WEIGHT;
                    $patientheight = $obj->PATIENT_HEIGHT;
                    $patientbloodgrp = $obj->PATIENT_BLOODGROUP;
                    $patientphoto = SHOST_IMAGES.$obj->PATIENT_IMAGE;
    					//$queue[]=array('REQU_CODE'=>$obj->REQU_CODE,'PATIENT_PATIENTCODE'=>$obj->PATIENT_PATIENTCODE,'PATIENT_FULLNAME'=>$obj->PATIENT_FNAME.' '.$obj->PATIENT_MNAME.' '.$obj->PATIENT_LNAME,'PATIENT_PATIENTNUM'=>$obj->PATIENT_PATIENTNUM,'PATIENT_PHONENUM'=>$obj->PATIENT_PHONENUM,'PATIENT_GENDER'=>$obj->PATIENT_GENDER,'PATIENT_MARITAL_STATUS'=>$obj->PATIENT_MARITAL_STATUS,'PATIENT_INPUTEDDATE'=>$obj->PATIENT_INPUTEDDATE,'PATIENT_AGE'=>$obj->PATIENT_AGE )
    				}
    				$views="requestqueue";
    		//	
    			}else{
    				$views="list";
    				$msg = 'No pending patient.';
               		$error = 'error';
    			}
    break;
	
    case "saveservicerequestqueue": //when approving queue
       // print_r($_POST);

        $postkey = $session->get("postkey");
        if ($postkey != $microtime){
            if (!empty($service)){
                //$requestcode = $engine->serviceRequestCode($faccode,$patientnum);
                //$visitcode = $engine->visitcode($faccode,$patientnum);
                $fcode = explode('@@@',$service);
                $servicecode = $fcode[0];
                $servicename = $fcode[1];
               // $pscheme = explode('@@@',$paymentscheme);
                //$payschemecode = $pscheme[0];
                //$payschemename = $pscheme[1];

                if ($servicecode == 'SER0001'){
                	$requeststatus = '2'; //to consulatation
                    $service=!empty($service)?explode('@@@',$service):'';
                    $servicecode=(is_array($service) && count($service) >0 )?$service[0]:'';
                    $servicename=(is_array($service) && count($service) >0 )?$service[1]:'';
                    $doctordept=!empty($prescribe)?explode('@@@',$prescribe):'';
                    $doctordeptcode=(is_array($doctordept) && count($doctordept) >0 )?$doctordept[0]:'';
                    $doctordeptname=(is_array($doctordept) && count($doctordept) >0 )?$doctordept[1]:'';
                    $doctor=!empty($prescribedoc)?explode('@@@',$prescribedoc):'';
                    $doctorcode=(is_array($doctor) && count($doctor) >0 )?$doctor[0]:'';
                    $doctorname=(is_array($doctor) && count($doctor) >0 )?$doctor[1]:'';
                }elseif ($servicecode == 'SER0002'){
                    $service=!empty($service)?explode('@@@',$service):'';
                    $servicecode=(is_array($service) && count($service) >0 )?$service[0]:'';
                    $servicename=(is_array($service) && count($service) >0 )?$service[1]:'';
                    $requeststatus = '7'; //to first aid
                }elseif ($servicecode == 'SER0004'){
                    $service=!empty($service)?explode('@@@',$service):'';
                    $servicecode=(is_array($service) && count($service) >0 )?$service[0]:'';
                    $servicename=(is_array($service) && count($service) >0 )?$service[1]:'';
                    $requeststatus = '8'; //to vitals
                }elseif($servicecode=='SER0010'){
                	$service=!empty($service)?explode('@@@',$service):'';
                    $servicecode=(is_array($service) && count($service) >0 )?$service[0]:'';
                    $servicename=(is_array($service) && count($service) >0 )?$service[1]:'';
                    $requeststatus = '11'; //emergency
                }
                

                if ($servicecode=='SER0002' || $servicecode=='SER0004'){
                	//update service request to first aid or vitals
				$stmt = $sql->Execute($sql->Prepare("UPDATE hms_service_request SET REQU_STATUS =".$sql->Param('a').",REQU_SERVICENAME=".$sql->Param('b').",REQU_SERVICECODE=".$sql->Param('c')." WHERE REQU_CODE=".$sql->Param('d')." AND REQU_PATIENTCODE=".$sql->Param('e')." AND REQU_FACICODE=".$sql->Param('f')." "),array($requeststatus,$servicename,$servicecode,$requestcode,$patientcode,$faccode));
				if ($servicecode=='SER0002'){
					//First Aid
					$stm = $sql->Execute($sql->Prepare("SELECT REQU_ID from hms_service_request WHERE REQU_CODE=".$sql->Param('a')." AND REQU_PATIENTCODE=".$sql->Param('b')." AND REQU_FACI_CODE=".$sql->Param('c')." LIMIT 1"),array($requestcode,$patientcode,$faccode));
					if ($stm->RecordCount()>0){
						while($objs=$stm->FetchNextObject){
							$tablerowid=$objs->REQU_ID;
						}
					}else{
						$tablerowid='';
					}
					$engine->setNotification('020',"Pending request to First Aid",'0001',$tablerowid,$sentto="",$faccode);
					$activity ="Service Request has been made to $servicename with requestcode $requestcode for patient with patient code $patiencode";
					$engine->setEventLog('046',$activity);
				}elseif ($servicecode=='SER0004'){
				$stm = $sql->Execute($sql->Prepare("SELECT REQU_ID from hms_service_request WHERE REQU_CODE=".$sql->Param('a')." AND REQU_PATIENTCODE=".$sql->Param('b')." AND REQU_FACI_CODE=".$sql->Param('c')." LIMIT 1"),array($requestcode,$patientcode,$faccode));
					if ($stm->RecordCount()>0){
						while($objs=$stm->FetchNextObject){
							$tablerowid=$objs->REQU_ID;
						}
					}else{
						$tablerowid='';
					}
					//Vitals
				$engine->setNotification('019',"Pending request for vitals",'0002',$tablerowid,$sentto="",$faccode);
				$activity ="Service Request has been made to $servicename with requestcode $requestcode for patient with patient code $patiencode";
				$engine->setEventLog('048',$activity);
				}
                }elseif ($servicecode=='SER0001'){
                	//send request to consuiltation
                	if (!empty($doctorname)){
                	
				$stmt = $sql->Execute($sql->Prepare("UPDATE hms_service_request SET REQU_STATUS =".$sql->Param('a').",REQU_SERVICENAME=".$sql->Param('b').",REQU_SERVICECODE=".$sql->Param('c').",REQU_DOCTORCODE=".$sql->Param('d').",REQU_DOCTORNAME=".$sql->Param('e')." WHERE REQU_CODE=".$sql->Param('b')." AND REQU_PATIENTCODE=".$sql->Param('c')." AND REQU_FACICODE=".$sql->Param('f')." "),array($requeststatus,$servicename,$servicecode,$doctorcode,$doctorname,$requestcode,$patientcode,$faccode));
					$actudate = date("Y-m-d H:m:s");
					$startdate= date("Y-m-d");
					$inputtime=date("H:m");
					$consltcode = $patientCls->getConsultCode($activeinstitution);
				    $objrequst = $patientCls->getServRequestDetail($requestcode);
                	 if($objrequst->REQU_FACI_CODE == 1){
			  				$objsrv = $engine->getDefaultService();
						  }
			 $sql->Execute("INSERT INTO hms_consultation(CONS_CODE,CONS_PATIENTCODE,CONS_REQUCONFIRMDATE,CONS_PATIENTNUM,CONS_PATIENTNAME,CONS_REQUCODE,CONS_DOCTORNAME,CONS_DOCTORCODE,CONS_FACICODE,CONS_VISITCODE,CONS_SERVICENAME,CONS_SERVICECODE,CONS_SCHEDULEDATE,CONS_SCHEDULETIME) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('j').",".$sql->Param('k').",".$sql->Param('l').",".$sql->Param('m').",".$sql->Param('n').") ",array($consltcode,$objrequst->REQU_PATIENTCODE,$actudate,$objrequst->REQU_PATIENTNUM,$objrequst->REQU_PATIENT_FULLNAME,$objrequst->REQU_CODE,$objrequst->REQU_DOCTORNAME,$objrequst->REQU_DOCTORCODE,$objrequst->REQU_FACI_CODE,$objrequst->REQU_VISITCODE,$objrequst->REQU_SERVICENAME,$objrequst->REQU_SERVICECODE,$startdate,$inputtime));	
			 $tablerowid=$sql->Insert_ID();

			 $sql->Execute("INSERT INTO hms_visit(VISIT_CODE,VISIT_INDEXNUM,VISIT_DATE,VISIT_PATIENT,VISIT_ACTORNAME,VISIT_ACTORCODE,
VISIT_FACICODE,VISIT_CASHAMT,VISIT_ALTAMT) VALUES ({$sql->Param('k')},{$sql->Param('k')},{$sql->Param('k')},{$sql->Param('k')},{$sql->Param('k')},{$sql->Param('k')},{$sql->Param('k')},{$sql->Param('k')},{$sql->Param('k')})",[$objrequst->REQU_VISITCODE,
                 $objrequst->REQU_PATIENTNUM,$startdate,$objrequst->REQU_PATIENT_FULLNAME,$objrequst->REQU_ACTORNAME,$faccode
                ,
                 ]);
			 print $sql->ErrorMsg();
					//Consultation
					
					$engine->setNotification('021',"Pending request to Consultation",'0005',$tablerowid,$sentto="",$faccode);
					$activity ="Service Request has been made to $servicename with requestcode $requestcode for patient with patient code $patiencode";
					$engine->setEventLog('047',$activity);	  
						  
                	}else{
                		 $msg = 'Please select prescriber.';
               			 $error = 'error';
                	}
                }elseif ($servicecode=='SER0010'){
                	//emergency request
                $stmt = $sql->Execute($sql->Prepare("UPDATE hms_service_request SET REQU_STATUS =".$sql->Param('a').",REQU_SERVICENAME=".$sql->Param('b').",REQU_SERVICECODE=".$sql->Param('c')." WHERE REQU_CODE=".$sql->Param('b')." AND REQU_PATIENTCODE=".$sql->Param('c')." AND REQU_FACICODE=".$sql->Param('f')." "),array($requeststatus,$servicename,$servicecode,$requestcode,$patientcode,$faccode));
					$actudate = date("Y-m-d H:m:s");
					$startdate= date("Y-m-d");
					$inputtime=date("H:m");
					$emergcode = $patientCls->getEmergCode($activeinstitution);
				    $objrequst = $patientCls->getServRequestDetail($requestcode);
                	 if($objrequst->REQU_FACI_CODE == 1){
			  				$objsrv = $engine->getDefaultService();
						  }
						  //insert into emergency table
			 $sql->Execute("INSERT INTO hms_emergency(EMER_CODE,EMER_PATIENTCODE,EMER_REQUCONFIRMDATE,EMER_PATIENTNUM,EMER_PATIENTNAME,EMER_REQUCODE,EMER_FACICODE,EMER_VISITCODE,EMER_SERVICENAME,EMER_SERVICECODE,EMER_SCHEDULEDATE,EMER_SCHEDULETIME) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('j').",".$sql->Param('k').",".$sql->Param('l').") ",array($emergcode,$objrequst->REQU_PATIENTCODE,$actudate,$objrequst->REQU_PATIENTNUM,$objrequst->REQU_PATIENT_FULLNAME,$objrequst->REQU_CODE,$objrequst->REQU_FACI_CODE,$objrequst->REQU_VISITCODE,$objrequst->REQU_SERVICENAME,$objrequst->REQU_SERVICECODE,$startdate,$inputtime));	
			 $tablerowid=$sql->Insert_ID(); 
			 print $sql->ErrorMsg();
					//Consultation
					
				//	$engine->setNotification('028',"Pending request to Emergency",'0005',$tablerowid,$sentto="",$faccode);
					$activity ="Service Request has been made to $servicename with requestcode $requestcode for patient with patient code $patiencode";
					$engine->setEventLog('064',$activity);	  
				}
                print $sql->ErrorMsg();

                if ($stmt){
                    $msg = 'You have successfully requested for '.$servicename.' service for patient with Number '.$patientnum;
                    $status = 'success';
                }
//                if ($paymentscheme == ''){}
            }else{
                $msg = 'All fields are required.';
                $status = 'error';
            }
        }else{
            $msg = 'Be sure you are accessing this page rightly';
            $status = 'error';
        }
        
        
$stmt= $sql->Execute($sql->Prepare("SELECT REQU_CODE,PATIENT_PATIENTCODE,PATIENT_FNAME,PATIENT_MNAME,PATIENT_LNAME,PATIENT_PATIENTNUM,PATIENT_PHONENUM,PATIENT_GENDER,PATIENT_MARITAL_STATUS,PATIENT_INPUTEDDATE,TIMESTAMPDIFF(YEAR,PATIENT_DOB,NOW()) AS PATIENT_DOB,PATIENT_BLOODGROUP,PATIENT_IMAGE,PATIENT_HEIGHT,PATIENT_WEIGHT,PATIENT_EMERGNAME1,PATIENT_EMAIL,PATIENT_PHONENUM FROM hms_patient JOIN hms_service_request ON PATIENT_PATIENTCODE=REQU_PATIENTCODE WHERE PATIENT_STATUS = ".$sql->Param('b')." AND PATIENT_FACILITYCODE=".$sql->Param('a')." AND REQU_STATUS=".$sql->Param('b')."ORDER BY PATIENT_INPUTEDDATE DESC LIMIT 1"),array('1',$faccode,'1'));
    			if ($stmt->RecordCount()>0){
    				while ($obj=$stmt->FetchNextObject()){
    				$requestcode=$obj->REQU_CODE;
                    $patientnum = $obj->PATIENT_PATIENTNUM;
                    $patientcode = $obj->PATIENT_PATIENTCODE;
                    $patient_fullname = $obj->PATIENT_FNAME.' '.$obj->PATIENT_MNAME.' '.$obj->PATIENT_LNAME;
                    $patientdob = $obj->PATIENT_DOB;
                    $patientgender = $obj->PATIENT_GENDER;
                    $patientphonenum = $obj->PATIENT_PHONENUM;
                    $patientemail = $obj->PATIENT_EMAIL;
                    $patientemergnum = $obj->PATIENT_EMERGNAME1;
                    $patientweight = $obj->PATIENT_WEIGHT;
                    $patientheight = $obj->PATIENT_HEIGHT;
                    $patientbloodgrp = $obj->PATIENT_BLOODGROUP;
                    $patientphoto = SHOST_IMAGES.$obj->PATIENT_IMAGE;
    					//$queue[]=array('REQU_CODE'=>$obj->REQU_CODE,'PATIENT_PATIENTCODE'=>$obj->PATIENT_PATIENTCODE,'PATIENT_FULLNAME'=>$obj->PATIENT_FNAME.' '.$obj->PATIENT_MNAME.' '.$obj->PATIENT_LNAME,'PATIENT_PATIENTNUM'=>$obj->PATIENT_PATIENTNUM,'PATIENT_PHONENUM'=>$obj->PATIENT_PHONENUM,'PATIENT_GENDER'=>$obj->PATIENT_GENDER,'PATIENT_MARITAL_STATUS'=>$obj->PATIENT_MARITAL_STATUS,'PATIENT_INPUTEDDATE'=>$obj->PATIENT_INPUTEDDATE,'PATIENT_AGE'=>$obj->PATIENT_AGE )
    				}
    				$views="requestqueue";
    		//	
    			}else{
    				$views="list";
    				$msg = 'No pending patient.';
               		$error = 'error';
    			}
    break;
	
	
    case "saveservicerequest": //approve individual request

       // print_r($_POST);
        $postkey = $session->get("postkey");
        if ($postkey != $microtime){
        	if (!empty($service)){
				
				 //$requestcode = $engine->serviceRequestCode($faccode,$patientnum);
                $visitcode = $engine->visitcode($faccode,$patientnum);
                $fcode = explode('@@@',$service);
                $servicecode = $fcode[0];
                $servicename = $fcode[1];
				$servicestatus = $fcode[2];
				
				
				
			
			// $stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_service_request(REQU_CODE,REQU_PATIENTCODE,REQU_PATIENTNUM,REQU_PATIENT_FULLNAME,REQU_SERVICECODE,REQU_SERVICENAME,REQU_FACI_CODE,REQU_VISITCODE,REQU_ACTORCODE,REQU_ACTORNAME,REQU_DOCTORCODE,REQU_DOCTORNAME,REQU_STATUS,REQU_DATE,REQU_INPUTEDDATE) VALUES (,".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('j').",".$sql->Param('k').",".$sql->Param('l').",".$sql->Param('m').",".$sql->Param('n').",".$sql->Param('o').")")
			//,array($requestcode,$patiendetails->PATIENT_PATIENTCODE,$patiendetails->PATIENT_PATIENTNUM,$patiendetails->PATIENT_FNAME.' '.$patiendetails->PATIENT_MNAME.' '.$patiendetails->PATIENT_LNAME,$servicecode,$servicename,$faccode,$visitcode,$actorcode,$actorname,$doctorcode,$doctorname,$requeststatus,$sql->userDate($crtdate,'Y-m-d'),$crtdate));
				
			//	$sql->Execute("INSERT INTO hms_visit(VISIT_CODE,VISIT_INDEXNUM,VISIT_DATE,VISIT_PATIENT,VISIT_ACTORNAME,VISIT_ACTORCODE,VISIT_FACICODE,VISIT_CASHAMT,VISIT_ALTAMT) VALUES ({$sql->Param('k')},{$sql->Param('k')},{$sql->Param('k')},{$sql->Param('k')},{$sql->Param('k')},{$sql->Param('k')},{$sql->Param('k')},{$sql->Param('k')},{$sql->Param('k')})",[$objrequst->REQU_VISITCODE,
            //     $objrequst->REQU_PATIENTNUM,$startdate,$objrequst->REQU_PATIENT_FULLNAME,$objrequst->REQU_ACTORNAME,$faccode
            //    ,
            //     ]);
				
				// exit;
                // $pscheme = explode('@@@',$paymentscheme);
                //$payschemecode = $pscheme[0];
                //$payschemename = $pscheme[1];

                if ($servicecode == 'SER0001'){
                	$requeststatus = '9'; //to consultation
                    $service=!empty($service)?explode('@@@',$service):'';
                    $servicecode=(is_array($service) && count($service) >0 )?$service[0]:'';
                    $servicename=(is_array($service) && count($service) >0 )?$service[1]:'';
                    $doctordept=!empty($prescribe)?explode('@@@',$prescribe):'';
                    $doctordeptcode=(is_array($doctordept) && count($doctordept) >0 )?$doctordept[0]:'';
                    $doctordeptname=(is_array($doctordept) && count($doctordept) >0 )?$doctordept[1]:'';
                    $doctor=!empty($prescribedoc)?explode('@@@',$prescribedoc):'';
                    $doctorcode=(is_array($doctor) && count($doctor) >0 )?$doctor[0]:'';
                    $doctorname=(is_array($doctor) && count($doctor) >0 )?$doctor[1]:'';
                    
                }elseif ($servicecode == 'SER0002'){
                    $service=!empty($service)?explode('@@@',$service):'';
                    $servicecode=(is_array($service) && count($service) >0 )?$service[0]:'';
                    $servicename=(is_array($service) && count($service) >0 )?$service[1]:'';
                    $requeststatus = '7'; //to first aid
                }elseif ($servicecode == 'SER0004'){
                    $service=!empty($service)?explode('@@@',$service):'';
                    $servicecode=(is_array($service) && count($service) >0 )?$service[0]:'';
                    $servicename=(is_array($service) && count($service) >0 )?$service[1]:'';
                    $requeststatus = '8'; //to vitals
                }elseif ($servicecode=='SER0010'){
					$service=!empty($service)?explode('@@@',$service):'';
                    $servicecode=(is_array($service) && count($service) >0 )?$service[0]:'';
                    $servicename=(is_array($service) && count($service) >0 )?$service[1]:'';
                    $requeststatus = '11'; //to emergency
                
				 }elseif ($servicecode=='SER0006'){
					$service=!empty($service)?explode('@@@',$service):'';
                    $servicecode=(is_array($service) && count($service) >0 )?$service[0]:'';
                    $servicename=(is_array($service) && count($service) >0 )?$service[1]:'';
                    $requeststatus = '5'; //to detain
                }elseif ($servicecode=='SER0005'){
					$service=!empty($service)?explode('@@@',$service):'';
                    $servicecode=(is_array($service) && count($service) >0 )?$service[0]:'';
                    $servicename=(is_array($service) && count($service) >0 )?$service[1]:'';
                    $requeststatus = '4'; //to admission
                }elseif ($servicecode=='SER0007'){
					$service=!empty($service)?explode('@@@',$service):'';
                    $servicecode=(is_array($service) && count($service) >0 )?$service[0]:'';
                    $servicename=(is_array($service) && count($service) >0 )?$service[1]:'';
                    $requeststatus = '12'; //to referral internal
                }   $requestcode = $engine->serviceRequestCode($faccode,$patientnum);
				
				
				$pmeth = explode('@@@', $paymentscheme);
				$pamethcode = $pmeth['0'];
				$pameth = $pmeth['1'];
				$paschcode = $pmeth['2'];
				$paschname = $pmeth['3'];
				
				$billcode = $coder->getbillitemCode();
				$paysett = $sett->getpaybeforesetting($faccode);
                $dy = Date('Y-m-d');
				
				$stmt=$sql->Execute($sql->Prepare("select VISIT_CODE from hms_visit where VISIT_PATIENTNUM =".$sql->Param('a')." AND VISIT_STATUS=".$sql->Param('b')." AND VISIT_FACICODE=".$sql->Param('c').""),array($patientnum,1,$faccode));
				if($stmt->RecordCount()>0){
					$obj=$stmt->fetchNextObject();
						$visitdate=$obj->VISIT_DATE;
					 $msg = 'Sorry! patient has active visit not closed: Visit Date '.$visitdate;
               		 $status = 'error';
					
					}else{
					
					
				
				$stmt=$sql->Execute($sql->Prepare("select REQU_SERVICENAME from hms_service_request where REQU_PATIENTNUM =".$sql->Param('a')." AND REQU_SERVICECODE=".$sql->Param('b')." AND REQU_STATUS=".$sql->Param('c').""),array($patientnum,$servicecode, $requeststatus));
				if($stmt->RecordCount()>0){
					$obj=$stmt->fetchNextObject();
					$service_name=$obj->REQU_SERVICENAME;
					 $msg = 'Sorry! patient has pending request: '.$service_name;
               		 $status = 'error';
					}else{
							
						//admission 
					if($servicecode=='SER0005'){
							
				$patiendetails =$patientCls->getPatientDetails($patientnum);
        	  	$visitcode = $engine->visitcode($faccode,$patientnum);
        	  	$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_service_request(REQU_CODE,REQU_PATIENTCODE,REQU_PATIENTNUM,REQU_PATIENT_FULLNAME,REQU_SERVICECODE,REQU_SERVICENAME,REQU_FACI_CODE,REQU_VISITCODE,REQU_ACTORCODE,REQU_ACTORNAME,REQU_DOCTORCODE,REQU_DOCTORNAME,REQU_STATUS,REQU_DATE,REQU_INPUTEDDATE) VALUES (".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('j').",".$sql->Param('k').",".$sql->Param('l').",".$sql->Param('m').",".$sql->Param('n').",".$sql->Param('o').")"),array($requestcode,$patiendetails->PATIENT_PATIENTCODE,$patiendetails->PATIENT_PATIENTNUM,$patiendetails->PATIENT_FNAME.' '.$patiendetails->PATIENT_MNAME.' '.$patiendetails->PATIENT_LNAME,$servicecode,$servicename,$faccode,$visitcode,$actorcode,$actorname,$doctorcode,$doctorname,$requeststatus,$sql->userDate($crtdate,'Y-m-d'),$crtdate));
				
				print $sql->ErrorMsg();
				$tablerowid=$sql->Insert_ID();	
				$sentto=$doctorcode;	
					
					$itemprice = $price->getserviceprice($servicecode,$faccode,$paschcode);
				$itemotherprice = $price->getserviceotherprice($servicecode,$faccode,$paschcode);
				
				$diff = $itemprice - $itemotherprice ;
				
				
				
			
								
				if($pamethcode == 'PC0001'){
				
				$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_visit(VISIT_CODE,VISIT_PATIENTCODE,VISIT_PATIENTNUM,VISIT_PATIENT,VISIT_DATE,VISIT_CASHAMT,VISIT_ACTORNAME,VISIT_ACTORCODE,VISIT_FACICODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').") "), 
				array($visitcode,$patientcode,$patientnum,$patient_fullname,$crtdate,$itemprice,$actorname,$actorcode,$faccode));
				print $sql->ErrorMsg();
				
				$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_billitem(B_CODE,B_SERVCODE,B_DT,B_PATIENTCODE,B_PATIENTNUM,B_PATIENT,B_VISITCODE,B_ITEM,B_ITEMNAME,B_PAYSCHEME,B_PAYSCHEMENAME,B_QTY,B_TOTAMT,B_CASHAMT,B_ALTAMT,B_DPT,B_FACICODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').",".$sql->Param('17').")"), array($billcode,$requestcode,$crtdate,$patientcode,$patientnum,$patient_fullname,$visitcode,$servicecode,$servicename,$paschcode,$paschname,'1',$itemprice,$itemprice,'0','ADMISSION',$faccode));
                print $sql->ErrorMsg();
				
				if($paysett == '0'){
					
					$stmt = $sql->Execute($sql->Prepare("UPDATE hms_consultation SET CONS_PAYSTATE =".$sql->Param('a')." WHERE CONS_VISITCODE=".$sql->Param('d')." AND CONS_PATIENTCODE=".$sql->Param('e')." AND CONS_FACICODE=".$sql->Param('f').""),array('2',$visitcode,$patientcode,$faccode));
			    
				}
				
									
				}else if($pamethcode == 'PC0002'){
					
				$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_visit(VISIT_CODE,VISIT_PATIENTCODE,VISIT_PATIENTNUM,VISIT_PATIENT,VISIT_DATE,VISIT_CASHAMT,VISIT_ALTAMT,VISIT_ACTORNAME,VISIT_ACTORCODE,VISIT_FACICODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').") "), 
				array($visitcode,$patientcode,$patientnum,$patient_fullname,$crtdate,$diff,$itemprice,$actorname,$actorcode,$faccode));
				print $sql->ErrorMsg();
				
				$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_billitem(B_CODE,B_SERVCODE,B_DT,B_PATIENTCODE,B_PATIENTNUM,B_PATIENT,B_VISITCODE,B_ITEM,B_ITEMNAME,B_PAYSCHEME,B_PAYSCHEMENAME,B_QTY,B_TOTAMT,B_CASHAMT,B_ALTAMT,B_DPT,B_FACICODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').",".$sql->Param('17').")"), array($billcode,$requestcode,$crtdate,$patientcode,$patientnum,$patient_fullname,$visitcode,$servicecode,$servicename,$paschcode,$paschname,'1',$itemprice,$diff,$itemprice,'ADMISSION',$faccode));
                print $sql->ErrorMsg();
				
				if($diff == '0'){
					
				$stmt = $sql->Execute($sql->Prepare("UPDATE hms_consultation SET CONS_PAYSTATE =".$sql->Param('a')." WHERE CONS_VISITCODE=".$sql->Param('d')." AND CONS_PATIENTCODE=".$sql->Param('e')." AND CONS_FACICODE=".$sql->Param('f').""),array('2',$visitcode,$patientcode,$faccode));
			    
				}
					
					
				}else{
					
				$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_visit(VISIT_CODE,VISIT_PATIENTCODE,VISIT_PATIENTNUM,VISIT_PATIENT,VISIT_DATE,VISIT_CASHAMT,VISIT_ALTAMT,VISIT_ACTORNAME,VISIT_ACTORCODE,VISIT_FACICODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').") "), 
				array($visitcode,$patientcode,$patientnum,$patient_fullname,$crtdate,$diff,$itemprice,$actorname,$actorcode,$faccode));
				print $sql->ErrorMsg();
				
				$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_billitem(B_CODE,B_SERVCODE,B_DT,B_PATIENTCODE,B_PATIENTNUM,B_PATIENT,B_VISITCODE,B_ITEM,B_ITEMNAME,B_PAYSCHEME,B_PAYSCHEMENAME,B_QTY,B_TOTAMT,B_CASHAMT,B_ALTAMT,B_DPT,B_FACICODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').",".$sql->Param('17').")"), array($billcode,$requestcode,$crtdate,$patientcode,$patientnum,$patient_fullname,$visitcode,$servicecode,$servicename,$paschcode,$paschname,'1',$itemprice,'0',$itemprice,'CONSULT',$faccode));
                print $sql->ErrorMsg();
					
				}
				
				 //setNotification($code,$desc,$menudetailscode,$tablerowid,$sentto="",$faccodeout="");
				 
				 $engine->setNotification('003',"Pending request to admission",'0055',$tablerowid,$sentto,$faccode);
							
						}
					
				 //sending to consultation
        	$stmtcheck=$sql->Execute($sql->Prepare("SELECT REQU_CODE from hms_service_request WHERE REQU_CODE=".$sql->Param('a')." AND REQU_FACI_CODE=".$sql->Param('b').""),array($requestcode,$faccode));
        	  if ($stmtcheck->RecordCount() < 1){
        	  	if ($servicecode=='SER0002' || $servicecode=='SER0004'){
        	  	$patiendetails =$patientCls->getPatientDetails($patientnum);
        	  	$visitcode = $engine->visitcode($faccode,$patientnum);
        	  	 
        	  	$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_service_request(REQU_CODE,REQU_PATIENTCODE,REQU_PATIENTNUM,REQU_PATIENT_FULLNAME,REQU_SERVICECODE,REQU_SERVICENAME,REQU_FACI_CODE,REQU_VISITCODE,REQU_ACTORCODE,REQU_ACTORNAME,REQU_STATUS,REQU_DATE,REQU_INPUTEDDATE) VALUES (".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('j').",".$sql->Param('k').",".$sql->Param('l').",".$sql->Param('m').")"),array($requestcode,$patiendetails->PATIENT_PATIENTCODE,$patiendetails->PATIENT_PATIENTNUM,$patiendetails->PATIENT_FNAME.' '.$patiendetails->PATIENT_MNAME.' '.$patiendetails->PATIENT_LNAME,$servicecode,$servicename,$faccode,$visitcode,$actorcode,$actorname,$requeststatus,$sql->userDate($crtdate,'Y-m-d'),$crtdate));
        	  	$itemprice = $price->getserviceprice($servicecode,$faccode,$paschcode);
				$itemotherprice = $price->getserviceotherprice($servicecode,$faccode,$paschcode);
				
				$diff = $itemprice - $itemotherprice ;
				//this coode has been reverted to comply with the vital post
				//insert into vitals
			/**	if($servicecode=='SER0004'){
						$vitalcode=$engine->getVitalsCode();
				$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_vitals (VITALS_CODE, VITALS_VISITCODE, VITALS_REQUCODE, VITALS_PATIENTID, VITALS_SERVICE,VITALS_FACILITYCODE,VITALS_PATIENTNO,VITALS_ACTOR,VITALS_DATE,VITALS_ACTOR_NAME,VITALS_PAYMENT)VALUES(".$sql->Param('a').",".$sql->Param('b').", ".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('g').",".$sql->Param('g').",".$sql->Param('g').",".$sql->Param('h').")"), array($vitalcode,$visitcode,$requestcode,$patientcode, $servicename,$faccode,$patientnum,$actorcode,date('Y-m-d'),$actorname,$paschcode));
				}**/
				
				
			
								
				if($pamethcode == 'PC0001'){
				
				$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_visit(VISIT_CODE,VISIT_PATIENTCODE,VISIT_PATIENTNUM,VISIT_PATIENT,VISIT_DATE,VISIT_CASHAMT,VISIT_ACTORNAME,VISIT_ACTORCODE,VISIT_FACICODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').") "), 
				array($visitcode,$patientcode,$patientnum,$patient_fullname,$crtdate,$itemprice,$actorname,$actorcode,$faccode));
				print $sql->ErrorMsg();
				
				$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_billitem(B_CODE,B_SERVCODE,B_DT,B_PATIENTCODE,B_PATIENTNUM,B_PATIENT,B_VISITCODE,B_ITEM,B_ITEMNAME,B_PAYSCHEME,B_PAYSCHEMENAME,B_QTY,B_TOTAMT,B_CASHAMT,B_ALTAMT,B_DPT,B_FACICODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').",".$sql->Param('17').")"), array($billcode,$requestcode,$crtdate,$patientcode,$patientnum,$patient_fullname,$visitcode,$servicecode,$servicename,$paschcode,$paschname,'1',$itemprice,$itemprice,'0','VF',$faccode));
                print $sql->ErrorMsg();
				
				if($paysett == '0'){
					
					$stmt = $sql->Execute($sql->Prepare("UPDATE hms_consultation SET CONS_PAYSTATE =".$sql->Param('a')." WHERE CONS_VISITCODE=".$sql->Param('d')." AND CONS_PATIENTCODE=".$sql->Param('e')." AND CONS_FACICODE=".$sql->Param('f').""),array('2',$visitcode,$patientcode,$faccode));
			    
				}
				
									
				}else if($pamethcode == 'PC0002'){
					
				$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_visit(VISIT_CODE,VISIT_PATIENTCODE,VISIT_PATIENTNUM,VISIT_PATIENT,VISIT_DATE,VISIT_CASHAMT,VISIT_ALTAMT,VISIT_ACTORNAME,VISIT_ACTORCODE,VISIT_FACICODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').") "), 
				array($visitcode,$patientcode,$patientnum,$patient_fullname,$crtdate,$diff,$itemprice,$actorname,$actorcode,$faccode));
				print $sql->ErrorMsg();
				
				$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_billitem(B_CODE,B_SERVCODE,B_DT,B_PATIENTCODE,B_PATIENTNUM,B_PATIENT,B_VISITCODE,B_ITEM,B_ITEMNAME,B_PAYSCHEME,B_PAYSCHEMENAME,B_QTY,B_TOTAMT,B_CASHAMT,B_ALTAMT,B_DPT,B_FACICODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').",".$sql->Param('17').")"), array($billcode,$requestcode,$crtdate,$patientcode,$patientnum,$patient_fullname,$visitcode,$servicecode,$servicename,$paschcode,$paschname,'1',$itemprice,$diff,$itemprice,'VF',$faccode));
                print $sql->ErrorMsg();
				
				if($diff == '0'){
					
				$stmt = $sql->Execute($sql->Prepare("UPDATE hms_consultation SET CONS_PAYSTATE =".$sql->Param('a')." WHERE CONS_VISITCODE=".$sql->Param('d')." AND CONS_PATIENTCODE=".$sql->Param('e')." AND CONS_FACICODE=".$sql->Param('f').""),array('2',$visitcode,$patientcode,$faccode));
			    
				}
					
					
				}else{
					
				$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_visit(VISIT_CODE,VISIT_PATIENTCODE,VISIT_PATIENTNUM,VISIT_PATIENT,VISIT_DATE,VISIT_CASHAMT,VISIT_ALTAMT,VISIT_ACTORNAME,VISIT_ACTORCODE,VISIT_FACICODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').") "), 
				array($visitcode,$patientcode,$patientnum,$patient_fullname,$crtdate,$diff,$itemprice,$actorname,$actorcode,$faccode));
				print $sql->ErrorMsg();
				
				$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_billitem(B_CODE,B_SERVCODE,B_DT,B_PATIENTCODE,B_PATIENTNUM,B_PATIENT,B_VISITCODE,B_ITEM,B_ITEMNAME,B_PAYSCHEME,B_PAYSCHEMENAME,B_QTY,B_TOTAMT,B_CASHAMT,B_ALTAMT,B_DPT,B_FACICODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').",".$sql->Param('17').")"), array($billcode,$requestcode,$crtdate,$patientcode,$patientnum,$patient_fullname,$visitcode,$servicecode,$servicename,$paschcode,$paschname,'1',$itemprice,'0',$itemprice,'VF',$faccode));
                print $sql->ErrorMsg();
					
				}
				
				
				
				
				if ($servicecode=='SER0002'){
        	  	$stm = $sql->Execute($sql->Prepare("SELECT REQU_ID from hms_service_request WHERE REQU_CODE=".$sql->Param('a')." AND REQU_PATIENTCODE=".$sql->Param('b')." AND REQU_FACI_CODE=".$sql->Param('c')." LIMIT 1"),array($requestcode,$patientcode,$faccode));
					if ($stm->RecordCount()>0){
						while($objs=$stm->FetchNextObject){
							$tablerowid=$objs->REQU_ID;
						}
					}else{
						$tablerowid='';
					}
					//First Aid
					$engine->setNotification('020',"Pending request to First Aid",'0001',$tablerowid,$sentto="",$faccode);
					$activity ="Service Request has been made to $servicename with requestcode $requestcode for patient with patient code $patiencode";
					$engine->setEventLog('046',$activity);
				}elseif ($servicecode=='SER0004'){
				$stm = $sql->Execute($sql->Prepare("SELECT REQU_ID from hms_service_request WHERE REQU_CODE=".$sql->Param('a')." AND REQU_PATIENTCODE=".$sql->Param('b')." AND REQU_FACI_CODE=".$sql->Param('c')." LIMIT 1"),array($requestcode,$patientcode,$faccode));
					if ($stm->RecordCount()>0){
						while($objs=$stm->FetchNextObject){
							$tablerowid=$objs->REQU_ID;
						}
					}else{
						$tablerowid='';
					}
					//Vitals
				$engine->setNotification('019',"Pending request for vitals",'0002',$tablerowid,$sentto="",$faccode);
				$activity ="Service Request has been made to $servicename with requestcode $requestcode for patient with patient code $patiencode";
				$engine->setEventLog('048',$activity);
				}
				
        	  	}elseif($servicecode=='SER0001'){
        	  	//	echo "BOOOOOOOOOOOOOOOOOOOOOOOOOOOOM";die();
        	  	
        	  		if (!empty($doctorname)){
						
						
				
				$patiendetails =$patientCls->getPatientDetails($patientnum);
        	  	$visitcode = $engine->visitcode($faccode,$patientnum);
        	  	 $stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_service_request(REQU_CODE,REQU_PATIENTCODE,REQU_PATIENTNUM,REQU_PATIENT_FULLNAME,REQU_SERVICECODE,REQU_SERVICENAME,REQU_FACI_CODE,REQU_VISITCODE,REQU_ACTORCODE,REQU_ACTORNAME,REQU_DOCTORCODE,REQU_DOCTORNAME,REQU_STATUS,REQU_DATE,REQU_INPUTEDDATE,REQU_PAYMETHCODE,REQU_PAYMETH) VALUES (".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('j').",".$sql->Param('k').",".$sql->Param('l').",".$sql->Param('m').",".$sql->Param('n').",".$sql->Param('o').",".$sql->Param('q').",".$sql->Param('r').")"),array($requestcode,$patiendetails->PATIENT_PATIENTCODE,$patiendetails->PATIENT_PATIENTNUM,$patiendetails->PATIENT_FNAME.' '.$patiendetails->PATIENT_MNAME.' '.$patiendetails->PATIENT_LNAME,$servicecode,$servicename,$faccode,$visitcode,$actorcode,$actorname,$doctorcode,$doctorname,$requeststatus,$sql->userDate($crtdate,'Y-m-d'),$crtdate,$paschcode,$paschname));
				$actudate = date("Y-m-d H:m:s");
					$startdate= date("Y-m-d");
					//$startdate = $sql->BindDate($engine->getDateFormat($startdate));
					$inputtime=date("H:m");
					$consltcode = $patientCls->getConsultCode($activeinstitution);
				    $objrequst = $patientCls->getServRequestDetail($requestcode);
                	 if($objrequst->REQU_FACI_CODE == 1){
			  				$objsrv = $engine->getDefaultService();
						  }
						  //Insert value in consultation table
			  $sql->Execute("INSERT INTO hms_consultation(CONS_CODE,CONS_PATIENTCODE,CONS_REQUCONFIRMDATE,CONS_PATIENTNUM,CONS_PATIENTNAME,CONS_REQUCODE,CONS_DOCTORNAME,CONS_DOCTORCODE,CONS_FACICODE,CONS_VISITCODE,CONS_SERVICENAME,CONS_SERVICECODE,CONS_SCHEDULEDATE,CONS_SCHEDULETIME,CONS_PAYMETHCODE,CONS_PAYMETH,CONS_DATE) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('j').",".$sql->Param('k').",".$sql->Param('l').",".$sql->Param('m').",".$sql->Param('n').",".$sql->Param('n').",".$sql->Param('n').",".$sql->Param('o').") ",array($consltcode,$objrequst->REQU_PATIENTCODE,$actudate,$objrequst->REQU_PATIENTNUM,$objrequst->REQU_PATIENT_FULLNAME,$objrequst->REQU_CODE,$objrequst->REQU_DOCTORNAME,$objrequst->REQU_DOCTORCODE,$objrequst->REQU_FACI_CODE,$objrequst->REQU_VISITCODE,$objrequst->REQU_SERVICENAME,$objrequst->REQU_SERVICECODE,$startdate,$inputtime,$paschcode,$paschname,$actudate));	
				$tablerowid=$sql->Insert_ID();
			  print $sql->ErrorMsg();
			  //Consultation ,$paschcode,$paschname
			 // setNotification($code,$desc,$menudetailscode,$tablerowid,$sentto="",$faccodeout="")
					$engine->setNotification('021',"Pending request to Consultation",'0005',$tablerowid,$sentto="",$faccode);
					$activity ="Service Request has been made to $servicename with requestcode $requestcode for patient with patient code $patiencode";
					$engine->setEventLog('047',$activity);
			//	$engine->setNotification('019',"Pending request for vitals",'0002',$tablerowid,$sentto="",$faccode);
			
				
				$itemprice = $price->getserviceprice($servicecode,$faccode,$paschcode);
				$itemotherprice = $price->getserviceotherprice($servicecode,$faccode,$paschcode);
				
				$diff = $itemprice - $itemotherprice ;
				
				
				
			
								
				if($pamethcode == 'PC0001'){
				
				$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_visit(VISIT_CODE,VISIT_PATIENTCODE,VISIT_PATIENTNUM,VISIT_PATIENT,VISIT_DATE,VISIT_CASHAMT,VISIT_ACTORNAME,VISIT_ACTORCODE,VISIT_FACICODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').") "), 
				array($visitcode,$patientcode,$patientnum,$patient_fullname,$crtdate,$itemprice,$actorname,$actorcode,$faccode));
				print $sql->ErrorMsg();
				
				$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_billitem(B_CODE,B_SERVCODE,B_DT,B_PATIENTCODE,B_PATIENTNUM,B_PATIENT,B_VISITCODE,B_ITEM,B_ITEMNAME,B_PAYSCHEME,B_PAYSCHEMENAME,B_QTY,B_TOTAMT,B_CASHAMT,B_ALTAMT,B_DPT,B_FACICODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').",".$sql->Param('17').")"), array($billcode,$requestcode,$crtdate,$patientcode,$patientnum,$patient_fullname,$visitcode,$servicecode,$servicename,$paschcode,$paschname,'1',$itemprice,$itemprice,'0','CONSULT',$faccode));
                print $sql->ErrorMsg();
				
				if($paysett == '0'){
					
					$stmt = $sql->Execute($sql->Prepare("UPDATE hms_consultation SET CONS_PAYSTATE =".$sql->Param('a')." WHERE CONS_VISITCODE=".$sql->Param('d')." AND CONS_PATIENTCODE=".$sql->Param('e')." AND CONS_FACICODE=".$sql->Param('f').""),array('2',$visitcode,$patientcode,$faccode));
			    
				}
				
									
				}else if($pamethcode == 'PC0002'){
					
				$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_visit(VISIT_CODE,VISIT_PATIENTCODE,VISIT_PATIENTNUM,VISIT_PATIENT,VISIT_DATE,VISIT_CASHAMT,VISIT_ALTAMT,VISIT_ACTORNAME,VISIT_ACTORCODE,VISIT_FACICODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').") "), 
				array($visitcode,$patientcode,$patientnum,$patient_fullname,$crtdate,$diff,$itemprice,$actorname,$actorcode,$faccode));
				print $sql->ErrorMsg();
				
				$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_billitem(B_CODE,B_SERVCODE,B_DT,B_PATIENTCODE,B_PATIENTNUM,B_PATIENT,B_VISITCODE,B_ITEM,B_ITEMNAME,B_PAYSCHEME,B_PAYSCHEMENAME,B_QTY,B_TOTAMT,B_CASHAMT,B_ALTAMT,B_DPT,B_FACICODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').",".$sql->Param('17').")"), array($billcode,$requestcode,$crtdate,$patientcode,$patientnum,$patient_fullname,$visitcode,$servicecode,$servicename,$paschcode,$paschname,'1',$itemprice,$diff,$itemprice,'CONSULT',$faccode));
                print $sql->ErrorMsg();
				
				if($diff == '0'){
					
				$stmt = $sql->Execute($sql->Prepare("UPDATE hms_consultation SET CONS_PAYSTATE =".$sql->Param('a')." WHERE CONS_VISITCODE=".$sql->Param('d')." AND CONS_PATIENTCODE=".$sql->Param('e')." AND CONS_FACICODE=".$sql->Param('f').""),array('2',$visitcode,$patientcode,$faccode));
			    
				}
					
					
				}else{
					
				$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_visit(VISIT_CODE,VISIT_PATIENTCODE,VISIT_PATIENTNUM,VISIT_PATIENT,VISIT_DATE,VISIT_CASHAMT,VISIT_ALTAMT,VISIT_ACTORNAME,VISIT_ACTORCODE,VISIT_FACICODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",,".$sql->Param('10').") "), 
				array($visitcode,$patientcode,$patientnum,$patient_fullname,$crtdate,$diff,$itemprice,$actorname,$actorcode,$faccode));
				print $sql->ErrorMsg();
				
				$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_billitem(B_CODE,B_SERVCODE,B_DT,B_PATIENTCODE,B_PATIENTNUM,B_PATIENT,B_VISITCODE,B_ITEM,B_ITEMNAME,B_PAYSCHEME,B_PAYSCHEMENAME,B_QTY,B_TOTAMT,B_CASHAMT,B_ALTAMT,B_DPT,B_FACICODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').",".$sql->Param('17').")"), array($billcode,$requestcode,$crtdate,$patientcode,$patientnum,$patient_fullname,$visitcode,$servicecode,$servicename,$paschcode,$paschname,'1',$itemprice,'0',$itemprice,'CONSULT',$faccode));
                print $sql->ErrorMsg();
					
				}
				
					
                }else{
						
                	$msg = 'Please select prescriber.';
               		$status = 'error';
						 
                }
                
        	  	}elseif ($servicecode=='SER0010'){
        	  		//request to emergency
        	  		//echo $faccode;die();
        	  	$patiendetails =$patientCls->getPatientDetails($patientnum);
        	  	$visitcode = $engine->visitcode($faccode,$patientnum);
        	  	//echo $patientnum; die();
        	  	 $stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_service_request(REQU_CODE,REQU_PATIENTCODE,REQU_PATIENTNUM,REQU_PATIENT_FULLNAME,REQU_SERVICECODE,REQU_SERVICENAME,REQU_FACI_CODE,REQU_VISITCODE,REQU_ACTORCODE,REQU_ACTORNAME,REQU_STATUS,REQU_DATE,REQU_INPUTEDDATE) VALUES (".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('j').",".$sql->Param('k').",".$sql->Param('l').",".$sql->Param('m').")"),array($requestcode,$patiendetails->PATIENT_PATIENTCODE,$patiendetails->PATIENT_PATIENTNUM,$patiendetails->PATIENT_FNAME.' '.$patiendetails->PATIENT_MNAME.' '.$patiendetails->PATIENT_LNAME,$servicecode,$servicename,$faccode,$visitcode,$actorcode,$actorname,$requeststatus,$sql->userDate($crtdate,'Y-m-d'),$crtdate));
        	  	 print $sql->ErrorMsg();
        	  	// echo $faccode;die();
				$actudate = date("Y-m-d H:m:s");
					$startdate= date("Y-m-d");
					//$startdate = $sql->BindDate($engine->getDateFormat($startdate));
					$inputtime=date("H:m");
					$emergcode = $patientCls->getEmergCode($activeinstitution);
				    $objrequst = $patientCls->getServRequestDetail($requestcode);
                	 if($objrequst->REQU_FACI_CODE == 1){
			  				$objsrv = $engine->getDefaultService();
						  }
						  //Insert value in emergency table
			  $sql->Execute("INSERT INTO hms_emergency(EMER_CODE,EMER_PATIENTCODE,EMER_REQUCONFIRMDATE,EMER_PATIENTNUM,EMER_PATIENTNAME,EMER_REQUCODE,EMER_FACICODE,EMER_VISITCODE,EMER_SERVICENAME,EMER_SERVICECODE,EMER_SCHEDULEDATE,EMER_SCHEDULETIME) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('j').",".$sql->Param('k').",".$sql->Param('l').") ",array($emergcode,$objrequst->REQU_PATIENTCODE,$actudate,$objrequst->REQU_PATIENTNUM,$objrequst->REQU_PATIENT_FULLNAME,$objrequst->REQU_CODE,$objrequst->REQU_FACI_CODE,$objrequst->REQU_VISITCODE,$objrequst->REQU_SERVICENAME,$objrequst->REQU_SERVICECODE,$startdate,$inputtime));	
				$tablerowid=$sql->Insert_ID();
			  print $sql->ErrorMsg();
			  //Consultation
			 // setNotification($code,$desc,$menudetailscode,$tablerowid,$sentto="",$faccodeout="")
					//$engine->setNotification('021',"Pending request to Emergency",'0005',$tablerowid,$sentto="",$faccode);
					$activity ="Service Request has been made to $servicename with requestcode $requestcode for patient with patient code $patiencode";
					$engine->setEventLog('064',$activity);
			//	$engine->setNotification('019',"Pending request for vitals",'0002',$tablerowid,$sentto="",$faccode);
                	/**}else{
                		 $msg = 'Please select prescriber.';
               			 $error = 'error';
                	}**/
                
        	  	$itemprice = $price->getserviceprice($servicecode,$faccode,$paschcode);
				$itemotherprice = $price->getserviceotherprice($servicecode,$faccode,$paschcode);
				
				$diff = $itemprice - $itemotherprice ;
										
				if($pamethcode == 'PC0001'){
				
				$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_visit(VISIT_CODE,VISIT_PATIENTCODE,VISIT_PATIENTNUM,VISIT_PATIENT,VISIT_DATE,VISIT_CASHAMT,VISIT_ACTORNAME,VISIT_ACTORCODE,VISIT_FACICODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').") "), 
				array($visitcode,$patientcode,$patientnum,$patient_fullname,$crtdate,$itemprice,$actorname,$actorcode,$faccode));
				print $sql->ErrorMsg();
				
				$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_billitem(B_CODE,B_SERVCODE,B_DT,B_PATIENTCODE,B_PATIENTNUM,B_PATIENT,B_VISITCODE,B_ITEM,B_ITEMNAME,B_PAYSCHEME,B_PAYSCHEMENAME,B_QTY,B_TOTAMT,B_CASHAMT,B_ALTAMT,B_DPT,B_FACICODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').",".$sql->Param('17').")"), array($billcode,$requestcode,$crtdate,$patientcode,$patientnum,$patient_fullname,$visitcode,$servicecode,$servicename,$paschcode,$paschname,'1',$itemprice,$itemprice,'0','EMER',$faccode));
                print $sql->ErrorMsg();
				
				if($paysett == '0'){
					
					$stmt = $sql->Execute($sql->Prepare("UPDATE hms_consultation SET CONS_PAYSTATE =".$sql->Param('a')." WHERE CONS_VISITCODE=".$sql->Param('d')." AND CONS_PATIENTCODE=".$sql->Param('e')." AND CONS_FACICODE=".$sql->Param('f').""),array('2',$visitcode,$patientcode,$faccode));
			    
				}
				
									
				}else if($pamethcode == 'PC0002'){
					
				$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_visit(VISIT_CODE,VISIT_PATIENTCODE,VISIT_PATIENTNUM,VISIT_PATIENT,VISIT_DATE,VISIT_CASHAMT,VISIT_ALTAMT,VISIT_ACTORNAME,VISIT_ACTORCODE,VISIT_FACICODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').") "), 
				array($visitcode,$patientcode,$patientnum,$patient_fullname,$crtdate,$diff,$itemprice,$actorname,$actorcode,$faccode));
				print $sql->ErrorMsg();
				
				$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_billitem(B_CODE,B_SERVCODE,B_DT,B_PATIENTCODE,B_PATIENTNUM,B_PATIENT,B_VISITCODE,B_ITEM,B_ITEMNAME,B_PAYSCHEME,B_PAYSCHEMENAME,B_QTY,B_TOTAMT,B_CASHAMT,B_ALTAMT,B_DPT,B_FACICODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').",".$sql->Param('17').")"), array($billcode,$requestcode,$crtdate,$patientcode,$patientnum,$patient_fullname,$visitcode,$servicecode,$servicename,$paschcode,$paschname,'1',$itemprice,$diff,$itemprice,'EMER',$faccode));
                print $sql->ErrorMsg();
				
				if($diff == '0'){
					
				$stmt = $sql->Execute($sql->Prepare("UPDATE hms_consultation SET CONS_PAYSTATE =".$sql->Param('a')." WHERE CONS_VISITCODE=".$sql->Param('d')." AND CONS_PATIENTCODE=".$sql->Param('e')." AND CONS_FACICODE=".$sql->Param('f').""),array('2',$visitcode,$patientcode,$faccode));
			    
				}
					
					
				}else{
					
				$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_visit(VISIT_CODE,VISIT_PATIENTCODE,VISIT_PATIENTNUM,VISIT_PATIENT,VISIT_DATE,VISIT_CASHAMT,VISIT_ALTAMT,VISIT_ACTORNAME,VISIT_ACTORCODE,VISIT_FACICODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').") "), 
				array($visitcode,$patientcode,$patientnum,$patient_fullname,$crtdate,$diff,$itemprice,$actorname,$actorcode,$faccode));
				print $sql->ErrorMsg();
				
				$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_billitem(B_CODE,B_SERVCODE,B_DT,B_PATIENTCODE,B_PATIENTNUM,B_PATIENT,B_VISITCODE,B_ITEM,B_ITEMNAME,B_PAYSCHEME,B_PAYSCHEMENAME,B_QTY,B_TOTAMT,B_CASHAMT,B_ALTAMT,B_DPT,B_FACICODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').",".$sql->Param('17').")"), array($billcode,$requestcode,$crtdate,$patientcode,$patientnum,$patient_fullname,$visitcode,$servicecode,$servicename,$paschcode,$paschname,'1',$itemprice,'0',$itemprice,'EMER',$faccode));
                print $sql->ErrorMsg();
					
				}
				
        	  		
        	  	}
        	    print $sql->ErrorMsg();
        	  }else{
			    if ($servicecode=='SER0002' || $servicecode=='SER0004'){
				$stmt = $sql->Execute($sql->Prepare("UPDATE hms_service_request SET REQU_STATUS =".$sql->Param('a').",REQU_SERVICENAME=".$sql->Param('b').",REQU_SERVICECODE=".$sql->Param('c')." WHERE REQU_CODE=".$sql->Param('d')." AND REQU_PATIENTCODE=".$sql->Param('e')." AND REQU_FACICODE=".$sql->Param('f').""),array($requeststatus,$servicename,$servicecode,$requestcode,$patientcode,$faccode));
			    	if ($servicecode=='SER0002'){
			    	$stm = $sql->Execute($sql->Prepare("SELECT REQU_ID from hms_service_request WHERE REQU_CODE=".$sql->Param('a')." AND REQU_PATIENTCODE=".$sql->Param('b')." AND REQU_FACI_CODE=".$sql->Param('c')." LIMIT 1"),array($requestcode,$patientcode,$faccode));
					if ($stm->RecordCount()>0){
						while($objs=$stm->FetchNextObject){
							$tablerowid=$objs->REQU_ID;
						}
					}else{
						$tablerowid='';
					}
					//First Aid
					$engine->setNotification('020',"Pending request to First Aid",'0001',$tablerowid,$sentto="",$faccode);
					$activity ="Service Request has been made to $servicename with requestcode $requestcode for patient with patient code $patiencode";
					$engine->setEventLog('046',$activity);
					
				}elseif ($servicecode=='SER0004'){
					
				$stm = $sql->Execute($sql->Prepare("SELECT REQU_ID from hms_service_request WHERE REQU_CODE=".$sql->Param('a')." AND REQU_PATIENTCODE=".$sql->Param('b')." AND REQU_FACI_CODE=".$sql->Param('c')." LIMIT 1"),array($requestcode,$patientcode,$faccode));
					if ($stm->RecordCount()>0){
						while($objs=$stm->FetchNextObject){
							$tablerowid=$objs->REQU_ID;
						}
					}else{
						$tablerowid='';
					}
					//Vitals
				$engine->setNotification('019',"Pending request for vitals",'0002',$tablerowid,$sentto="",$faccode);
				$activity ="Service Request has been made to $servicename with requestcode $requestcode for patient with patient code $patiencode";
				$engine->setEventLog('048',$activity);
				}
				//$engine->setNotification($code,$desc,$menudetailscode,$tablerowid,$sentto="",$faccodeout="");
                }
                elseif ($servicecode=='SER0010'){
                	
        	  		//request to emergency
        	  		
        	  	$patiendetails =$patientCls->getPatientDetails($patientnum);
        	  	$visitcode = $engine->visitcode($faccode,$patientnum);
        	  	 $stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_service_request(REQU_CODE,REQU_PATIENTCODE,REQU_PATIENTNUM,REQU_PATIENT_FULLNAME,REQU_SERVICECODE,REQU_SERVICENAME,REQU_FACI_CODE,REQU_VISITCODE,REQU_ACTORCODE,REQU_ACTORNAME,REQU_STATUS,REQU_DATE,REQU_INPUTEDDATE) VALUES (".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('j').",".$sql->Param('k').",".$sql->Param('l').",".$sql->Param('m').")"),array($requestcode,$patiendetails->PATIENT_PATIENTCODE,$patiendetails->PATIENT_PATIENTNUM,$patiendetails->PATIENT_FNAME.' '.$patiendetails->PATIENT_MNAME.' '.$patiendetails->PATIENT_LNAME,$servicecode,$servicename,$faccode,$visitcode,$actorcode,$actorname,$requeststatus,$sql->userDate($crtdate,'Y-m-d'),$crtdate));
				$actudate = date("Y-m-d H:m:s");
					$startdate= date("Y-m-d");
					//$startdate = $sql->BindDate($engine->getDateFormat($startdate));
					$inputtime=date("H:m");
					$emergcode = $patientCls->getEmergCode($activeinstitution);
				    $objrequst = $patientCls->getServRequestDetail($requestcode);
                	 if($objrequst->REQU_FACI_CODE == 1){
			  				$objsrv = $engine->getDefaultService();
						  }
						  //Insert value in emergency table
			  $sql->Execute("INSERT INTO hms_emergency(EMER_CODE,EMER_PATIENTCODE,EMER_REQUCONFIRMDATE,EMER_PATIENTNUM,EMER_PATIENTNAME,EMER_REQUCODE,EMER_FACICODE,EMER_VISITCODE,EMER_SERVICENAME,EMER_SERVICECODE,EMER_SCHEDULEDATE,EMER_SCHEDULETIME) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('j').",".$sql->Param('k').",".$sql->Param('l').") ",array($emergcode,$objrequst->REQU_PATIENTCODE,$actudate,$objrequst->REQU_PATIENTNUM,$objrequst->REQU_PATIENT_FULLNAME,$objrequst->REQU_CODE,$objrequst->REQU_FACI_CODE,$objrequst->REQU_VISITCODE,$objrequst->REQU_SERVICENAME,$objrequst->REQU_SERVICECODE,$startdate,$inputtime));	
				$tablerowid=$sql->Insert_ID();
			  print $sql->ErrorMsg();
			  //Consultation
			 // setNotification($code,$desc,$menudetailscode,$tablerowid,$sentto="",$faccodeout="")
					//$engine->setNotification('021',"Pending request to Emergency",'0005',$tablerowid,$sentto="",$faccode);
					$activity ="Service Request has been made to $servicename with requestcode $requestcode for patient with patient code $patiencode";
					$engine->setEventLog('064',$activity);
			//	$engine->setNotification('019',"Pending request for vitals",'0002',$tablerowid,$sentto="",$faccode);
                	/**}else{
                		 $msg = 'Please select prescriber.';
               			 $error = 'error';
                	}**/
                $itemprice = $price->getserviceprice($servicecode,$faccode,$paschcode);
				$itemotherprice = $price->getserviceotherprice($servicecode,$faccode,$paschcode);
				
				$diff = $itemprice - $itemotherprice ;
										
				if($pamethcode == 'PC0001'){
				
				$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_visit(VISIT_CODE,VISIT_PATIENTCODE,VISIT_PATIENTNUM,VISIT_PATIENT,VISIT_DATE,VISIT_CASHAMT,VISIT_ACTORNAME,VISIT_ACTORCODE,VISIT_FACICODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').") "), 
				array($visitcode,$patientcode,$patientnum,$patient_fullname,$crtdate,$itemprice,$actorname,$actorcode,$faccode));
				print $sql->ErrorMsg();
				
				$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_billitem(B_CODE,B_SERVCODE,B_DT,B_PATIENTCODE,B_PATIENTNUM,B_PATIENT,B_VISITCODE,B_ITEM,B_ITEMNAME,B_PAYSCHEME,B_PAYSCHEMENAME,B_QTY,B_TOTAMT,B_CASHAMT,B_ALTAMT,B_DPT,B_FACICODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').",".$sql->Param('17').")"), array($billcode,$requestcode,$crtdate,$patientcode,$patientnum,$patient_fullname,$visitcode,$servicecode,$servicename,$paschcode,$paschname,'1',$itemprice,$itemprice,'0','EMER',$faccode));
                print $sql->ErrorMsg();
				
				if($paysett == '0'){
					
					$stmt = $sql->Execute($sql->Prepare("UPDATE hms_consultation SET CONS_PAYSTATE =".$sql->Param('a')." WHERE CONS_VISITCODE=".$sql->Param('d')." AND CONS_PATIENTCODE=".$sql->Param('e')." AND CONS_FACICODE=".$sql->Param('f').""),array('2',$visitcode,$patientcode,$faccode));
			    
				}
				
									
				}else if($pamethcode == 'PC0002'){
					
				$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_visit(VISIT_CODE,VISIT_PATIENTCODE,VISIT_PATIENTNUM,VISIT_PATIENT,VISIT_DATE,VISIT_CASHAMT,VISIT_ALTAMT,VISIT_ACTORNAME,VISIT_ACTORCODE,VISIT_FACICODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').") "), 
				array($visitcode,$patientcode,$patientnum,$patient_fullname,$crtdate,$diff,$itemprice,$actorname,$actorcode,$faccode));
				print $sql->ErrorMsg();
				
				$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_billitem(B_CODE,B_SERVCODE,B_DT,B_PATIENTCODE,B_PATIENTNUM,B_PATIENT,B_VISITCODE,B_ITEM,B_ITEMNAME,B_PAYSCHEME,B_PAYSCHEMENAME,B_QTY,B_TOTAMT,B_CASHAMT,B_ALTAMT,B_DPT,B_FACICODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').",".$sql->Param('17').")"), array($billcode,$requestcode,$crtdate,$patientcode,$patientnum,$patient_fullname,$visitcode,$servicecode,$servicename,$paschcode,$paschname,'1',$itemprice,$diff,$itemprice,'EMER',$faccode));
                print $sql->ErrorMsg();
				
				if($diff == '0'){
					
				$stmt = $sql->Execute($sql->Prepare("UPDATE hms_consultation SET CONS_PAYSTATE =".$sql->Param('a')." WHERE CONS_VISITCODE=".$sql->Param('d')." AND CONS_PATIENTCODE=".$sql->Param('e')." AND CONS_FACICODE=".$sql->Param('f').""),array('2',$visitcode,$patientcode,$faccode));
			    
				}
					
					
				}else{
					
				$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_visit(VISIT_CODE,VISIT_PATIENTCODE,VISIT_PATIENTNUM,VISIT_PATIENT,VISIT_DATE,VISIT_CASHAMT,VISIT_ALTAMT,VISIT_ACTORNAME,VISIT_ACTORCODE,VISIT_FACICODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",,".$sql->Param('10').") "), 
				array($visitcode,$patientcode,$patientnum,$patient_fullname,$crtdate,$diff,$itemprice,$actorname,$actorcode,$faccode));
				print $sql->ErrorMsg();
				
				$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_billitem(B_CODE,B_SERVCODE,B_DT,B_PATIENTCODE,B_PATIENTNUM,B_PATIENT,B_VISITCODE,B_ITEM,B_ITEMNAME,B_PAYSCHEME,B_PAYSCHEMENAME,B_QTY,B_TOTAMT,B_CASHAMT,B_ALTAMT,B_DPT,B_FACICODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').",".$sql->Param('17').")"), array($billcode,$requestcode,$crtdate,$patientcode,$patientnum,$patient_fullname,$visitcode,$servicecode,$servicename,$paschcode,$paschname,'1',$itemprice,'0',$itemprice,'EMER',$faccode));
                print $sql->ErrorMsg();
					
				}
        	  	
        	  		
        	  	
                }
                elseif ($servicecode=='SER0001'){
                	if (!empty($doctorname)){
                	
				$stmt = $sql->Execute($sql->Prepare("UPDATE hms_service_request SET REQU_STATUS =".$sql->Param('a').",REQU_SERVICENAME=".$sql->Param('b').",REQU_SERVICECODE=".$sql->Param('c').",REQU_DOCTORCODE=".$sql->Param('d').",REQU_DOCTORNAME=".$sql->Param('e')." WHERE REQU_CODE=".$sql->Param('b')." AND REQU_PATIENTCODE=".$sql->Param('c')." AND REQU_FACICODE=".$sql->Param('f').""),array($requeststatus,$servicename,$servicecode,$doctorcode,$doctorname,$requestcode,$patientcode,$faccode));
				$actudate = date("Y-m-d H:m:s");
					$startdate= date("Y-m-d");
					//$startdate = $sql->BindDate($engine->getDateFormat($startdate));
					$inputtime=date("H:m");
					$consltcode = $patientCls->getConsultCode($activeinstitution);
				    $objrequst = $patientCls->getServRequestDetail($requestcode);
                	 if($objrequst->REQU_FACI_CODE == 1){
			  				$objsrv = $engine->getDefaultService();
						  }
						  //Insert value in consultation table
			  $sql->Execute("INSERT INTO hms_consultation(CONS_CODE,CONS_PATIENTCODE,CONS_REQUCONFIRMDATE,CONS_PATIENTNUM,CONS_PATIENTNAME,CONS_REQUCODE,CONS_DOCTORNAME,CONS_DOCTORCODE,CONS_FACICODE,CONS_VISITCODE,CONS_SERVICENAME,CONS_SERVICECODE,CONS_SCHEDULEDATE,CONS_SCHEDULETIME) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('j').",".$sql->Param('k').",".$sql->Param('l').",".$sql->Param('m').",".$sql->Param('n').") ",array($consltcode,$objrequst->REQU_PATIENTCODE,$actudate,$objrequst->REQU_PATIENTNUM,$objrequst->REQU_PATIENT_FULLNAME,$objrequst->REQU_CODE,$objrequst->REQU_DOCTORNAME,$objrequst->REQU_DOCTORCODE,$objrequst->REQU_FACI_CODE,$objrequst->REQU_VISITCODE,$objrequst->REQU_SERVICENAME,$objrequst->REQU_SERVICECODE,$startdate,$inputtime));	
			  $tablerowid=$sql->Insert_ID();
			  print $sql->ErrorMsg();
			  
				$engine->setNotification('021',"Pending request to Consultation",'0005',$tablerowid,$sentto="",$faccode);
				$activity ="Service Request has been made to $servicename with requestcode $requestcode for patient with patient code $patiencode";
				$engine->setEventLog('047',$activity);
			//	$engine->setNotification($code,$desc,$menudetailscode,$tablerowid,$sentto="",$faccodeout="");
                	}else{
                		 $msg = 'Please select prescriber.';
               			 $status = 'error';
                	}
                }
        	
                print $sql->ErrorMsg();
        	}
                if ($stmt){
                    $msg = 'You have successfully requested for '.$servicename.' service for patient with Number '.$patientnum;
                    $status = 'success';
					 
                	
                }
//                if ($paymentscheme == ''){}
            
				}
				
				}
				
				}else{
                $msg = 'All fields are required.';
                $status = 'error';
            }
        
        }else{
            $msg = 'Be sure you are accessing this page rightly';
            $status = 'error';
        }
    break;


	default:
		
	break;
}
	//Get countries
	//$stmtnatl = $sql->Execute($sql->Prepare("SELECT * FROM hms_countries_nationalities"));
	//$nationalities = array();
	/**while($natl = $stmtnatl->FetchNextObject()){
		$nationalities[]=$natl;
	}**/
	
	//$stmtrln = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_relation WHERE PR_PATIENTNUM = ".$sql->Param('a')." "),array($data));

   include 'model/js.php';



    if(!empty($fdsearch)){
	
        $query = "SELECT PATIENT_FNAME,PATIENT_MNAME,PATIENT_PATIENTCODE,PATIENT_LNAME,PATIENT_PATIENTNUM,PATIENT_PHONENUM,PATIENT_GENDER,PATIENT_MARITAL_STATUS,PATIENT_INPUTEDDATE,TIMESTAMPDIFF(YEAR,PATIENT_DOB,NOW()) AS PATIENT_AGE FROM hms_patient WHERE PATIENT_STATUS = ".$sql->Param('a')." AND PATIENT_FACILITYCODE=".$sql->Param('b')."  AND (PATIENT_PATIENTNUM = ".$sql->Param('c')." OR PATIENT_FNAME LIKE ".$sql->Param('d')." OR PATIENT_MNAME LIKE ".$sql->Param('e')." OR PATIENT_LNAME LIKE ".$sql->Param('f')." OR PATIENT_PHONENUM = ".$sql->Param('g')." OR PATIENT_EMAIL LIKE ".$sql->Param('h').") ORDER BY PATIENT_INPUTEDDATE DESC";
        $input = array('1',$faccode,$fdsearch,'%'.$fdsearch.'%','%'.$fdsearch.'%','%'.$fdsearch.'%','%'.$fdsearch,'%'.$fdsearch.'%');

    }
else{
	
	$query = "SELECT PATIENT_FNAME,PATIENT_PATIENTCODE,PATIENT_MNAME,PATIENT_LNAME,PATIENT_PATIENTNUM,PATIENT_PHONENUM,PATIENT_GENDER,PATIENT_MARITAL_STATUS,PATIENT_INPUTEDDATE,TIMESTAMPDIFF(YEAR,PATIENT_DOB,NOW()) AS PATIENT_AGE FROM hms_patient WHERE PATIENT_STATUS = ".$sql->Param('b')." AND PATIENT_FACILITYCODE=".$sql->Param('a')." ORDER BY PATIENT_INPUTEDDATE DESC";
    
 //   $query = "SELECT PATIENT_FNAME,PATIENT_PATIENTCODE,PATIENT_MNAME,PATIENT_LNAME,PATIENT_PATIENTNUM,PATIENT_PHONENUM,PATIENT_GENDER,PATIENT_MARITAL_STATUS,PATIENT_INPUTEDDATE,TIMESTAMPDIFF(YEAR,PATIENT_DOB,NOW()) AS PATIENT_AGE FROM hms_patient JOIN hms_service_request ON PATIENT_PATIENTCODE = REQU_PATIENTCODE WHERE PATIENT_STATUS = ".$sql->Param('b')." AND PATIENT_FACILITYCODE=".$sql->Param('a')." AND REQU_STATUS=".$sql->Param('b')."ORDER BY PATIENT_INPUTEDDATE DESC";
    $input = array('1',$faccode);
	$stmtpatpaymethlov = $sql->Execute($sql->prepare("SELECT * from hms_patient_paymentscheme where PAY_PATIENTNUMBER = ".$sql->Param('a')." and PAY_STATUS = ".$sql->Param('a')." "),array($patientnum,'1'));

//	$stmtspecimenlov = $sql->Execute($sql->prepare("SELECT * from hms_lab_specimen where SP_STATUS = ".$sql->Param('a').""),array('1'));

}

//  Get Pay Methods
//$stmtprescriber=$sql->Execute($sql->Prepare("SELECT USR_CODE,CONCAT(USR_SURNAME,' ',USR_SURNAME) USR_FULLNAME FROM hms_users "));


$stmtservcie=$sql->Execute($sql->Prepare("SELECT DISTINCT ST_SERVICE,ST_SERVICENAME from hms_assigndept WHERE ST_DEPT IN ($actordept) AND ST_FACICODE=".$sql->Param('b')." AND ST_STATUS=".$sql->Param('c')." "),array($faccode,'1'));

$stmtdepartments = $sql->Execute($sql->Prepare("SELECT DISTINCT ST_DEPT, ST_DEPTNAME from hms_assigndept WHERE ST_DEPT IN ($actordept) AND ST_FACICODE=".$sql->Param('b')." AND ST_STATUS=".$sql->Param('c')." AND ST_SERVICE=".$sql->Param('d')." "),array($faccode,'1','SER0001'));
/**
if (!empty($doctordeptcode)){
$stmtprescriber=$sql->Execute($sql->Prepare("SELECT USR_CODE,CONCAT(USR_SURNAME,' ',USR_OTHERNAME) USR_FULLNAME,USR_ONLINE_STATUS FROM hms_users JOIN hms_userdepartment ON USR_CODE=USRDEPT_USERCODE WHERE FIND_IN_SET('$doctordeptcode',USRDEPT_DEPTCODE) AND USR_FACICODE= ".$sql->Param('a')." AND USR_TYPE=".$sql->Param('b').""),array($faccode,'1'));
die();
   if ($stmtprescriber->RecordCount()>0){
   	while ($objp =$stmtprescriber->FetchNextObject()){
   		$alldoctors[]=array('CODE'=>$objp->USR_CODE,'FULLNAME'=>$objp->USR_FULLNAME,'STATUS'=>$objp->USR_STATUS);
   	}
   }else{
   	$alldoctors='';
   }
}
**/
//$stmtdepartments = $sql->Execute($sql->Prepare("SELECT DISTINCT ST_DEPT, ST_DEPTNAME from hms_assigndept WHERE ST_DEPT IN ($actordept) AND ST_FACICODE=".$sql->Param('b')." AND ST_STATUS=".$sql->Param('c')." AND ST_SERVICE=".$sql->Param('d')." "),array($faccode,'1','SER0001'));


$stmtprescriber=$sql->Execute($sql->Prepare("SELECT USR_CODE,CONCAT(USR_SURNAME,' ',USR_OTHERNAME) USR_FULLNAME,USR_ONLINE_STATUS FROM hms_users WHERE USR_FACICODE= ".$sql->Param('a')." AND USR_TYPE=".$sql->Param('b').""),array($faccode,'1'));
		/**if ($stmtprescriber->RecordCount()>0){
   	while ($objp =$stmtprescriber->FetchNextObject()){
   		$alldoctors[]=array('CODE'=>$objp->USR_CODE,'FULLNAME'=>$objp->USR_FULLNAME,'STATUS'=>$objp->USR_STATUS);
   	}
		}else{
   		$alldoctors='';
   	}**/
		

//  Get Service Request
// $stmtservcie = $sql->Execute($sql->Prepare("SELECT SERV_CODE,SERV_NAME FROM hmsb_services WHERE SERV_STATUS = '1' AND SERV_CODE IN ('SER0001','SER0002','SER0004') ORDER BY SERV_NAME DESC"));

if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=ad2376beebecdcf7846ba973fa1a005b&option=6831b98f85019ddb98bd98d44bdbac40#',$input);

?>