<?php 
include('../../../../config.php');
if(isset($_POST["id"])){
$postto=explode('@@@',implode(',',$_POST["id"]));
$datapost1 =(str_replace(',','',$postto));
$datapost =(str_replace('on','',$datapost1));
for ($i=0;$i < count($datapost);$i++){
	$stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_labtest SET LT_STATUS='0' WHERE LT_CODE=".$sql->Param('a').""),array($datapost[$i]));
	print $sql->ErrorMsg();
	}
	//print_r($data);
}
?>
