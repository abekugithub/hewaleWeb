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

if (!empty($txtarea) && !empty($condtype)){
    $stmtp = $sql->Execute($sql->Prepare("SELECT PATIENT_ALLERGIES,PATIENT_CHRONIC_CONDITION FROM hms_patient WHERE PATIENT_PATIENTNUM = ".$sql->Param('a')." "),array($patientnum));
    print $sql->ErrorMsg();
    $objp = $stmtp->FetchNextObject();

    if($condtype == 1){
    $txtarea = $txtarea.' '.$objp->PATIENT_ALLERGIES;
    $stmtpos = $sql->Execute("UPDATE hms_patient SET PATIENT_ALLERGIES = ".$sql->Param('a')." WHERE PATIENT_PATIENTNUM = ".$sql->Param('b')." ",array($txtarea,$patientnum) );
    
    //Save event log
    $activity = "Allergies saved for patient with Hewale Number: ".$patientnum." by doctor ".$usrname." using code ".$usrcode." The details of the allergies are: ".$txtarea;
    $engine->setEventLog("114",$activity);

    }elseif($condtype == 2){
        $txtarea = $txtarea.' '.$objp->PATIENT_CHRONIC_CONDITION;
        $stmtpos = $sql->Execute("UPDATE hms_patient SET PATIENT_CHRONIC_CONDITION = ".$sql->Param('a')." WHERE  PATIENT_PATIENTNUM = ".$sql->Param('b')." ",array($txtarea,$patientnum) );
    
    //Save event log
    $activity = "Chroniques conditions saved for patient with Hewale Number: ".$patientnum." by doctor ".$usrname." using code ".$usrcode." The details of the chroniques conditions are: ".$txtarea;
    $engine->setEventLog("115",$activity);
    }
    print $sql->ErrorMsg();

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
}