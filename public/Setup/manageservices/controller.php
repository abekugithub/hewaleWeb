<?php
//print_r($_POST);
$crypt = new cryptCls();
$actorid = $session->get("userid");
$actorname = $engine->getActorName();
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$objdtls = $engine->getFacilityDetails();
$facilityalias = $objdtls->FACI_ALIAS ;
$faccode = $engine->getActorDetails()->USR_FACICODE;

switch($viewpage){
	case "saveservice":
	$duplicatekeeper = $session->get("post_key");
	if($microtime != $duplicatekeeper){
		$session->set("post_key",$microtime);
		if (!empty($service)){
		    $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hmsb_hospital_services WHERE HOSPSERV_SERVCODE=".$sql->Param('a')." AND HOSPSERV_HOSCODE=".$sql->Param('b')." AND HOSPSERV_STATUS='1'"),array($service,$faccode));
		    print $sql->ErrorMsg();
		    if ($stmt->RecordCount()>0){
		        $msg = "This Service already exists";
		        $status = 'error';
            }else{
		        $stmt = $sql->Execute($sql->Prepare("INSERT INTO hmsb_hospital_services (HOSPSERV_HOSCODE, HOSPSERV_SERVCODE,HOSPSERV_STATUS) VALUES (".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').")"),array($faccode,$service,'1'));
		        print $sql->ErrorMsg();
		        if ($stmt){
		            $msg = "You have successfully added a new service to your list of services";
		            $status = 'success';
                }
            }
        }
	}
	break;
	
	case "editservice":
	 if(isset($keys) && !empty($keys)){
		$stmt = $sql->Execute($sql->Prepare("SELECT HOSPSERV_SERVCODE,HOSPSERV_HOSCODE,HOSPSERV_STATUS FROM hmsb_hospital_services WHERE HOSPSERV_ID = ".$sql->Param('a')." "),array($keys));
		print $sql->ErrorMsg();
		if($stmt->RecordCount() == 1){
			$obj = $stmt->FetchNextObject();
			$service = $obj->HOSPSERV_SERVCODE;
			$usrstatus = $obj->HOSPSERV_STATUS;
	    }
		 
	}
	break;
	
	case "deleteservice":
        if(isset($keys) && !empty($keys)){
            $stmt = $sql->Execute($sql->Prepare("SELECT HOSPSERV_SERVCODE,HOSPSERV_HOSCODE,HOSPSERV_STATUS FROM hmsb_hospital_services WHERE HOSPSERV_ID = ".$sql->Param('a')." "),array($keys));
            print $sql->ErrorMsg();
            if($stmt->RecordCount() == 1){
                $stmt = $sql->Execute($sql->Prepare("UPDATE hmsb_hospital_services SET HOSPSERV_STATUS = '0' WHERE HOSPSERV_ID=".$sql->Param('a')));
                print $sql->ErrorMsg();
                if ($stmt){
                    $msg = "Service successfully deleted";
                    $status = "success";
                }
            }
        }
	break;
	
	case "reset":
	   $fdsearch = $action_search = "";
	break;
}

$stmtservices = $sql->Execute($sql->Prepare("SELECT SERV_CODE,SERV_NAME FROM hmsb_services WHERE SERV_STATUS = '1'"));

if(isset($action_search) && $action_search == "search"){
	if(!empty($fdsearch)){
    $query = "SELECT * FROM hmsb_hospital_services JOIN hmsb_services ON SERV_CODE = HOSPSERV_HOSCODE WHERE HOSPSERV_STATUS = '1' AND HOSPSERV_HOSCODE=".$sql->Param('a')."";
    $input = array($activeinstitution,$fdsearch.'%',$fdsearch.'%');
	}
}else {

    $query = "SELECT * FROM hmsb_hospital_services WHERE HOSPSERV_STATUS = '1' AND HOSPSERV_HOSCODE=".$sql->Param('a')."";
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