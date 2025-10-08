<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 9/14/2017
 * Time: 5:21 PM
 */

include '../../../../../config.php';
include SPATH_LIBRARIES . DS . "engine.Class.php";
$patientCls = new patientClass();
$engine = new engineClass();
$actorname = $engine->getActorName();
$faccode = $engine->getActorDetails()->USR_FACICODE;

$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_facilities_payment WHERE PINS_CATEGORY_CODE = ".$sql->Param('a')." AND PINS_FACICODE=".$sql->Param('b')." AND PINS_STATUS = '1'"),array($paycatcode,$facilitycode));
print $sql->ErrorMsg();

$result = array();
if ($stmt->RecordCount()>0){
    while ($obj = $stmt->FetchNextObject()){
        $result[] = array("<option value='".$obj->PINS_METHOD_CODE."@@@".$obj->PINS_METHOD."'>".$obj->PINS_METHOD."</option>");
    }
}else{
    $result[] = array("<option value='' selected disabled>No Payment Scheme</option>");
}
echo json_encode($result);
