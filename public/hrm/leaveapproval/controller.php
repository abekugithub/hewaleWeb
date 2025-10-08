<?php
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$enddate = date("Y-m-d H:m:s");
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
	
	
	case "approveleaverequest":
		if(!empty($keys)){ 
			
			$stmt = $sql->Execute($sql->Prepare("UPDATE hms_hrm_leaverequest SET LR_STATUS='2', LR_DAYSNO=".$sql->Param('a').",LR_USERAPPRO=".$sql->Param('b')." WHERE LR_CODE=".$sql->Param('c')),array($noofdays,$actorid,$keys));
		
		
        $msg = "Leave Request Approved Successfully.";
	    $status = "success";
        $activity = "Leave Request Approved Successfully.";
		$engine->setEventLog("043",$activity);	
		}
	
	
	break;
	
	case "delleaverequest":
	
	if(!empty($keys)){ 
			
			$stmt = $sql->Execute($sql->Prepare("UPDATE hms_hrm_leaverequest SET LR_STATUS='0', LR_DAYSNO=".$sql->Param('a').",LR_USERAPPRO=".$sql->Param('b')." WHERE LR_CODE=".$sql->Param('c')),array($noofdays,$actorid,$keys));
		
		
        $msg = "Leave Request Rejected Successfully.";
	    $status = "success";
        $activity = "Leave Request Rejected Successfully.";
		$engine->setEventLog("043",$activity);	
		}
	
	break;
	
	
	case "edit":
	
	
	
	$stmt = $sql->Execute($sql->Prepare("SELECT DATEDIFF(LR_ENDDATE,LR_STARTDATE) AS NODAYS, LR_CODE,LR_STAFF,LR_STAFFCODE,  LR_STARTDATE, LR_ENDDATE, LR_DESC, LT_NAME,LR_STATUS from hms_hrm_leaverequest join hms_hrm_leavetype ON LR_LEAVETYPE = LT_CODE WHERE LR_CODE  = ".$sql->Param('a')." "),array($keys)); 
		print $sql->ErrorMsg();
		if($stmt->RecordCount() == 1){
			$obj = $stmt->FetchNextObject();
			$empname = $obj->LR_STAFF;
			$noofdays = $obj->NODAYS;
			$leavetype = $obj->LT_NAME;
			$reason = $obj->LR_DESC;
			$startdate = $obj->LR_STARTDATE;
			$enddate = $obj->LR_ENDDATE;
	    }
	
	$leavestart = date("d/m/Y",strtotime($startdate));
	$leaveend= date("d/m/Y",strtotime($enddate));
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

    $query = "SELECT DATEDIFF(LR_ENDDATE,LR_STARTDATE) AS days, LR_CODE,LR_STAFF,LR_STAFFCODE,  LR_STARTDATE, LR_ENDDATE, LR_DESC, LT_NAME,LR_STATUS from hms_hrm_leaverequest join hms_hrm_leavetype ON LR_LEAVETYPE = LT_CODE WHERE LR_INSTU=".$sql->Param('a')." AND LR_STATUS='1' "; $input = array($userCourier);
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
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=0ae6717ed4b10a21cfd627685a748a46&option=84a1779db97f611146e85ddc7a854a17&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);

//Get all positions
$stmtpos = $engine->getUserPosition();


?>