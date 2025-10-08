<?php
/**
 * User: Bless
 * Date: 11/14/2017
 * Time: 11:59 AM
 */
include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);

$engine = new engineClass();
$day = Date("Y-m-d H:m:s");
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();
$actor = $engine->getActorDetails();
$activeinstitution = $actor->USR_FACICODE;

if (!empty($drugcode)&&!empty($drugname)){
	$drugname = $encaes->encrypt($drugname);
	$drugcode = $encaes->encrypt($drugcode);
	
    $precode = $engine->getprescriptionCode();
    $qty = $frequency * $days * $times ;

    $prescriptioncheck = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_STATUS='1' AND PRESC_DRUGID=".$sql->Param('a')." AND PRESC_DRUG=".$sql->Param('a')." AND PRESC_VISITCODE=".$sql->Param('a')." AND (PRESC_PATIENTNUM=".$sql->Param('b')." OR PRESC_PATIENTCODE=".$sql->Param('b').")"),array($drugcode,$drugname,$visitcode,$patientnum,$patientcode));
    print $sql->ErrorMsg();

    if ($prescriptioncheck->RecordCount()>0){
        $fetchstmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_STATUS='1' AND PRESC_VISITCODE=".$sql->Param('a')." AND (PRESC_PATIENTNUM=".$sql->Param('b')." OR PRESC_PATIENTCODE=".$sql->Param('b').") ORDER BY PRESC_ID DESC"),array($visitcode,$patientnum,$patientcode));
        print $sql->ErrorMsg();
        $result = array();
        $num = 1;
        if ($fetchstmt->RecordCount()>0){
            while ($obj = $fetchstmt->FetchNextObject()){
				// Decrypt text with another key if necessary
				$decrypid = $obj->PRESC_ENCRYPKEY;
				if($decrypid != $activekey){
				$saltencrypt = $encryptkeys[$decrypid]['salt'];
                $pepperdecrypt =  $encryptkeys[$decrypid]['pepper'];
				$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
				}
				
				$drugname = $encaes->decrypt($obj->PRESC_DRUG);
                $result[]=array("<tr><td>".$num++."</td><td>".$drugname."</td><td>".$obj->PRESC_DAYS."</td><td>".$obj->PRESC_FREQ."</td><td>".$obj->PRESC_TIMES."</td><td><button type='button' id='deleteprescription' onclick='deleteprescription(\"".$obj->PRESC_CODE."\");' class=\"btn-danger removecomplain\">&times;</button></td></tr>");
            }
        }
    }else{
        $stmtpresc = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_prescription (PRESC_CODE,PRESC_PATIENT,PRESC_PATIENTNUM,PRESC_DATE,PRESC_VISITCODE,PRESC_DRUGID,PRESC_DRUG,PRESC_QUANTITY,PRESC_DOSAGENAME,PRESC_DOSAGECODE,PRESC_FREQ,PRESC_DAYS,PRESC_TIMES,PRESC_ACTORNAME,PRESC_ACTORCODE,PRESC_INSTCODE,PRESC_PATIENTCODE,PRESC_ENCRYPKEY) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').",".$sql->Param('16').",".$sql->Param('17').")"),
            array($precode,$patientname,$patientnum,$day,$visitcode,$drugcode,$drugname,$qty,$drugdosename,$drugdose,$frequency,$days,$times,$usrname,$usrcode,$activeinstitution,$patientcode,$encryptkey));
        print $sql->ErrorMsg();
        if ($stmtpresc){
            $msg = "Consultation has been saved successfully";
            $status = "success";

            $fetchstmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_STATUS='1' AND PRESC_VISITCODE=".$sql->Param('a')." AND (PRESC_PATIENTNUM=".$sql->Param('b')." OR PRESC_PATIENTCODE=".$sql->Param('b').") ORDER BY PRESC_ID DESC"),array($visitcode,$patientnum,$patientcode));
            print $sql->ErrorMsg();
            $result = array();
            $num = 1;
            if ($fetchstmt->RecordCount()>0){
                while ($obj = $fetchstmt->FetchNextObject()){
			    // Decrypt text with another key if necessary
				$decrypid = $obj->PRESC_ENCRYPKEY;
				if($decrypid != $activekey){
				$saltencrypt = $encryptkeys[$decrypid]['salt'];
                $pepperdecrypt =  $encryptkeys[$decrypid]['pepper'];
				$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
				}
				
					$drugname = $encaes->decrypt($obj->PRESC_DRUG);
                    $result[]=array("<tr><td>".$num++."</td><td>".$drugname."</td><td>".$obj->PRESC_DAYS."</td><td>".$obj->PRESC_FREQ."</td><td>".$obj->PRESC_TIMES."</td><td><button type='button' id='deleteprescription' onclick='deleteprescription(\"".$obj->PRESC_CODE."\");' class=\"btn-danger removecomplain\">&times;</button></td></tr>");
                }
            }
        }
    }
    echo json_encode($result);
}