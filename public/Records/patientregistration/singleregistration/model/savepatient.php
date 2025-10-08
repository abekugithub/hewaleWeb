<?php

include '../../../../../config.php';
include SPATH_LIBRARIES . DS . "engine.Class.php";
$patientCls = new patientClass();
$engine = new engineClass();
$actorname = $engine->getActorName();
$faccode = $engine->getActorDetails()->USR_FACICODE;

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
		
		
		
	$patientnum = $pn_code;
	$patientcode = $patientCls->getPatientCode();
	$patientdate = date("Y-m-d");
	$facilitycode = "";

    $dt = $dob_year.'-'.$dob_month.'-'.$dob_day;
    $dob = $sql->userDate($dt,'Y-m-d');


    $sql->Execute($sql->Prepare("INSERT INTO hms_patient (PATIENT_PATIENTNUM,PATIENT_PATIENTCODE,PATIENT_DATE,PATIENT_FNAME,PATIENT_MNAME,PATIENT_LNAME,PATIENT_DOB,PATIENT_GENDER,PATIENT_PHONENUM,PATIENT_ALTPHONENUM,PATIENT_ADDRESS,PATIENT_EMAIL,PATIENT_EMERGNUM1,PATIENT_EMERGNUM2,PATIENT_FACILITYCODE,PATIENT_SOURCE,PATIENT_EMERGNAME1,PATIENT_EMERGADDRESS1,PATIENT_EMERGNAME2,PATIENT_EMERGADDRESS2,PATIENT_BLOODGROUP,PATIENT_ALLERGIES,PATIENT_CHRONIC_CONDITION,PATIENT_NATIONALITY,PATIENT_COUNTRY_RESIDENT,PATIENT_MARITAL_STATUS,PATIENT_IMAGE,PATIENT_IDCARDTYPE,PATIENT_IDCARDNUM,PATIENT_DIGITALADDRESS,PATIENT_POSTADDRESS) VALUES (".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('d').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('d').",".$sql->Param('d').",".$sql->Param('d').",".$sql->Param('d').",".$sql->Param('d').")"),array($patientnum, $patientcode, $patientdate, $fname, $middlename, $lastname, $dob, $gender, $phonenumber, $altphonenumber, $residentialaddress, $email, $emerphonenumber1, $emerphonenumber2, $faccode, '2',$emername1,$emeraddress1,$emername2,$emeraddress2,$bgroup,$allergies,$conditions,$nationality,$residence,$mstatus,$new_image_name,'National ID',$nationalid,$digitaladdress,$address));
		print $sql->ErrorMsg();
		
		$activity = 'Patient Registration with full name: '.$fname.' '.$middlename.' '.$lastname.' patient number: '.$patientnum.' by '.$actorname;
             $engine->setEventLog('005',$activity);
	}
}else{
	if (!empty($fname)&&!empty($lastname)){
        $stmtupdate = $sql->Execute("UPDATE hms_patient SET PATIENT_FNAME = ".$sql->Param('a')." ,PATIENT_MNAME = ".$sql->Param('a')." ,PATIENT_LNAME = ".$sql->Param('a')." ,PATIENT_DOB = ".$sql->Param('a')." ,PATIENT_GENDER = ".$sql->Param('a')." ,PATIENT_PHONENUM = ".$sql->Param('a')." ,PATIENT_ALTPHONENUM = ".$sql->Param('a')." ,PATIENT_ADDRESS = ".$sql->Param('a')." ,PATIENT_EMAIL = ".$sql->Param('a')." ,PATIENT_EMERGNUM1 = ".$sql->Param('a')." ,PATIENT_EMERGNUM2 = ".$sql->Param('a')." ,PATIENT_FACILITYCODE = ".$sql->Param('a')." ,PATIENT_SOURCE = ".$sql->Param('a')." ,PATIENT_EMERGNAME1 = ".$sql->Param('a')." ,PATIENT_EMERGADDRESS1 = ".$sql->Param('a')." ,PATIENT_EMERGNAME2 = ".$sql->Param('a')." ,PATIENT_EMERGADDRESS2 = ".$sql->Param('a')." ,PATIENT_BLOODGROUP = ".$sql->Param('a')." ,PATIENT_ALLERGIES = ".$sql->Param('a')." ,PATIENT_CHRONIC_CONDITION = ".$sql->Param('a')." ,PATIENT_NATIONALITY = ".$sql->Param('a')." ,PATIENT_COUNTRY_RESIDENT = ".$sql->Param('a')." ,PATIENT_MARITAL_STATUS = ".$sql->Param('a')." ,PATIENT_IMAGE = ".$sql->Param('a')." ,PATIENT_IDCARDTYPE = ".$sql->Param('a')." ,PATIENT_IDCARDNUM = ".$sql->Param('a')." ,PATIENT_DIGITALADDRESS = ".$sql->Param('a')." ,PATIENT_POSTADDRESS = ".$sql->Param('a')." WHERE PATIENT_PATIENTCODE = ".$sql->Param('a')." ",array($fname, $middlename, $lastname, $dob, $gender, $phonenumber, $altphonenumber, $residentialaddress, $email, $emerphonenumber1, $emerphonenumber2, $faccode, '2',$emername1,$emeraddress1,$emername2,$emeraddress2,$bgroup,$allergies,$conditions,$nationality,$residence,$mstatus,$new_image_name,'National ID',$nationalid,$digitaladdress,$address,$patientcode));
	
	}

	//  Save Patient Payment Scheme Upon Registration
    if (!empty($paymentcategory) && !empty($pat_paymentscheme)){
	    $patpayschcode = $patientCls->getPatientPaymentSchemeCode();
	    $paycat = explode('@@@',$paymentcategory);
	    $paysch = explode('@@@',$pat_paymentscheme);
	    $paycat_code = $paycat[0];
	    $paycat_name = $paycat[1];
	    $paysch_code = $paysch[0];
	    $paysch_name = $paysch[1];
	    $p_date = date("Y-m-d");

        $schemecheck = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_paymentscheme WHERE PAY_PATIENTCODE=".$sql->Param('a')." AND PAY_PAYMENTMETHODCODE=".$sql->Param('a')." AND PAY_SCHEMECODE=".$sql->Param('a')." AND PAY_STATUS = '1'"),array($patientcode,$paycat_code,$paysch_code));
        print $sql->ErrorMsg();
        if ($schemecheck->RecordCount()<1){
            if ($paycat_code == 'PC0001'){
                $pay_type = '1';
                $pay_typename = 'Cash';
            }elseif ($paycat_code == 'PC0002'){
                $pay_type = '2';
                $pay_typename = 'National Health Insurance Authority';
            }elseif ($paycat_code == 'PC0003'){
                $pay_type = '3';
                $pay_typename = 'Private Health Insurance';
            }elseif ($paycat_code == 'PC0004'){
                $pay_type = '4';
                $pay_typename = 'Partner Company';
            }
            $startdate = (!empty($startdate))?$sql->userdate($startdate,'Y-m-d'):'';
            $enddate = (!empty($enddate))?date('Y-m-d',$enddate):'';
            $issuedate = (!empty($issuedate))?date('Y-m-d',$issuedate):"";
            $expirydate = (!empty($expirydate))?date('Y-m-d',$expirydate):'';
            $stmtpayscheme = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_paymentscheme (PAY_CODE, PAY_DATE, PAY_PATIENTNUMBER, PAY_PATIENTCODE, PAY_TYPE, PAY_TYPENAME, PAY_PAYMENTMETHODCODE, PAY_PAYMENTMETHOD, PAY_SCHEMECODE, PAY_SCHEMENAME, PAY_CARDNUM, PAY_STARTDT, PAY_ENDDT, PAY_FACCODE, PAY_DATEOFISSUE, PAY_EXPIRYDATE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').")"),array($patpayschcode,$p_date,$patientnum,$patientcode,$pay_type,$pay_typename,$paycat_code,$paycat_name,$paysch_code,$paysch_name,$membershipnumber,$startdate,$enddate,$faccode,$issuedate,$expirydate));
        }

    }
}
	

echo $patientcode.'@@@'.$patientnum;
//echo json_encode($patientnum);
