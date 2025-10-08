<?php
ob_start();
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 8/25/2017
 * Time: 3:35 PM
 */


include ('../../../../config.php');
include SPATH_LIBRARIES.DS."engine.Class.php";

$engine = new engineClass();
ob_start();
//$day = Date("Y-m-d");

//echo json_encode($_POST['patientnum']);

if (!empty($_POST['patientnum']) && !empty($_POST['visitcode'])){

    $fetchstmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_complains WHERE PC_STATUS='1' AND PC_VISITCODE=".$sql->Param('a')." AND PC_PATIENTCODE=".$sql->Param('b')." ORDER BY PC_ID DESC"),array($_POST['visitcode'],$_POST['patientnum']));
    print $sql->ErrorMsg();
    $result = array();
    $num = 1;
    if ($fetchstmt->RecordCount()>0){
        while ($obj = $fetchstmt->FetchNextObject()){
            $result[]=array("<tr><td>".$num++."</td><td>".$obj->PC_COMPLAIN."</td><td>".$obj->PC_STORYLINE."</td><td><button type='button' id='deletecomplain' onclick='deleteComplains(\"".$obj->PC_CODE."\");' class=\"btn-danger removecomplain\">&times;</button></td></tr>");
        }
        echo json_encode($result);
    }
}else{
    echo json_encode('erororo data empty');
}

//echo json_encode($_POST['patientnum'].'triela and error'.$_POST['visitcode']);