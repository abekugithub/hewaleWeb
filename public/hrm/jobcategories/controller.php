<?php
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$userCourier = $engine->getActorCourier();
$ccode = $engine->getparcelcode();
switch($viewpage){
	
	case "insertcategory":
	
	$postkey = $session->get("postkey");
if($postkey != $microtime){
	$session->set("postkey",$microtime);
	
	if( empty($inputcategoryname)){
		
		$msg = "Please you cannot save. All Fields are Required";
		$status = "error";	
		
	}else {
		
		$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_hrm_jobcategory WHERE JB_NAME=".$sql->Param('a')." AND JB_INSTU = ".$sql->Param('b')."  "),array($inputcategoryname, $userCourier));
			print $sql->ErrorMsg();
		
		if($stmt->RecordCount()>0){
				$msg = "Failed, Agent exists already.";
	    		$status = "error";
		}else {
			
			
			$newinputcategoryname = strtoupper($inputcategoryname);
			
			$jobcode = uniqid();
			
			$sql->Execute($sql->Prepare("INSERT INTO hms_hrm_jobcategory (JB_CODE,JB_NAME, JB_INSTU) VALUES (".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').")"), array($jobcode,$newinputcategoryname,$userCourier));
print $sql->ErrorMsg();

			
		$msg = "Job Category Added Successfully.";
	    $status = "success";
        $activity = "Job Category Added Successfully.";
		$engine->setEventLog("031",$activity);

		}
	}
	
}
	
	break;
	
	
	case "edit":
	
	$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_hrm_jobcategory  WHERE JB_CODE  = ".$sql->Param('a')." "),array($keys)); 
		print $sql->ErrorMsg();
		if($stmt->RecordCount() == 1){
			$obj = $stmt->FetchNextObject();
			$inputcategoryname = $obj->JB_NAME;
			
	    }
	
	
	break;
	
	case "updatecategory":
	
	if(!empty($keys)){ 
		
			$newinputcategoryname = strtoupper($inputcategoryname);
		
			
			$stmt = $sql->Execute($sql->Prepare("UPDATE hms_hrm_jobcategory SET JB_NAME=".$sql->Param('a')." WHERE JB_CODE=".$sql->Param('b')),array($newinputcategoryname,$keys));
		
		
        $msg = "Job Category Editted Successfully.";
	    $status = "success";
        $activity = "Job Category Editted Successfully.";
		$engine->setEventLog("053",$activity);	
		
	}
	
	break;
	
	
	
	
	
}


if(!empty($fdsearch)){
	
	$query = "SELECT * FROM hms_hrm_jobcategory WHERE JB_NAME LIKE ".$sql->Param('a')."  AND JB_INSTU=".$sql->Param('a')." "; $input = array('%'.$fdsearch.'%',$userCourier);

}else {

    $query = "SELECT * FROM hms_hrm_jobcategory WHERE JB_STATUS ='1'  AND JB_INSTU=".$sql->Param('a')." "; $input = array($userCourier);
}




if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=0ae6717ed4b10a21cfd627685a748a46&option=2db39cc28ee6af74f0acbd11f80df09a&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);

//Get all positions
$stmtpos = $engine->getUserPosition();

?>