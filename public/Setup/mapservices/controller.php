<?php
//print_r($_POST);
$crypt = new cryptCls();
$actorid = $session->get("userid");
$actorname = $engine->getActorName();
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$objdtls = $engine->getFacilityDetails();
$facilityalias = $objdtls->FACI_ALIAS ;
$facicode = $session->get("activeinstitution");

switch($viewpage){
	case "savemap":
	$duplicatekeeper = $session->get("post_key");
	if($microtime != $duplicatekeeper){
		$session->set("post_key",$microtime);
        if(!empty($depcode)){
            //get department name
			$objdept = $engine->getDepartmentDetails($depcode);
            $depname = $objdept->DEPT_NAME;
			
			foreach($_POST['syscheckbox'] as $value){
				//get service name
				$objserdt = $engine->getServiceDetails($value);
				$servname = $objserdt->SERV_NAME;
				$sql->Execute("INSERT INTO hms_assigndept(ST_SERVICE,ST_SERVICENAME,ST_DEPT,ST_DEPTNAME,ST_FACICODE,ST_USRCODE) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').")",array($value,$servname,$depcode,$depname,$facicode,$actorid));

			print $sql->ErrorMsg();
			}

			 $activity = 'Insertion: Services assigned to the : '.$depname.' department. Services codes are : '.implode(",",$_POST['syscheckbox']).' by '.$actorname;
             $engine->setEventLog('052',$activity);
			 
				   $msg = "Success: Services mapped successfully.";
	               $status = "success";
	               $view ='';
	}else{
		           $msg = "Error: No department selected.";
	               $status = "error";
	               $view ="mapservices";
		
		 }
	}
	break;
	
	
	case "savemapedit":
	$duplicatekeeper = $session->get("post_key");
	if($microtime != $duplicatekeeper){
		$session->set("post_key",$microtime);
        if(!empty($depcode)){
            //get department name
			$objdept = $engine->getDepartmentDetails($depcode);
            $depname = $objdept->DEPT_NAME;
			
			//Delete all previous mapping
			$sql->Execute("DELETE FROM hms_assigndept WHERE ST_DEPT = ".$sql->Param('a')." AND ST_FACICODE = ".$sql->Param('b')." ",array($depcode,$facicode));
			
			
			foreach($_POST['syscheckbox'] as $value){
				//get service name
				$objserdt = $engine->getServiceDetails($value);
				$servname = $objserdt->SERV_NAME;
				$sql->Execute("INSERT INTO hms_assigndept(ST_SERVICE,ST_SERVICENAME,ST_DEPT,ST_DEPTNAME,ST_FACICODE,ST_USRCODE) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').")",array($value,$servname,$depcode,$depname,$facicode,$actorid));

			print $sql->ErrorMsg();
			}

			 $activity = 'Update: Services assigned to the : '.$depname.' department. Services codes are : '.implode(",",$_POST['syscheckbox']).' by '.$actorname;
             $engine->setEventLog('052',$activity);
			 
				   $msg = "Success: Services mapped successfully.";
	               $status = "success";
	               $view ='';
	}else{
		           $msg = "Error: No department selected.";
	               $status = "error";
	               $view ="mapservices";
		
		 }
	}
	break;
	
	
	case "editmapping":
	 if(isset($keys) && $keys != ''){
		$stmt = $sql->Execute($sql->Prepare("SELECT DISTINCT ST_DEPT,ST_DEPTNAME FROM hms_assigndept WHERE ST_DEPT = ".$sql->Param('a')." AND ST_FACICODE = ".$sql->Param('b')." "),array($keys,$activeinstitution));
		print $sql->ErrorMsg();
		if($stmt->RecordCount() == 1){
			$obj = $stmt->FetchNextObject();
			$depcode = $obj->ST_DEPT;
			$depname = $obj->ST_DEPTNAME;
		
		$stmtdept = $sql->Execute($sql->Prepare("SELECT * FROM hmsb_department "));	
	    }
		 
	}
	break;
	
	case "reset":
	   $fdsearch = $action_search = "";
	break;
}

$stmtdepartment = $sql->Execute($sql->Prepare("SELECT * FROM hmsb_department WHERE DEPT_CODE NOT IN (SELECT ST_DEPT FROM hms_assigndept WHERE ST_FACICODE = ".$sql->Param('a')." ) "),array($activeinstitution));
print $sql->ErrorMsg();

if(isset($action_search) && $action_search == "search"){
	if(!empty($fdsearch)){
    $query = "SELECT * FROM hms_users WHERE USR_DELETE_STATUS = '0' AND USR_FACICODE = ".$sql->Param('a')." AND ( USR_SURNAME LIKE ".$sql->Param('b')." OR USR_OTHERNAME LIKE ".$sql->Param('c')." OR USR_USERNAME LIKE ".$sql->Param('d')." OR USR_PHONENO = ".$sql->Param('e').")";
    $input = array($activeinstitution,$fdsearch.'%',$fdsearch.'%',$fdsearch.'%',$fdsearch);
	}
}else {

    $query = "SELECT DISTINCT ST_DEPT,ST_DEPTNAME,ST_STATUS FROM hms_assigndept WHERE ST_STATUS = '1' AND ST_FACICODE = ".$sql->Param('a')." ";
    $input = array($activeinstitution);
}
if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=ad2376beebecdcf7846ba973fa1a005b&option=5eff45b3aa908749a0785fc4da47cd69&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);
?>