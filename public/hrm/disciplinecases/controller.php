<?php
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$userCourier = $engine->getActorCourier();
$ccode = $engine->getparcelcode();
$actorid = $engine->getActorCode();
switch($viewpage){
	
	case "load_empname":
	
	$stmt = $sql->Execute($sql->Prepare("SELECT SM_FNAME,SM_SURNAME FROM hms_hrm_staffmgt WHERE SM_CODE  = ".$sql->Param('a')." "),array($empcode)); 
		print $sql->ErrorMsg();
		if($stmt->RecordCount() == 1){
			$obj = $stmt->FetchNextObject();
			$empname = $obj->SM_SURNAME." ".$obj->SM_FNAME;
			
			
	    }
	
	break;
	
	case "insertcase":
	$postkey = $session->get("postkey");
if($postkey != $microtime){
	$session->set("postkey",$microtime);
	
	if( empty($empcode) || empty($casename)||empty($casetype)||empty($startdate) || empty($description) ){
	$msg = "Please you cannot save. All Fields are Required";
		$status = "error";	

	}else {
		
		$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_hrm_disciplinarycases WHERE  HDC_EMPLOYEECODE=".$sql->Param('a')." AND HDC_INSTU = ".$sql->Param('b')."  "),array($empcode, $userCourier));
			print $sql->ErrorMsg();
		
		if($stmt->RecordCount()>0){
				$msg = "Failed, Disciplinary Case exists already.Pending Response";
	    		$status = "error";
	}else {
		
		
		$casestart = date("Y-m-d",strtotime($startdate));
			
			$casecode = uniqid();
			
			$sql->Execute($sql->Prepare("INSERT INTO hms_hrm_disciplinarycases (HDC_CODE,HDC_NAME,HDC_DES,HDC_EMPLOYEECODE, HDC_EMPLOYEE, HDC_WRITTER, HDC_TYPE, HDC_INSTU,HDC_ENDRES) VALUES (".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i')." )"), array($casecode,$casename,$description,$empcode,$empname,$actorid,$casetype,$userCourier,$casestart));
print $sql->ErrorMsg();

			
		$msg = "Disciplinary Case Added Successfully.";
	    $status = "success";
        $activity = "Disciplinary Case Added Successfully.";
		$engine->setEventLog("056",$activity);
		
		
	}
	

}
	
}
	break;
	case "edit":
	$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_hrm_disciplinarycases  WHERE HDC_CODE  = ".$sql->Param('a')." "),array($keys)); 
		print $sql->ErrorMsg();
		if($stmt->RecordCount() == 1){
			$obj = $stmt->FetchNextObject();
			$empname = $obj->HDC_EMPLOYEE;
			$casename = $obj->HDC_NAME;
			$description = $obj->HDC_DES;
			$startdate = $obj->HDC_ENDRES;
			$casetype = $obj->HDC_TYPE;
			$delievery = $obj->HDC_STATUS;
			$statusdel = $obj->HDC_STATUS;
			$response = $obj->HDC_ENDORS;
	    }
		$caseend = date("d/m/Y",strtotime($startdate));
	
	break;
	
	case "updatecase":
	
	
	if(!empty($keys)){ 
			
			$stmt = $sql->Execute($sql->Prepare("UPDATE hms_hrm_disciplinarycases SET HDC_STATUS=".$sql->Param('a').", HDC_ENDORS=".$sql->Param('a').",HDC_RESPONSE=".$sql->Param('a')." WHERE HDC_CODE=".$sql->Param('c')),array($casestatus,$response,$actorid,$keys));
		
		
        $msg = "Disciplinary Case Responded Successfully.";
	    $status = "success";
        $activity = "Disciplinary Case Responded Successfully.";
		$engine->setEventLog("057",$activity);	
		}
	
	
	
	break;
	
	
	
	
	
	
	
}

if(!empty($fdsearch)){
	$query = "SELECT * FROM hms_hrm_disciplinarycases WHERE HDC_INSTU =".$sql->Param('a')." AND HDC_EMPLOYEE LIKE ".$sql->Param('b')." ";$input = array($userCourier,'%'.$fdsearch.'%');

}else {

    $query = "SELECT * FROM hms_hrm_disciplinarycases WHERE HDC_INSTU=".$sql->Param('a')." "; $input = array($userCourier);
}

$stmtemployee = $sql->Execute($sql->Prepare("SELECT SM_CODE,SM_FNAME,SM_SURNAME from hms_hrm_staffmgt where SM_STATUS='1' AND SM_INSTU=".$sql->Param('a')."  "), $input = array($userCourier));


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