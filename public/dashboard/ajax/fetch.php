<?php
include("../../../config.php");
include("../../../library/engine.Class.php");
$engine = new engineClass();
$objdtls = $engine->getFacilityDetails();
$facilityalias = $objdtls->FACI_ALIAS ;
$last = !empty($_SESSION['lasttxfetch']) ?  $_SESSION['lasttxfetch']  : date('Y-m-d H:i:s') ;

//die($objdtls->FACI_CODE);
$stmt=$sql->Execute($sql->Prepare("SELECT * FROM hms_patient_prescription JOIN hms_broadcast_prescription ON PRESC_VISITCODE=BRO_VISITCODE WHERE PRESC_DATE > {$sql->Param('a')} AND BRO_PHARMACYCODE={$sql->Param('a')}  AND BRO_STATUS = ".$sql->Param('a')  ),array($last,$objdtls->FACI_CODE,'1'));
$stmt=$sql->Execute($sql->Prepare("SELECT * FROM hms_pending_prescription WHERE PEND_DATE > ".$sql->Param('a')." AND PEND_FACICODE=".$sql->Param('a')."  AND PEND_STATUS = ".$sql->Param('a')),array($last,$objdtls->FACI_CODE,'1'));
//echo $sql->ErrorMsg();
//var_dump($stmt->FetchNextObject);
$ress = [];
if(!$sql->ErrorMsg()){
    if($stmt->RecordCount()>0){
        $ress = $stmt->GetAll();
        $resSize = count($ress);
        $lastRec = $ress[$resSize -1];
        $lastDate = $lastRec['PRESC_DATE'];
        $last = $_SESSION['lasttxfetch'] = $lastDate;
    }
    echo json_encode($ress);

}


?>