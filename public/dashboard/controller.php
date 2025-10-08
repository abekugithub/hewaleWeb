<?php
$objdtls = $engine->getFacilityDetails();
$actor = $engine->getActorDetails();
$facitype = $objdtls->FACI_TYPE ;
$facilityalias = $objdtls->FACI_ALIAS ;
$faccode = $objdtls->FACI_CODE ;
$usercode = $actor->USR_CODE;

switch($viewpage){

	case "changeVH":

		//Update the users table
		if(!empty($facicode)){

		$sql->Execute("UPDATE hms_users SET USR_FACICODE = ".$sql->Param('a')." WHERE USR_CODE= ".$sql->Param('b')." ",array($facicode,$usercode));


		}
	break;
}

/*
$queryBroad = "SELECT * FROM hms_broadcast_prescription WHERE BRO_PHARMACYCODE = ".$sql->Param('a')." AND BRO_STATUS =".$sql->Param('b')."";
$day = date('Y-m-d');
$stmtlisttestdetails = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_LABCODE =  ".$sql->Param('b')." AND LT_STATUS IN ('3','4','5') and LT_DATE < ".$sql->Param('1')."   "),array($faccode,$day));
		print $sql->Errormsg();

$input = array($faccode,'1');
$pagingBroad = new OS_Pagination($sql,$queryBroad,$limit,$lenght,'index.php?pg=ad2376beebecdcf7846ba973fa1a005b&option=6831b98f85019ddb98bd98d44bdbac40#',$input);
*/
include("model/js.php");
?>