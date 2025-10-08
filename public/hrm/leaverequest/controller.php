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
	
	
	case "insertleaverequest":
	
	//$startdate = $engine->getDateFormat($startdate);
	
	

	
	$postkey = $session->get("postkey");
if($postkey != $microtime){
	$session->set("postkey",$microtime);
	
	if( empty($empcode) || empty($leavetype)||empty($startdate)||empty($enddate) || empty($reason) ){
		
		$msg = "Please you cannot save. All Fields are Required";
		$status = "error";	
		
	}else {
		
		$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_hrm_leaverequest WHERE LR_STATUS='1' AND LR_STAFFCODE=".$sql->Param('a')." AND LR_INSTU = ".$sql->Param('b')."  "),array($empcode, $userCourier));
			print $sql->ErrorMsg();
		
		if($stmt->RecordCount()>0){
				$msg = "Failed, Leave Request exists already.Pending Approval";
	    		$status = "error";
		}else {
			
			$leavestart = date("Y-m-d",strtotime($startdate));
			$enddate = $engine->getDateFormat($enddate);
			
			
			$leaverequestcode = uniqid();
			
			$sql->Execute($sql->Prepare("INSERT INTO hms_hrm_leaverequest (LR_CODE,LR_STAFF,LR_STAFFCODE,LR_LEAVETYPE, LR_STARTDATE, LR_ENDDATE, LR_DESC, LR_INSTU,LR_USERREQ) VALUES (".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i')." )"), array($leaverequestcode,$empname,$empcode,$leavetype,$startdate,$enddate,$reason,$userCourier,$actorid));
print $sql->ErrorMsg();

			
		$msg = "Leave Request Added Successfully.";
	    $status = "success";
        $activity = "Leave Request Added Successfully.";
		$engine->setEventLog("042",$activity);

		}
	}
	
}
	
	break;
	
	
	case "edit":
	
	$stmt = $sql->Execute($sql->Prepare("Select LR_CODE,LR_STAFF,LR_STAFFCODE, LT_CODE, LR_STARTDATE, LR_ENDDATE, LR_DESC, LT_NAME,LR_STATUS from hms_hrm_leaverequest join hms_hrm_leavetype ON LR_LEAVETYPE = LT_CODE  WHERE LR_CODE  = ".$sql->Param('a')." "),array($keys)); 
		print $sql->ErrorMsg();
		if($stmt->RecordCount() == 1){
			$obj = $stmt->FetchNextObject();
			$leavetype = $obj->LT_NAME;
			$fname = $obj->LR_STAFF;
			$startdate=$obj->LR_STARTDATE;
			$enddate=$obj->LR_ENDDATE;
			$delievery=$obj->LR_STATUS;
			$leavetypecode=$obj->LT_CODE;
			$content=$obj->LR_DESC;
			
			
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
		
		
		case "updateleaverequest":
		
		
		$stmt = $sql->Execute($sql->Prepare("Select LR_CODE,LR_STAFF,LR_STAFFCODE, LT_CODE, LR_STARTDATE, LR_ENDDATE, LR_DESC, LT_NAME,LR_STATUS from hms_hrm_leaverequest join hms_hrm_leavetype ON LR_LEAVETYPE = LT_CODE  WHERE LR_CODE  = ".$sql->Param('a')." "),array($keys)); 
		print $sql->ErrorMsg();
		if($stmt->RecordCount() == 1){
			$obj = $stmt->FetchNextObject();
			$leavetype = $obj->LT_NAME;
			$fname = $obj->LR_STAFF;
			$startdate=$obj->LR_STARTDATE;
			$enddate=$obj->LR_ENDDATE;
			$delievery=$obj->LR_STATUS;
			$leavetypecode=$obj->LT_CODE;
			$content=$obj->LR_DESC;
			
			
	    }
	
	
	
		
			
$sql->Execute("UPDATE hms_hrm_leaverequest 
SET LR_LEAVETYPE = ".$sql->Param('a').", 
LR_STARTDATE = ".$sql->Param('b').",
LR_ENDDATE = ".$sql->Param('c')." ,
LR_DESC = ".$sql->Param('d')." 
WHERE LR_CODE = ".$sql->Param('e')."",array($leavetypecode,$startdate,$enddate,$content,$keys));
		print $sql->ErrorMsg();
		
		
        $msg = "Leave Requested Editted Successfully.";
	    $status = "success";
        $activity = "Leave Requested Editted Successfully.";
		$engine->setEventLog("040",$activity);	
		
	
	
	break;
	
	
	
	
	
}


if(!empty($fdsearch)){

}else {

    $query = "Select LR_CODE,LR_STAFF,LR_STAFFCODE,  LR_STARTDATE, LR_ENDDATE, LR_DESC, LT_NAME,LR_STATUS from hms_hrm_leaverequest join hms_hrm_leavetype ON LR_LEAVETYPE = LT_CODE WHERE LR_INSTU=".$sql->Param('a')." "; $input = array($userCourier);
}
$stmtleavetype = $sql->Execute($sql->Prepare("SELECT * from hms_hrm_leavetype where LT_STATUS='1' AND LT_INSTU=".$sql->Param('a')."  "), $input = array($userCourier));


$stmtemployee = $sql->Execute($sql->Prepare("SELECT SM_CODE,SM_FNAME,SM_SURNAME from hms_hrm_staffmgt where SM_STATUS='1' AND SM_INSTU=".$sql->Param('a')."  "), $input = array($userCourier));



if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=0ae6717ed4b10a21cfd627685a748a46&option=6f54bdcd66cda60ffd246df2bbdb570f&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);

//Get all positions
$stmtpos = $engine->getUserPosition();


?>