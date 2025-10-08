<?php
/**
 * Created by VSCode.
 * User: Gyan
 * Date: 7/31/2017
 * Time: 4:14 PM
 */
ob_start();
include '../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
$engine = new engineClass();
$facilitycode = $engine->GetFacilityCode('H');
ob_start();
$actualdate = date('Y-m-d H:i:s');

if (!empty($hosptname)&&!empty($hosptregistration_num)){
    $stmt = $sql->Execute($sql->Prepare("INSERT INTO hmsb_allfacilities (FACI_CODE,FACI_NAME,FACI_TYPE,FACI_REGNUM,FACI_PHONENUM,FACI_EMAIL,FACI_LOCATION,FACI_STATUS) VALUES (".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').") "), array($facilitycode,$hosptname,'H',$hosptregistration_num,$hosptphonenum,$hosptemail,$hosptlocation,'0'));
    print $sql->ErrorMsg();

    if ($stmt){
        $msg = "Your Registration was successful. You will be contacted.";
        $status = "success";
    }else{
        $msg = "Your Registration has been declined. Review your details provided";
        $status = "error";
    }
}
echo json_encode($msg);