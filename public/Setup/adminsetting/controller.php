<?php
//print_r($_POST);
$crypt = new cryptCls();
$actorid = $session->get("userid");
$startdate = date("Y-m-d H:m:s");
$objdtls = $engine->getFacilityDetails();
$faccode = $objdtls->FACI_CODE ;

switch ($viewpage){
	
	case "savesetting":
	
		if(empty($description) && empty($paystatus)){
			
			$msg = " Failed. Required field(s) can't be empty!.";
			$status = "error";
			$target ='';
	}elseif(empty($keys)){
		$pscode = uniqid();
		$stmt=$sql->Execute($sql->Prepare("Insert into hms_admin_setting(PS_CODE,PS_DESCRIPTION,PS_VALUE,PS_FACI_CODE)Values(".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').")"),array($pscode,$description,$paystatus,$faccode ));
		print $sql->Errormsg();
		$msg = 'Your payment setting has been added successfully';
       $status = 'success';
	    $target = '';
	    $activity = "Hospital payment setting captured Successfully.";
	 $engine->setEventLog("099",$activity);
		}else{			
			$stmt = $sql->Execute($sql->Prepare("UPDATE hms_admin_setting SET PS_DESCRIPTION =".$sql->Param('1').", PS_VALUE =".$sql->Param('0')." WHERE PS_CODE=".$sql->Param('3')." "),array($description,$paystatus,$keys));
		$msg = 'Your payment setting has been Changed successfully';
       $status = 'success';
	    $target = '';
	    $activity = "Hospital payment setting captured Successfully.";
	 $engine->setEventLog("099",$activity);
			}
	
	break;
		
}


$stmt = $sql->execute($sql->Prepare("SELECT * FROM hms_admin_setting WHERE PS_FACI_CODE = ".$sql->Param('1').""),array($faccode));
print $sql->Errormsg();
	
$obj = $stmt->FetchNextObject();
$keys=$obj->PS_CODE;
$description=$obj->PS_DESCRIPTION;
$paystatus=$obj->PS_VALUE;


?>