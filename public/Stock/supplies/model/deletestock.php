<?php
include("../../../../config.php");
include SPATH_LIBRARIES.DS."engine.Class.php";
$engine = new engineClass();
$actor_id = $session->get("actorid");
$actordetails = $engine->getActorDetails();
$facicode = $actordetails->USR_FACICODE;

if(isset($rowrecord) && !empty($rowrecord)){
	$sql->Execute("DELETE FROM  hms_ph_suppliesdetails WHERE  SUPDT_SUPCODE = ".$sql->Param('a')." AND SUPDT_ID = ".$sql->Param('b')." ",array($suppcode,$rowrecord));
print $sql->ErrorMsg();	
	}	

//Get Inserted records
$stmtsup = $sql->Execute($sql->Prepare("SELECT * FROM hms_ph_suppliesdetails WHERE SUPDT_SUPCODE = ".$sql->Param('a')." "),array($suppcode));
$i = 1;
while($objsup = $stmtsup->FetchNextObject()){
	echo '
	       <tr id="'.$objsup->SUPDT_ID.'">
           <td class="center">'.$i++.'</td>
           <td>'.$objsup->SUPDT_STOCKNAME.'</td>
           <td>'.$objsup->SUPDT_BATCHCODE.'</td>
           <td>'.$objsup->SUPDT_QUANTITY.'</td>
           <td>'.$objsup->SUPDT_UNITPRICE.'</td>
		   <td>'.date("d/m/Y",strtotime($objsup->SUPDT_EXPIRYDATE)).'</td>
		   <td>'.(($objsup->SUPDT_TYPE == 1)?'Store':'Shelf').'</td>
           <td class="hidden-xs">
           <button type="button" class="btn btn-gyn-danger square deleterow btn-danger" title="Delete">
            <i class="fa fa-trash-o "></i></button>
		   </td>
		   <input type="hidden" name="rowvalue" id="rowvalue" value="'.$objsup->SUPDT_ID.'">
		   
		   
         </tr>
	     ';
}
?>