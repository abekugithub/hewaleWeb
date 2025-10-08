<?php
$crypt = new cryptCls();
$actorid = $session->get("userid");
$actorname = $engine->getActorName();
$actorgroup = $engine->getUsergroup();

$actudate = date("Y-m-d H:m:s");
$objdtls = $engine->getFacilityDetails();
$facilityalias = $objdtls->FACI_ALIAS ;
$actorcode = $engine->getActorCode();

switch($viewpage){
	case "reset":
	   $fdsearch = $action_search = "";
	break;
}

if(isset($action_search) && $action_search == "search"){
	if(!empty($fdsearch)){
    $query = "SELECT * FROM hms_ph_supplies WHERE SUP_FACICODE = ".$sql->Param('a')." AND ( SUP_WAYBILL = ".$sql->Param('b')." OR SUP_SUPPLIERNAME LIKE ".$sql->Param('c')." )";
    $input = array($activeinstitution,$fdsearch,$fdsearch.'%');
	}
}else {

    $query = "SELECT * FROM hms_ph_supplies WHERE SUP_FACICODE = ".$sql->Param('a')." ";
    $input = array($activeinstitution);
}
if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=27ce7f8b5623b2e2df568d64cf051607&option=76ad3bde62e444c0ee091a4c446d3c68&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);

//Get all positions
$stmtpos2 = $engine->getUserPosition();
?>