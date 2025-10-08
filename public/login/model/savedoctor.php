<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 7/20/2017
 * Time: 12:54 PM
 */
ob_start();
include '../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
$engine = new engineClass();
ob_start();
$actualdate = date('Y-m-d H:i:s');

if (!empty($fname)&&!empty($lname)){
    $specialty = $engine->getDoctorSpecialty($specialisation);
    $stmt = $sql->Execute($sql->Prepare("INSERT INTO hmsb_med_prac(MP_SURNAME,MP_OTHERNAME,MP_EMAIL,MP_PHONENO,MP_LOCATION,MP_SPECIALISATION_CODE,MP_SPECIALISATION,MP_MEDLICENSENO,MP_INPUTEDDATE,MP_STATUS) VALUES (".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('j').")"),array($lname,$fname,$email,$phonenum,$location,$specialisation,$specialty,$registration_num,$actualdate,'0'));
    print $sql->ErrorMsg();

    if ($stmt){
        $msg = "Your Registration was successful, we will contact you by mail.";
        $status = "success";
    }else{
        $msg = "Your Registration has been declined. Review your details provided";
        $status = "error";
    }
}else{
    $msg = "All fields required";
    $status = "error";
}
echo json_encode($msg);