<?php
include("../../../../config.php");
include SPATH_LIBRARIES.DS."engine.Class.php";
$engine = new engineClass();
$actor_id = $session->get("actorid");
$actordetails = $engine->getActorDetails();
$facicode = $actordetails->USR_FACICODE;

$wrong = true;
if(isset($rowrecord) && !empty($rowrecord)){
	//Get supplies details
	$objdetails = $engine->getStockSupplyDetails($rowrecord);
	$stockqtity = $objdetails->SUPDT_QUANTITY;
	$stockcode = $objdetails->SUPDT_STOCKCODE;
	$stocktype = $objdetails->SUPDT_TYPE;
	
	//Get current stock from stocklevel
	$objstockdetails = $engine->getStockDetails($stockcode,$facicode);
	$storeqtity = $objstockdetails->ST_STORE_QTY;
	$shelfqtity = $objstockdetails->ST_SHEL_QTY;
	$totalqtity = $objstockdetails->ST_QTY;
	
	if($stocktype == 1 && $stockqtity >= $storeqtity){
		$remainstock = $stockqtity - $storeqtity;
		$totalqtity = abs($totalqtity - $stockqtity);
		$sql->Execute("UPDATE hms_pharmacystock SET ST_STORE_QTY = ".$sql->Param('a').", ST_QTY = ".$sql->Param('b')."  WHERE  ST_CODE = ".$sql->Param('a')." AND ST_FACICODE = ".$sql->Param('b')." ",array($storeqtity,$totalqtity,$stockcode,$facicode));
		
		$wrong = false;
	}else{
		    $wrong = true;
		
		 }
		 
	
    if($stocktype == 2 && $stockqtity >= $shelfqtity){
		$remainstock = $shelfqtity - $storeqtity;
		$totalqtity = abs($totalqtity - $stockqtity);
		$sql->Execute("UPDATE hms_pharmacystock SET ST_SHEL_QTY = ".$sql->Param('a').", ST_QTY = ".$sql->Param('b')."  WHERE ST_CODE = ".$sql->Param('a')." AND ST_FACICODE = ".$sql->Param('b')." ",array($storeqtity,$totalqtity,$stockcode,$facicode));
		$wrong = false;
	}else{
		    $wrong = true;
		
		 }
	if($wrong == false){
	$sql->Execute("DELETE FROM hms_ph_suppliesdetails WHERE SUPDT_SUPCODE = ".$sql->Param('a')." AND SUPDT_ID = ".$sql->Param('b')." ",array($suppcode,$rowrecord));
print $sql->ErrorMsg();
	  }
	}	

//Get Inserted records
$stmtsup = $sql->Execute($sql->Prepare("SELECT * FROM hms_ph_suppliesdetails WHERE SUPDT_SUPCODE = ".$sql->Param('a')." "),array($suppcode));
$i = 1;

if($wrong == true){
	$output1 = "1";
}
while($objsup = $stmtsup->FetchNextObject()){
	
	$objstockdetails = $engine->getStockDetails($objsup->SUPDT_STOCKCODE,$facicode);
	
	$output2[] = '
	       <tr id="'.$objsup->SUPDT_ID.'">
           <td class="center">'.$i++.'</td>
           <td>'.$objsup->SUPDT_STOCKNAME.'</td>
           <td>'.$objsup->SUPDT_BATCHCODE.'</td>
           <td>'.$objsup->SUPDT_QUANTITY.'</td>
           <td>'.$objsup->SUPDT_UNITPRICE.'</td>
		   <td>'.date("d/m/Y",strtotime($objsup->SUPDT_EXPIRYDATE)).'</td>
		   <td>'.(($objsup->SUPDT_TYPE == 1)?'Store':'Shelf').'</td>
           <td class="hidden-xs">
		   '.(($objstockdetails->SUPDT_ID == '')?'<button type="button" class="btn btn-danger deleterow" ><i class="fa fa-chevron-left"></i> Delete Stock</button>':' <button type="button" class="btn btn-danger recallrow" ><i class="fa fa-chevron-left"></i> Recall Stock</button>').'
		  
     
		   </td>
		   <input type="hidden" name="rowvalue" id="rowvalue" value="'.$objsup->SUPDT_ID.'">
		   
		   
         </tr>
	     ';
}
 $output = array('data1'=>$output1,'data2'=>$output2);
 //print_r($output);
 echo json_encode($output);
?>