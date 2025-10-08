<?php
ob_start();
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 8/25/2017
 * Time: 3:35 PM
 */

include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";

$engine = new engineClass();
$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
$day = Date("Y-m-d");
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();
$actor = $engine->getActorDetails();
$activeinstitution = $actor->USR_FACICODE;

if (!empty($comcode)&&!empty($patientnum)&&!empty($patientcode)&&!empty($visitcode)){
    if ($type === 'Complains'){
        $stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_complains SET PC_STATUS='0' WHERE PC_CODE=".$sql->Param('a')." AND (PC_PATIENTNUM=".$sql->Param('a')." OR PC_PATIENTCODE=".$sql->Param('a').") AND PC_VISITCODE=".$sql->Param('a').""),array($comcode,$patientnum,$patientcode,$visitcode));
        print $sql->ErrorMsg();

        if ($stmt){
            $fetchstmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_complains WHERE PC_STATUS='1' AND PC_VISITCODE=".$sql->Param('a')." AND (PC_PATIENTNUM=".$sql->Param('b')." OR PC_PATIENTCODE=".$sql->Param('a').") ORDER BY PC_ID DESC"),array($visitcode,$patientnum,$patientcode));
            print $sql->ErrorMsg();
            $result = array();
            $num = 1;
            if ($fetchstmt->RecordCount()>0){
                while ($obj = $fetchstmt->FetchNextObject()){
                    $result[]=array("<tr><td>".$num++."</td><td>".$encaes->decrypt($obj->PC_COMPLAIN)."</td><td>".$engine->add3dots($encaes->decrypt($obj->PC_STORYLINE),'...',20)."</td><td><button type='button' id='deletecomplain' onclick='deleteComplains(\"".$obj->PC_CODE."\",\"Complains\");' class=\"btn-danger removecomplain\">&times;</button></td></tr>");
                }
            }else{
                $result[]=array("");
            }
            echo json_encode($result);
        }
    }else if ($type === 'Labs'){
        $stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_labtest SET LT_STATUS='0' WHERE LT_CODE=".$sql->Param('a')." AND (LT_PATIENTNUM=".$sql->Param('a')." OR LT_PATIENTCODE=".$sql->Param('a').") AND LT_VISITCODE=".$sql->Param('a').""),array($comcode,$patientnum,$patientcode,$visitcode));
        print $sql->ErrorMsg();

        if ($stmt){
            $fetchstmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_STATUS IN ('1','2','3','4','6') AND LT_VISITCODE=".$sql->Param('a')." AND (LT_PATIENTNUM=".$sql->Param('b')." OR LT_PATIENTCODE=".$sql->Param('a').") ORDER BY LT_ID DESC"),array($visitcode,$patientnum,$patientcode));
            print $sql->ErrorMsg();
            $result = array();
            $num = 1;
            if ($fetchstmt->RecordCount()>0){
                while ($obj = $fetchstmt->FetchNextObject()){
                    $result[]=array("<tr><td>".$num++."</td><td>".$encaes->decrypt($obj->LT_TESTNAME)."</td><td>".$encaes->decrypt($obj->LT_RMK)."</td><td><button type='button' id='deletecomplain' onclick='deleteComplains(\"".$obj->LT_CODE."\",\"Labs\");' class=\"btn-danger removecomplain\">&times;</button></td></tr>");
                }
            }else{
                $result[] = array("");
            }
            echo json_encode($result);
        }
    }else if ($type === 'Xray'){
        $stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_xraytest SET XT_STATUS='0' WHERE XT_CODE=".$sql->Param('a')." AND (XT_PATIENTNUM=".$sql->Param('a')." OR XT_PATIENTCODE=".$sql->Param('a').") AND XT_VISITCODE=".$sql->Param('a').""),array($comcode,$patientnum,$patientcode,$visitcode));
        print $sql->ErrorMsg();

        if ($stmt){
            $fetchstmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_xraytest WHERE XT_STATUS IN ('1','2','3','4','6') AND XT_VISITCODE=".$sql->Param('a')." AND (XT_PATIENTNUM=".$sql->Param('b')." OR XT_PATIENTCODE=".$sql->Param('a').") ORDER BY XT_ID DESC"),array($visitcode,$patientnum,$patientcode));
            print $sql->ErrorMsg();
            $result = array();
            $num = 1;
            if ($fetchstmt->RecordCount()>0){
                while ($obj = $fetchstmt->FetchNextObject()){
                    $result[]=array("<tr><td>".$num++."</td><td>".$encaes->decrypt($obj->XT_TESTNAME)."</td><td>".$encaes->decrypt($obj->XT_RMK)."</td><td><button type='button' id='deletecomplain' onclick='deleteComplains(\"".$obj->XT_CODE."\",\"Xray\");' class=\"btn-danger removecomplain\">&times;</button></td></tr>");
                }
            }else{
                $result[] = array("");
            }
            echo json_encode($result);
        }
    }else if ($type === 'Diagnosis'){
        $stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_diagnosis SET DIA_STATUS='0' WHERE DIA_CODE=".$sql->Param('a')." AND (DIA_PATIENTNUM=".$sql->Param('a')." OR DIA_PATIENTCODE=".$sql->Param('a').") AND DIA_VISITCODE=".$sql->Param('a').""),array($comcode,$patientnum,$patientcode,$visitcode));
        print $sql->ErrorMsg();

        if ($stmt){
            $fetchstmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_diagnosis WHERE DIA_STATUS IN ('1','2','3','4') AND DIA_VISITCODE=".$sql->Param('a')." AND (DIA_PATIENTNUM=".$sql->Param('b')." OR DIA_PATIENTCODE=".$sql->Param('a').") ORDER BY DIA_ID DESC"),array($visitcode,$patientnum,$patientcode));
            print $sql->ErrorMsg();
            $result = array();
            $num = 1;
            if ($fetchstmt->RecordCount()>0){
                while ($obj = $fetchstmt->FetchNextObject()){
                    $result[]=array("<tr><td>".$num++."</td><td>".$encaes->decrypt($obj->DIA_DIAGNOSIS)."</td><td>".$encaes->decrypt($obj->DIA_RMK)."</td><td><button type='button' id='deletecomplain' onclick='deleteComplains(\"".$obj->DIA_CODE."\",\"Diagnosis\");' class=\"btn-danger removecomplain\">&times;</button></td></tr>");
                }
            }else{
                $result[] = array("");
            }
            echo json_encode($result);
        }
    }else if ($type === 'Prescription'){
        $stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_prescription SET PRESC_STATUS='0' WHERE PRESC_CODE=".$sql->Param('a')." AND (PRESC_PATIENTNUM=".$sql->Param('a')." OR PRESC_PATIENTCODE=".$sql->Param('a').") AND PRESC_VISITCODE=".$sql->Param('a').""),array($comcode,$patientnum,$patientcode,$visitcode));
        print $sql->ErrorMsg();

        if ($stmt){
            $fetchstmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_STATUS IN ('1','2','3','4','5','6') AND PRESC_VISITCODE=".$sql->Param('a')." AND (PRESC_PATIENTNUM=".$sql->Param('b')." OR PRESC_PATIENTCODE=".$sql->Param('a').") ORDER BY PRESC_ID DESC"),array($visitcode,$patientnum,$patientcode));
            print $sql->ErrorMsg();
            $result = array();
            $num = 1;
            if ($fetchstmt->RecordCount()>0){
                while ($obj = $fetchstmt->FetchNextObject()){
                    $result[]=array("<tr><td>".$num++."</td><td>".$encaes->decrypt($obj->PRESC_DRUG)."</td><td>".$obj->PRESC_FREQ."</td><td>".$obj->PRESC_TIMES."</td><td>".$obj->PRESC_DAYS."</td><td>".$obj->PRESC_QUANTITY."</td><td>".$obj->PRESC_ROUTENAME."</td><td><button type='button' id='deletecomplain' onclick='deleteComplains(\"".$obj->PRESC_CODE."\",\"Prescription\");' class=\"btn-danger removecomplain\">&times;</button></td></tr>");
                }
            }else{
                $result[] = array("");
            }
            echo json_encode($result);
        }
    }
}