<?php
//print_r($_POST);
$crypt = new cryptCls();
$actorid = $session->get("userid");
$actorname = $engine->getActorName();
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$objdtls = $engine->getFacilityDetails();
$facilityalias = $objdtls->FACI_ALIAS ;

switch($viewpage){
	case "saverole":
	$valid = true;
	$duplicatekeeper = $session->get("post_key");
	if($microtime != $duplicatekeeper){
		$session->set("post_key",$microtime);
	if(!empty($prole) && !empty($userlevel)){
			if(!empty($keys)){
				
			//Check if username is unique
			$stmt = $sql->Execute($sql->Prepare("SELECT FACPOS_NAME FROM hms_facilities_usrposition WHERE FACPOS_FACICODE = ".$sql->Param('a')." AND FACPOS_FACLVID = ".$sql->Param('b')." AND FACPOS_ID != ".$sql->Param('c')." "),array($activeinstitution,$userlevel,$keys));
			print $sql->ErrorMsg();
			if($stmt){
				$proletemp = strtolower(str_replace(' ','',$prole));
				while($obj = $stmt->FetchNextObject())
				{
					$tempname = strtolower(str_replace(' ','',$obj->FACPOS_NAME));
					if($tempname == $proletemp){
						$valid = false;
					}
				}
			
				
			if($valid == true){
			
			$sql->Execute("UPDATE hms_facilities_usrposition SET FACPOS_NAME = ".$sql->Param('a').",FACPOS_DESCRIPTION = ".$sql->Param('b').",FACPOS_FACLVID = ".$sql->Param('c').",FACPOS_STATUS = ".$sql->Param('d')." WHERE FACPOS_ID = ".$sql->Param('e')." ",array($prole,$descrpt,$userlevel,$usrstatus,$keys));
			print $sql->ErrorMsg();
			
			 $activity = 'User position edited with name: '.$prole.' by '.$actorname;
             $engine->setEventLog('010',$activity);
			 
				   $msg = "Success: User role edited successfully.";
	               $status = "success";
	               $view ='';
				}else{
					 $msg = "Failed. User role already exists.";
	                 $status = "error";
	                 $view ='addposition';
					  }
				
				 }
				
			}else{
			//Check if username is unique
			$stmt = $sql->Execute($sql->Prepare("SELECT FACPOS_NAME FROM hms_facilities_usrposition WHERE FACPOS_FACICODE = ".$sql->Param('a')." AND FACPOS_FACLVID = ".$sql->Param('b')." "),array($activeinstitution,$userlevel));
			print $sql->ErrorMsg();
			if($stmt){
				$proletemp = strtolower(str_replace(' ','',$prole));
				while($obj = $stmt->FetchNextObject())
				{
					$tempname = strtolower(str_replace(' ','',$obj->FACPOS_NAME));
					if($tempname == $proletemp){
						$valid = false;
					}
				}
			
				
			if($valid == true){
			//Generate position Code		
            $poscode = $engine->getPositionCode($activeinstitution);
			
			$sql->Execute("INSERT INTO hms_facilities_usrposition(FACPOS_CODE,FACPOS_NAME,FACPOS_DESCRIPTION,FACPOS_FACLVID,FACPOS_FACICODE,FACPOS_STATUS,FACPOS_ACTORID) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').")",array($poscode,$prole,$descrpt,$userlevel,$activeinstitution,$usrstatus,$actorid));
			print $sql->ErrorMsg();
			
			 $activity = 'New position created with name: '.$prole.' by '.$actorname;
             $engine->setEventLog('009',$activity);
			 
				   $msg = "Success: User role captured successfully.";
	               $status = "success";
	               $view ='';
				}else{
					 $msg = "Failed. User role already exists.";
	                 $status = "error";
	                 $view ='addposition';
					  }
				
				 }
			}
			}else{
				   $msg = "Failed. Required field(s) cannot be empty.";
	               $status = "error";
	               $view ='addposition';
				 }
	}
	break;
	
	case "editrole":
	 if(isset($keys) && $keys != ''){
		$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_facilities_usrposition WHERE FACPOS_ID = ".$sql->Param('a')." "),array($keys)); 
		print $sql->ErrorMsg();
		if($stmt->RecordCount() == 1){
			$obj = $stmt->FetchNextObject();
			$prole = $obj->FACPOS_NAME;
			$descrpt = $obj->FACPOS_DESCRIPTION;
			$userlevel = $obj->FACPOS_FACLVID;
			$usrstatus = $obj->FACPOS_STATUS;
	    }
		 
	}
	break;
	
	case "deleterole":
	
	break;
	
	case "reset":
	   $fdsearch = $action_search = "";
	break;
}

if(isset($action_search) && $action_search == "search"){
	if(!empty($fdsearch)){
    $query = "SELECT * FROM hms_facilities_usrposition JOIN hms_facilities_usrlevel ON FACPOS_FACLVID = FACLV_ID WHERE FACPOS_FACICODE = ".$sql->Param('a')." AND ( FACPOS_NAME LIKE ".$sql->Param('b')." OR FACPOS_DESCRIPTION LIKE ".$sql->Param('c').")";
    $input = array($activeinstitution,$fdsearch.'%',$fdsearch.'%');
	}
}else {

    $query = "SELECT * FROM hms_facilities_usrposition JOIN hms_facilities_usrlevel ON FACPOS_FACLVID = FACLV_ID WHERE FACPOS_FACICODE = ".$sql->Param('a')." ";
    $input = array($activeinstitution);
}
if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=ad2376beebecdcf7846ba973fa1a005b&option=b5ca58d7396478f68ba7aa00736b23c8',$input);

//Get all positions
$stmtpos2 = $engine->getUserPosition();
?>