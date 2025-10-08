<?php

include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
$patientCls = new patientClass();
$engine = new engineClass();
$actorname = $engine->getActorName();

if (empty($patientnum)){
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
	
	
	$sql->Execute($sql->Prepare("INSERT INTO hms_patient (PATIENT_PATIENTNUM,PATIENT_CODE,PATIENT_DATE,PATIENT_FNAME,PATIENT_MNAME,PATIENT_LNAME,PATIENT_DOB,PATIENT_GENDER,PATIENT_PHONENUM,PATIENT_ALTPHONENUM,PATIENT_ADDRESS,PATIENT_EMAIL,PATIENT_EMERGNUM1,PATIENT_EMERGNUM2,PATIENT_FACILITYCODE,PATIENT_SOURCE,PATIENT_EMERGNAME1,PATIENT_EMERGADDRESS1,PATIENT_EMERGNAME2,PATIENT_EMERGADDRESS2,PATIENT_BLOODGROUP,PATIENT_ALLERGIES,PATIENT_CHRONIC_CONDITION,PATIENT_NATIONALITY,PATIENT_COUNTRY_RESIDENT,PATIENT_MARITAL_STATUS) VALUES (".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('d').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').")"),array($patientnum, $patientcode, $patientdate, $fname, $middlename, $lastname, $dob, $gender, $phonenumber, $altphonenumber, $address, $email, $emerphonenumber1, $emerphonenumber2, $facilitycode, '2',$emername1,$emeraddress1,$emername2,$emeraddress2,$bgroup,$allergies,$conditions,$nationality,$residence,$mstatus)); 
		print $sql->ErrorMsg();
		
		$activity = 'Patient Registration with full name: '.$fname.' '.$middlename.' '.$lastname.' patient number: '.$patientnum.' by '.$actorname;
             $engine->setEventLog('005',$activity);
	}
}else{
	if (!empty($fname)&&!empty($lastname)){
	$sql->Execute("UPDATE hms_patient SET PATIENT_FNAME = ".$sql->Param('a')." ,PATIENT_MNAME = ".$sql->Param('a')." ,PATIENT_LNAME = ".$sql->Param('a')." ,PATIENT_DOB = ".$sql->Param('a')." ,PATIENT_GENDER = ".$sql->Param('a')." ,PATIENT_PHONENUM = ".$sql->Param('a')." ,PATIENT_ALTPHONENUM = ".$sql->Param('a')." ,PATIENT_ADDRESS = ".$sql->Param('a')." ,PATIENT_EMAIL = ".$sql->Param('a')." ,PATIENT_EMERGNUM1 = ".$sql->Param('a')." ,PATIENT_EMERGNUM2 = ".$sql->Param('a')." ,PATIENT_FACILITYCODE = ".$sql->Param('a')." ,PATIENT_SOURCE = ".$sql->Param('a')." ,PATIENT_EMERGNAME1 = ".$sql->Param('a')." ,PATIENT_EMERGADDRESS1 = ".$sql->Param('a')." ,PATIENT_EMERGNAME2 = ".$sql->Param('a')." ,PATIENT_EMERGADDRESS2 = ".$sql->Param('a')." ,PATIENT_BLOODGROUP = ".$sql->Param('a')." ,PATIENT_ALLERGIES = ".$sql->Param('a')." ,PATIENT_CHRONIC_CONDITION = ".$sql->Param('a')." ,PATIENT_NATIONALITY = ".$sql->Param('a')." ,PATIENT_COUNTRY_RESIDENT = ".$sql->Param('a')." ,PATIENT_MARITAL_STATUS = ".$sql->Param('a')." WHERE PATIENT_PATIENTNUM = ".$sql->Param('a')." ",array($fname, $middlename, $lastname, $dob, $gender, $phonenumber, $altphonenumber, $address, $email, $emerphonenumber1, $emerphonenumber2, $facilitycode, '2',$emername1,$emeraddress1,$emername2,$emeraddress2,$bgroup,$allergies,$conditions,$nationality,$residence,$mstatus,$patientnum));
	
	}
}
	

echo $patientnum;
//echo json_encode($patientnum);
