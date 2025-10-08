<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 8/10/2017
 * Time: 8:21 PM
 */
$crypt = new cryptCls();

if (isset($k)&&!empty($k)) {
	;
    $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_service_request JOIN hms_patient ON REQU_PATIENTNUM=PATIENT_PATIENTNUM WHERE REQU_PATIENTNUM = " . $sql->Param('a') . " AND REQU_STATUS IN ('6','5','4','3','2','1','7') "), array($crypt->simple_crypt_decrypt($k,'d')));
    print $sql->ErrorMsg();
    if ($stmt) {
        while ($obj = $stmt->FetchNextObj()) {
			
			
			
            $patientname = $obj->REQU_PATIENT_FULLNAME;
            $dob = $obj->PATIENT_DOB;
            $email = $obj->PATIENT_EMAIL;
            $phonenumber = $obj->PATIENT_PHONENUM;
            $postaladdress=$obj->PATIENT_POSTALADDRESS;
            $residential = $obj->PATIENT_ADDRESS;
            $allegy     = $obj->PATIENT_ALLERGIES;
            $chronic_condition = $obj->PATIENT_CHRONIC_CONDITION;
            $patientphoto = SHOST_PASSPORT.$obj->PATIENT_IMAGE;

        }
    }

  /*  $stmt1 = $sql->Execute($sql->Prepare("SELECT * FROM hms_consultation WHERE CONS_PATIENTNUM=".$sql->Param('a')." ORDER BY CONS_CODE DESC LIMIT 5"),array($crypt->simple_crypt_decrypt($k,'d')));
    print $sql->ErrorMsg();
    if ($stmt1){
        return $stmt1;
    }*/
	
	$stmtpat = $sql->Execute($sql->Prepare("SELECT * FROM hms_consultation WHERE CONS_PATIENTNUM=".$sql->Param('a')." ORDER BY 
	CONS_CODE DESC LIMIT 5"),array($keys));


}


