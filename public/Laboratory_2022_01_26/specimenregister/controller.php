<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 8/8/2017
 * Time: 5:14 PM
 */

//var_dump($_POST);
$crypt = new cryptCls();
$actorid = $session->get("userid");
$actorname = $engine->getActorName();
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$objdtls = $engine->getFacilityDetails();
$facilityalias = $objdtls->FACI_ALIAS ;
$faccode = $objdtls->FACI_CODE ;
$patientCls = new patientClass();


//print_r($_POST);
//echo $keys;
switch ($viewpage){

    
	case "testdetails":

    $stmt = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest_main WHERE LTM_PACKAGECODE = ".$sql->Param('1')."   "),array($keys));
    print $sql->Errormsg();

        
    if($stmt->Recordcount() > 0){

        $obj = $stmt->FetchNextObject();
        $patient = $obj->LTM_PATIENTNAME;
        $patientnum = $obj->LTM_PATIENTNUM;
        $patientcode = $obj->LTM_PATIENTCODE;
        $packagecode = $obj->LTM_PACKAGECODE;
        $patientdate = $obj->LTM_DATE;
        $medic = $obj->LTM_ACTORNAME;
        $Total  = $obj->LTM_TOTAL_AMOUNT;

        $patientcontact = $patientCls->getPatientDetails($patientnum)->PATIENT_PHONENUM ;
        $patientgender = $patientCls->getPatientDetails($patientnum)->PATIENT_GENDER ;

    }

    $stmtlisttestdetails = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_PACKAGECODE = ".$sql->Param('1')." and  LT_SPECIMENSTATE = ".$sql->Param('1')."   "),array($keys,'1'));
    print $sql->Errormsg();
    

break;



    
}
include 'model/js.php';


if(!empty($fdsearch)){

    $query = "SELECT LTM_VISITCODE,LTM_DATE,LTM_PATIENTNUM,LTM_PATIENTCODE,LTM_PATIENTNAME,LTM_RMK,LTM_ACTORCODE,LTM_ACTORNAME,LTM_INSTCODE,LTM_TOTAL_AMOUNT,LTM_PACKAGECODE FROM hms_patient_labtest_main WHERE  LTM_LABCODE = ".$sql->Param('a')." and LTM_SAMPLESTATE  ".$sql->Param('b')." AND (LTM_PATIENTNAME LIKE ".$sql->Param('c')." OR LTM_PATIENTNUM LIKE ".$sql->Param('d')."  ) ";
   $input = array($faccode,'1','%'.$fdsearch.'%','%'.$fdsearch.'%');

}else {

   //echo $faccode;
   $query = "SELECT LTM_VISITCODE,LTM_DATE,LTM_PATIENTNUM,LTM_PATIENTCODE,LTM_PATIENTNAME,LTM_RMK,LTM_ACTORCODE,LTM_ACTORNAME,LTM_INSTCODE,LTM_TOTAL_AMOUNT,LTM_PACKAGECODE FROM hms_patient_labtest_main WHERE LTM_SAMPLESTATE = ".$sql->Param('a')." AND LTM_LABCODE = ".$sql->Param('b')." ";
   $input = array('1',$faccode);

}

$stmtlisttestsampledetails = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_PACKAGECODE = ".$sql->Param('1')." and  LT_SPECIMENSTATE = ".$sql->Param('1')."   "),array($keys,'1'));
print $sql->Errormsg();


   if(!isset($limit)){
       $limit = $session->get("limited");
   }else if(empty($limit)){
       $limit =20;
   }
   $session->set("limited",$limit);
   $lenght = 10;
   $paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=e684d8eeee72ed2583865b78e8d3f57a&option=85401ead437783774ed80a3807ed532a&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);

   //Get all positions
   $stmtpos2 = $engine->getUserPosition();
   //include 'model/js.php';
