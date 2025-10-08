<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 11/27/2017
 * Time: 4:34 PM
 */
include SPATH_PLUGINS.'/fpdf/fpdf.php';
include 'model/pdfReportClass.php';
$actorname = $engine->getActorName();

$patientCls = new patientClass();
$sms = new smsgetway();
$import = new importClass();
$faccode = $engine->getActorDetails()->USR_FACICODE;
$actorcode = $engine->getActorDetails()->USR_CODE;
$userid = $engine->getActorDetails()->USR_USERID;
$facilityname = $engine->getFacilityDetails()->FACI_NAME;
$facilitylocation = $engine->getFacilityDetails()->FACI_LOCATION;
$facilityphoneno = $engine->getFacilityDetails()->FACI_PHONENUM;
$facilitylogo = SHOST_PATIENTPHOTO.$engine->getFacilityDetails()->FACI_LOGO_ONAME;
$crtdate= date("Y-m-d H:m:s");
$date_from = $datefrom;
$date_to = $dateto;
$result = array();

//$export_url = 'public/Laboratory Reports/Lab. Request Report/';
//$print_url = 'public/Laboratory Reports/Lab. Request Report/s/list.php?datefrom='.$datefrom.'&dateto='.$dateto;

switch ($viewpage){
    case 'report':
        $report_comp_logo = $facilitylogo;
        $report_comp_name = $facilityname;
        $report_title = 'Laboratory Request Report';
        $report_comp_location = $facilitylocation;
        $report_phone_number = $facilityphoneno;
        include 'model/js.php';
        $postkey = $session->get("postkey");
        if (!empty($datefrom)&&!empty($dateto)){
            $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_LABCODE = ".$sql->Param('a')." AND LT_DATE BETWEEN ".$sql->Param('b')." AND ".$sql->Param('c')),array($faccode,$datefrom,$dateto));
            print $sql->ErrorMsg();

            if ($stmt->RecordCount()>0){
                $num = 0;
                while ($obj = $stmt->FetchNextObject()){
                    $result[] = array(
                        'patientname' => $obj->LT_PATIENTNAME,
                        'patientcode' => $obj->LT_PATIENTCODE,
                        'testname'    => $encaes->decrypt($obj->LT_TESTNAME),
                        'labdiscpline'=>$obj->LT_DISCPLINENAME,
                        'labrequestdate'=>$obj->LT_DATE
                    );
                }
            }
        }
    break;

    case 'excelexport':
    break;

    case 'pdfexport':
        if (!empty($hiddatefrom)&&!empty($hiddateto)){
            $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_LABCODE = ".$sql->Param('a')." AND LT_DATE BETWEEN ".$sql->Param('b')." AND ".$sql->Param('c')),array($faccode,$hiddatefrom,$hiddateto));
            print $sql->ErrorMsg();

            if ($stmt->RecordCount()>0){
                $num = 0;
                while ($obj = $stmt->FetchNextObject()){
                    $result[] = array(
                        'patientname' => $obj->LT_PATIENTNAME,
                        'patientcode' => $obj->LT_PATIENTCODE,
                        'testname'    => $encaes->decrypt($obj->LT_TESTNAME),
                        'labdiscpline'=>$obj->LT_DISCPLINENAME,
                        'labrequestdate'=>$obj->LT_DATE
                    );
                }
            }
            $pdf = new pdfReport();
            $pdf->formtype=$formtype;
            $pdf->formname=$formname;
            $pdf->from=$month_array[$datefrom];
            $pdf->to= $dateto;
            $pdf->AliasNbPages();
            $pdf->AddPage();
            ob_end_clean();
            $pdf->eventlogg($result);
//            print_r($result);
        }
    break;
}
//print_r ($_POST);

//include 'model/js.php';