<?php 
include("../../../../config.php");
include(SPATH_LIBRARIES."/engine.Class.php");
include("../model/excelReport.php");


$engine = new engineClass();
$excel = new excelReport();



//$actor = $engine->getActorDetails();
//$activeinstitution = $actor->USR_FACICODE;
$data =[];
  


if (!empty($datefrom)&&!empty($dateto)){
//$sql->debug = true;
$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_consultation WHERE CONS_DOCTORCODE = ".$sql->Param('a')." AND CONS_DATE >={$sql->Param('a')} AND  CONS_DATE <={$sql->Param('a')} AND CONS_STATUS IN ('0','8','7','6','5','4','3','2','1')  ORDER BY CONS_INPUTDATE"),array($usrcode,$from,$to));
    print $sql->ErrorMsg();

    while ($obj = $stmt->FetchNextObject()){

         $pcode = $obj->CONS_PATIENTCODE;
                       //$actorcode = $obj->FIR_PATIENTID;
                       $stmtp = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient WHERE PATIENT_PATIENTCODE =".$sql->Param('a').""),array($pcode));
                       $objp  = $stmtp->FetchNextObject();
 
        $data []=array( $objp->PATIENT_FNAME.' '.$objp->PATIENT_MNAME.' '$objp->PATIENT_LNAME,$objp->PATIENT_PATIENTNUM,$objp->PATIENT_GENDER,$objp->PATIENT_EMAIL,date("d/m/Y",strtotime($obj->CONS_DATE)));
    }

    var_dump($data);die;
}



$excel->ReportHeader($header);
   ob_end_clean(); 
   $excel->consultation($data); 
   

?>