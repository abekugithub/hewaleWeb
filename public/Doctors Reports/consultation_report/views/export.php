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

$sql->debug = true;
    $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_consultation WHERE CONS_FACICODE =".$sql->Param('a')." AND CONS_SCHEDULEDATE >= ".$sql->Param('a')." AND CONS_SCHEDULEDATE   <= ".$sql->Param('a')." AND CONS_DOCTORCODE =".$sql->Param('a').""),array($activeinstitution,$from,$to,$usrcode));
    print $sql->ErrorMsg();

    while ($obj = $stmt->FetchNextObject()){
        $data []=array($obj->CONS_PATIENTNAME,$obj->CONS_PATIENTNUM,$obj->CONS_VISITCODE,date("d/m/Y",strtotime($obj->CONS_SCHEDULEDATE)),$obj->CONS_DOCTORNAME);
    }

    //var_dump($data);die;
}



$excel->ReportHeader($header);
   ob_end_clean(); 
   $excel->consultation($data); 
   

?>