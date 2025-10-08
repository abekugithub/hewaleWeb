<?php
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$userCourier = $engine->getActorCourier();
$actorcode = $engine->getActorCode();
switch($viewpage){
	
	case "edit":
	//echo $userCourier;exit;
		$stmt = $sql->Execute($sql->Prepare("SELECT SU_CODE,SU_NAME, SU_CONTACT,SU_EMAIL,SU_ADDRESS,SU_LOCATION,SU_CONTACTPERSON,SU_CONPHONE, SU_CONEMAIL, SU_INSTICODE FROM hms_pharmsuppliers  WHERE SU_CODE  = ".$sql->Param('a')." "),array($keys)); 
		print $sql->ErrorMsg();
		if($stmt->RecordCount() > 0){
			$obj = $stmt->FetchNextObject();
			$supplier = $obj->SU_NAME;
			$contactno = $obj->SU_CONTACT;
			$email = $obj->SU_EMAIL;
			$address = $obj->SU_ADDRESS;
			$location = $obj->SU_LOCATION;
			$contperson = $obj->SU_CONTACTPERSON;
			$phonenumber = $obj->SU_CONPHONE;
			 $peremail = $obj->SU_CONEMAIL;
			 
			 //$imgold = $obj->COU_UNAME;
			
	    }
		
		//$agentdob = date("d-m-Y",strtotime($startdate));
		 
	break;
	
	
	case "insertsupplier":
	
	//echo $actorcode;exit;
	
	$postkey = $session->get("postkey");
if($postkey != $microtime){
	$session->set("postkey",$microtime);
	
	if( empty($supplier) || empty($contactno) || empty($email) ||  empty($location) ){
		
		$msg = "Please you cannot save. All Fields are Required";
		$status = "error";	
		
	}else {
		
		$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_pharmsuppliers WHERE SU_NAME=".$sql->Param('a')." AND SU_INSTICODE = ".$sql->Param('b')."  "),array($supplier, $userCourier));
			print $sql->ErrorMsg();
		
		
		
		if($stmt->RecordCount()>0){
				$msg = "Failed, Supplier exists already.";
	    		$status = "error";
		}else {

			$newsupplier = strtoupper($supplier);
			$suppliercode = uniqid();
			
			$sql->Execute($sql->Prepare("INSERT INTO hms_pharmsuppliers (SU_CODE,SU_NAME, SU_CONTACT,SU_EMAIL,SU_ADDRESS,SU_LOCATION,SU_CONTACTPERSON,SU_CONPHONE, SU_CONEMAIL, SU_INSTICODE,SU_ACTORCODE) VALUES (".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').", ".$sql->Param('e').", ".$sql->Param('f').", ".$sql->Param('g').", ".$sql->Param('h').", ".$sql->Param('i').", ".$sql->Param('j').", ".$sql->Param('k').")"), array($suppliercode,$newsupplier,$contactno, $email,$address, $location,$contperson,$phonenumber,$peremail,$userCourier,$actorcode));
print $sql->ErrorMsg();
			
			
			
		$msg = "Supplier Created Successfully.";
	    $status = "success";
        $activity = "Supplier Created Successfully.";
		$engine->setEventLog("024",$activity);	
			
		}
	}
}
	
	
	break;
	
	case "updatesupplier":
	
			

		if(!empty($keys)){ 
		
			
			$newsupplier = strtoupper($supplier);
		
			
			$stmt = $sql->Execute($sql->Prepare("UPDATE hms_pharmsuppliers SET SU_NAME=".$sql->Param('a').", SU_CONTACT=".$sql->Param('c').", SU_EMAIL=".$sql->Param('d').", SU_ADDRESS=".$sql->Param('e').",SU_LOCATION=".$sql->Param('f').", SU_CONTACTPERSON=".$sql->Param('g').",SU_CONPHONE=".$sql->Param('g').",SU_CONEMAIL=".$sql->Param('g').",SU_STATUS=".$sql->Param('g')." WHERE SU_CODE=".$sql->Param('b')),array($newsupplier,$contactno, $email,$address, $location,$contperson,$phonenumber,$peremail,$supstatus,$keys));
		
		
        $msg = "Supplier Details Editted Successfully.";
	    $status = "success";
        $activity = "Supplier Details Editted Successfully.";
		$engine->setEventLog("025",$activity);	
	
		
		
		}
	break;
	
	
	
	
	
	
	case "reset":
	$fdsearch='';
	
	break;
	

	
}

if(!empty($fdsearch)){
	
	 $query = "SELECT SU_CODE,SU_NAME, SU_CONTACT,SU_EMAIL,SU_LOCATION,SU_CONTACTPERSON,SU_STATUS,SU_INSTICODE FROM hms_pharmsuppliers WHERE  SU_INSTICODE=".$sql->Param('a')." AND (SU_NAME LIKE ".$sql->Param('b')." OR SU_CONTACT LIKE ".$sql->Param('b')." ) "; $input = array($userCourier,'%'.$fdsearch.'%','%'.$fdsearch.'%');

}else {

    $query = "SELECT SU_CODE,SU_NAME, SU_CONTACT,SU_EMAIL,SU_LOCATION,SU_CONTACTPERSON,SU_STATUS,SU_INSTICODE FROM hms_pharmsuppliers WHERE  SU_INSTICODE=".$sql->Param('a')." "; $input = array($userCourier);
}
if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=27ce7f8b5623b2e2df568d64cf051607&option=1814d65a76028fdfbadab64a5a8076df&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);

//Get all positions
$stmtpos = $engine->getUserPosition();

?>