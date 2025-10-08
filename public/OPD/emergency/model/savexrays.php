<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 8/25/2017
 * Time: 11:59 AM
 */
include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
//include SPATH_LIBRARIES.DS."patient.Class.php";

$engine = new engineClass();
$patientCls = new patientClass();
$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);

$day = Date("Y-m-d");
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();
$actor = $engine->getActorDetails();
$activeinstitution = $actor->USR_FACICODE;

if (!empty($xraycode)&&!empty($xrayname)){
	$xrayname = $encaes->encrypt($xrayname);
	$xraycode = $encaes->encrypt($xraycode);
	$remark = $encaes->encrypt($remark);
    $xcode = $engine->getXrayTestCode();

//    $stmtlabdiscplinecheck = $sql->Execute($sql->Prepare("SELECT FACFE_MENUCATCODE FROM hmsb_facilities_features WHERE FACFE_MENUCATCODE=".$sql->Param('a')." AND FACFE_FACICODE=".$sql->Param('b')." AND FACFE_STATUS='1'"),array('DI0011',$activeinstitution));

    $xraycheck = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_xraytest WHERE XT_STATUS='1' AND XT_TEST=".$sql->Param('a')." AND XT_TESTNAME=".$sql->Param('a')." AND XT_VISITCODE=".$sql->Param('a')." AND (XT_PATIENTNUM=".$sql->Param('b')." OR XT_PATIENTCODE=".$sql->Param('b').")"),array($xraycode,$xrayname,$visitcode,$patientnum,$patientcode));
    print $sql->ErrorMsg();

    if ($xraycheck->RecordCount()>0){
        $fetchstmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_xraytest WHERE XT_STATUS='1' AND XT_VISITCODE=".$sql->Param('a')." AND (XT_PATIENTNUM=".$sql->Param('b')." OR XT_PATIENTCODE=".$sql->Param('b').") ORDER BY XT_ID DESC"),array($visitcode,$patientnum,$patientcode));
        print $sql->ErrorMsg();
        $result = array();
        $num = 1;
        if ($fetchstmt->RecordCount()>0){
            while ($obj = $fetchstmt->FetchNextObject()){
				// Decrypt text with another key if necessary
				$decrypid = $obj->XT_ENCRYPKEY;
				if($decrypid != $activekey){
				$saltencrypt = $encryptkeys[$decrypid]['salt'];
                $pepperdecrypt =  $encryptkeys[$decrypid]['pepper'];
				$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
				}
				
				$xrayname = $encaes->decrypt($obj->XT_TESTNAME);
				$xrayrmk = $encaes->decrypt($obj->XT_RMK);
                $result[]=array("<tr><td>".$num++."</td><td>".$xrayname."</td><td>".$xrayrmk."</td><td><button type='button' id='deletecomplain' onclick='deleteComplains(\"".$obj->XT_CODE."\",\"Xray\");' class=\"btn-danger removecomplain\">&times;</button></td></tr>");
            }
        }
    }else{
        if (isset($activeinstitution) && !empty($activeinstitution)){

            $stmt = $sql->Execute($sql->Prepare("SELECT FACFE_MENUCATCODE FROM hmsb_facilities_features WHERE FACFE_FACICODE = ".$sql->Param('a')." AND FACFE_MENUCATCODE = ".$sql->Param('b')." AND FACFE_STATUS = '1'"),array($activeinstitution,'004'));
            print $sql->ErrorMsg();
            if ($stmt->RecordCount() == 1){

                $stmtlab = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_xraytest (XT_CODE,XT_VISITCODE,XT_DATE,XT_PATIENTNUM,XT_PATIENTNAME,XT_TEST,XT_TESTNAME,XT_DISCIPLINE,XT_DISCPLINENAME,XT_RMK,XT_ACTORCODE,XT_ACTORNAME,XT_INSTCODE,XT_PATIENTCODE,XT_ENCRYPKEY,XT_LABCODE,XT_LABNAME,XT_STATUS) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').",".$sql->Param('17').")"),
                    array($xcode,$visitcode,$day,$patientnum,$patientname,$xraycode,$xrayname,$dicscode,$dicsname,$remark,$usrcode,$usrname,$activeinstitution,$patientcode,$encryptkey,$activeinstitution,$activeinstitution,'6'));

                print $sql->ErrorMsg();

                //  Notification
                $code = '004';
                $desc = 'x-rayrequest Request for '.$patientname;
                $menudetailscode = '0008';
                //Get row id
                $smtrequstdetails = $patientCls->getServRequestInfo($visitcode);
                $tablerowid = $sql->insert_Id();
                $sentto = $activeinstitution;
                $engine->setNotification($code,$desc,$menudetailscode,$tablerowid,$sentto);
            }else{

                $stmtlab = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_xraytest (XT_CODE,XT_VISITCODE,XT_DATE,XT_PATIENTNUM,XT_PATIENTNAME,XT_TEST,XT_TESTNAME,XT_DISCIPLINE,XT_DISCPLINENAME,XT_RMK,XT_ACTORCODE,XT_ACTORNAME,XT_INSTCODE,XT_PATIENTCODE,XT_ENCRYPKEY) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('13').",".$sql->Param('14').")"),
                    array($xcode,$visitcode,$day,$patientnum,$patientname,$xraycode,$xrayname,$dicscode,$dicsname,$remark,$usrcode,$usrname,$activeinstitution,$patientcode,$encryptkey));

                print $sql->ErrorMsg();
            }

        }
        if ($stmtlab){
            $msg = "Consultation has been saved successfully";
            $status = "success";

            $fetchstmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_xraytest WHERE XT_STATUS IN ('1','6') AND XT_VISITCODE=".$sql->Param('a')." AND (XT_PATIENTNUM=".$sql->Param('b')." OR XT_PATIENTCODE=".$sql->Param('b').") ORDER BY XT_ID DESC"),array($visitcode,$patientnum,$patientcode));
            print $sql->ErrorMsg();
            $result = array();
            $num = 1;
            if ($fetchstmt->RecordCount()>0){
                while ($obj = $fetchstmt->FetchNextObject()){
				// Decrypt text with another key if necessary
				$decrypid = $obj->XT_ENCRYPKEY;
				if($decrypid != $activekey){
				$saltencrypt = $encryptkeys[$decrypid]['salt'];
                $pepperdecrypt =  $encryptkeys[$decrypid]['pepper'];
				$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
				}
					$xrayname = $encaes->decrypt($obj->XT_TESTNAME);
					$xrayrmk = $encaes->decrypt($obj->XT_RMK);
                    $result[]=array("<tr><td>".$num++."</td><td>".$xrayname."</td><td>".$xrayrmk."</td><td><button type='button' id='deletecomplain' onclick='deleteComplains(\"".$obj->XT_CODE."\",\"Xray\");' class=\"btn-danger removecomplain\">&times;</button></td></tr>");
                }
            }
        }
    }
    echo json_encode($result);
}