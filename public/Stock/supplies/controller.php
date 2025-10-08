<?php
$crypt = new cryptCls();
$actorid = $session->get("userid");
$actorname = $engine->getActorName();
$actorgroup = $engine->getUsergroup();

$actudate = date("Y-m-d H:m:s");
$objdtls = $engine->getFacilityDetails();
$facilityalias = $objdtls->FACI_ALIAS ;
$facicode = $objdtls->FACI_CODE ;
$actorcode = $engine->getActorCode();

switch($viewpage){
	case "savewaybill":
	$postkey = $session->get("postkey");
    if($postkey != $microtime){
	$session->set("postkey",$microtime);
	
	$supplierarray = explode("&&",$supplier);
    $suppliercode = $supplierarray[0];
    $suppliername = $supplierarray[1];
		
	$startdate = $sql->BindDate($engine->getDateFormat($startdate));	
	
    if(empty($suppcode)){
	if(!empty($supplier) && !empty($startdate) && !empty($waybill) ){
    //check uniqueness of waybill for the said supplier
	$stmtwa = $sql->Execute($sql->Prepare("SELECT * FROM hms_ph_supplies WHERE SUP_SUPPLIERCODE = ".$sql->Param('a')." AND SUP_WAYBILL = ".$sql->Param('b')." "),array($suppliercode,$waybill));
	print $sql->ErrorMsg();
	if($stmtwa && $stmtwa->RecordCount() > 0){
	    $msg = "Error: Duplicate entry for waybill.";
        $status = "error";
        $view ='add';
	}else{
	
     //Get Supply Code
     $suppcode = $engine->getSuppCode($facicode);
	  
	 $sql->Execute("INSERT INTO hms_ph_supplies(SUP_FACICODE,SUP_CODE,SUP_SUPPLIERNAME,SUP_SUPPLIERCODE,SUP_DATE,SUP_WAYBILL,SUP_ACTORCODE,SUP_ACTORNAME) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').")",array($facicode,$suppcode,$suppliername,$suppliercode,$startdate,$waybill,$actorcode,$actorname));
print $sql->ErrorMsg();
	}
		}else{
			    $msg = "Required field(s) cannot be left blank.";
                $status = "error";
                $view ='add';
			  }
     }else{
		     //Update main suppli info
			 $sql->Execute("UPDATE hms_ph_supplies SET SUP_SUPPLIERNAME = ".$sql->Param('a').",SUP_SUPPLIERCODE = ".$sql->Param('b').",SUP_DATE = ".$sql->Param('c').", SUP_WAYBILL = ".$sql->Param('d')." WHERE SUP_CODE = ".$sql->Param('e')." ",array($suppliername,$suppliercode,$startdate,$waybill,$suppcode));
			 
			 //Fetch supplies details if there is any
			 $stmtsup = $sql->Execute($sql->Prepare("SELECT * FROM hms_ph_suppliesdetails WHERE SUPDT_SUPCODE = ".$sql->Param('a')." "),array($suppcode));
			 print $sql->ErrorMsg();
			 
			 // Save Activity	 
			$activity = 'Supply updated . Supply code: '.$suppcode.' Supplier name: '.$suppliername.' Supplier Code: '.$suppliercode.' Supply Date : '.$startdate;
			print $sql->ErrorMsg();
             $engine->setEventLog('043',$activity);
		  }
	}
	break;
	
	
	case "addprior":
	if(!empty($suppcode)){
	$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_ph_supplies WHERE SUP_CODE = ".$sql->Param('a')." "),array($suppcode));
	print $sql->ErrorMsg();
	
	if($stmt->RecordCount() == 1){
		$obj = $stmt->FetchNextObject();
		$supplier = $obj->SUP_SUPPLIERCODE.'&&'.$obj->SUP_SUPPLIERNAME;
		$startdate = $obj->SUP_DATE;
		$waybill = $obj->SUP_WAYBILL;
		}
	}
	break;
	
	case "fetchstock":
	if(!empty($suppcode)){
	$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_ph_supplies WHERE SUP_CODE = ".$sql->Param('a')." "),array($suppcode));
	print $sql->ErrorMsg();
	
	if($stmt->RecordCount() == 1){
		$obj = $stmt->FetchNextObject();
		$supplier = $obj->SUP_SUPPLIERCODE.'&&'.$obj->SUP_SUPPLIERNAME;
		$startdate = $obj->SUP_DATE;
		$waybill = $obj->SUP_WAYBILL;
		}
		
	         //Fetch supplies details if there is any
			 $stmtsup = $sql->Execute($sql->Prepare("SELECT * FROM hms_ph_suppliesdetails WHERE SUPDT_SUPCODE = ".$sql->Param('a')." "),array($suppcode));
			 print $sql->ErrorMsg();
			 
	}
	break;
	
	case "savesupply":
	 //Update status as done
	 $sql->Execute("UPDATE hms_ph_supplies SET SUP_STATUS = '1' WHERE SUP_CODE = ".$sql->Param('a')." ",array($suppcode));
	 print $sql->ErrorMsg();
	 //Update hms_pharmacystocks
	$stmtsup = $sql->Execute($sql->Prepare("SELECT * FROM hms_ph_suppliesdetails JOIN hms_ph_supplies ON SUPDT_SUPCODE = SUP_CODE  WHERE SUPDT_SUPCODE = ".$sql->Param('a')." "),array($suppcode));
	print $sql->ErrorMsg();
	$objsup = $stmtsup->FetchNextObject();
	$suppliername = $objsup->SUP_SUPPLIERNAME;
	$suppliercode = $objsup->SUP_SUPPLIERCODE;
	$waybill = $objsup->SUP_WAYBILL;
	$capturedate = $objsup->SUP_DATE;
	
	do{
		if($objsup->SUPDT_TYPE == 1){
			//Update stock in store
		    $sql->Execute("UPDATE hms_pharmacystock SET ST_STORE_QTY = ST_STORE_QTY + ".$sql->Param('a')." WHERE ST_CODE = ".$sql->Param('a')." ",array($objsup->SUPDT_QUANTITY,$objsup->SUPDT_STOCKCODE));
			print $sql->ErrorMsg();
			
			// Save Activity	 
			$activity = 'Stock update with new supply. The details are: Supply code: '.$objsup->SUPDT_SUPCODE.' Stock Type: Store   Quantity added : '.$objsup->SUPDT_QUANTITY;
			print $sql->ErrorMsg();
             $engine->setEventLog('027',$activity);
			 
	    }else{
			//Update stock in shelf
			 $sql->Execute("UPDATE hms_pharmacystock SET ST_SHEL_QTY = ST_SHEL_QTY + ".$sql->Param('a')." WHERE ST_CODE = ".$sql->Param('a')." ",array($objsup->SUPDT_QUANTITY,$objsup->SUPDT_STOCKCODE));
			 print $sql->ErrorMsg();
			 
			 // Save Activity	 
			$activity = 'Stock update with new supply. The details are: Supply code: '.$objsup->SUPDT_SUPCODE.' Stock Type: Shelf  Quantity added : '.$objsup->SUPDT_QUANTITY;
             $engine->setEventLog('027',$activity);
			 
			 }
			 
			 //Update total quantity in stock
			  $sql->Execute("UPDATE hms_pharmacystock SET ST_QTY = ST_QTY + ".$sql->Param('a')." WHERE ST_CODE = ".$sql->Param('a')." ",array($objsup->SUPDT_QUANTITY,$objsup->SUPDT_STOCKCODE));
			 print $sql->ErrorMsg();
			 
	}while($objsup = $stmtsup->FetchNextObject());
	
			// Save Activity	 
			$activity = 'Supplies added. The details are: Supplier Name '.$suppliername.' Supplier Code '.$suppliercode.' Waybill : '.$waybill.' Captured Date : '.$capturedate;
             $engine->setEventLog('026',$activity);
			 
		     $msg = "Success: Supply captured successfully.";
	         $status = "success";
	         $view =''; 
	break;
	
	case "fetchallsupply":
	if(!empty($keys)){
		
	}
	break;
	
	case "getsuppcode":
	  $suppcode = '';
	break;
	case "reset":
	   $fdsearch = $action_search = "";
	break;
}

if(isset($action_search) && $action_search == "search"){
	if(!empty($fdsearch)){
    $query = "SELECT * FROM hms_ph_supplies WHERE SUP_FACICODE = ".$sql->Param('a')." AND ( SUP_WAYBILL = ".$sql->Param('b')." OR SUP_SUPPLIERNAME LIKE ".$sql->Param('c')." )";
    $input = array($activeinstitution,$fdsearch,$fdsearch.'%');
	}
}else {

    $query = "SELECT * FROM hms_ph_supplies WHERE SUP_FACICODE = ".$sql->Param('a')." ";
    $input = array($activeinstitution);
}
if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=27ce7f8b5623b2e2df568d64cf051607&option=76ad3bde62e444c0ee091a4c446d3c68&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);

//Get all positions
$stmtpos2 = $engine->getUserPosition();

//Get all Suppliers
$stmtsupp = $engine->getSuppliers($facicode);

//Get all stocks
$stmtstock = $engine->getPharmStock($facicode);

include("model/js.php");
?>