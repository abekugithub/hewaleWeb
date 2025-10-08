<?php
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$actorid = $session->get("userid");


$objdtls = $engine->getFacilityDetails();
$facilityalias = $objdtls->FACI_ALIAS ;
$faccode = $objdtls->FACI_CODE ;
switch($viewpage)
{
	
    
    
    
    case "savestockitem":
	   
       if(empty($stockitem) || empty($paymentmethod) || empty($amt)) {

			$msg = "Failed. Required field(s) can't be empty!.";
			$status = "error";
			$view ='add';
		
		}else{
		  

			 $paymentmethod=(!empty($paymentmethod)?explode('|',$paymentmethod):'');
		if (!empty($stockitem)){
             $stockitem=explode('|',$stockitem);
			 }else{
			 	$stockitem='';
			 }
						//echo $stockitem[0].'--'.$paymentmethod[0];die();
			 $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_pharmacyprice WHERE PPR_DRUGCODE =".$sql->Param('a')." and PPR_METHODCODE =".$sql->Param('a')." "),array($stockitem[0],$paymentmethod[0]));
			print $sql->ErrorMsg();
				
			if($stmt->RecordCount()>0){
				
                $msg = "Failed, Stock Item $stockitem[1] Price already exist for payment method $paymentmethod[1]!";
				$status = "error";
				$view ='add';
				
			}else{
			 $pharmacypricecode=$engine->getpharmacypricecode();
			 
			// $paymentmethod=(!empty($paymentmethod)?explode('|',$paymentmethod):'');
			// print_r($paymentmethod); die();
             $stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_pharmacyprice (PPR_CODE,PPR_FACICODE,PPR_METHOD,PPR_METHODCODE,PPR_CATEGORYCODE,PPR_DRUG,PPR_DRUGCODE,PPR_PRICE,PPR_NHIS) VALUES(".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5')." ,".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').")"),array($pharmacypricecode,$faccode,$paymentmethod[1],$paymentmethod[0],$paymentmethod[2],$stockitem[1],$stockitem[0],$amt,$topup));
			 print $sql->ErrorMsg();
			
            	$msg = " Stock Item Price has been set successfully.";
				$status = "success";
				$view =''; 
						
				// userlog event
				$activity= "Stock item price setting: ".$stockitem."  ";
                $engine->setEventLog("051",$activity);
                
                
                }
                }
					
		
	
break;
		
		case "edititem":
	 if(isset($keys) && $keys != ''){
		$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_pharmacystock LEFT JOIN hms_pharmacyprice ON ST_CODE=PPR_DRUGCODE WHERE ST_CODE = ".$sql->Param('a')." "),array($keys)); 
		print $sql->ErrorMsg();
		if($stmt->RecordCount() == 1){
			$obj = $stmt->FetchNextObject();
			$item = $obj->ST_CODE;
			$itemname= $obj->ST_NAME;
			$dosage = $obj->ST_DOSAGE;
			$level = $obj->ST_REORDER_LEVEL;
			$amt = $obj->PPR_PRICE;
			$topup = $obj->PPR_NHIS;
			$qty = $obj->ST_STORE_QTY;
			$qty1 = $obj->ST_SHEL_QTY;
			$enddate = $obj->ST_DATE;
			$pricecode = $obj->PPR_CODE;
			$paymentcat=$obj->PPR_CATEGORYCODE;
			
	    }
		 
	}
	break;
		
		case "savedititem":
		
			$sql->Execute("UPDATE hms_pharmacyprice SET PPR_PRICE=".$sql->Param('c').",PPR_NHIS=".$sql->Param('b')." WHERE PPR_CODE = ".$sql->Param('c')."",array($amt,$topup,$pricecode));
			$msg = " Price has been updated successfully.";
			$status = "success";
			$view ='';
			 //$sql->Execute("UPDATE hms_users SET USR_SURNAME = ".$sql->Param('a')." ,USR_OTHERNAME = ".$sql->Param('b')." ,USR_EMAIL = ".$sql->Param('c').",USR_PHONENO = ".$sql->Param('d').",USR_EMERGENCYCONTACT = ".$sql->Param('a')." ,USR_ADDRESS = ".$sql->Param('a')." ,USR_LEVEL_FACLVID = ".$sql->Param('a')." ,USR_HOSPOSITION = ".$sql->Param('a')." ,USR_STATUS = ".$sql->Param('a')." ,USR_PHONENO2 = ".$sql->Param('a')." WHERE USR_USERID = ".$sql->Param('a')." ",array($fname,$othername,$email,$phoneno,$emcontact,$address,$userlevel,$usrposition,$usrstatus,$altphone,$keys));
	print $sql->ErrorMsg();
		
		break;
		
	
		
		
		
		
		
		
		
		
		
		
		

		
		
		
	
}

if(!empty($fdsearch)){
 $query = "SELECT * from hms_pharmacystock LEFT JOIN hms_pharmacyprice ON ST_CODE=PPR_DRUGCODE WHERE ST_FACICODE = ".$sql->Param('a')."  AND (ST_STATUS = ".$sql->Param('b')." OR ST_STATUS = ".$sql->Param('c').") AND (ST_NAME LIKE ".$sql->Param('c')." OR ST_DOSAGE LIKE ".$sql->Param('c').") ";
    $input = array($faccode,'1','2','%'.$fdsearch.'%','%'.$fdsearch.'%');
}else {

    $query = "SELECT * from hms_pharmacystock LEFT JOIN hms_pharmacyprice ON ST_CODE=PPR_DRUGCODE WHERE ST_FACICODE = ".$sql->Param('a')."  AND (ST_STATUS = ".$sql->Param('b')."  OR ST_STATUS = ".$sql->Param('c').")";
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
$stmtstockitem = $sql->Execute($sql->Prepare("SELECT * from hms_pharmacystock where ST_FACICODE = '$faccode' "));
$stmtpaymeth = $sql->Execute($sql->Prepare("SELECT * from hms_facilities_payment where PINS_FACICODE = '$faccode' "));


?>