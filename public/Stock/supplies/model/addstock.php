<?php
include("../../../../config.php");
include SPATH_LIBRARIES.DS."engine.Class.php";
$engine = new engineClass();
$actor_id = $session->get("actorid");
$actordetails = $engine->getActorDetails();
$facicode = $actordetails->USR_FACICODE;

$stockarray = explode("&&",$stock);
$stockcode = $stockarray[0];
$stockname = $stockarray[1];

$enddate = $sql->BindDate($engine->getDateFormat($enddate));

//Insert into Supply Details Table
$sql->Execute("INSERT INTO hms_ph_suppliesdetails(SUPDT_SUPCODE,SUPDT_STOCKNAME,SUPDT_STOCKCODE,SUPDT_QUANTITY,SUPDT_UNITPRICE,SUPDT_BATCHCODE,SUPDT_EXPIRYDATE,SUPDT_TYPE) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('a').")",array($suppcode,$stockname,$stockcode,$qtity,$unitprice,$batchcode,$enddate,$stocktype));
print $sql->ErrorMsg();	


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