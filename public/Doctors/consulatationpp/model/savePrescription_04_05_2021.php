<?php
ob_start();
include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);

$engine = new engineClass();
$patientCls = new patientClass();

$day = Date("Y-m-d H:m:s");
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();
$actor = $engine->getActorDetails();
$activeinstitution = $actor->USR_FACICODE;

if (!empty($drugcode)&&!empty($drugname)){
	$drugname = $encaes->encrypt(trim($drugname));
	$drugcode = $encaes->encrypt(trim($drugcode));
//	$routename = $encaes->encrypt($routename);

    $precode = $engine->getprescriptionCode('hms_patient_prescription','DR','PRESC_CODE');
//    $qty = $frequency * $days * $times ;

//Generate Prescription Package Code
$objcons = $patientCls->getConsultationVisitDetails($visitcode);
$consdate = date("Ymd", strtotime($objcons->CONS_DATE));
$consid = substr($objcons->CONS_ID, -1);

$objpatient = $patientCls->getPatientDetails($patientnum);
$phonenum = $objpatient->PATCON_PHONENUM;

$prespackagecode = $patientnum.'_'.$consdate.$consid;

//Get item code
$itemcode = $engine->getItemCode($patientnum);
/*
 * Check if insertion is done in the main table 
 * if not do the insertion otherwise skip insertion.
 */
$presmain = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_prescription_main WHERE PRESCM_PACKAGECODE = ".$sql->Param('a')." "),array($prespackagecode));
print $sql->ErrorMsg();

if($presmain->RecordCount() == 0 ){ 
    $presmid = uniqid();
    $stmtpresc = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_prescription_main (PRESCM_ID,PRESCM_PATIENT,PRESCM_PATIENTNUM,PRESCM_DATE,PRESCM_VISITCODE,PRESCM_ACTORNAME,PRESCM_ACTORCODE,PRESCM_INSTCODE,PRESCM_PATIENTCODE,PRESCM_ENCRYPKEY,PRESCM_PACKAGECODE,PRESCM_PATIENTCONTACT,PRESCM_ITEMCODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').")"),
    array($presmid,$patientname,$patientnum,$day,$visitcode,$usrname,$usrcode,$activeinstitution,$patientcode,$encryptkey,$prespackagecode,$phonenum,$itemcode));
print $sql->ErrorMsg();

//Send medication to Sterrida
$Code = $engine->getBroadcastPrescriptionCode();
$pharmacy_name = 'Stereda Pharmacy , Weija';
$facicode = "P0038";
$longitude = "";
$latitude = "";
$pressource = "1";

$stmtb=$sql->Execute($sql->Prepare("INSERT INTO hms_broadcast_prescription (BRO_CODE, BRO_PRESCCODE, BRO_VISITCODE, BRO_PATIENTNAME, BRO_PATIENTCODE, BRO_PATIENTNUM, BRO_PATIENTCONTACT, BRO_PHARMACYNAME, BRO_PHARMACYCODE, BRO_DATE, BRO_LONGITUDE, BRO_LATITUDE,BRO_STATE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').")"),array($Code, $prespackagecode, $visitcode, $patientname, $patientcode, $patientnum, $phonenum, $pharmacy_name, $facicode, $day,$longitude,$latitude,$pressource));
print $sql->ErrorMsg();

}

$prescriptioncheck = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_STATUS='1' AND PRESC_DRUGID=".$sql->Param('a')." AND PRESC_DRUG=".$sql->Param('a')." AND PRESC_VISITCODE=".$sql->Param('a')." AND (PRESC_PATIENTNUM=".$sql->Param('b')." OR PRESC_PATIENTCODE=".$sql->Param('b').")"),array($drugcode,$drugname,$visitcode,$patientnum,$patientcode));
print $sql->ErrorMsg();

    //$prescriptioncheck = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_STATUS='1' AND PRESC_DRUGID=".$sql->Param('a')." AND PRESC_DRUG=".$sql->Param('a')." AND PRESC_VISITCODE=".$sql->Param('a')." AND (PRESC_PATIENTNUM=".$sql->Param('b')." OR PRESC_PATIENTCODE=".$sql->Param('b').")"),array($drugcode,$drugname,$visitcode,$patientnum,$patientcode));
    //print $sql->ErrorMsg();

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
                $result[]=array("<tr><td>".$num++."</td><td>".$drugname."</td><td>".$obj->$obj->PRESC_FREQ."</td><td>".$obj->PRESC_TIMES."</td><td>".$obj->PRESC_DAYS."</td><td>".$obj->PRESC_QUANTITY."</td><td>".$obj->PRESC_ROUTENAME."</td><td><button type='button' id='deletecomplain' onclick='deleteComplains(\"".$obj->PRESC_CODE."\",\"Prescription\");' class=\"btn-danger removecomplain\">&times;</button></td></tr>");
            }
        }
    }else{
        $presid = uniqid();

        //get item code
        $stmtitcode = $sql->Execute($sql->Prepare("SELECT PRESCM_ITEMCODE FROM hms_patient_prescription_main WHERE  PRESCM_PACKAGECODE = ".$sql->Param('a')." "),array($prespackagecode));
        $objitcode = $stmtitcode->FetchNextObject();
        $icode = $objitcode->PRESCM_ITEMCODE ;

        $stmtpresc = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_prescription (PRESC_ID,PRESC_CODE,PRESC_PATIENT,PRESC_PATIENTNUM,PRESC_DATE,PRESC_VISITCODE,PRESC_DRUGID,PRESC_DRUG,PRESC_QUANTITY,PRESC_DOSAGENAME,PRESC_DOSAGECODE,PRESC_FREQ,PRESC_DAYS,PRESC_TIMES,PRESC_ACTORNAME,PRESC_ACTORCODE,PRESC_INSTCODE,PRESC_PATIENTCODE,PRESC_ENCRYPKEY,PRESC_ROUTECODE,PRESC_ROUTENAME,PRESC_PACKAGECODE,PRESC_PATIENTCONTACT,PRESC_ITEMCODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').",".$sql->Param('16').",".$sql->Param('17').",".$sql->Param('18').",".$sql->Param('19').",".$sql->Param('20').",".$sql->Param('21').",".$sql->Param('22').",".$sql->Param('23').")"),
            array($presid,$precode,$patientname,$patientnum,$day,$visitcode,$drugcode,$drugname,$qty,$drugdosename,$drugdose,$frequency,$days,$times,$usrname,$usrcode,$activeinstitution,$patientcode,$encryptkey,$routecode,$routename,$prespackagecode,$phonenum,$icode));
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
                    $result[]=array("<tr><td>".$num++."</td><td>".$drugname."</td><td>".$obj->PRESC_FREQ."</td><td>".$obj->PRESC_TIMES."</td><td>".$obj->PRESC_DAYS."</td><td>".$obj->PRESC_QUANTITY."</td><td>".$obj->PRESC_ROUTENAME."</td><td><button type='button' id='deletecomplain' onclick='deleteComplains(\"".$obj->PRESC_CODE."\",\"Prescription\");' class=\"btn-danger removecomplain\">&times;</button></td></tr>");
                }
            }
        }
    }
    echo json_encode($result);
}