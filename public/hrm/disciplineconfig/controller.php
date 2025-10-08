<?php
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$userCourier = $engine->getActorCourier();
$ccode = $engine->getparcelcode();
switch($viewpage){
	
	
	
	
	
	
	
	
	
	
	
}

if(!empty($fdsearch)){
	$query = "SELECT * FROM hms_paygrade WHERE PG_INSTI =".$sql->Param('a')." AND PG_NAME LIKE ".$sql->Param('a')." ";$input = array($userCourier,'%'.$fdsearch.'%');

}else {

    $query = "SELECT * FROM hms_paygrade WHERE PG_STATUS ='1'  AND PG_INSTI=".$sql->Param('a')." "; $input = array($userCourier);
}




if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=0ae6717ed4b10a21cfd627685a748a46&option=21698f43a55a39cd399d8c492bd6828a&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);

//Get all positions
$stmtpos = $engine->getUserPosition();

?>