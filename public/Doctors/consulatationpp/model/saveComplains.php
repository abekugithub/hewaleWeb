<?php
ob_start();
include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";

$engine = new engineClass();
$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);

$day = Date("Y-m-d");
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();
$actor = $engine->getActorDetails();
$actorcode = $actor->USR_CODE;
$activeinstitution = $actor->USR_FACICODE;
$countrycode = $actor->USR_COUNTRYCODE;

if (!empty($complaincode)){ // &&!empty($complain)
	$complain = $encaes->encrypt(trim($complain));
	$complaincode = $encaes->encrypt(trim($complaincode));
	$storyline = $encaes->encrypt(trim($storyline));
    $comcode = $engine->getcomplainCode();

    $complaincheck = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_complains WHERE PC_STATUS='1' AND PC_COMPLAINCODE=".$sql->Param('a')." AND PC_COMPLAIN=".$sql->Param('a')." AND PC_VISITCODE=".$sql->Param('a')." AND (PC_PATIENTNUM=".$sql->Param('b')." OR PC_PATIENTCODE=".$sql->Param('b').") "),array($complaincode,$complain,$visitcode,$patientnum,$patientcode));
    print $sql->ErrorMsg();

    if ($complaincheck->RecordCount() > 0){
        $fetchstmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_complains WHERE PC_STATUS='1' AND PC_VISITCODE=".$sql->Param('a')." AND (PC_PATIENTNUM=".$sql->Param('b')." OR PC_PATIENTCODE=".$sql->Param('b').") ORDER BY PC_ID DESC"),array($visitcode,$patientnum,$patientcode));
        print $sql->ErrorMsg();
        $result = array();
        $num = 1;
        if ($fetchstmt->RecordCount()>0){
            while ($obj = $fetchstmt->FetchNextObject()){
				// Decrypt text with another  key if necessary
				$decrypid = $obj->PC_ENCRYPKEY;
				if($decrypid != $activekey){
				$saltencrypt = $encryptkeys[$decrypid]['salt'];
                $pepperdecrypt =  $encryptkeys[$decrypid]['pepper'];
				$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
				}
				$complain = $encaes->decrypt($obj->PC_COMPLAIN);
                $storyln = $encaes->decrypt($obj->PC_STORYLINE);
                $result[]=array("<tr><td>".$num++."</td><td>".$complain."</td><td>".$engine->add3dots($storyln,'...',20)."</td><td><button type='button' id='deletecomplain' onclick='deleteComplains(\"".$obj->PC_CODE."\",\"Complains\");' class=\"btn-danger removecomplain\">&times;</button></td></tr>");
            }
        }
    }else{
        $stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_complains (PC_CODE,PC_PATIENTNUM,PC_VISITCODE,PC_DATE,PC_COMPLAINCODE,PC_COMPLAIN,PC_INSTCODE,PC_ACTORCODE,PC_ACTORNAME,PC_PATIENTCODE,PC_STORYLINE,PC_ENCRYPKEY,PC_COUNTRYCODE) VALUES(".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').")"), array($comcode,$patientnum,$visitcode,$day,$complaincode,$complain,$activeinstitution,$usrcode,$usrname,$patientcode,$storyline,$encryptkey,$countrycode));
        print $sql->ErrorMsg();
        if ($stmt){
            $msg = "Consultation has been saved successfully";
            $status = "success";

            $fetchstmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_complains WHERE PC_STATUS='1' AND PC_VISITCODE=".$sql->Param('a')." AND (PC_PATIENTNUM=".$sql->Param('b')." OR PC_PATIENTCODE=".$sql->Param('b').") ORDER BY PC_ID DESC"),array($visitcode,$patientnum,$patientcode));
            print $sql->ErrorMsg();
            $result = array();
            $num = 1;
            if ($fetchstmt->RecordCount()>0){
                while ($obj = $fetchstmt->FetchNextObject()){
				// Decrypt text with another  key if necessary
				$decrypid = $obj->PC_ENCRYPKEY;
				if($decrypid != $activekey){
				$saltencrypt = $encryptkeys[$decrypid]['salt'];
                $pepperdecrypt =  $encryptkeys[$decrypid]['pepper'];
				$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
				}
				
                    $complaincode=$encaes->decrypt($obj->PC_CODE);
					$complain = $encaes->decrypt($obj->PC_COMPLAIN);
					$storyln = $encaes->decrypt($obj->PC_STORYLINE);
                    $result[]=array("<tr><td>".$num++."</td><td>".$complain."</td><td>".$engine->add3dots($storyln,'...',20)."</td><td><button type='button' id='deletecomplain' onclick='deleteComplains(\"".$obj->PC_CODE."\",\"Complains\");' class=\"btn-danger removecomplain\">&times;</button></td></tr>");
                }
//                echo json_encode($result);
            }else{
                $result[]=array("<tr><td>There was an error</td></tr>");
            }
        }
    }
}else{
    //  Add Complain or Symptom to the hmsb_st_symptoms table
    $complaincode = $engine->getsymptomCode();
//    $complaincode = $engine->generateCode_bk('hmsb_st_symtoms','SY','SY_CODE');
    $complain = strtoupper($complain);
    $stmt = $sql->Execute($sql->Prepare("INSERT INTO hmsb_st_symtoms (SY_CODE, SY_DESC, SY_NAME, SY_ACTOR, SY_DATE_CREATED, SY_STATUS,SY_COUNTRY) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').")"),array($complaincode,$complain,$complain,$actorcode,$day,'2',$countrycode));
    print $sql->ErrorMsg();
    if ($stmt){
        $complain = $encaes->encrypt(trim($complain));
        $complaincode = $encaes->encrypt(trim($complaincode));
        $storyline = $encaes->encrypt(trim($storyline));
        $comcode = $engine->getcomplainCode();

        $complaincheck = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_complains WHERE PC_STATUS='1' AND PC_COMPLAINCODE=".$sql->Param('a')." AND PC_COMPLAIN=".$sql->Param('a')." AND PC_VISITCODE=".$sql->Param('a')." AND (PC_PATIENTNUM=".$sql->Param('b')." OR PC_PATIENTCODE=".$sql->Param('b').") "),array($complaincode,$complain,$visitcode,$patientnum,$patientcode));
        print $sql->ErrorMsg();

        if ($complaincheck->RecordCount() > 0){
            $fetchstmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_complains WHERE PC_STATUS='1' AND PC_VISITCODE=".$sql->Param('a')." AND (PC_PATIENTNUM=".$sql->Param('b')." OR PC_PATIENTCODE=".$sql->Param('b').") ORDER BY PC_ID DESC"),array($visitcode,$patientnum,$patientcode));
            print $sql->ErrorMsg();
            $result = array();
            $num = 1;
            if ($fetchstmt->RecordCount()>0){
                while ($obj = $fetchstmt->FetchNextObject()){
                    // Decrypt text with another  key if necessary
                    $decrypid = $obj->PC_ENCRYPKEY;
                    if($decrypid != $activekey){
                        $saltencrypt = $encryptkeys[$decrypid]['salt'];
                        $pepperdecrypt =  $encryptkeys[$decrypid]['pepper'];
                        $encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
                    }
                    $complain = $encaes->decrypt($obj->PC_COMPLAIN);
                    $storyln = $encaes->decrypt($obj->PC_STORYLINE);
                    $result[]=array("<tr><td>".$num++."</td><td>".$complain."</td><td>".$engine->add3dots($storyln,'...',20)."</td><td><button type='button' id='deletecomplain' onclick='deleteComplains(\"".$obj->PC_CODE."\",\"Complains\");' class=\"btn-danger removecomplain\">&times;</button></td></tr>");
                }
            }
        }else{
            $stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_complains (PC_CODE,PC_PATIENTNUM,PC_VISITCODE,PC_DATE,PC_COMPLAINCODE,PC_COMPLAIN,PC_INSTCODE,PC_ACTORCODE,PC_ACTORNAME,PC_PATIENTCODE,PC_STORYLINE,PC_ENCRYPKEY,PC_COUNTRYCODE) VALUES(".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').")"), array($comcode,$patientnum,$visitcode,$day,$complaincode,$complain,$activeinstitution,$usrcode,$usrname,$patientcode,$storyline,$encryptkey,$countrycode));
            print $sql->ErrorMsg();
            if ($stmt){
                $msg = "Consultation has been saved successfully";
                $status = "success";

                $fetchstmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_complains WHERE PC_STATUS='1' AND PC_VISITCODE=".$sql->Param('a')." AND (PC_PATIENTNUM=".$sql->Param('b')." OR PC_PATIENTCODE=".$sql->Param('b').") ORDER BY PC_ID DESC"),array($visitcode,$patientnum,$patientcode));
                print $sql->ErrorMsg();
                $result = array();
                $num = 1;
                if ($fetchstmt->RecordCount()>0){
                    while ($obj = $fetchstmt->FetchNextObject()){
                        // Decrypt text with another  key if necessary
                        $decrypid = $obj->PC_ENCRYPKEY;
                        if($decrypid != $activekey){
                            $saltencrypt = $encryptkeys[$decrypid]['salt'];
                            $pepperdecrypt =  $encryptkeys[$decrypid]['pepper'];
                            $encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
                        }

                        $complaincode=$encaes->decrypt($obj->PC_CODE);
                        $complain = $encaes->decrypt($obj->PC_COMPLAIN);
                        $storyln = $encaes->decrypt($obj->PC_STORYLINE);
                        $result[]=array("<tr><td>".$num++."</td><td>".$complain."</td><td>".$engine->add3dots($storyln,'...',20)."</td><td><button type='button' id='deletecomplain' onclick='deleteComplains(\"".$obj->PC_CODE."\",\"Complains\");' class=\"btn-danger removecomplain\">&times;</button></td></tr>");
                    }
//                echo json_encode($result);
                }else{
                    $result[]=array("<tr><td>There was an error</td></tr>");
                }
            }
        }
    }
}
echo json_encode($result);
