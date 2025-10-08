<?php

include '../../../../../config.php';
include SPATH_LIBRARIES . DS . "engine.Class.php";
$patientCls = new patientClass();
$engine = new engineClass();
$actorname = $engine->getActorName();
$faccode = $engine->getActorDetails()->USR_FACICODE;

if (!empty($patientcode)) {
    $stmtscheme = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_paymentscheme WHERE PAY_STATUS='1' AND PAY_PATIENTCODE=" . $sql->Param('a') . " AND PAY_FACCODE=" . $sql->Param('b')), array($patientcode, $faccode));
    print $sql->ErrorMsg();

    $result = array();
    if ($stmtscheme->RecordCount() > 0) {
        while ($obj = $stmtscheme->FetchNextObject()) {
            $result[] = array("<option value='" . $obj->PAY_SCHEMECODE."@@@".$obj->PAY_SCHEMENAME. "'>" . $obj->PAY_SCHEMENAME . "</option>");
        }
    } else {
        $result[] = array("<option value=''>No Payment Scheme</option>");
    }
    echo json_encode($result);
}
