<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 9/22/2017
 * Time: 9:57 AM
 */

include '../../../../../config.php';
include SPATH_LIBRARIES . DS . "engine.Class.php";
$patientCls = new patientClass();
$engine = new engineClass();
$actorname = $engine->getActorName();
$faccode = $engine->getActorDetails()->USR_FACICODE;
//$result = array();
if (!empty($_POST['groupname']) && !empty($grouptype)){
    if (!empty($groupcode)){
        $stmt1 = $sql->Execute($sql->Prepare("SELECT PATGRP_ID,PATGRP_CODE,PATGRP_NAME,PATGRP_NUMBEROFPATIENT,PATGRP_GROUPTYPE,PATGRP_STATUS FROM hms_patient_group WHERE PATGRP_CODE=".$sql->Param('a').""),array($groupcode));
        print $sql->ErrorMsg();
        if ($stmt1->RecordCount()>0){
            // Update Group
            $stmtsave = $sql->Execute($sql->Prepare("UPDATE hms_patient_group SET PATGRP_NAME=".$sql->Param('a').", PATGRP_GROUPTYPE=".$sql->Param('b')." WHERE PATGRP_CODE=".$sql->Param('c')),array($groupname,$grouptype,$groupcode));
            print $sql->ErrorMsg();
            if ($stmtsave){
                $msg = 'Patient Group has been successfully updated.';
                $status = 'success';

            }
        }

    }else{
        $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_group WHERE PATGRP_NAME=".$sql->Param('a').""),array($groupname));
        print $sql->ErrorMsg();

        if ($stmt->RecordCount()>0){
            $msg = "A Patient Group with this name already exists";
            $status = "error";
        }else{
            //Get Group Code for group creation
            $groupcode = $patientCls->getPatientGroupCode($faccode);

            $stmtsave = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_group(PATGRP_CODE,PATGRP_NAME,PATGRP_GROUPTYPE) VALUES (".$sql->Param('a').",".$sql->Param('a').",".$sql->Param('a').")"),array($groupcode,$groupname,$grouptype));
            print $sql->ErrorMsg();

            if ($stmtsave){
                $msg = 'Patient Group name has been saved successfully';
                $status = 'success';
            }else{
                $msg = 'There was an error saving the patient group name';
                $status = 'error';
            }
        }
    }
//    $engine->msgBox($msg,$status);
    $response = $groupcode;
    echo json_encode($response);
}else{
    $msg = 'There was an error saving the patient group name';
    $status = 'error';
}