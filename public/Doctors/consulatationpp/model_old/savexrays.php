<?php
ob_start();
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
    //Get diagnostic type
$stmtdg = $sql->Execute($sql->Prepare("SELECT X_TYPE FROM hmsb_st_xray WHERE X_CODE = ".$sql->Param('a')." "),array($xraycode));
if($stmtdg->RecordCount() > 0){
    $objdg = $stmtdg->FetchNextObject();
    $type = $objdg->X_TYPE ;
}

	$xrayname = $encaes->encrypt(trim($xrayname));
	$xraycode = $encaes->encrypt(trim($xraycode));
	$remark = $encaes->encrypt(trim($remark));
    //$xcode = $engine->getXrayTestCode();
    $xcode = $patientnum.'_'.uniqid();

    $objcons = $patientCls->getConsultationVisitDetails($visitcode);
    $consdate = date("Ymd", strtotime($objcons->CONS_DATE));
    $consid = substr($objcons->CONS_ID, -1);
    $prespackagecode = $patientnum.'_'.$consdate.$consid.'R';

/*
 * Check if insertion is done in the main table 
 * if not do the insertion otherwise skip insertion.
 */
$labmain = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_xraytest_main WHERE XTM_PACKAGECODE = ".$sql->Param('a')." "),array($prespackagecode));
print $sql->ErrorMsg();
if($labmain->RecordCount() == 0 ){
  $ltmmid = uniqid();

  $sql->Execute($sql->Prepare("INSERT INTO hms_patient_xraytest_main (XTM_ID,XTM_PACKAGECODE,XTM_VISITCODE,XTM_DATE,XTM_PATIENTNUM,XTM_PATIENTNAME,XTM_ACTORCODE,XTM_ACTORNAME,XTM_INSTCODE,XTM_PATIENTCODE,XTM_ENCRYPKEY,XTM_STATUS,XTM_TYPE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').")"),array($ltmmid,$prespackagecode,$visitcode,$day,$patientnum,$patientname,$usrcode,$usrname,$activeinstitution,$patientcode,$encryptkey,'1',$type));

  print $sql->ErrorMsg();
}

    $xraycheck = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_xraytest WHERE XT_STATUS='1' AND XT_TEST=".$sql->Param('a')." AND XT_TESTNAME=".$sql->Param('a')." AND XT_VISITCODE=".$sql->Param('a')." AND (XT_PATIENTNUM=".$sql->Param('b')." OR XT_PATIENTCODE=".$sql->Param('b').")"),array($xraycode,$xrayname,$visitcode,$patientnum,$patientcode));
    print $sql->ErrorMsg();

    if ($xraycheck->RecordCount()>0){
        $fetchstmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_xraytest WHERE XT_STATUS='1' AND XT_VISITCODE=".$sql->Param('a')." AND (XT_PATIENTNUM=".$sql->Param('b')." OR XT_PATIENTCODE=".$sql->Param('b').") ORDER BY XT_INPUTEDDATE DESC "),array($visitcode,$patientnum,$patientcode));
        print $sql->ErrorMsg();
        $result = array();
        $num = 1;
        if ($fetchstmt->RecordCount()>0){
            while ($obj = $fetchstmt->FetchNextObject()){
				//Decrypt text with another key if necessary
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
            $ltmmid = uniqid();

            $stmt = $sql->Execute($sql->Prepare("SELECT FACFE_MENUCATCODE FROM hmsb_facilities_features WHERE FACFE_FACICODE = ".$sql->Param('a')." AND FACFE_MENUCATCODE = ".$sql->Param('b')." AND FACFE_STATUS = '1'"),array($activeinstitution,'004'));
            print $sql->ErrorMsg();
            if ($stmt->RecordCount() == 1){
             
                $stmtlab = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_xraytest (XT_ID,XT_CODE,XT_VISITCODE,XT_DATE,XT_PATIENTNUM,XT_PATIENTNAME,XT_TEST,XT_TESTNAME,XT_DISCIPLINE,XT_DISCPLINENAME,XT_RMK,XT_ACTORCODE,XT_ACTORNAME,XT_INSTCODE,XT_PATIENTCODE,XT_ENCRYPKEY,XT_STATUS,XT_TYPE,XT_PACKAGECODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').",".$sql->Param('17').",".$sql->Param('18').")"),
                    array($ltmmid,$xcode,$visitcode,$day,$patientnum,$patientname,$xraycode,$xrayname,'','',$remark,$usrcode,$usrname,$activeinstitution,$patientcode,$encryptkey,'1',$type,$prespackagecode));

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
               
                $stmtlab = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_xraytest (XT_ID,XT_CODE,XT_VISITCODE,XT_DATE,XT_PATIENTNUM,XT_PATIENTNAME,XT_TEST,XT_TESTNAME,XT_DISCIPLINE,XT_DISCPLINENAME,XT_RMK,XT_ACTORCODE,XT_ACTORNAME,XT_INSTCODE,XT_PATIENTCODE,XT_ENCRYPKEY,XT_TYPE,XT_PACKAGECODE,XT_STATUS) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').",".$sql->Param('17').",".$sql->Param('18').")"),
                    array($ltmmid,$xcode,$visitcode,$day,$patientnum,$patientname,$xraycode,$xrayname,'','',$remark,$usrcode,$usrname,$activeinstitution,$patientcode,$encryptkey,$type,$prespackagecode,'1'));

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