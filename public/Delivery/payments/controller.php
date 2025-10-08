<?php
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$userCourier = $engine->getActorCourier();
switch($viewpage){
	
	
	
	
	case "reset":
	
	$fdsearch='';
	break;
	}

if(!empty($fdsearch)){
	$query = "SELECT COUP_CODE,COUP_PROCESSCODE,COUP_AMT,COUP_DATE, COUP_STATUS from hms_courierpayment WHERE COUP_COURIER=".$sql->Param('a')." AND (COUP_PROCESSCODE LIKE ".$sql->Param('b').") ";
 $input = array($userCourier,$fdsearch.'%');

}else {

    $query = "SELECT COUP_CODE,COUP_PROCESSCODE,COUP_AMT,COUP_DATE, COUP_STATUS from hms_courierpayment WHERE COUP_COURIER=".$sql->Param('a')." ORDER BY COUP_DATE DESC "; $input = array($userCourier);
}
if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=065ab3a28ca4f16f55f103adc7d0226f&option=6a5ed2142b41b6e28c309f3f1fe772e5&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);

//Get all positions
$stmtpos = $engine->getUserPosition();

?>