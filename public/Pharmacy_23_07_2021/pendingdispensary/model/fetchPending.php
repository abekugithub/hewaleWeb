<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 11/26/2018
 * Time: 11:17 AM
 */
ob_start();
include("../../../../config.php");
include("../../../../library/engine.Class.php");
$engine = new engineClass();
$objdtls = $engine->getFacilityDetails();
$faccode = $objdtls->FACI_CODE;


$stmt = $sql->Execute($sql->Prepare("SELECT DISTINCT PRESCM_VISITCODE,PRESCM_PATIENT,PRESCM_PATIENTNUM,PRESCM_DATE,PRESCM_STATUS,PRESCM_PICKUPCODE,PRESCM_COUR_NAME,PRESCM_STATE,BRO_STATUS,BRO_IMAGENAME,BRO_VISITCODE,BRO_STATE,PRESCM_PACKAGECODE,PRESCM_ITEMCODE FROM hms_patient_prescription_main JOIN hms_broadcast_prescription ON PRESCM_VISITCODE=BRO_VISITCODE WHERE PRESCM_STATUS IN ('1','2') AND BRO_PHARMACYCODE = ".$sql->Param('a')." AND BRO_STATUS = ".$sql->Param('b').""),array($faccode,'1'));
print $sql->ErrorMsg();

if($stmt) {
    $total_pending = $stmt->RecordCount();
    echo json_encode($total_pending);
}
