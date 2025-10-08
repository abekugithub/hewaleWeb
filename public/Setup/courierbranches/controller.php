<?php
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$userCourier = $engine->getActorCourier();
//$userfacicode = $engine->courierBranceCode($userCourier);
switch($viewpage){
	
	
	case "load_regions":
	
	$stmtregions = $sql->Execute($sql->Prepare("SELECT REG_COUNTRYID,REG_NAME, REG_CODE,REG_ID FROM hmsb_region WHERE REG_COUNTRYID=".$sql->Param('a')." AND REG_STATUS='1' ORDER BY REG_NAME ASC "),array($branchcountry));
	
	break;
	
	case "savebranch":
	//echo $inputregions;exit;

	$postkey = $session->get("postkey");
if($postkey != $microtime){
	$session->set("postkey",$microtime);
	
	
	if(empty($branchname) || empty($branchlocation) || empty($branchtelephone)) {
		
		$msg = "Please you cannot save. All Fields are Required";
		$status = "error";
	}else {
	
	$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hmsb_courier_branches WHERE BRCH_FACICODE=".$sql->Param('a')." AND BRCH_NAME = ".$sql->Param('b')."  "),array($userCourier, $branchname));
			print $sql->ErrorMsg();
	
	if($stmt->RecordCount()>0){
				$msg = "Failed, Branch exists already.";
	    		$status = "error";
		}else {
			
			$newbranchname = strtoupper($branchname);
			
			
			$sql->Execute($sql->Prepare("INSERT INTO hmsb_courier_branches (BRCH_CODE,BRCH_NAME, BRCH_FACICODE,BRCH_COUNTRY,BRCH_REGION,BRCH_LOCATION,BRCH_CONTACT_NAME,BRCH_CONTACT_PHONE) VALUES (".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').", ".$sql->Param('e').", ".$sql->Param('f').", ".$sql->Param('g').", ".$sql->Param('h').")"), array($ccode,$newbranchname,$userCourier, $branchcountry,$inputregions, $branchlocation,$branchcontact,$branchtelephone));
print $sql->ErrorMsg();



	$ciu = "COU";
	$ccode = $ciu.date("dmy").$sql->insert_ID();
	$stmt = "UPDATE hmsb_courier_branches SET BRCH_CODE = ".$sql->Param('a')." WHERE BRCH_ID=".$sql->Param('a');
       $sql->Execute($stmt,array($ccode,$sql->insert_ID()));

		
		$msg = "Branch Created Successfully.";
	    $status = "success";
        $activity = "Branch Created Successfully.";
		$engine->setEventLog("104",$activity);	
	
			
		}
	
	
	
	
	
	}

	
}
	break;
	
}

if(!empty($fdsearch)){
	$query = "SELECT BRCH_NAME,BRCH_CODE, BRCH_FACICODE,BRCH_COUNTRY,BRCH_REGION,BRCH_LOCATION,BRCH_CONTACT_NAME,BRCH_CONTACT_PHONE FROM hmsb_courier_branches WHERE  BRCH_FACICODE=".$sql->Param('a')." AND (BRCH_NAME LIKE ".$sql->Param('b').") ";
 $input = array($userCourier,$fdsearch.'%');

}else {

    $query = "SELECT BRCH_NAME,BRCH_CODE, BRCH_FACICODE,BRCH_COUNTRY,BRCH_REGION,BRCH_LOCATION,BRCH_CONTACT_NAME,BRCH_CONTACT_PHONE FROM hmsb_courier_branches WHERE  BRCH_FACICODE=".$sql->Param('a')."  "; $input = array($userCourier);
}

$stmtcountries = $sql->Execute($sql->Prepare("SELECT CN_ID,CN_COUNTRY from hmsb_countries_nationalities WHERE CN_STATUS='1' "));

if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=ad2376beebecdcf7846ba973fa1a005b&option=dfc7e74a2707af638a0c5539897de3b9&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);

//Get all positions
$stmtpos = $engine->getUserPosition();

?>