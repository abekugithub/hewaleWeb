<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 8/15/2017
 * Time: 6:03 PM
 */
include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";

$engine = new engineClass();
$day = Date("Y-m-d");
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();
$actor = $engine->getActorDetails();
$activeinstitution = $actor->USR_FACICODE;
$countrycode = $actor->USR_COUNTRYCODE;

$data = $_POST;
foreach ($data['result'] as $res){
    if ($res['name']=='patientnum'){
        $patientnum = $res['value'];
    }
    if ($res['name']=='visitcode'){
        $visitcode = $res['value'];
    }
    if ($res['name']=='patientname'){
        $patientname = $res['value'];
    }

    //  Complains Saving
    if ($res['name']=='comp'){
        $com = explode('&',$res['value'].'  ');
        $complaincode = $engine->getcomplainCode();

        $stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_complains (PC_CODE,PC_PATIENTNUM,PC_VISITCODE,PC_DATE,PC_COMPLAINCODE,PC_COMPLAIN,PC_INSTCODE,PC_ACTORCODE,PC_ACTORNAME,PC_COUNTRYCODE) VALUES(".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').")"), array($complaincode,$patientnum,$visitcode,$day,$com[0],$com[1],$activeinstitution,$usrcode,$usrname,$countrycode));
        print $sql->ErrorMsg();
        if ($stmt){
            $msg = "Consultation has been saved successfully";
            $status = "success";
        }
    }
    //  Laboratory Savings
    if ($res['name']=='lab'){
        $lt = explode('@@@', $res['value']);
        $lcode = $lt[0];
        $ltest = $lt[1];
        $dcode = $lt[2];
        $ddis = $lt[3];
        $lremark = $lt[4];
        $lqcode = $engine->getlabtestCode();

        $stmtlab = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_labtest (LT_CODE,LT_VISITCODE,LT_DATE,LT_PATIENTNUM,LT_PATIENTNAME,LT_TEST,LT_TESTNAME,LT_DISCIPLINE,LT_DISCPLINENAME,LT_RMK,LT_ACTORCODE,LT_ACTORNAME,LT_INSTCODE,LT_COUNTRYCODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('14').")"), array($lqcode,$visitcode,$day,$patientnum,$patientname,$lcode,$ltest,$dcode,$ddis,$lremark,$usrcode,$usrname,$activeinstitution,$countrycode));
        print $sql->ErrorMsg();
        if ($stmtlab){
            $msg = "Consultation has been saved successfully";
            $status = "success";
        }
    }
    //  Diagnoses Savings
    if ($res['name']=='diagnose'){
        $diagnose = explode(',',$res['value']);
        $diacode = $engine->getdiagnosisCode();
        $dicode = $diagnose[0];
        $diname = $diagnose[1];
        $drmk = $diagnose[2];

        $stmtdiag = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_diagnosis (DIA_CODE,DIA_VISITCODE,DIA_DATE,DIA_PATIENTNUM,DIA_DIA,DIA_DIAGNOSIS,DIA_RMK,DIA_ACTORNAME,DIA_ACTORCODE,DIA_INSTCODE,DIA_COUNTRYCODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('9').",".$sql->Param('10').")"), array($diacode,$visitcode,$day,$patientnum,$dicode,$diname,$drmk,$usrname,$usrcode,$activeinstitution,$countrycode));
        print $sql->ErrorMsg();
        if ($stmtdiag){
            $msg = "Consultation has been saved successfully";
            $status = "success";
        }
    }
    //  Prescription Savings
    if ($res['name']=='drugname'){
        $drugname = explode(',',$res['value']);
        $precode = $engine->getprescriptionCode();
        $drcode = $drugname[0];
        $drname = $drugname[1];
        $dscode = $drugname[2];
        $dsname = $drugname[3];
        $frequency = $drugname[4];
        $days = $drugname[5];
        $times = $drugname[6];
        $qty = $frequency * $days * $times ;

        $stmtpresc = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_prescription (PRESC_CODE,PRESC_PATIENT,PRESC_PATIENTNUM,PRESC_DATE,PRESC_VISITCODE,PRESC_DRUGID,PRESC_DRUG,PRESC_QUANTITY,PRESC_DOSAGENAME,PRESC_DOSAGECODE,PRESC_FREQ,PRESC_DAYS,PRESC_TIMES,PRESC_ACTORNAME,PRESC_ACTORCODE,PRESC_INSTCODE,PRESC_COUNTRYCODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').",".$sql->Param('17').")"), array($precode,$patientname,$patientnum,$day,$visitcode,$drcode,$drname,$qty,$dsname,$dscode,$frequency,$days,$times,$usrname,$usrcode,$activeinstitution,$countrycode));
        print $sql->ErrorMsg();
        if ($stmtpresc){
            $msg = "Consultation has been saved successfully";
            $status = "success";
        }
    }
}
$activity = "Dr. $usrname has saved Consultation";
$engine->setEventLog('017',$activity);
echo $engine->msgBox($msg,$status);
