<?php
ob_start();
/**
 * User: Acker
 * Date: 22/05/2018
 */
include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";

$engine = new engineClass();

$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();
$actor = $engine->getActorDetails();

    $stmtpre = $sql->Execute($sql->Prepare("SELECT PATIENT_ALLERGIES FROM hms_patient WHERE PATIENT_PATIENTNUM = ".$sql->Param('a')." "),array($patientnum));
    $objpre = $stmtpre->FetchNextObject();

    $stmtpos = $sql->Execute("UPDATE hms_patient SET PATIENT_ALLERGIES = '' WHERE PATIENT_PATIENTNUM = ".$sql->Param('a')." ",array($patientnum) );

    //Save event log
    $activity = "Allergies deleted for patient with Hewale Number: ".$patientnum." by doctor ".$usrname." using code ".$usrcode." The details of the allergies were: ".$objpre->PATIENT_ALLERGIES;
    $engine->setEventLog("116",$activity);

   if ($stmtpos){

		$fetchstmt = $sql->Execute($sql->Prepare("SELECT PATIENT_ALLERGIES,PATIENT_CHRONIC_CONDITION FROM hms_patient WHERE PATIENT_PATIENTNUM = ".$sql->Param('a')." "),array($patientnum));
        print $sql->ErrorMsg();
        //$result = array();
        $num = 1;
        if ($fetchstmt->RecordCount()>0){
            $obj = $fetchstmt->FetchNextObject();
				
                
				$result = '<tr>
                <td>Allergies</td>
                <td>'.$obj->PATIENT_ALLERGIES.'</td>
                <td class="text-center valign-middle" width="100">
                <button class="btn btn-xs btn-danger square" type="button" onclick="deleteAllergies()"><i class="fa fa-close"></i>
                </button>
                </td>
                <tr>
                <tr>
                <td>Chroniques Conditions</td>
                <td>'.$obj->PATIENT_CHRONIC_CONDITION.'</td>
                <td class="text-center valign-middle" width="100">
                <button class="btn btn-xs btn-danger square" type="button" onclick="deleteChroniques()"><i class="fa fa-close"></i>
                </button>
                </td>
                <tr>';
            
           
        }
		echo $result;
    }