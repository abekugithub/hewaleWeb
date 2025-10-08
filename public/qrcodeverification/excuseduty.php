<?php
	$stmt = $sql->Execute($sql->Prepare("SELECT EXCD_VERIFICATIONCODE FROM hms_patient_excuseduty WHERE EXCD_VERIFICATIONCODE = ".$sql->Param('a')." "),array($code)); 
	print $sql->ErrorMsg();
?>
