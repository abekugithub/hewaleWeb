<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 2/8/2018
 * Time: 10:51 AM
 */

include '../../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";

$engine = new engineClass();
$day = Date("Y-m-d");
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();
$actor = $engine->getActorDetails();
$activeinstitution = $actor->USR_FACICODE;

if (!empty($code) && !empty($patientcode)){
    $stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_paymentscheme SET PAY_STATUS = '0' WHERE PAY_CODE=".$sql->Param('a')." AND PAY_PATIENTCODE=".$sql->Param('b')),array($code,$patientcode));
    print $sql->ErrorMsg();

    if ($stmt){
        $fetchstmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_paymentscheme WHERE PAY_PATIENTCODE=".$sql->Param('a')." AND PAY_FACCODE=".$sql->Param('a')." AND PAY_STATUS = '1'"),array($patientcode,$activeinstitution));
        print $sql->ErrorMsg();
        $result = array();
        $num = 1;
        if ($fetchstmt->RecordCount()>0){
            while ($obj = $fetchstmt->FetchNextObject()){
                $paymentcat = $obj->PAY_PAYMENTMETHOD;
                $paymentsch = $obj->PAY_SCHEMENAME;
                $membnumber = $obj->PAY_CARDNUM;
                $datestart = ($obj->PAY_STARTDT != '' && $obj->PAY_STARTDT != '1970-01-01')?$obj->PAY_STARTDT:'';
                $dateend = ($obj->PAY_ENDDT != '' && $obj->PAY_ENDDT != '1970-01-01')?$obj->PAY_ENDDT:'';

                $result[]=array("<tr><td>".$num++."</td><td>".$paymentcat."</td><td>".$paymentsch."</td><td>".$membnumber."</td><td>".$datestart."</td><td>".$dateend."</td><td><button type='button' id='deletescheme' onclick='deleteScheme(\"".$obj->PAY_CODE."\",\"".$obj->PAY_PATIENTCODE."\");' class=\"btn-danger removecomplain\">&times;</button></td></tr>");
            }
        }
        echo json_encode($result);
    }
}