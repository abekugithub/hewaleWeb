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
	
	case "editward":
	
		if(empty($ward) || empty($gender) ){
		
			$msg = "Failed. Required field(s) can't be empty!.";
			$status = "error";
			$view ='edit';
			
		
		}else{
		
		
			$stmt = $sql->Execute($sql->Prepare("SELECT * from hms_st_ward WHERE WARD_NAME = ".$sql->Param('1')."  and WARD_FACICODE = ".$sql->Param('2').""),array($ward,$faccode));
			print $sql->ErrorMsg();
	
			if($stmt->RecordCount() > 0){
		
				$msg = "Failed. Ward exist Already";
				$status = "error";
				$view ='edit';
				
			}else{
			
				$stmt = $sql->Execute($sql->Prepare("UPDATE hms_st_ward SET WARD_NAME = ".$sql->Param('1').", WARD_GENDER = ".$sql->Param('2')."  WHERE WARD_CODE = ".$sql->Param('3')." "), array($ward,$gender,$keys));	
				print $sql->ErrorMsg();
		
				$msg = "Success:Changes applied successfully";
				$status = "success";
				$view ='';
		
			}
		}
	
	break;
	
	
	case "edit":
	 if(isset($keys) && $keys != ''){
		$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_st_ward WHERE WARD_CODE = ".$sql->Param('a')." "),array($keys)); 
		print $sql->ErrorMsg();
		if($stmt->RecordCount() == 1){
			$obj = $stmt->FetchNextObject();
			$ward = $obj->WARD_NAME;
			$gend = $obj->WARD_GENDER;
			
			$keys = $obj->WARD_CODE;
	    }
		 
	}
	break;
	
	
	// 15 MAR 2018, JOSEPH ADORBOE , SAVE WARD 
	case "saveward":
	
		if(empty($ward) || empty($gender) ){
	
			$msg = "Failed. Required field(s) can't be empty!.";
			$status = "error";
			$view ='add';
		
		}else{
	
			$stmt = $sql->Execute($sql->Prepare("SELECT * from hms_st_ward WHERE WARD_NAME = ".$sql->Param('1')." and WARD_FACICODE = ".$sql->Param('2').""),array($ward,$faccode));
			print $sql->ErrorMsg();
	
				if($stmt->RecordCount() > 0){
		
					$msg = "Failed. Ward exist Already";
					$status = "error";
					$view ='add';
		
		
				}else{
		
					$wardcode = $coder->getwardscode();
					$sql->Execute("INSERT INTO hms_st_ward(WARD_CODE,WARD_NAME,WARD_GENDER,WARD_FACICODE,WARD_USERCODE,WARD_USER) VALUES(".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('5').")",array($wardcode,$ward,$gender,$activeinstitution,$actorid,$actorname));
					print $sql->ErrorMsg();
		
					$msg = "Success:Saved successfully";
					$status = "success";
					$view ='add';
					
					$ward=$gender='';
			
		
				}

	
			}
	
	
	break;
	
	
	
	case "reset":
	   $fdsearch = $action_search = "";
	break;
}

$stmtpayschemelov = $sql->Execute($sql->prepare("SELECT * from hmsb_st_paymentmethod WHERE PAYM_FACICODE = '$activeinstitution'"));
$stmtservicelov = $sql->Execute($sql->prepare("SELECT * from hmsb_st_labtest WHERE SERV_BILLABLE = '1'"));
		
// if(isset($action_search) && $action_search == "search"){
	if(!empty($fdsearch)){
		//  (  
		
    $query = "SELECT * FROM hms_st_ward WHERE  WARD_FACICODE = ".$sql->Param('1')." and WARD_NAME  LIKE ".$sql->Param('2')." OR WARD_GENDER  LIKE ".$sql->Param('3')." ";
    $input = array($activeinstitution,'%'.$fdsearch.'%','%'.$fdsearch.'%');
	
//	}
}else{

    $query = "SELECT * FROM hms_st_ward WHERE WARD_FACICODE = ".$sql->Param('1')." ";
    $input = array($activeinstitution);
}


if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=ad2376beebecdcf7846ba973fa1a005b&option=6831b98f85019ddb98bd98d44bdbac40#',$input);

//Get all positions
$stmtpos2 = $engine->getUserPosition();
?>