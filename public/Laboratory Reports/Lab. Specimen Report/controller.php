<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 12/5/2017
 * Time: 12:57 PM
 */

$actor = $engine->getActorDetails();
$import = new importClass();
$faccode = $engine->getActorDetails()->USR_FACICODE;
$actorcode = $engine->getActorDetails()->USR_CODE;
$userid = $engine->getActorDetails()->USR_USERID;
$facilityname = $engine->getFacilityDetails()->FACI_NAME;
$facilitylocation = $engine->getFacilityDetails()->FACI_LOCATION;
$facilityphoneno = $engine->getFacilityDetails()->FACI_PHONENUM;
$facilitylogo = SHOST_PATIENTPHOTO.$engine->getFacilityDetails()->FACI_LOGO_ONAME;
$report_title = 'Laboratory Request Report';
$crtdate= date("Y-m-d H:m:s");
//print_r ($_POST);
//echo $activeinstitution;


switch($viewpage){

    case "report":
        if (!empty($datefrom)&&!empty($dateto)){
            $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_LABCODE = ".$sql->Param('a')." AND LT_DATE BETWEEN ".$sql->Param('b')." AND ".$sql->Param('c')),array($faccode,$datefrom,$dateto));
            print $sql->ErrorMsg();
            if ($stmt){

                $obj = $stmt->FetchNextObject();

//                $report_comp_logo = "media/img/".$obj->FACI_LOGO_UNINAME;
                $report_comp_logo = $facilitylogo;
                $report_comp_name = $facilityname;
                $report_title = "Signed Off Report";
                $report_comp_location = $facilitylocation;
                $report_phone_number = $facilityphoneno;
                //$report_content = '';
                include("model/js.php");
            }
        }else{
            $view ="";
        }
        break;


}



//include 'model/js.php';