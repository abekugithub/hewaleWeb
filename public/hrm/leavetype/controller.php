<?php
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$userCourier = $engine->getActorCourier();
$ccode = $engine->getparcelcode();
switch($viewpage){
	
	case "insertleavetype":
	
	$postkey = $session->get("postkey");
if($postkey != $microtime){
	$session->set("postkey",$microtime);
	
	if( empty($leavetype)){
		
		$msg = "Please you cannot save. All Fields are Required";
		$status = "error";	
		
	}else {
		
		$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_hrm_leavetype WHERE LT_NAME=".$sql->Param('a')." AND LT_INSTU = ".$sql->Param('b')."  "),array($leavetype, $userCourier));
			print $sql->ErrorMsg();
		
		if($stmt->RecordCount()>0){
				$msg = "Failed, Leave Type exists already.";
	    		$status = "error";
		}else {
			
			$newleavetype = strtoupper($leavetype);
			
			$leavetypecode = uniqid();
			
			$sql->Execute($sql->Prepare("INSERT INTO hms_hrm_leavetype (LT_CODE,LT_NAME,LT_INSTU) VALUES (".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c')." )"), array($leavetypecode,$newleavetype,$userCourier));
print $sql->ErrorMsg();

			
		$msg = "Leave Type Added Successfully.";
	    $status = "success";
        $activity = "Leave Type Added Successfully.";
		$engine->setEventLog("039",$activity);

		}
	}
	
}
	
	break;
	
	
	case "edit":
	
	$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_hrm_leavetype  WHERE LT_CODE  = ".$sql->Param('a')." "),array($keys)); 
		print $sql->ErrorMsg();
		if($stmt->RecordCount() == 1){
			$obj = $stmt->FetchNextObject();
			$leavetype = $obj->LT_NAME;
			
			
	    }
	
	
	break;
	
	
	case "updateleavetype":
	
	if(!empty($keys)){ 
		
			$newleavetype = strtoupper($leavetype);
		
			
			$stmt = $sql->Execute($sql->Prepare("UPDATE hms_hrm_leavetype SET LT_NAME=".$sql->Param('a')." WHERE LT_CODE=".$sql->Param('b')),array($newleavetype,$keys));
		
		
        $msg = "Leave Type Editted Successfully.";
	    $status = "success";
        $activity = "Leave Type Editted Successfully.";
		$engine->setEventLog("040",$activity);	
		
	}
	
	break;
	
	
	
	
	
}


if(!empty($fdsearch)){

}else {

    $query = "SELECT * FROM hms_hrm_leavetype WHERE LT_STATUS ='1'  AND LT_INSTU=".$sql->Param('a')." "; $input = array($userCourier);
}




if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=0ae6717ed4b10a21cfd627685a748a46&option=d7537109884329dd67f7f97d974d1ffb&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);

//Get all positions
$stmtpos = $engine->getUserPosition();


?>