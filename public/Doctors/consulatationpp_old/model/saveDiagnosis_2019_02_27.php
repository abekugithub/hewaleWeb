<?php
ob_start();
include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);

$engine = new engineClass();
$day = Date("Y-m-d");
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();
$actor = $engine->getActorDetails();
$activeinstitution = $actor->USR_FACICODE;

if (!empty($diagnosiscode)&&!empty($diagnosisname)){
	$diagnosisname = $encaes->encrypt($diagnosisname);
	$diagnosiscode = $encaes->encrypt($diagnosiscode);
	$remark = $encaes->encrypt($remark);
	
    $diacode = $engine->getdiagnosisCode();

    $diagnosischeck = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_diagnosis WHERE DIA_STATUS='1' AND DIA_DIA=".$sql->Param('a')." AND DIA_DIAGNOSIS=".$sql->Param('a')." AND DIA_VISITCODE=".$sql->Param('a')." AND (DIA_PATIENTNUM=".$sql->Param('b')." OR DIA_PATIENTCODE=".$sql->Param('b').") ORDER BY DIA_ID DESC"),array($diagnosiscode,$diagnosisname,$visitcode,$patientnum,$patientcode));
    print $sql->ErrorMsg();

    if ($diagnosischeck->RecordCount()>0){
        $fetchstmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_diagnosis WHERE DIA_STATUS='1' AND DIA_VISITCODE=".$sql->Param('a')." AND (DIA_PATIENTNUM=".$sql->Param('b')." OR DIA_PATIENTCODE=".$sql->Param('b').") ORDER BY DIA_ID DESC"),array($visitcode,$patientnum,$patientcode));
        print $sql->ErrorMsg();
        $result = array();
        $num = 1;
        if ($fetchstmt->RecordCount()>0){
            while ($obj = $fetchstmt->FetchNextObject()){
				// Decrypt text with another key if necessary
				$decrypid = $obj->DIA_ENCRYPKEY;
				if($decrypid != $activekey){
				$saltencrypt = $encryptkeys[$decrypid]['salt'];
                $pepperdecrypt =  $encryptkeys[$decrypid]['pepper'];
				$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
				}
				
			$diagnosisname = $encaes->decrypt($obj->DIA_DIAGNOSIS);
	        $diagremark = $encaes->decrypt($obj->DIA_RMK);
                $result[]=array("<tr><td>".$num++."</td><td>".$diagnosisname."</td><td>".$diagremark."</td><td><button type='button' id='deletecomplain' onclick='deleteComplains(\"".$obj->DIA_CODE."\",\"Diagnosis\");' class=\"btn-danger removecomplain\">&times;</button></td></tr>");
            }
        }
    }else{
        $stmtdiag = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_diagnosis (DIA_CODE,DIA_VISITCODE,DIA_DATE,DIA_PATIENTNUM,DIA_DIA,DIA_DIAGNOSIS,DIA_RMK,DIA_ACTORNAME,DIA_ACTORCODE,DIA_INSTCODE,DIA_PATIENTCODE,DIA_ENCRYPKEY) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('9').",".$sql->Param('9').",".$sql->Param('10').")"),
            array($diacode,$visitcode,$day,$patientnum,$diagnosiscode,$diagnosisname,$remark,$usrname,$usrcode,$activeinstitution,$patientcode,$encryptkey));
        print $sql->ErrorMsg();
        if ($stmtdiag){
            $msg = "Consultation has been saved successfully";
            $status = "success";

            $fetchstmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_diagnosis WHERE DIA_STATUS='1' AND DIA_VISITCODE=".$sql->Param('a')." AND (DIA_PATIENTNUM=".$sql->Param('b')." OR DIA_PATIENTCODE=".$sql->Param('b').") ORDER BY DIA_ID DESC"),array($visitcode,$patientnum,$patientcode));
            print $sql->ErrorMsg();
            $result = array();
            $num = 1;
            if ($fetchstmt->RecordCount()>0){
                while ($obj = $fetchstmt->FetchNextObject()){
				// Decrypt text with another key if necessary
				$decrypid = $obj->DIA_ENCRYPKEY;
				if($decrypid != $activekey){
				$saltencrypt = $encryptkeys[$decrypid]['salt'];
                $pepperdecrypt =  $encryptkeys[$decrypid]['pepper'];
				$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
				}
				
				$diagnosisname = $encaes->decrypt($obj->DIA_DIAGNOSIS);
	            $diagremark = $encaes->decrypt($obj->DIA_RMK);
                    $result[]=array("<tr><td>".$num++."</td><td>".$diagnosisname."</td><td>".$diagremark."</td><td><button type='button' id='deletecomplain' onclick='deleteComplains(\"".$obj->DIA_CODE."\",\"Diagnosis\");' class=\"btn-danger removecomplain\">&times;</button></td></tr>");
                }
            }
        }
    }
    echo json_encode($result);
}