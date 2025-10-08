<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 8/25/2017
 * Time: 11:59 AM
 */
include '../../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
//include SPATH_LIBRARIES.DS."patient.Class.php";

$engine = new engineClass();
$patientCls = new patientClass();


$day = Date("Y-m-d");
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();
$actor = $engine->getActorDetails();
$activeinstitution = $actor->USR_FACICODE;

if (!empty($paymentcategory)&&!empty($pat_paymentscheme)&&!empty($patientcode)){
    $patpayschcode = $patientCls->getPatientPaymentSchemeCode();
    $paycat = explode('@@@',$paymentcategory);
    $paysch = explode('@@@',$pat_paymentscheme);
    $paycat_code = $paycat[0];
    $paycat_name = $paycat[1];
    $paysch_code = $paysch[0];
    $paysch_name = $paysch[1];

    $schemecheck = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_paymentscheme WHERE PAY_PATIENTCODE=".$sql->Param('a')." AND PAY_PAYMENTMETHODCODE=".$sql->Param('a')." AND PAY_SCHEMECODE=".$sql->Param('a')." AND PAY_STATUS = '1'"),array($patientcode,$paycat_code,$paysch_code));
    print $sql->ErrorMsg();

    if ($schemecheck->RecordCount() > 0){
        $fetchstmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_paymentscheme WHERE PAY_PATIENTCODE=".$sql->Param('a')." AND PAY_FACCODE=".$sql->Param('a')." AND PAY_STATUS = '1'"),array($patientcode,$activeinstitution));
        print $sql->ErrorMsg();
        if ($fetchstmt->RecordCount()>0){
            $result = array();
            $num = 1;
            while ($obj = $fetchstmt->FetchNextObject()){
                $paymentcat = $obj->PAY_PAYMENTMETHOD;
                $paymentsch = $obj->PAY_SCHEMENAME;
                $membnumber = $obj->PAY_CARDNUM;
                $datestart = ($obj->PAY_STARTDT != '' && $obj->PAY_STARTDT != '1970-01-01')?$obj->PAY_STARTDT:'';
                $dateend = ($obj->PAY_ENDDT != '' && $obj->PAY_ENDDT != '1970-01-01')?$obj->PAY_ENDDT:'';

                $result[]=array("<tr><td>".$num++."</td><td>".$paymentcat."</td><td>".$paymentsch."</td><td>".$membnumber."</td><td>".$datestart."</td><td>".$dateend."</td><td><button type='button' id='deletescheme' onclick='deleteScheme(\"".$obj->PAT_CODE."\",\"".$obj->PAT_PATIENTCODE."\");' class=\"btn-danger removecomplain\">&times;</button></td></tr>");
            }
        }
    }else{
        if ($paycat_code == 'PC0001'){
            $pay_type = '1';
            $pay_typename = 'Cash';
        }elseif ($paycat_code == 'PC0002'){
            $pay_type = '2';
            $pay_typename = 'National Health Insurance Authority';
        }elseif ($paycat_code == 'PC0003'){
            $pay_type = '3';
            $pay_typename = 'Private Health Insurance';
        }elseif ($paycat_code == 'PC0004'){
            $pay_type = '4';
            $pay_typename = 'Partner Company';
        }
        $startdate = (!empty($startdate)?date('Y-m-d',strtotime($startdate)):'');
        $enddate = (!empty($enddate)?date('Y-m-d',strtotime($enddate)):'');
        $issuedate = (!empty($issuedate)?date('Y-m-d',strtotime($issuedate)):'');
        $expirydate = (!empty($expirydate)?date('Y-m-d',strtotime($expirydate)):'');
        if ($pay_type == '1' || $pay_type == '4' ){
            $stmtpayscheme = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_paymentscheme (PAY_CODE, PAY_DATE, PAY_PATIENTNUMBER, PAY_PATIENTCODE, PAY_TYPE, PAY_TYPENAME, PAY_PAYMENTMETHODCODE, PAY_PAYMENTMETHOD, PAY_SCHEMECODE, PAY_SCHEMENAME, PAY_CARDNUM, PAY_FACCODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').")"),array($patpayschcode,$day,$patientnum,$patientcode,$pay_type,$pay_typename,$paycat_code,$paycat_name,$paysch_code,$paysch_name,$membershipnumber,$activeinstitution));
        }else{
            $stmtpayscheme = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_paymentscheme (PAY_CODE, PAY_DATE, PAY_PATIENTNUMBER, PAY_PATIENTCODE, PAY_TYPE, PAY_TYPENAME, PAY_PAYMENTMETHODCODE, PAY_PAYMENTMETHOD, PAY_SCHEMECODE, PAY_SCHEMENAME, PAY_CARDNUM, PAY_STARTDT, PAY_ENDDT, PAY_FACCODE, PAY_DATEOFISSUE, PAY_EXPIRYDATE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').")"),array($patpayschcode,$day,$patientnum,$patientcode,$pay_type,$pay_typename,$paycat_code,$paycat_name,$paysch_code,$paysch_name,$membershipnumber,$startdate,$enddate,$activeinstitution,$issuedate,$expirydate));
        }

        print $sql->ErrorMsg();
        if ($stmtpayscheme){
            $msg = "Consultation has been saved successfully";
            $status = "success";

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
//                echo json_encode($result);
            }else{
                $result[]=array("<tr><td>There was an error</td></tr>");
            }
        }
    }
    echo json_encode($result);
}