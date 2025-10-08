<?php
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$userCourier = $engine->getActorCourier();
$ccode = $engine->getparcelcode();
switch($viewpage){
	
	case "insertcomponent":
	
	$postkey = $session->get("postkey");
if($postkey != $microtime){
	$session->set("postkey",$microtime);
	
	if( empty($componentname) || empty($type) || empty($added) || empty($valuetype)){
		
		$msg = "Please you cannot save. All Fields are Required";
		$status = "error";	
		
	}else {
		
		$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_hrm_salarycomponents WHERE SC_NAME=".$sql->Param('a')." AND SC_INSTI = ".$sql->Param('b')."  "),array($componentname, $userCourier));
			print $sql->ErrorMsg();
		
		if($stmt->RecordCount()>0){
				$msg = "Failed, Agent exists already.";
	    		$status = "error";
		}else {
			
			
			$newcomponentname = strtoupper($componentname);
			
			$salcomcode = uniqid();
			
			$sql->Execute($sql->Prepare("INSERT INTO hms_hrm_salarycomponents (SC_CODE,SC_NAME, SC_TYPE, SC_ADDTO, SC_INSTI, SC_VALUE) VALUES (".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f')." )"), array($salcomcode,$newcomponentname,$type,$added,$userCourier,$valuetype));
print $sql->ErrorMsg();

			
		$msg = "Salary Component Added Successfully.";
	    $status = "success";
        $activity = "Salary Component Added Successfully.";
		$engine->setEventLog("032",$activity);

		}
	}
	
}
	
	break;
	
	
	case "edit":
	
	$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_hrm_salarycomponents  WHERE SC_CODE  = ".$sql->Param('a')." "),array($keys)); 
		print $sql->ErrorMsg();
		if($stmt->RecordCount() == 1){
			$obj = $stmt->FetchNextObject();
			$componentname = $obj->SC_NAME;
			$type = $obj->SC_TYPE;
			$added = $obj->SC_ADDTO;
			$valueadd = $obj->SC_VALUE;
			
			
	    }
	
	
	break;
	
	
	case "updatecomponent":
	
	if(!empty($keys)){ 
		
			$newcomponentname = strtoupper($componentname);
		
			
			$stmt = $sql->Execute($sql->Prepare("UPDATE hms_hrm_salarycomponents SET SC_NAME=".$sql->Param('a').", SC_TYPE=".$sql->Param('c').", SC_ADDTO=".$sql->Param('d').", SC_VALUE=".$sql->Param('e')."  WHERE SC_CODE=".$sql->Param('b')),array($newcomponentname,$type,$added,$valuetype,$keys));
		
		
        $msg = "Salary Component Updated Successfully.";
	    $status = "success";
        $activity = "Salary Component Updated Successfully.";
		$engine->setEventLog("033",$activity);	
		
	}
	
	break;
	
	
	
	
	
}


if(!empty($fdsearch)){

$query = "SELECT * FROM hms_hrm_salarycomponents WHERE SC_NAME LIKE ".$sql->Param('a')."  AND SC_INSTI=".$sql->Param('a')." "; $input = array('%'.$fdsearch.'%',$userCourier);

}else {

    $query = "SELECT * FROM hms_hrm_salarycomponents WHERE SC_STATUS ='1'  AND SC_INSTI=".$sql->Param('a')." "; $input = array($userCourier);
}




if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=0ae6717ed4b10a21cfd627685a748a46&option=0448b99249a79be6c489cef1584b7f12&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);

//Get all positions
$stmtpos = $engine->getUserPosition();


?>