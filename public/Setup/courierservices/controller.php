<?php
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$userCourier = $engine->getActorCourier();
$objdtls = $engine->getFacilityDetails();
$faccode = $objdtls->FACI_CODE ;
switch($viewpage){
	
	case "savecourierselection":
	
	$postkey = $session->get("postkey");
if($postkey != $microtime){
	$session->set("postkey",$microtime);
	
		if(is_array($_POST['courierservice'])){
		foreach($_POST['courierservice'] as $index){
			
			$adcode = uniqid();
		//$facidetails = $engine->getFacility($index);	
		//$faciname = $facidetails->FACI_NAME;
		$stmtname=$sql->Execute($sql->Prepare("SELECT FACI_NAME from hmsb_allfacilities WHERE FACI_CODE=".$sql->Param('a')." "),array($index));
		if ($stmtname->RecordCount()>0){
			while ($objname=$stmtname->FetchNextObject()){
				$faciname=$objname->FACI_NAME;
			}
		}else{
			$faciname='';
		}
$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_pharmcourierselection (CS_CODE,CS_PHARMCODE, CS_COURIERCODE, CS_COURIERNAME) VALUES (".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').")"),array($adcode,$userCourier,$index,$faciname));

		}
 print $sql->ErrorMsg();
 
 		$msg = "Courier Service Selected Successfully.";
	    $status = "success";
        $activity = "Courier Service Selected Successfully.";
		$engine->setEventLog("105",$activity);	
 
	}
	

	}
	
	break;
	
	case "remove":
	if(!empty($keys)){ 
	$stmt = $sql->Execute($sql->Prepare("DELETE FROM hms_pharmcourierselection WHERE CS_CODE = ".$sql->Param('b').""),array($keys));
		print $sql->ErrorMsg();
		
				$msg = "Courier Service Deleted Successfully.";
                $status = "success";
                $activity = "Courier Service Deleted Successfully.";
				$engine->setEventLog("106",$activity);
	}
	break;
	
	case "add":
	 $stmtcourierbranches = $sql->Execute($sql->Prepare("SELECT FACI_NAME,FACI_CODE,FACI_PHONENUM,FACI_LOCATION FROM hmsb_allfacilities WHERE FACI_TYPE = 'C' AND FACI_STATUS = '1' AND FACI_CODE NOT IN (SELECT CS_COURIERCODE FROM hms_pharmcourierselection WHERE CS_PHARMCODE ='".$faccode."' )"));

    $stmtcountries = $sql->Execute($sql->Prepare("SELECT CN_ID,CN_COUNTRY from hmsb_countries_nationalities WHERE CN_STATUS='1' "));
	break;
	
	case "reset":
	$fdsearch = "";
	break;
		
}
	
	
if(!empty($fdsearch)){
	$query = "SELECT FACI_NAME,FACI_CODE,FACI_PHONENUM,FACI_LOCATION,CS_CODE from hmsb_allfacilities JOIN hms_pharmcourierselection ON FACI_CODE = CS_COURIERCODE WHERE CS_PHARMCODE=".$sql->Param('a')." AND (FACI_NAME LIKE ".$sql->Param('b').") ";
 $input = array($userCourier,$fdsearch.'%');

}else {

    $query = "SELECT FACI_NAME,FACI_CODE,FACI_PHONENUM,FACI_LOCATION,CS_CODE from hmsb_allfacilities JOIN hms_pharmcourierselection ON FACI_CODE = CS_COURIERCODE WHERE CS_PHARMCODE=".$sql->Param('a')."  "; $input = array($userCourier);
}

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