<?php
/**
 * Created by Dreamweaver.
 * User: Nana Eben
 * Date: 7/31/2017
 * Time: 4:14 PM
 */
include '../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
$engine = new engineClass();
$facilitycode = $engine->GetFacilityCode('C');

$actualdate = date('Y-m-d H:i:s');
ob_start();
if (!empty($compname)&&!empty($business_reg)){
    $stmt = $sql->Execute($sql->Prepare("INSERT INTO hmsb_allfacilities (FACI_CODE,FACI_NAME,FACI_TYPE,FACI_REGNUM,FACI_PHONENUM,FACI_EMAIL,FACI_LOCATION, FACI_TIN) VALUES (".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').", ".$sql->Param('h').") "), array($facilitycode,$compname,'C',$business_reg,$contact,$email,$location, $tax_number));
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