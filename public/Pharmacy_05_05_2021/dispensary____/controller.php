<?php
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
switch($viewpage){
	
}

if(!empty($fdsearch)){

}else {

    $query = "SELECT * FROM hms_users WHERE USR_DELETE_STATUS = '0' AND USR_FACICODE = ".$sql->Param('a')." ";
    $input = array($activeinstitution);
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