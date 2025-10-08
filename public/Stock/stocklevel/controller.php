<?php

$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$actorid = $session->get("userid");


$objdtls = $engine->getFacilityDetails();
$facilityalias = $objdtls->FACI_ALIAS ;
$faccode = $objdtls->FACI_CODE ;
switch($viewpage)
{
		case "saveitem":
		 
$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_pharmacystock WHERE ST_CODE =".$sql->Param('a')." "),array($itemcode));
print $sql->ErrorMsg();
if($stmt->RecordCount()== 1){
	$obj= $stmt->FetchNextObject();
	$quantity = $obj->ST_STORE_QTY;
//	echo $quantity; die();
	if ($qtymove <=$quantity){
$sql->Execute("UPDATE hms_pharmacystock SET ST_SHEL_QTY = ST_SHEL_QTY + ".$sql->Param('a').",ST_STORE_QTY = ST_STORE_QTY - ".$sql->Param('a')." WHERE ST_CODE = ".$sql->Param('a')." ",array($qtymove,$qtymove,$itemcode));
			print $sql->ErrorMsg();
			
			// Save Activity	 
			$activity = 'Stock update with new supply. The details are: Supply code: '.$objsup->SUPDT_SUPCODE.' Stock Type: Store   Quantity added : '.$objsup->SUPDT_QUANTITY;
			print $sql->ErrorMsg();
             $engine->setEventLog('027',$activity);
            	$msg = " Shelf Stock has been update.";
				$status = "success";
				$view =''; 
						
				// userlog event
				$activity= "STOCK ITEM SETTING UP: ".$items.", QUANTITY: ".$qty."  ";
                $engine->setEventLog("051",$activity);
                
                $drug=$keys=$dose=$type=$typ=$s=$p=$rqty=$qty=$sunit=$nhiscode=$price=$level=$datestock= '';
				
				} else{
					$msg="Quantiy intended to move is greater than existing quantity, please try again.";
					$status="error";
					$view="edit";
				} 
			}
		
	
break;
		
		case "edititem":
	 if(isset($keys) && $keys != ''){
		$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_pharmacystock WHERE ST_CODE = ".$sql->Param('a')." "),array($keys)); 
		print $sql->ErrorMsg();
		if($stmt->RecordCount() == 1){
			$obj = $stmt->FetchNextObject();
			$item = $obj->ST_CODE;
			$itemname=$obj->ST_NAME;
			$dosage = $obj->ST_DOSAGE;
			$level = $obj->ST_REORDER_LEVEL;
			$price = $obj->ST_PRICE;
			$qty = $obj->ST_STORE_QTY;
			$qty1 = $obj->ST_SHEL_QTY;
			$enddate = $obj->ST_DATE;
			
	    }
		 
	}
	break;
		
		case "savedititem":
		if(!empty($fname))
		{
			 $sql->Execute("UPDATE hms_users SET USR_SURNAME = ".$sql->Param('a')." ,USR_OTHERNAME = ".$sql->Param('b')." ,USR_EMAIL = ".$sql->Param('c').",USR_PHONENO = ".$sql->Param('d').",USR_EMERGENCYCONTACT = ".$sql->Param('a')." ,USR_ADDRESS = ".$sql->Param('a')." ,USR_LEVEL_FACLVID = ".$sql->Param('a')." ,USR_HOSPOSITION = ".$sql->Param('a')." ,USR_STATUS = ".$sql->Param('a')." ,USR_PHONENO2 = ".$sql->Param('a')." WHERE USR_USERID = ".$sql->Param('a')." ",array($fname,$othername,$email,$phoneno,$emcontact,$address,$userlevel,$usrposition,$usrstatus,$altphone,$keys));
	print $sql->ErrorMsg();
	
			
		}
		
		break;
		
	
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	
}

if(!empty($fdsearch)){
 $query = "SELECT * FROM hms_pharmacystock WHERE ST_FACICODE = ".$sql->Param('a')."  AND (ST_STATUS = ".$sql->Param('b')." OR ST_STATUS = ".$sql->Param('b').") AND (ST_NAME LIKE ".$sql->Param('c')." OR ST_DOSAGE LIKE ".$sql->Param('c').") ";
    $input = array($faccode,'1','2','%'.$fdsearch.'%','%'.$fdsearch.'%');
}else {

    $query = "SELECT * FROM hms_pharmacystock WHERE ST_FACICODE = ".$sql->Param('a')."  AND (ST_STATUS = ".$sql->Param('b')." OR ST_STATUS = ".$sql->Param('b').")";
    $input = array($faccode,'1','2');
}
if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=27ce7f8b5623b2e2df568d64cf051607&option=a8eeadce8f6beba98cf36604423f8ca7&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);


//Get all positions
$stmtpos = $engine->getUserPosition();
$stmtstockitem = $sql->Execute($sql->Prepare("SELECT * from hms_ph_drugs ORDER BY ST_NAME ASC"));


?>