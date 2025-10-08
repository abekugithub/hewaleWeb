<?php
ob_start();
include '../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
//include SPATH_LIBRARIES.DS."facility.Class.php";
$engine = new engineClass();
//$facility = new facilityClass();
ob_start();
if(empty($labname) || empty($loca) || empty($email) || empty($phonenum) || empty($regnum) || empty($fac_type)){
	
	$msg = "Required field cannot be empty";
	$status = "error";
	
	}else{

    if ($fac_type == '1'){
        //  Laboratory
        $facilitycode = $engine->getFacilityCode('L');
        $stmt = $sql->Execute($sql->Prepare("INSERT INTO hmsb_allfacilities (FACI_CODE,FACI_NAME,FACI_TYPE,FACI_REGNUM,FACI_PHONENUM,FACI_EMAIL,FACI_LOCATION,FACI_STATUS) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('7').") "), array($facilitycode,$labname,'L',$regnum,$phonenum,$email,$loca,'0'));
        print $sql->ErrorMsg();
    }elseif ($fac_type == '2'){
        //  Xray
        $facilitycode = $engine->getFacilityCode('X');
        $stmt = $sql->Execute($sql->Prepare("INSERT INTO hmsb_allfacilities (FACI_CODE,FACI_NAME,FACI_TYPE,FACI_REGNUM,FACI_PHONENUM,FACI_EMAIL,FACI_LOCATION,FACI_STATUS) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('7').") "), array($facilitycode,$labname,'X',$regnum,$phonenum,$email,$loca,'0'));
        print $sql->ErrorMsg();
    }

	 if ($stmt){
        $msg = "Your Registration was successful, we will contact you by mail.";
        $status = "success";
    }else{
        $msg = "Your Registration has been declined. Review your details provided";
        $status = "error";
    }
	
}

echo json_encode($msg);