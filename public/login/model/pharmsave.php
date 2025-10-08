<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 7/20/2017
 * Time: 12:54 PM
 */
ob_start();
include '../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
include SPATH_LIBRARIES.DS."facility.Class.php";
$engine = new engineClass();
$facility = new facilityClass();
ob_start();
$actualdate = date('Y-m-d H:i:s');

if (!empty($pharmname)&&!empty($registration_num)){
	$facilitycode = $facility->getFacilityCode('P');
	
    $stmt = $sql->Execute($sql->Prepare("INSERT INTO hmsb_allfacilities (FACI_CODE,FACI_NAME,FACI_TYPE,FACI_REGNUM,FACI_PHONENUM,FACI_EMAIL,FACI_LOCATION) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').") "), array($facilitycode,$pharmname,'P',$registration_num,$phonenum,$email,$location));
    print $sql->ErrorMsg();

    if ($stmt){
        $msg = "Your Registration was successful, we will contact you by mail.";
        $status = "success";
    }else{
        $msg = "Your Registration has been declined. Review your details provided";
        $status = "error";
    }
}else{
    $msg = "All fields required";
    $status = "error";
}
echo json_encode($msg);