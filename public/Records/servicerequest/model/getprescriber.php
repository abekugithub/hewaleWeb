<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 9/14/2017
 * Time: 5:21 PM
 */

include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
$patientCls = new patientClass();
$engine = new engineClass();
$actorname = $engine->getActorName();
$faccode= $session->get("activeinstitution");
$stmt = $sql->Execute($sql->Prepare("SELECT USR_CODE,CONCAT(USR_SURNAME,' ',USR_SURNAME) USR_FULLNAME FROM hms_user WHERE USR_FACICODE= ".$sql->Param('a')." AND USR_ONLINE_STATUS = '1'"),array($faccode));
print $sql->ErrorMsg();

$result = array();
if ($stmt->RecordCount()>0){
    while ($obj = $stmt->FetchNextObject()){
        $result[] = array("<option value='".$obj->USR_CODE."'>".$obj->USR_FULLNAME."</option>");
    }
}else{
    $result = "<option value=''>No Doctor Available</option>";
}
echo json_encode($result);
