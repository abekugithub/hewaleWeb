<?php
ob_start();
include "config.php";
include SPATH_LIBRARIES.DS."engine.Class.php";

$engine = new engineClass();

 if(isset($code)){
	$stmt = $sql->Execute($sql->Prepare("SELECT EXCD_VERIFICATIONCODE FROM hms_patient_excuseduty WHERE EXCD_VERIFICATIONCODE = ".$sql->Param('a')." "),array($code)); 
	print $sql->ErrorMsg();
	if($stmt->RecordCount() > 0){
		echo "<strong>HEWALE - SOCIAL HEALTH</strong> <br /><br /><div style='color:#3BB50A'>QR CODE VERIFIED</div><br /> THANK YOU.";
	}else{
		echo "<strong>HEWALE - SOCIAL HEALTH</strong> <br /><br /><div style='color:#ff0000'>QR CODE NOT VERIFIED</div><br /> THANK YOU.";
		}
  }
?>
