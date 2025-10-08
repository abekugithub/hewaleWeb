<?php
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");

$objdtls = $engine->getFacilityDetails();
$facilityalias = $objdtls->FACI_ALIAS ;
$faccode = $objdtls->FACI_CODE ;
switch($viewpage){
	
}

if(!empty($fdsearch)){
 $query = "SELECT * FROM hms_patient_prescription WHERE PRESC_FACICODE = ".$sql->Param('a')."  AND AND PRESC_STATUS = ".$sql->Param('a').") ";
    $input = array($faccode,'2');
}else {

    $query = "SELECT * FROM hms_patient_prescription WHERE PRESC_FACICODE = ".$sql->Param('a')." AND PRESC_STATUS =  ".$sql->Param('2')." ";
    $input = array($faccode,'2');
}
if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=ad2376beebecdcf7846ba973fa1a005b&option=6831b98f85019ddb98bd98d44bdbac40#',$input);

//Get all positions
$stmtpos = $engine->getUserPosition();

?>