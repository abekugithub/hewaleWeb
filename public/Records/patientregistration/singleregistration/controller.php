<?php
$actorname = $engine->getActorName();

$patientCls = new patientClass();
$sms = new smsgetway();
$import = new importClass();
$price = new priceClass();
$faccode = $engine->getActorDetails()->USR_FACICODE;
$actorcode = $engine->getActorDetails()->USR_CODE;
$userid = $engine->getActorDetails()->USR_USERID;
$crtdate= date("Y-m-d H:m:s");
//print_r($_POST);

switch($viewpages){

	case "save":
		$postkey = $session->get("postkey");
        if($postkey != $microtime){
                //reset post key
                $session->set("postkey",$microtime);

            if (empty($patientcode)){
            if (!empty($fname)&&!empty($lastname)){

                $middle = "";
                $first = $fname[0];
                $last = $lastname[0];

                if (!empty($middlename)){
                $middle = $middlename[0];
                }

                $initial = strtoupper($first.$middle.$last);
                $pn_code = $patientCls->getPatientNum($initial);
                //$pn_code ="";


                //echo 'tmp_dir'.$tmp_dir;
                //echo $pn_code;
            //die();
            $patientnum = $pn_code;
            $patientcode = $patientCls->getPatientCode();
            $patientdate = date("Y-m-d");
            $facilitycode = "";

            //  Service Request Code Generation
            $requestcode = $engine->serviceRequestCode($faccode,$patientnum);
            //  Visit Code Generation
            $visitcode = $engine->visitcode($faccode,$patientnum);

                $dt = $dob_year.'-'.$dob_month.'-'.$dob_day;
                $dob = $sql->userDate($dt,'Y-m-d');

                $new_image_name = $import->uploadImage($_FILES['image'],SHOST_PATIENTPHOTO);
			    //$new_image_name = $import->remoteTransfer($_FILES['image'],SHOST_PATIENTPHOTO);

            $stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_patient (PATIENT_PATIENTNUM,PATIENT_PATIENTCODE,PATIENT_DATE,PATIENT_FNAME,PATIENT_MNAME,PATIENT_LNAME,PATIENT_DOB,PATIENT_GENDER,PATIENT_PHONENUM,PATIENT_ALTPHONENUM,PATIENT_ADDRESS,PATIENT_EMAIL,PATIENT_EMERGNUM1,PATIENT_EMERGNUM2,PATIENT_FACILITYCODE,PATIENT_SOURCE,PATIENT_EMERGNAME1,PATIENT_EMERGADDRESS1,PATIENT_EMERGNAME2,PATIENT_EMERGADDRESS2,PATIENT_BLOODGROUP,PATIENT_ALLERGIES,PATIENT_CHRONIC_CONDITION,PATIENT_NATIONALITY,PATIENT_COUNTRY_RESIDENT,PATIENT_MARITAL_STATUS,PATIENT_IMAGE,PATIENT_IDCARDTYPE,PATIENT_IDCARDNUM,PATIENT_DIGITALADDRESS,PATIENT_POSTADDRESS) VALUES (".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('d').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('d').",".$sql->Param('d').",".$sql->Param('d').",".$sql->Param('d').",".$sql->Param('d').")"),array($patientnum, $patientcode, $patientdate, $fname, $middlename, $lastname, $dob, $gender, $phonenumber, $altphonenumber, $residentialaddress, $email, $emerphonenumber1, $emerphonenumber2, $faccode, '2',$emername1,$emeraddress1,$emername2,$emeraddress2,$bgroup,$allergies,$conditions,$nationality,$residence,$mstatus,$new_image_name,'National ID',$nationalid,$digitaladdress,$address));
                print $sql->ErrorMsg();

                if ($stmt){
                    $msg = "Patient Saved Successfully. Patient's Hewale Number is: $patientnum";
                    $status = "success";

                    $activity = 'Patient Registration for - full name: '.$fname.' '.$middlename.' '.$lastname.' patient code: '.$patientcode.' by '.$actorname;
                    $engine->setEventLog('005',$activity);

                    // SMS to notify patient of successful registration to be done here.
                }

            }else{
                $msg = "Patient Was Not Saved.";
                $status = "error";
            }
            }else {
                if (!empty($fname)&&!empty($lastname)){

                    $dt = $dob_year.'-'.$dob_month.'-'.$dob_day;
                    $dob = $sql->userDate($dt,'Y-m-d');

                    if(!empty($_FILES['image']['tmp_name'])){
					
					$new_image_name = $import->uploadImage($_FILES['image'],SHOST_PATIENTPHOTO);
						
                      // $new_image_name = $import->remoteTransfer($_FILES['image'],SHOST_PATIENTPHOTO);
					}
					$new_image_name=(!empty($new_image_name)?$new_image_name:$patphoto);
			    $stmtupdate = $sql->Execute("UPDATE hms_patient SET PATIENT_FNAME = ".$sql->Param('a')." ,PATIENT_MNAME = ".$sql->Param('a')." ,PATIENT_LNAME = ".$sql->Param('a')." ,PATIENT_DOB = ".$sql->Param('a')." ,PATIENT_GENDER = ".$sql->Param('a')." ,PATIENT_PHONENUM = ".$sql->Param('a')." ,PATIENT_ALTPHONENUM = ".$sql->Param('a')." ,PATIENT_ADDRESS = ".$sql->Param('a')." ,PATIENT_EMAIL = ".$sql->Param('a')." ,PATIENT_EMERGNUM1 = ".$sql->Param('a')." ,PATIENT_EMERGNUM2 = ".$sql->Param('a')." ,PATIENT_FACILITYCODE = ".$sql->Param('a')." ,PATIENT_SOURCE = ".$sql->Param('a')." ,PATIENT_EMERGNAME1 = ".$sql->Param('a')." ,PATIENT_EMERGADDRESS1 = ".$sql->Param('a')." ,PATIENT_EMERGNAME2 = ".$sql->Param('a')." ,PATIENT_EMERGADDRESS2 = ".$sql->Param('a')." ,PATIENT_BLOODGROUP = ".$sql->Param('a')." ,PATIENT_ALLERGIES = ".$sql->Param('a')." ,PATIENT_CHRONIC_CONDITION = ".$sql->Param('a')." ,PATIENT_NATIONALITY = ".$sql->Param('a')." ,PATIENT_COUNTRY_RESIDENT = ".$sql->Param('a')." ,PATIENT_MARITAL_STATUS = ".$sql->Param('a')." ,PATIENT_IMAGE = ".$sql->Param('a')." ,PATIENT_IDCARDTYPE = ".$sql->Param('a')." ,PATIENT_IDCARDNUM = ".$sql->Param('a')." ,PATIENT_DIGITALADDRESS = ".$sql->Param('a')." ,PATIENT_POSTADDRESS = ".$sql->Param('a')." WHERE PATIENT_PATIENTCODE = ".$sql->Param('a')." ",array($fname, $middlename, $lastname, $dob, $gender, $phonenumber, $altphonenumber, $residentialaddress, $email, $emerphonenumber1, $emerphonenumber2, $faccode, '2',$emername1,$emeraddress1,$emername2,$emeraddress2,$bgroup,$allergies,$conditions,$nationality,$residence,$mstatus,$new_image_name,'National ID',$nationalid,$digitaladdress,$address,$patientcode));
                    print $sql->ErrorMsg();

                    if ($stmtupdate){
                        $activity = 'Update of Patient Registration for - full name: '.$fname.' '.$middlename.' '.$lastname.' patient code: '.$patientcode.' by '.$actorname;
                        $engine->setEventLog('005',$activity);

                        if (!empty($paymentscheme) && !empty($service)) {
                            //  Generate Service Request Code
                            $requestcode = $engine->serviceRequestCode($faccode, $patientnum);
                            //  Generate Visit Code
                            $visitcode = $engine->visitcode($faccode, $patientnum);
                            $serv = ((!empty($service))?explode('@@@', $service):'');
                            $servicecode = ((is_array($serv))?$serv[0]:'');
                            $servicename = ((is_array($serv))?$serv[1]:'');
                            $pscheme = explode('@@@', $paymentscheme);
                            $payschemecode = $pscheme[0];
                            $payschemename = $pscheme[1];
                            $patientname = $fname.' '.$middlename.' '.$lastname;

                           $requeststatus = $patientCls->getRequestStatus($servicecode);

                           if (!empty($requeststatus)){
                               $prescriber = (!empty($prescribe)?explode('@@@', $prescribe):'');
                               $prescribercode = ((is_array($prescriber) && count($prescriber)>0)?$prescriber[0]:'');
                               $prescribername = ((is_array($prescriber) && count($prescriber)>0)?$prescriber[1]:'');

                               //  Service Request for new patient after registration
                               $sql->Execute($sql->Prepare("INSERT INTO hms_service_request(REQU_CODE,REQU_PATIENTCODE,REQU_PATIENTNUM,REQU_PATIENT_FULLNAME,REQU_SERVICECODE,REQU_SERVICENAME,REQU_FACI_CODE,REQU_VISITCODE,REQU_ACTORCODE,REQU_ACTORNAME,REQU_STATUS,REQU_DATE,REQU_INPUTEDDATE,REQU_DOCTORCODE,REQU_DOCTORNAME) VALUES (" . $sql->Param('a') . "," . $sql->Param('b') . "," . $sql->Param('c') . "," . $sql->Param('d') . "," . $sql->Param('e') . "," . $sql->Param('f') . "," . $sql->Param('g') . "," . $sql->Param('h') . "," . $sql->Param('i') . "," . $sql->Param('j') . "," . $sql->Param('k') . "," . $sql->Param('l') . "," . $sql->Param('m') . "," . $sql->Param('n') . "," . $sql->Param('o') . ")"), array($requestcode, $patientcode, $patientnum, $patientname, $servicecode, $servicename, $faccode, $visitcode, $actorcode, $actorname, $requeststatus, $sql->userDate($crtdate, 'Y-m-d'), $crtdate,$prescribercode,$prescribername));
                               print $sql->ErrorMsg();
							  
							   $itemprice = $engine->getserviceprice($servicecode,$faccode,$paschcode);
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
					
				$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_visit(VISIT_CODE,VISIT_PATIENTCODE,VISIT_PATIENTNUM,VISIT_PATIENT,VISIT_DATE,VISIT_CASHAMT,VISIT_ALTAMT,VISIT_ACTORNAME,VISIT_ACTORCODE,VISIT_FACICODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').") "), 
				array($visitcode,$patientcode,$patientnum,$patient_fullname,$crtdate,$itemprice,$actorname,$actorcode,$faccode));
				print $sql->ErrorMsg();
				
				$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_billitem(B_CODE,B_SERVCODE,B_DT,B_PATIENTCODE,B_PATIENTNUM,B_PATIENT,B_VISITCODE,B_ITEM,B_ITEMNAME,B_PAYSCHEME,B_PAYSCHEMENAME,B_QTY,B_TOTAMT,B_CASHAMT,B_ALTAMT,B_DPT,B_FACICODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').",".$sql->Param('17').")"), array($billcode,$requestcode,$crtdate,$patientcode,$patientnum,$patient_fullname,$visitcode,$servicecode,$servicename,$paschcode,$paschname,'1',$itemprice,'0',$itemprice,'EMER',$faccode));
                print $sql->ErrorMsg();
					
				}
        	  	

                               $request_insertid = $sql->insert_id();

                               //  Event Log for Service Request
                               $activity = 'Service Request has been made for '.$patientname.' by '.$actorname.'. With Visitcode: '.$visitcode.' and Requestcode: '.$requestcode;
                               $engine->setEventLog('038',$activity);

                               if ($servicecode == 'SER0001'){
                                   //   To Consultation

                                   //  Get Consultation Code
                                   $consltcode = $patientCls->getConsultCode($faccode);
                                   //  Service Request for new patient after registration
                                   $sql->Execute($sql->Prepare("INSERT INTO hms_consultation(CONS_CODE, CONS_PATIENTNUM, CONS_PATIENTNAME, CONS_REQUCODE, CONS_VISITCODE, CONS_SERVICECODE, CONS_SERVICENAME, CONS_DOCTORNAME, CONS_DOCTORCODE, CONS_SCHEDULEDATE, CONS_FACICODE, CONS_SCHEDULETIME, CONS_PATIENTCODE,CONS_STATUS) VALUES (" . $sql->Param('a') . "," . $sql->Param('b') . "," . $sql->Param('c') . "," . $sql->Param('d') . "," . $sql->Param('e') . "," . $sql->Param('f') . "," . $sql->Param('g') . "," . $sql->Param('h') . "," . $sql->Param('i') . "," . $sql->Param('j') . "," . $sql->Param('k') . "," . $sql->Param('l') . "," . $sql->Param('m') . "," . $sql->Param('n') . ")"), array($consltcode, $patientnum, $patientname, $requestcode, $visitcode, $servicecode, $servicename, $prescribername, $prescribercode, $sql->userDate($crtdate, 'Y-m-d'), $faccode, $sql->userDate($crtdate, 'H:m:s'), $patientcode,'1'));
                                   print $sql->ErrorMsg();

                                   //  Event Log for Consultation Service Request
                                   $activity = 'Consultation Service Request has been made for '.$patientname.' by '.$actorname.'. Visitcode: '.$visitcode.'; Requestcode: '.$requestcode;
                                   $engine->setEventLog('047',$activity);

                                   //Send Notification
                                   $code = '017' ;
                                   $desc = "Patient in queue waiting for consultation.";
                                   $menudetailscode = '0005';
                                   //Get row id
                                   $smtpatdetails = $patientCls->getPatientDetails($patientnum);
                                   $tablerowid = $sql->insert_id();
                                   $sentto = '';
                                   $engine->setNotification($code,$desc,$menudetailscode,$tablerowid,$sentto,$faccode);
                               }elseif ($servicecode == 'SER0002'){
                                   //   First Aid

                                   //Send Notification
                                   $code = '020' ;
                                   $desc = "Patient in queue waiting for First Aid.";
                                   $menudetailscode = '0001';
                                   //Get row id
                                   $tablerowid = $request_insertid;
                                   $sentto = '';
                                   $engine->setNotification($code,$desc,$menudetailscode,$tablerowid,$sentto,$faccode);
                               }elseif ($servicecode == 'SER0004'){
                                   //   Vital

                                   //Send Notification
                                   $code = '019' ;
                                   $desc = "Patient in queue waiting for Vitals.";
                                   $menudetailscode = '0002';
                                   //Get row id
                                   $tablerowid = $request_insertid;
                                   $sentto = '';
                                   $engine->setNotification($code,$desc,$menudetailscode,$tablerowid,$sentto,$faccode);
                               }
                           }

                        }

//                        $msg = "Patient saved successfully and request for service has been raised for this patient.";
                        $msg = "Patient Registration was successfully. Patient's Hewale Number is: ".$patientnum;
                        $status = "success";
                    }

                }else{
                $msg = "Patient Was Not Saved.";
                $status = "error";
                }
            }
            $patientnum = '';
        }
	break;

    case "savegrouppatient":
        $postkey = $session->get("postkey");
        if ($postkey != $microtime){
            //reset post key
            $session->set("postkey",$microtime);

            if (!empty($saveoption)){
                if ($saveoption == '1'){
//                    $v = 'group';
                    $views = 'groupregistrationadd';
                }elseif ($saveoption == '2'){
//                    $v = 'group';
                    $views = 'groupregistrationlist';
                }
            }

            if (!empty($groupcode)){
                if (empty($patientcode)){
                    if (!empty($fname)&&!empty($lastname)){

                        $middle = "";
                        $first = $fname[0];
                        $last = $lastname[0];

                        if (!empty($middlename)){
                            $middle = $middlename[0];
                        }

                        $initial = strtoupper($first.$middle.$last);
                        $pn_code = $patientCls->getPatientNum($initial);
                        //$pn_code ="";


                        //echo 'tmp_dir'.$tmp_dir;
                        //echo $pn_code;
                        //die();
                        $patientnum = $pn_code;
                        $patientcode = $patientCls->getPatientCode();
                        $patientdate = date("Y-m-d");
                        $facilitycode = "";

                        //  Service Request Code Generation
                        $requestcode = $engine->serviceRequestCode($faccode,$patientnum);
                        //  Visit Code Generation
                        $visitcode = $engine->visitcode($faccode,$patientnum);

                        $dt = $dob_year.'-'.$dob_month.'-'.$dob_day;
                        $dob = $sql->userDate($dt,'Y-m-d');

                        // $new_image_name = $import->uploadImage($_FILES['image'],SHOST_IMAGES.DS.'patientphotos'.DS);
                        $new_image_name = $import->uploadImage($_FILES['image'],SHOST_PATIENTPHOTO);

                        $stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_patient (PATIENT_PATIENTNUM,PATIENT_PATIENTCODE,PATIENT_DATE,PATIENT_FNAME,PATIENT_MNAME,PATIENT_LNAME,PATIENT_DOB,PATIENT_GENDER,PATIENT_PHONENUM,PATIENT_ALTPHONENUM,PATIENT_ADDRESS,PATIENT_EMAIL,PATIENT_EMERGNUM1,PATIENT_EMERGNUM2,PATIENT_FACILITYCODE,PATIENT_SOURCE,PATIENT_EMERGNAME1,PATIENT_EMERGADDRESS1,PATIENT_EMERGNAME2,PATIENT_EMERGADDRESS2,PATIENT_BLOODGROUP,PATIENT_ALLERGIES,PATIENT_CHRONIC_CONDITION,PATIENT_NATIONALITY,PATIENT_COUNTRY_RESIDENT,PATIENT_MARITAL_STATUS,PATIENT_IMAGE,PATIENT_GROUPCODE) VALUES (".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('d').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('d').",".$sql->Param('d').")"),array($patientnum, $patientcode, $patientdate, $fname, $middlename, $lastname, $dob, $gender, $phonenumber, $altphonenumber, $address, $email, $emerphonenumber1, $emerphonenumber2, $faccode, '2',$emername1,$emeraddress1,$emername2,$emeraddress2,$bgroup,$allergies,$conditions,$nationality,$residence,$mstatus,$new_image_name,$groupcode));
                        print $sql->ErrorMsg();

                        if ($stmt){
                            $msg = "Patient Saved Successfully. Patient's Hewale Number is: $patientnum";
                            $status = "success";

                            $activity = 'Patient Registration for - full name: '.$fname.' '.$middlename.' '.$lastname.' patient code: '.$patientcode.' by '.$actorname;
                            $engine->setEventLog('005',$activity);

                            $patientcode = '';

                            // SMS to notify patient of successful registration to be done here.
                        }

                    }else{
                        $msg = "Patient Was Not Saved.";
                        $status = "error";
                    }
                }else{
                    if (!empty($fname)&&!empty($lastname)){

                        $dt = $dob_year.'-'.$dob_month.'-'.$dob_day;
                        $dob = $sql->userDate($dt,'Y-m-d');

                        if(!empty($_FILES['image']['tmp_name'])){
                            $new_image_name = $import->uploadImage($_FILES['image'],SHOST_PATIENTPHOTO);
                        }

                        $stmtupdate = $sql->Execute("UPDATE hms_patient SET PATIENT_FNAME = ".$sql->Param('a')." ,PATIENT_MNAME = ".$sql->Param('a')." ,PATIENT_LNAME = ".$sql->Param('a')." ,PATIENT_DOB = ".$sql->Param('a')." ,PATIENT_GENDER = ".$sql->Param('a')." ,PATIENT_PHONENUM = ".$sql->Param('a')." ,PATIENT_ALTPHONENUM = ".$sql->Param('a')." ,PATIENT_ADDRESS = ".$sql->Param('a')." ,PATIENT_EMAIL = ".$sql->Param('a')." ,PATIENT_EMERGNUM1 = ".$sql->Param('a')." ,PATIENT_EMERGNUM2 = ".$sql->Param('a')." ,PATIENT_FACILITYCODE = ".$sql->Param('a')." ,PATIENT_SOURCE = ".$sql->Param('a')." ,PATIENT_EMERGNAME1 = ".$sql->Param('a')." ,PATIENT_EMERGADDRESS1 = ".$sql->Param('a')." ,PATIENT_EMERGNAME2 = ".$sql->Param('a')." ,PATIENT_EMERGADDRESS2 = ".$sql->Param('a')." ,PATIENT_BLOODGROUP = ".$sql->Param('a')." ,PATIENT_ALLERGIES = ".$sql->Param('a')." ,PATIENT_CHRONIC_CONDITION = ".$sql->Param('a')." ,PATIENT_NATIONALITY = ".$sql->Param('a')." ,PATIENT_COUNTRY_RESIDENT = ".$sql->Param('a')." ,PATIENT_MARITAL_STATUS = ".$sql->Param('a')." ,PATIENT_IMAGE = ".$sql->Param('a')." ,PATIENT_GROUPCODE = ".$sql->Param('a')." WHERE PATIENT_PATIENTCODE = ".$sql->Param('a')." ",array($fname, $middlename, $lastname, $dob, $gender, $phonenumber, $altphonenumber, $address, $email, $emerphonenumber1, $emerphonenumber2, $faccode, '2',$emername1,$emeraddress1,$emername2,$emeraddress2,$bgroup,$allergies,$conditions,$nationality,$residence,$mstatus,$new_image_name,$groupcode,$patientcode));
                        print $sql->ErrorMsg();

                        if ($stmtupdate){
                            $activity = 'Update of Patient Registration for - full name: '.$fname.' '.$middlename.' '.$lastname.' patient code: '.$patientcode.' by '.$actorname;
                            $engine->setEventLog('005',$activity);

                            if (!empty($paymentscheme) && !empty($service)) {
                                //  Generate Service Request Code
                                $requestcode = $engine->serviceRequestCode($faccode, $patientnum);
                                //  Generate Visit Code
                                $visitcode = $engine->visitcode($faccode, $patientnum);
                                $serv = ((!empty($service))?explode('@@@', $service):'');
                                $servicecode = ((is_array($serv))?$serv[0]:'');
                                $servicename = ((is_array($serv))?$serv[1]:'');
                                $pscheme = explode('@@@', $paymentscheme);
                                $payschemecode = $pscheme[0];
                                $payschemename = $pscheme[1];
                                $patientname = $fname.' '.$middlename.' '.$lastname;

                                $requeststatus = $patientCls->getRequestStatus($servicecode);

                                if (!empty($requeststatus)){
                                    $prescriber = (!empty($prescribe)?explode('@@@', $prescribe):'');
                                    $prescribercode = ((is_array($prescriber) && count($prescriber)>0)?$prescriber[0]:'');
                                    $prescribername = ((is_array($prescriber) && count($prescriber)>0)?$prescriber[1]:'');

                                    //  Service Request for new patient after registration
                                    $sql->Execute($sql->Prepare("INSERT INTO hms_service_request(REQU_CODE,REQU_PATIENTCODE,REQU_PATIENTNUM,REQU_PATIENT_FULLNAME,REQU_SERVICECODE,REQU_SERVICENAME,REQU_FACI_CODE,REQU_VISITCODE,REQU_ACTORCODE,REQU_ACTORNAME,REQU_STATUS,REQU_DATE,REQU_INPUTEDDATE,REQU_DOCTORCODE,REQU_DOCTORNAME) VALUES (" . $sql->Param('a') . "," . $sql->Param('b') . "," . $sql->Param('c') . "," . $sql->Param('d') . "," . $sql->Param('e') . "," . $sql->Param('f') . "," . $sql->Param('g') . "," . $sql->Param('h') . "," . $sql->Param('i') . "," . $sql->Param('j') . "," . $sql->Param('k') . "," . $sql->Param('l') . "," . $sql->Param('m') . "," . $sql->Param('n') . "," . $sql->Param('o') . ")"), array($requestcode, $patientcode, $patientnum, $patientname, $servicecode, $servicename, $faccode, $visitcode, $actorcode, $actorname, $requeststatus, $sql->userDate($crtdate, 'Y-m-d'), $crtdate,$prescribercode,$prescribername));
                                    print $sql->ErrorMsg();

                                    $request_insertid = $sql->insert_id();

                                    //  Event Log for Service Request
                                    $activity = 'Service Request has been made for '.$patientname.' by '.$actorname.'. With Visitcode: '.$visitcode.' and Requestcode: '.$requestcode;
                                    $engine->setEventLog('038',$activity);

                                    if ($servicecode == 'SER0001'){
                                        //   To Consultation

                                        //  Get Consultation Code
                                        $consltcode = $patientCls->getConsultCode($faccode);
                                        //  Service Request for new patient after registration
                                        $sql->Execute($sql->Prepare("INSERT INTO hms_consultation(CONS_CODE, CONS_PATIENTNUM, CONS_PATIENTNAME, CONS_REQUCODE, CONS_VISITCODE, CONS_SERVICECODE, CONS_SERVICENAME, CONS_DOCTORNAME, CONS_DOCTORCODE, CONS_SCHEDULEDATE, CONS_FACICODE, CONS_SCHEDULETIME, CONS_PATIENTCODE,CONS_STATUS) VALUES (" . $sql->Param('a') . "," . $sql->Param('b') . "," . $sql->Param('c') . "," . $sql->Param('d') . "," . $sql->Param('e') . "," . $sql->Param('f') . "," . $sql->Param('g') . "," . $sql->Param('h') . "," . $sql->Param('i') . "," . $sql->Param('j') . "," . $sql->Param('k') . "," . $sql->Param('l') . "," . $sql->Param('m') . "," . $sql->Param('n') . ")"), array($consltcode, $patientnum, $patientname, $requestcode, $visitcode, $servicecode, $servicename, $prescribername, $prescribercode, $sql->userDate($crtdate, 'Y-m-d'), $faccode, $sql->userDate($crtdate, 'H:m:s'), $patientcode,'1'));
                                        print $sql->ErrorMsg();

                                        //  Event Log for Consultation Service Request
                                        $activity = 'Consultation Service Request has been made for '.$patientname.' by '.$actorname.'. Visitcode: '.$visitcode.'; Requestcode: '.$requestcode;
                                        $engine->setEventLog('047',$activity);

                                        //Send Notification
                                        $code = '017' ;
                                        $desc = "Patient in queue waiting for consultation.";
                                        $menudetailscode = '0005';
                                        //Get row id
                                        $smtpatdetails = $patientCls->getPatientDetails($patientnum);
                                        $tablerowid = $sql->insert_id();
                                        $sentto = '';
                                        $engine->setNotification($code,$desc,$menudetailscode,$tablerowid,$sentto,$faccode);
                                    }elseif ($servicecode == 'SER0002'){
                                        //   First Aid

                                        //Send Notification
                                        $code = '020' ;
                                        $desc = "Patient in queue waiting for First Aid.";
                                        $menudetailscode = '0001';
                                        //Get row id
                                        $tablerowid = $request_insertid;
                                        $sentto = '';
                                        $engine->setNotification($code,$desc,$menudetailscode,$tablerowid,$sentto,$faccode);
                                    }elseif ($servicecode == 'SER0004'){
                                        //   Vital

                                        //Send Notification
                                        $code = '019' ;
                                        $desc = "Patient in queue waiting for Vitals.";
                                        $menudetailscode = '0002';
                                        //Get row id
                                        $tablerowid = $request_insertid;
                                        $sentto = '';
                                        $engine->setNotification($code,$desc,$menudetailscode,$tablerowid,$sentto,$faccode);
                                    }
                                }

                            }

                            $msg = "Patient Registration was successfully. Patient's Hewale Number is: $patientnum";
                            $status = "success";
                        }

                    }else{
                        $msg = "Patient Was Not Saved.";
                        $status = "error";
                    }
                }

                //COUNT NUMBER OF MEMBERS BELONGING TO A GROUP
                $stmt_group = $sql->Execute($sql->Prepare("SELECT PATIENT_PATIENTNUM FROM hms_patient WHERE PATIENT_GROUPCODE = ".$sql->Param('a')),array($groupcode));
                print $sql->ErrorMsg();

                if ($stmt_group){
                    $numofpatient = $stmt_group->RecordCount();

                    $stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_group SET PATGRP_NUMBEROFPATIENT=".$sql->Param('a')." WHERE PATGRP_CODE=".$sql->Param('b')),array($numofpatient,$groupcode));
                    print $sql->ErrorMsg();
                }
            }else{
                $msg = "No Patient Group was selected";
                $status = "error";
//                $v = 'group';
                $views = 'groupregistrationlist';
            }

            //Make empty the following fields
            $patientcode = '';
            $fname = '';
            $lname = '';
        }
    break;

    case "reset":
        $fdsearch = '';
    break;

    case "patientdetails":
        if (isset($patkey) && !empty($patkey)){
            $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient WHERE PATIENT_PATIENTCODE = ".$sql->Param('a')." AND PATIENT_STATUS = '1'"),array($patkey));
            print $sql->ErrorMsg();

            if ($stmt->RecordCount()>0){
                while ($obj = $stmt->FetchNextObject()){
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
					//get passport picture
		            $picname = $patientCls->getPassPicture($patientnum);
		            $photourl = 'media/uploaded/patientphotos/'.$patientphoto;
                  
                }
            }
        }
    break;

    case "editpatient":
        $postkey = $session->get("postkey");
        if ($postkey != $microtime){
            if (!empty($keys)){
                $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient WHERE PATIENT_STATUS = '1' AND PATIENT_PATIENTCODE = ".$sql->Param('a').""),array($keys));
                print $sql->ErrorMsg();

                if ($stmt->RecordCount()>0){
                    $obj = $stmt->FetchNextObject();
                    $patientnum = $obj->PATIENT_PATIENTNUM;
                    $patientcode = $obj->PATIENT_PATIENTCODE;
                    $fname = $obj->PATIENT_FNAME;
                    $mname = $obj->PATIENT_MNAME;
                    $lname = $obj->PATIENT_LNAME;
                    $dob = explode('-',$obj->PATIENT_DOB);
                    $dob_year = $dob[0];
                    $dob_month = $dob[1];
                    $dob_day = $dob[2];
                    $gender = $obj->PATIENT_GENDER;
                    $phonenumber = $obj->PATIENT_PHONENUM;
                    $altphonenumber = $obj->PATIENT_ALTPHONENUM;
                    $residentialaddress = $obj->PATIENT_ADDRESS;
                    $postaladdress = $obj->PATIENT_POSTADDRESS;
                    $email = $obj->PATIENT_EMAIL;
                    $emergname1 = $obj->PATIENT_EMERGNAME1;
                    $emergnum1 = $obj->PATIENT_EMERGNUM1;
                    $emergadd1 = $obj->PATIENT_EMERGADDRESS1;
                    $emername2 = $obj->PATIENT_EMERGNAME2;
                    $emernum2 = $obj->PATIENT_EMERGNUM2;
                    $emeradd2 = $obj->PATIENT_EMERGADDRESS2;
                    $bloodgrp = $obj->PATIENT_BLOODGROUP;
                    $allergy = $obj->PATIENT_ALLERGIES;
                    $chronic = $obj->PATIENT_CHRONIC_CONDITION;
                    $national = $obj->PATIENT_NATIONALITY;
                    $mstatus = $obj->PATIENT_MARITAL_STATUS;
                    $countryofresidence = $obj->PATIENT_COUNTRY_RESIDENT;
                    $patientphoto = $obj->PATIENT_IMAGE;
					//get passport picture
		            $picname = $patientCls->getPassPicture($patientnum);
		            $photourl = SHOST_PATIENTPHOTO.$patientphoto;
		            $address = $obj->PATIENT_POSTADDRESS;
                    $digitaladdress = $obj->PATIENT_DIGITALADDRESS;
                    $nationalid = $obj->PATIENT_IDCARDNUM;
                    $idtype = $obj->PATIENT_IDCARDTYPE;

                }

                $relationstmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_relation WHERE PR_STATUS = '1' AND PR_PATIENTCODE = ".$sql->Param('a').""),array($keys));
                print $sql->ErrorMsg();

                $fetchstmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_paymentscheme WHERE PAY_PATIENTCODE=".$sql->Param('a')." AND PAY_FACCODE=".$sql->Param('a')." AND PAY_STATUS = '1'"),array($keys,$faccode));
                print $sql->ErrorMsg();
            }
        }
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

    case "requestservice":
        $postkey = $session->get("postkey");
        if ($postkey != $microtime){
            if (!empty($patkey)){
                $requestcode = $engine->serviceRequestCode($faccode,$patientnum);
                $visitcode = $engine->visitcode($faccode,$patientnum);

                $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient WHERE PATIENT_PATIENTNUM = ".$sql->Param('a')." AND PATIENT_STATUS = '1'"),array($patkey));
                print $sql->ErrorMsg();

                if ($stmt->RecordCount()>0){
                    $obj = $stmt->FetchNextObject();
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

                    $stmtrequest = $sql->Execute($sql->Prepare("INSERT INTO hms_service_request(REQU_CODE,REQU_PATIENTCODE,REQU_PATIENTNUM,REQU_PATIENT_FULLNAME,REQU_FACI_CODE,REQU_VISITCODE,REQU_ACTORCODE,REQU_ACTORNAME,REQU_STATUS,REQU_DATE,REQU_INPUTEDDATE) VALUES (".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('j').",".$sql->Param('k').")"),array($requestcode,$patientcode,$patientnum,$patient_fullname,$faccode,$visitcode,$actorcode,$actorname,'1',$sql->userDate($crtdate,'Y-m-d'),$crtdate));
                    print $sql->ErrorMsg();

                    if ($stmtrequest){
                        //Send Notification
                        $code = '017' ;
                        $desc = "Patient in queue Requesting for Medical Service.";
                        $menudetailscode = '0004';
                        //Get row id
                        $smtpatdetails = $patientCls->getPatientDetails($patientnum);
                        $tablerowid = $smtpatdetails->PATIENT_ID;
                        $sentto = '';
                        $engine->setNotification($code,$desc,$menudetailscode,$tablerowid,$sentto,$faccode);

                        $activity = 'Service Requested for '.$patient_fullname.' by '.$actorname.'. Visitcode: '.$visitcode.'; Requestcode: '.$requestcode;
                        $engine->setEventLog('038',$activity);

                        $msg = 'You have successfully requested for service for patient '.$patient_fullname;
                        $status = 'success';
                    }else{
                        $msg = 'Service Request for patient '.$patient_fullname.' was unsuccessful';
                        $status = 'error';
                    }
                }

            }
        }
    break;

    case "saveservicerequest":
//        print_r($_POST);
        $postkey = $session->get("postkey");
        if ($postkey != $microtime){
            if (!empty($paymentscheme)&&!empty($service)){
                $requestcode = $engine->serviceRequestCode($faccode,$patientnum);
                $visitcode = $engine->visitcode($faccode,$patientnum);
                $serv = ((!empty($service))?explode('@@@',$service):'');
                $servicecode = ((is_array($serv))?$serv[0]:'');
                $servicename = ((is_array($serv))?$serv[1]:'');
                $pscheme = ((!empty($paymentscheme))?explode('@@@',$paymentscheme):'');
                $payschemecode = ((is_array($pscheme))?$pscheme[0]:'');
                $payschemename = ((is_array($pscheme))?$pscheme[1]:'');
			   
               $serviceprice =  $engine->getserviceprice($servicecode,$faccode,$payschemecode);
				
                $billcode = $coder->getbillitemCode();
                $dy = Date('Y-m-d');

                //  Get Request Status
                $requeststatus = $patientCls->getRequestStatus($servicecode);

            //    echo  $serviceprice,$servicecode,$faccode,$payschemecode ;
             

                if (!empty($requeststatus)) {
                    $prescriber = (!empty($prescribe) ? explode('@@@', $prescribe) : '');
                    $prescribercode = ((is_array($prescriber) && count($prescriber) > 0) ? $prescriber[0] : '');
                    $prescribername = ((is_array($prescriber) && count($prescriber) > 0) ? $prescriber[1] : '');

                    $stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_visit(VISIT_CODE,VISIT_PATIENTCODE,VISIT_PATIENTNUM,VISIT_PATIENT,VISIT_DATE,VISIT_CASHAMT,VISIT_ALTAMT,VISIT_FACICODE) VALUES 
                    (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').")"),
                                    array($visitcode,$patientcode,$patientnum,$patientname,$dy,$serviceprice,'0',$faccode));
                    print $sql->ErrorMsg();

                    
                    $stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_service_request(REQU_CODE,REQU_PATIENTCODE,REQU_PATIENTNUM,REQU_PATIENT_FULLNAME,REQU_SERVICECODE,REQU_SERVICENAME,REQU_FACI_CODE,REQU_VISITCODE,REQU_ACTORCODE,REQU_ACTORNAME,REQU_STATUS,REQU_DATE,REQU_INPUTEDDATE) VALUES (".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('j').",".$sql->Param('k').",".$sql->Param('l').",".$sql->Param('m').")"),array($requestcode,$patientcode,$patientnum,$patientname,$servicecode,$servicename,$faccode,$visitcode,$actorcode,$actorname,$requeststatus,$sql->userDate($crtdate,'Y-m-d'),$crtdate));
                    print $sql->ErrorMsg();
                    

                    $stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_billitem(B_CODE,B_SERVCODE,B_DT,B_PATIENTCODE,B_PATIENTNUM,B_PATIENT,B_VISITCODE,B_ITEM,B_ITEMNAME,B_PAYSCHEME,B_PAYSCHEMENAME,B_QTY,B_TOTAMT,B_CASHAMT,B_ALTAMT,B_FACICODE) VALUES 
                    (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').")"),
                    array($billcode,$requestcode,$crtdat,$patientcode,$patientnum,$patientname,$visitcode,$servicecode,$servicename,$payschemecode,$payschemename,'1',$serviceprice,$serviceprice,'0',$faccode));
                    print $sql->ErrorMsg();


                //    $stmt = $sql->Execute($sql->Prepare("UPDATE hms_visit SET VISIT_CASHAMT = VISIT_CASHAMT + ".$sql->Param('1')." WHERE VISIT_CODE  ".$sql->Param('2').",array($serviceprice,$visitcode)));
                //    print $sql->ErrorMsg();




                    if ($stmt){
                        $request_insertid = $sql->insert_id();

                        //  Event Log for Service Request
                        $activity = 'Service Request has been made for '.$patientname.' by '.$actorname.'. With Visitcode: '.$visitcode.' and Requestcode: '.$requestcode;
                        $engine->setEventLog('038',$activity);

                        $msg = 'You have successfully requested for '.$servicename.' service for patient with Number '.$patientnum;
                        $status = 'success';
                    }

                    if ($servicecode == 'SER0001'){
                        //  To Consultation
                        $consltcode = $patientCls->getConsultCode($faccode);
                        $sql->Execute($sql->Prepare("INSERT INTO hms_consultation(CONS_CODE, CONS_PATIENTNUM, CONS_PATIENTNAME, CONS_REQUCODE, CONS_VISITCODE, CONS_SERVICECODE, CONS_SERVICENAME, CONS_DOCTORNAME, CONS_DOCTORCODE, CONS_SCHEDULEDATE, CONS_FACICODE, CONS_SCHEDULETIME, CONS_PATIENTCODE,CONS_STATUS) VALUES (".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('j').",".$sql->Param('k').",".$sql->Param('l').",".$sql->Param('m').",".$sql->Param('n').")"),array($consltcode,$patientnum,$patientname,$requestcode,$visitcode,$servicecode,$servicename,$prescribername,$prescribercode,$sql->userDate($crtdate,'Y-m-d'),$faccode,$sql->userDate($crtdate,'H:m:s'),$patientcode,'1'));
                            print $sql->ErrorMsg();

                        //Send Notification
                        $code = '017' ;
                        $desc = "Patient in queue for Consultation.";
                        $menudetailscode = '0005';
                        //Get row id
                        $smtpatdetails = $patientCls->getPatientDetails($patientnum);
                        $tablerowid = $sql->insert_id();
                        $sentto = '';
                        $engine->setNotification($code,$desc,$menudetailscode,$tablerowid,$sentto,$faccode);

                        //  Event Log for Consultation Service Request
                        $activity = 'Consultation Service Request has been made for '.$patientname.' by '.$actorname.'. Visitcode: '.$visitcode.'; Requestcode: '.$requestcode;
                        $engine->setEventLog('047',$activity);
                    }elseif ($servicecode == 'SER0002'){
                        //   First Aid

                        //Send Notification
                        $code = '020' ;
                        $desc = "Patient in queue waiting for First Aid.";
                        $menudetailscode = '0001';
                        //Get row id
                        $tablerowid = $request_insertid;
                        $sentto = '';
                        $engine->setNotification($code,$desc,$menudetailscode,$tablerowid,$sentto,$faccode);
                    }elseif ($servicecode == 'SER0004'){
                        //  To Vitals

                        //Send Notification
                        $code = '020' ;
                        $desc = "Patient in queue waiting for First Aid.";
                        $menudetailscode = '0001';
                        //Get row id
                        $tablerowid = $request_insertid;
                        $sentto = '';
                        $engine->setNotification($code,$desc,$menudetailscode,$tablerowid,$sentto,$faccode);
                    }
                }

            }else{
                $msg = 'All fields are required.';
                $error = 'error';
            }
        }else{
            $msg = 'Be sure you are accessing this page rightly';
            $status = 'error';
        }
    break;
}
	//Get countries
	$stmtnatl = $sql->Execute($sql->Prepare("SELECT * FROM hmsb_countries_nationalities"));
	$nationalities = array();
	while($natl = $stmtnatl->FetchNextObject()){
		$nationalities[]=$natl;
	}
	
	$stmtrln = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_relation WHERE PR_PATIENTNUM = ".$sql->Param('a')." "),array($data));

   include 'model/js.php';

   //   Months Array
   $months = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December');
   //   Days Array
   $days = array();
   for ($i=01; $i<32; $i++){
       array_push($days,$i);
   }
   //   Years Array
$years = array();
   for ($i=date('Y'); $i>=1920; $i--){
       array_push($years,$i);
   }

    if(!empty($fdsearch)){
        if (!empty($advancesearch) && $advancesearch == 'advance'){
            $pos = strpos($fdsearch, ',');
            if ($pos === false){
                $query = "SELECT * FROM hms_patient WHERE PATIENT_STATUS = '1' AND (PATIENT_PATIENTNUM = ".$sql->Param('a')." OR ( PATIENT_FNAME LIKE ".$sql->Param('b')." OR PATIENT_MNAME LIKE ".$sql->Param('c')." OR PATIENT_LNAME LIKE ".$sql->Param('d')." OR PATIENT_PHONENUM = ".$sql->Param('e')." OR PATIENT_ALTPHONENUM = ".$sql->Param('e')." OR PATIENT_EMAIL LIKE ".$sql->Param('e').")) ORDER BY PATIENT_ID DESC";
                $input = array($fdsearch,$fdsearch.'%',$fdsearch.'%',$fdsearch.'%',$fdsearch,$fdsearch,$fdsearch.'%');
            }else{
                // Search for Patient by Patient Name or Hewale Number or Phone Number and Hospital of Registration to narrow search
                $str_explode = explode(',', $fdsearch);
                $fdsearch = $str_explode[0];
                $hospital_name = $str_explode[1];
                $stmt_hos = $sql->Execute($sql->Prepare("SELECT FACI_CODE FROM hmsb_allfacilities WHERE FACI_NAME LIKE ".$sql->Param('a')." AND FACI_STATUS = '1'"),array('%'.$hospital_name.'%'));
                if ($stmt_hos){
                    $facility_code = $stmt_hos->FetchNextObject()->FACI_CODE;

                    $query = "SELECT * FROM hms_patient WHERE PATIENT_FACILITYCODE = ".$sql->Param('a')." AND PATIENT_STATUS = '1' AND (PATIENT_PATIENTNUM = ".$sql->Param('a')." OR ( PATIENT_FNAME LIKE ".$sql->Param('b')." OR PATIENT_MNAME LIKE ".$sql->Param('c')." OR PATIENT_LNAME LIKE ".$sql->Param('d')." OR PATIENT_PHONENUM = ".$sql->Param('e')." OR PATIENT_ALTPHONENUM = ".$sql->Param('e')." OR PATIENT_EMAIL LIKE ".$sql->Param('e').")) ORDER BY PATIENT_ID DESC";
                    $input = array($facility_code,$fdsearch,$fdsearch.'%',$fdsearch.'%',$fdsearch.'%',$fdsearch,$fdsearch,$fdsearch.'%');
                }
            }
        }else{
            $query = "SELECT * FROM hms_patient WHERE PATIENT_FACILITYCODE = ".$sql->Param('a')." AND PATIENT_STATUS = '1' AND (PATIENT_PATIENTNUM = ".$sql->Param('a')." OR ( PATIENT_FNAME LIKE ".$sql->Param('b')." OR PATIENT_MNAME LIKE ".$sql->Param('c')." OR PATIENT_LNAME LIKE ".$sql->Param('d')." OR PATIENT_PHONENUM = ".$sql->Param('e')." OR PATIENT_ALTPHONENUM = ".$sql->Param('e')." OR PATIENT_EMAIL LIKE ".$sql->Param('e').")) ORDER BY PATIENT_ID DESC";
            $input = array($faccode,$fdsearch,$fdsearch.'%',$fdsearch.'%',$fdsearch.'%',$fdsearch,$fdsearch,$fdsearch.'%');
        }
   }else{
	  
        if ($views=='groupregistrationlist'){
			
            $query = "SELECT PATGRP_ID,PATGRP_CODE,PATGRP_NAME,PATGRP_NUMBEROFPATIENT,PATGRP_GROUPTYPE,PATGRP_STATUS FROM hms_patient_group WHERE PATGRP_STATUS = ".$sql->Param('1')." ORDER BY PATGRP_ID DESC";
            $input = array('1');
        }elseif ($views=='viewgroup'){
            $groupname = $groupname;
            $query = "SELECT * FROM hms_patient WHERE PATIENT_STATUS = ".$sql->Param('1')." AND PATIENT_FACILITYCODE = ".$sql->Param('2')." AND PATIENT_GROUPCODE = ".$sql->Param('3')." ORDER BY PATIENT_ID DESC";
            $input = array('1',$faccode,$groupcode);
        }else{

           $query = "SELECT * FROM hms_patient WHERE PATIENT_STATUS = ".$sql->Param('1')." AND PATIENT_FACILITYCODE = ".$sql->Param('2')." ORDER BY PATIENT_ID DESC";
            $input = array('1',$faccode);
        }

    }

//  Get Pay Methods
$stmtpaymentcategory = $sql->Execute($sql->Prepare("SELECT * FROM hmsb_set_paymentcatgory"));
$stmtfacilitypayment = $sql->Execute($sql->Prepare("SELECT DISTINCT PAY_SCHEMECODE, PAY_SCHEMENAME FROM hms_patient_paymentscheme WHERE PAY_PATIENTCODE=".$sql->Param('a')." AND PAY_FACCODE=".$sql->Param('a')." AND PAY_STATUS='1'"),array($patientcode,$faccode));
//$stmtscheme = $sql->Execute($sql->Prepare("SELECT * FROM hmsb_st_paymentmethod WHERE PAYM_STATUS='1' AND PAYM_INSTCODE=".$sql->Param('a')),array($faccode));
$stmtscheme = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_paymentscheme WHERE PAY_STATUS='1' AND PAY_PATIENTCODE=".$sql->Param('a')." AND PAY_FACCODE=".$sql->Param('b')),array($patientcode,$faccode));

//  Get Service Request
//$stmtservcie = $sql->Execute($sql->Prepare("SELECT * FROM hmsb_services WHERE SERV_STATUS = '1'"));

$actordept = $engine->getUserAssignedDepartment($actorcode,$faccode);
$actordept = (!empty($actordept)?$actordept:'');
$actordept = (!empty($actordept)?explode(',',$actordept):'');
$actordept = (is_array($actordept)?implode("','",$actordept):'');
$actordept = (!empty($actordept)?"'".$actordept."'":'');

//  Get Services based on department
$stmtservcie = $sql->Execute($sql->Prepare("SELECT DISTINCT ST_SERVICE,ST_SERVICENAME FROM hms_assigndept WHERE ST_FACICODE=".$sql->Param('a')." AND ST_DEPT IN ($actordept)"),array($faccode));

$stmtdepartments = $sql->Execute($sql->Prepare("SELECT DISTINCT ST_DEPT, ST_DEPTNAME from hms_assigndept WHERE ST_DEPT IN ($actordept) AND ST_FACICODE=".$sql->Param('b')." AND ST_STATUS=".$sql->Param('c')." AND ST_SERVICE=".$sql->Param('d')." "),array($faccode,'1','SER0001'));

//  Get Prescriber
$stmtprescriber=$sql->Execute($sql->Prepare("SELECT USR_CODE,CONCAT(USR_SURNAME,' ',USR_OTHERNAME) USR_FULLNAME,USR_ONLINE_STATUS FROM hms_users WHERE USR_FACICODE= ".$sql->Param('a')." AND USR_TYPE=".$sql->Param('b').""),array($faccode,'1'));

//  Get Department
$stmtdepartment=$sql->Execute($sql->Prepare("SELECT * FROM hmsb_department"));


if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=ad2376beebecdcf7846ba973fa1a005b&option=6831b98f85019ddb98bd98d44bdbac40#',$input);

?>