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
	
	case "editbed":
	
		if(empty($ward) || empty($bed) ){
		
			$msg = "Failed. Required field(s) can't be empty!.";
			$status = "error";
			$view ='edit';
			
		
		}else{
		
		
			$stmt = $sql->Execute($sql->Prepare("SELECT * from hms_st_wardbed WHERE BED_NAME = ".$sql->Param('1')."  and BED_FACICODE = ".$sql->Param('2').""),array($bed,$faccode));
			print $sql->ErrorMsg();
	
			if($stmt->RecordCount() > 0){
		
				$msg = "Failed. Bed exist Already";
				$status = "error";
				$view ='edit';
				
			}else{
				
				$wardbed = explode('@@@', $ward);
				$wardid = $wardbed[0];
				$wardname = $wardbed[1];
				$wardgender = $wardbed[2];
				
			
				$stmt = $sql->Execute($sql->Prepare("UPDATE hms_st_wardbed SET BED_NAME = ".$sql->Param('1').", BED_WARDID = ".$sql->Param('2')." , BED_WARDNAME = ".$sql->Param('3')." , BED_GENDERNAME = ".$sql->Param('2')."  WHERE BED_CODE = ".$sql->Param('3')." "), array($bed,$wardid,$wardname,$wardgender,$keys));	
				print $sql->ErrorMsg();
		
				$msg = "Success:Changes applied successfully";
				$status = "success";
				$view ='';
		
			}
		}
	
	break;
	
	
	case "edit":
	 if(isset($keys) && $keys != ''){
		$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_st_wardbed WHERE BED_CODE = ".$sql->Param('a')." "),array($keys)); 
		print $sql->ErrorMsg();
		if($stmt->RecordCount() == 1){
			$obj = $stmt->FetchNextObject();
			$bed = $obj->BED_NAME;
			$ward = $obj->BED_WARDID;
			
			$keys = $obj->BED_CODE;
	    }
		 
	}
	break;
	
	
	// 15 MAR 2018, JOSEPH ADORBOE , SAVE WARD 
	case "savebed":
	
		if(empty($ward) || empty($bed) ){
	
			$msg = "Failed. Required field(s) can't be empty!.";
			$status = "error";
			$view ='add';
		
		}else{
	
			$stmt = $sql->Execute($sql->Prepare("SELECT * from hms_st_wardbed WHERE BED_NAME = ".$sql->Param('1')." and BED_FACICODE = ".$sql->Param('2').""),array($bed,$faccode));
			print $sql->ErrorMsg();
	
				if($stmt->RecordCount() > 0){
		
					$msg = "Failed. Bed exist Already";
					$status = "error";
					$view ='add';
		
		
				}else{
					
					$wardbed = explode('@@@', $ward);
					$wardid = $wardbed[0];
					$wardname = $wardbed[1];
					$wardgender = $wardbed[2];
					
					$bedcode = $coder->getbedscode();
					$sql->Execute("INSERT INTO hms_st_wardbed(BED_CODE,BED_NAME,BED_WARDID,BED_WARDNAME,BED_GENDERNAME,BED_USERCODE,BED_USER,BED_FACICODE) VALUES(".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').")",
					array($bedcode,$bed,$wardid,$wardname,$wardgender,$actorid,$actorname,$activeinstitution));
					print $sql->ErrorMsg();
					
					
					$stmt = $sql->Execute($sql->Prepare("UPDATE hms_st_ward set WARD_CAPACITY = WARD_CAPACITY + ".$sql->Param('1')." , WARD_EMPTY = WARD_EMPTY + ".$sql->Param('1')."  WHERE  WARD_CODE = ".$sql->Param('2')." "), array('1','1',$wardid));
					print $sql->ErrorMsg();
		
					$msg = "Success: Saved successfully";
					$status = "success";
					$view ='add';
					
					$ward=$bed='';
			
		
				}

	
			}
	
	
	break;
	
	
	
	case "reset":
	   $fdsearch = $action_search = "";
	break;
}

$stmtwardlov = $sql->Execute($sql->prepare("SELECT * from hms_st_ward WHERE WARD_FACICODE = '$activeinstitution'"));
$stmtservicelov = $sql->Execute($sql->prepare("SELECT * from hmsb_st_labtest WHERE SERV_BILLABLE = '1'"));
		
// if(isset($action_search) && $action_search == "search"){
	if(!empty($fdsearch)){
		// WARD_FACICODE = ".$sql->Param('1')." and (  
		
    $query = "SELECT * FROM hms_st_wardbed WHERE  BED_FACICODE = ".$sql->Param('1')." and BED_NAME  LIKE ".$sql->Param('1')." OR BED_GENDERNAME  LIKE ".$sql->Param('2')." ";
    $input = array($activeinstitution,'%'.$fdsearch.'%','%'.$fdsearch.'%');
	
//	}
}else{

    $query = "SELECT * FROM hms_st_wardbed WHERE BED_FACICODE = ".$sql->Param('1')." ";
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