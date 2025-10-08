<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 9/18/2017
 * Time: 4:36 PM
 */

$actorname = $engine->getActorName();

$patientCls = new patientClass();
$sms = new smsgetway();
$import = new importClass();
$faccode = $engine->getActorDetails()->USR_FACICODE;
$crtdate= date("Y-m-d H:m:s");

switch ($viewpage){
    case "save":
        $postkey = $session->get("postkey");
        if ($postkey != $microtime){
            //reset post key
            $session->set("postkey",$microtime);

            if (!empty($saveoption)){
                if ($saveoption == '1'){
                    $v = 'group';
                    $views = 'group';
                }elseif ($saveoption == '2'){
                    $v = 'group';
                    $views = '';
                }
            }

            if (!empty($groupname)){
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
                        $new_image_name = $import->uploadImage($_FILES['image'],SHOST_PASSPORT);

                        $stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_patient (PATIENT_PATIENTNUM,PATIENT_PATIENTCODE,PATIENT_DATE,PATIENT_FNAME,PATIENT_MNAME,PATIENT_LNAME,PATIENT_DOB,PATIENT_GENDER,PATIENT_PHONENUM,PATIENT_ALTPHONENUM,PATIENT_ADDRESS,PATIENT_EMAIL,PATIENT_EMERGNUM1,PATIENT_EMERGNUM2,PATIENT_FACILITYCODE,PATIENT_SOURCE,PATIENT_EMERGNAME1,PATIENT_EMERGADDRESS1,PATIENT_EMERGNAME2,PATIENT_EMERGADDRESS2,PATIENT_BLOODGROUP,PATIENT_ALLERGIES,PATIENT_CHRONIC_CONDITION,PATIENT_NATIONALITY,PATIENT_COUNTRY_RESIDENT,PATIENT_MARITAL_STATUS,PATIENT_IMAGE) VALUES (".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('d').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('d').")"),array($patientnum, $patientcode, $patientdate, $fname, $middlename, $lastname, $dob, $gender, $phonenumber, $altphonenumber, $address, $email, $emerphonenumber1, $emerphonenumber2, $faccode, '2',$emername1,$emeraddress1,$emername2,$emeraddress2,$bgroup,$allergies,$conditions,$nationality,$residence,$mstatus,$new_image_name));
                        print $sql->ErrorMsg();

                        if ($stmt){
                            $msg = "Patient Saved Successfully. ---- $requestcode.' '.$visitcode";
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
                            $new_image_name = $import->uploadImage($_FILES['image'],SHOST_PASSPORT);
                        }

                        $stmtupdate = $sql->Execute("UPDATE hms_patient SET PATIENT_FNAME = ".$sql->Param('a')." ,PATIENT_MNAME = ".$sql->Param('a')." ,PATIENT_LNAME = ".$sql->Param('a')." ,PATIENT_DOB = ".$sql->Param('a')." ,PATIENT_GENDER = ".$sql->Param('a')." ,PATIENT_PHONENUM = ".$sql->Param('a')." ,PATIENT_ALTPHONENUM = ".$sql->Param('a')." ,PATIENT_ADDRESS = ".$sql->Param('a')." ,PATIENT_EMAIL = ".$sql->Param('a')." ,PATIENT_EMERGNUM1 = ".$sql->Param('a')." ,PATIENT_EMERGNUM2 = ".$sql->Param('a')." ,PATIENT_FACILITYCODE = ".$sql->Param('a')." ,PATIENT_SOURCE = ".$sql->Param('a')." ,PATIENT_EMERGNAME1 = ".$sql->Param('a')." ,PATIENT_EMERGADDRESS1 = ".$sql->Param('a')." ,PATIENT_EMERGNAME2 = ".$sql->Param('a')." ,PATIENT_EMERGADDRESS2 = ".$sql->Param('a')." ,PATIENT_BLOODGROUP = ".$sql->Param('a')." ,PATIENT_ALLERGIES = ".$sql->Param('a')." ,PATIENT_CHRONIC_CONDITION = ".$sql->Param('a')." ,PATIENT_NATIONALITY = ".$sql->Param('a')." ,PATIENT_COUNTRY_RESIDENT = ".$sql->Param('a')." ,PATIENT_MARITAL_STATUS = ".$sql->Param('a')." ,PATIENT_IMAGE = ".$sql->Param('a')." WHERE PATIENT_PATIENTCODE = ".$sql->Param('a')." ",array($fname, $middlename, $lastname, $dob, $gender, $phonenumber, $altphonenumber, $address, $email, $emerphonenumber1, $emerphonenumber2, $faccode, '2',$emername1,$emeraddress1,$emername2,$emeraddress2,$bgroup,$allergies,$conditions,$nationality,$residence,$mstatus,$new_image_name,$patientcode));
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

                            $msg = "Patient saved successfully and request for service has been raised for this patient.";
                            $status = "success";
                        }

                    }else{
                        $msg = "Patient Was Not Saved.";
                        $status = "error";
                    }
                }
            }else{
                $msg = "No Patient Group was selected";
                $status = "error";
                $v = 'group';
                $views = '';
            }
        }

//        $msg = 'hello again';
//        $status = 'success';
//        $views = 'bringhere';
    break;
    case "groupregistration":
        if (isset($groupname)&&!empty($groupname)){
            $views = 'add';
        }
    break;

    case "reset":
        $fdsearch = '';
        $v = 'group';
    break;

    case "add":
        if (!empty($groupname)){
            $v = 'group';
            echo $views = 'add';
        }
    break;
}

//Get countries
$stmtnatl = $sql->Execute($sql->Prepare("SELECT * FROM hms_countries_nationalities"));
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

if(isset($action_search) && $action_search == "search"){
    if(!empty($fdsearch)){

        $query = "SELECT * FROM hms_patient WHERE PATIENT_STATUS = '1' AND (PATIENT_PATIENTNUM = ".$sql->Param('a')." OR ( PATIENT_FNAME LIKE ".$sql->Param('b')." OR PATIENT_MNAME LIKE ".$sql->Param('c')." OR PATIENT_LNAME LIKE ".$sql->Param('d')." OR PATIENT_PHONENUM = ".$sql->Param('e')." OR PATIENT_EMAIL LIKE ".$sql->Param('e').")) ORDER BY PATIENT_INPUTEDDATE DESC";
        $input = array($fdsearch,$fdsearch.'%',$fdsearch.'%',$fdsearch.'%',$fdsearch,$fdsearch.'%');

    }
}else{

    $query = "SELECT * FROM hms_patient_group WHERE PATGRP_STATUS = ".$sql->Param('1')." ORDER BY PATGRP_INPUTEDDATE DESC";
    $input = array('1');

}

//  Get Pay Methods
$stmtpayment = $sql->Execute($sql->Prepare("SELECT * FROM hmsb_set_paymentcatgory"));

//  Get Service Request
$stmtservcie = $sql->Execute($sql->Prepare("SELECT * FROM hmsb_services WHERE SERV_STATUS = '1'"));

if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=ad2376beebecdcf7846ba973fa1a005b&option=6831b98f85019ddb98bd98d44bdbac40#',$input);