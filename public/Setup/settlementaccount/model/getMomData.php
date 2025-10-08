<?php 
include("../../../../config.php");
include SPATH_LIBRARIES.DS."engine.Class.php";
$engine= new engineClass();
$actor_id = $engine->getActorCode();
$userInfo= $engine->getActorDetails();
$facilitycode = $engine->getFacilityDetails();
$actor_facilitycode =!empty($facilitycode->FACI_CODE)?$facilitycode->FACI_CODE:$actor_id;

$paymode=$_POST['paymode'];
// echo $paymode;
if ($paymode=='1816111') {?>
<option value=" ">Select Network</option>
  <option  value="MTN" >MTN</option>
  <option  value="AIRTEL">AIRTEL</option>
  <option  value="VODAFONE">VODAFONE</option>
  <option value="TIGO">TIGO</option>
	

<?php }elseif($paymode=='1816193'){
	 echo '<option value=" ">Select Bank</option>';
	$stmtd=$sql->Execute($sql->Prepare("SELECT * FROM hms_bank"));

if ($stmtd->RecordCount() > 0) {

while ($obj=$stmtd->FetchNextObject()) {?>
	 <option value="<?php echo $obj->BANK_NAME; ?>"><?php echo $obj->BANK_NAME; ?></option>
	
	<?php }
}else{
	  echo '<option>no records found</option>';
}
}


?>