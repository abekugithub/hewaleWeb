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
$countrycode = $actor->USR_COUNTRYCODE;

if (!empty($testcode)&&!empty($testname)){
	$testname = $encaes->encrypt(trim($testname));
	$testcode = $encaes->encrypt(trim($testcode));
	$remark = $encaes->encrypt(trim($remark));
    //$lqcode = $engine->getlabtestCode();
    $lqcode = $patientnum.'_'.uniqid();
   
    $objcons = $patientCls->getConsultationVisitDetails($visitcode);
    $consdate = date("Ymd", strtotime($objcons->CONS_DATE));
    $consid = substr($objcons->CONS_ID, -1);

    $prespackagecode = $patientnum.'_'.$consdate.$consid.'M';

    //Get item code
    $itemcode = $engine->getItemCode($patientnum);

/*
 * Check if insertion is done in the main table 
 * if not do the insertion otherwise skip insertion.
 */
  $labmain = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_labtest_main WHERE LTM_PACKAGECODE = ".$sql->Param('a')." "),array($prespackagecode));
  print $sql->ErrorMsg();
  if($labmain->RecordCount() == 0 ){
    $ltmmid = uniqid();
    $sql->Execute($sql->Prepare("INSERT INTO hms_patient_labtest_main(LTM_ID,LTM_PACKAGECODE,LTM_VISITCODE,LTM_DATE,LTM_PATIENTNUM,LTM_PATIENTNAME,LTM_RMK,LTM_ACTORCODE,LTM_ACTORNAME,LTM_INSTCODE,LTM_PATIENTCODE,LTM_LABCODE,LTM_LABNAME,LTM_ITEMCODE,LTM_COUNTRYCODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').")"), array($ltmmid,$prespackagecode,$visitcode,$day,$patientnum,$patientname,$remark,$usrcode,$usrname,$activeinstitution,$patientcode,'','',$itemcode,$countrycode));
    print $sql->ErrorMsg();
}

    $labscheck = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_STATUS='1' AND LT_TEST=".$sql->Param('a')." AND LT_TESTNAME=".$sql->Param('a')." AND LT_VISITCODE=".$sql->Param('a')." AND (LT_PATIENTNUM=".$sql->Param('b')." OR LT_PATIENTCODE=".$sql->Param('b').")"),array($testcode,$testname,$visitcode,$patientnum,$patientcode));
    print $sql->ErrorMsg();

    if ($labscheck->RecordCount()>0){
        $fetchstmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_STATUS='1' AND LT_VISITCODE=".$sql->Param('a')." AND (LT_PATIENTNUM=".$sql->Param('b')." OR LT_PATIENTCODE=".$sql->Param('b').") ORDER BY LT_ID DESC"),array($visitcode,$patientnum,$patientcode));
        print $sql->ErrorMsg();
        $result = array();

        $num = 1;
        if ($fetchstmt->RecordCount()>0){
            while ($obj = $fetchstmt->FetchNextObject()){
				// Decrypt text with another key if necessary
				$decrypid = $obj->LT_ENCRYPKEY;
				if($decrypid != $activekey){
				$saltencrypt = $encryptkeys[$decrypid]['salt'];
                $pepperdecrypt =  $encryptkeys[$decrypid]['pepper'];
				$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
				}
				
				$testname = $encaes->decrypt($obj->LT_TESTNAME);
				$testrmk = $encaes->decrypt($obj->LT_RMK);
                $result[]=array("<tr><td>".$num++."</td><td>".$testname."</td><td>".$testrmk."</td><td><button type='button' id='deletecomplain' onclick='deleteComplains(\"".$obj->LT_CODE."\",\"Labs\");' class=\"btn-danger removecomplain\">&times;</button></td></tr>");
            }
        }
    }else{
        if (isset($activeinstitution) && !empty($activeinstitution)){

            $stmt = $sql->Execute($sql->Prepare("SELECT FACFE_MENUCATCODE FROM hmsb_facilities_features WHERE FACFE_FACICODE = ".$sql->Param('a')." AND FACFE_MENUCATCODE = ".$sql->Param('b')." AND FACFE_STATUS = '1'"),array($activeinstitution,'004'));
            print $sql->ErrorMsg();
            if ($stmt->RecordCount() == 1){
                $lttid = uniqid();
                
                //get item code
                $stmtitcode = $sql->Execute($sql->Prepare("SELECT LTM_ITEMCODE FROM hms_patient_labtest_main WHERE  LTM_PACKAGECODE = ".$sql->Param('a')." "),array($prespackagecode));
                $objitcode = $stmtitcode->FetchNextObject();
                $icode = $objitcode->LTM_ITEMCODE ;

                $stmtlab = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_labtest (LT_CODE,LT_VISITCODE,LT_DATE,LT_PATIENTNUM,LT_PATIENTNAME,LT_TEST,LT_TESTNAME,LT_DISCIPLINE,LT_DISCPLINENAME,LT_RMK,LT_ACTORCODE,LT_ACTORNAME,LT_INSTCODE,LT_PATIENTCODE,LT_ENCRYPKEY,LT_LABCODE,LT_LABNAME,LT_STATUS,LT_ID,LT_PACKAGECODE,LT_ITEMCODE,LT_COUNTRYCODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').",".$sql->Param('17').",".$sql->Param('18').",".$sql->Param('19').",".$sql->Param('20').",".$sql->Param('21').",".$sql->Param('22').")"), array($lqcode,$visitcode,$day,$patientnum,$patientname,$testcode,$testname,$dicscode,$dicsname,$remark,$usrcode,$usrname,$activeinstitution,$patientcode,$encryptkey,$activeinstitution,$activeinstitution,'6',$lttid,$prespackagecode,$icode,$countrycode));

                print $sql->ErrorMsg();

                //  Notification
				$stmt = $sql->Execute($sql->Prepare("SELECT REQU_ID FROM hms_service_request WHERE REQU_VISITCODE = ".$sql->Param('a')." "),array($visitcode));
            $client = $stmt->FetchNextObject();
			$tablerowid= $client->REQU_ID;
			
			
                $code = '004';
                $desc = 'Laboratory Request for '.$patientname;
                $menudetailscode = '0008';
                //Get row id
                $smtrequstdetails = $patientCls->getServRequestInfo($visitcode);
                //$tablerowid = $sql->insert_Id();
                $sentto = $activeinstitution;
                $engine->setNotification($code,$desc,$menudetailscode,$tablerowid,$sentto);
            }else{
                $lttid = uniqid();

                //get item code
                $stmtitcode = $sql->Execute($sql->Prepare("SELECT LTM_ITEMCODE FROM hms_patient_labtest_main WHERE  LTM_PACKAGECODE = ".$sql->Param('a')." "),array($prespackagecode));
                $objitcode = $stmtitcode->FetchNextObject();
                $icode = $objitcode->LTM_ITEMCODE ;

                $stmtlab = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_labtest (LT_CODE,LT_VISITCODE,LT_DATE,LT_PATIENTNUM,LT_PATIENTNAME,LT_TEST,LT_TESTNAME,LT_DISCIPLINE,LT_DISCPLINENAME,LT_RMK,LT_ACTORCODE,LT_ACTORNAME,LT_INSTCODE,LT_PATIENTCODE,LT_ENCRYPKEY,LT_ID,LT_PACKAGECODE,LT_ITEMCODE,LT_COUNTRYCODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').",".$sql->Param('17').",".$sql->Param('18').")"), array($lqcode,$visitcode,$day,$patientnum,$patientname,$testcode,$testname,$dicscode,$dicsname,$remark,$usrcode,$usrname,$activeinstitution,$patientcode,$encryptkey,$lttid,$prespackagecode,$icode,$countrycode));

                print $sql->ErrorMsg();

                //  Notification
                $code = '004';
                $desc = 'Laboratory Request for '.$patientname;
                $menudetailscode = '0008';
                //Get row id
                $smtrequstdetails = $patientCls->getServRequestInfo($visitcode);
                $tablerowid = $sql->insert_Id();
                $sentto = $activeinstitution;
                $engine->setNotification($code,$desc,$menudetailscode,$tablerowid,$sentto);
            }

        }
        if ($stmtlab){
            $msg = "Consultation has been saved successfully";
            $status = "success";

            $fetchstmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_STATUS IN ('1','2','3','4','5','6','7') AND LT_VISITCODE=".$sql->Param('a')." AND (LT_PATIENTNUM=".$sql->Param('b')." OR LT_PATIENTCODE=".$sql->Param('b').") ORDER BY LT_ID DESC"),array($visitcode,$patientnum,$patientcode));
            print $sql->ErrorMsg();
            $result = array();
            $num = 1;
            if ($fetchstmt->RecordCount()>0){
                while ($obj = $fetchstmt->FetchNextObject()){
				// Decrypt text with another key if necessary
				$decrypid = $obj->LT_ENCRYPKEY;
				if($decrypid != $activekey){
				$saltencrypt = $encryptkeys[$decrypid]['salt'];
                $pepperdecrypt =  $encryptkeys[$decrypid]['pepper'];
				$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
				}
					$testname = $encaes->decrypt($obj->LT_TESTNAME);
					$testrmk = $encaes->decrypt($obj->LT_RMK);
                    $result[]=array("<tr><td>".$num++."</td><td>".$testname."</td><td>".$testrmk."</td><td><button type='button' id='deletecomplain' onclick='deleteComplains(\"".$obj->LT_CODE."\",\"Labs\");' class=\"btn-danger removecomplain\">&times;</button></td></tr>");
                }
            }
        }
    }
    echo json_encode($result);
}