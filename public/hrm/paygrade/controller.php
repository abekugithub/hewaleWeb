<?php
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$userCourier = $engine->getActorCourier();
$ccode = $engine->getparcelcode();
switch($viewpage){
	
	case "insertgrade":
	
	$postkey = $session->get("postkey");
if($postkey != $microtime){
	$session->set("postkey",$microtime);
	
	if( empty($gradename)){
		
		$msg = "Please you cannot save. All Fields are Required";
		$status = "error";	
		
	}else {
		
		$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_hrm_paygrade WHERE PG_NAME=".$sql->Param('a')." AND PG_INSTI = ".$sql->Param('b')."  "),array($gradename, $userCourier));
			print $sql->ErrorMsg();
		
		if($stmt->RecordCount()>0){
				$msg = "Failed, Agent exists already.";
	    		$status = "error";
		}else {
			
			$newgradename = strtoupper($gradename);
			
			$gradecode = uniqid();
			
			$sql->Execute($sql->Prepare("INSERT INTO hms_hrm_paygrade (PG_CODE,PG_NAME,PG_MIN,PG_MAX,PG_INSTI) VALUES (".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').", ".$sql->Param('d').", ".$sql->Param('e')." )"), array($gradecode,$newgradename,$minsalary,$maxsalary,$userCourier));
print $sql->ErrorMsg();

			
		$msg = "Pay Grade Added Successfully.";
	    $status = "success";
        $activity = "Pay Grade Added Successfully.";
		$engine->setEventLog("034",$activity);

		}
	}
	
}
	
	break;
	
	
	case "edit":
	
	$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_hrm_paygrade  WHERE PG_CODE  = ".$sql->Param('a')." "),array($keys)); 
		print $sql->ErrorMsg();
		if($stmt->RecordCount() == 1){
			$obj = $stmt->FetchNextObject();
			$gradename = $obj->PG_NAME;
			$minsalary = $obj->PG_MIN;
			$maxsalary = $obj->PG_MAX;
			
	    }
	
	
	break;
	
	
	case "updategrade":
	
	if(!empty($keys)){ 
		
			$newgradename = strtoupper($gradename);
		
			
			$stmt = $sql->Execute($sql->Prepare("UPDATE hms_hrm_paygrade SET PG_NAME=".$sql->Param('a').", PG_MIN=".$sql->Param('c').", PG_MAX=".$sql->Param('d')." WHERE PG_CODE=".$sql->Param('b')),array($newgradename,$minsalary,$maxsalary,$keys));
		
		
        $msg = "Pay Grade Updated Successfully.";
	    $status = "success";
        $activity = "Pay Grade Updated Successfully.";
		$engine->setEventLog("035",$activity);	
		
	}
	
	break;
	
	
	
	
	
}


if(!empty($fdsearch)){
	$query = "SELECT * FROM hms_hrm_paygrade WHERE PG_INSTI =".$sql->Param('a')." AND PG_NAME LIKE ".$sql->Param('a')." ";$input = array($userCourier,'%'.$fdsearch.'%');

}else {

    $query = "SELECT * FROM hms_hrm_paygrade WHERE PG_STATUS ='1'  AND PG_INSTI=".$sql->Param('a')." "; $input = array($userCourier);
}




if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=0ae6717ed4b10a21cfd627685a748a46&option=09255e20d360da2cee07598a834c39e5&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);

//Get all positions
$stmtpos = $engine->getUserPosition();


?>