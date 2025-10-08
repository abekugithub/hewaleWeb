<?php
ob_start();
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 11/26/2018
 * Time: 11:17 AM
 */
include("../../../../config.php");
include("../../../../library/engine.Class.php");
$engine = new engineClass();
$objdtls = $engine->getFacilityDetails();
$faccode = $objdtls->FACI_CODE;
$userCourier = $engine->getActorCourier();
$ccode = $engine->getparcelcode();
$agentcode = $engine->getActorCode();


$stmt = $sql->Execute($sql->Prepare("SELECT DISTINCT COB_TRACKINGCODE,COB_PATIENT, COB_PATIENTCODE,COB_PATIENTNUM,COB_DATE, COB_VISITCODE,COB_PICKUPCODE,COB_PHARMACYCODE,COB_PHARMACY,COB_PHARMACYLOCATION,COB_STATUS,COB_PRESCRIPTIONCODE FROM hmsb_courier_basket WHERE  COB_COURIERCODE = ".$sql->Param('1')." AND COB_STATUS IN ('1') "),array($userCourier));
print $sql->ErrorMsg();

if($stmt) {
    $total_pending = $stmt->RecordCount();
    echo json_encode($total_pending);
}
