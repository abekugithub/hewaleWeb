<?php 
include("../../../../config.php");
include SPATH_LIBRARIES.DS."engine.Class.php";
$engine= new engineClass();
$actor_id = $engine->getActorCode();
$userInfo= $engine->getActorDetails();
$facilitycode = $engine->getFacilityDetails();
$actor_facilitycode =!empty($facilitycode->FACI_CODE)?$facilitycode->FACI_CODE:$actor_id;

// echo $actor_facilitycode;
// die();
$paymode=$_POST['paymode'];
// echo $paymode;
$mypaymode=explode("@#@",$paymode );
// var_dump($mypaymode);
$paycode=$mypaymode[0];
$paymode=strtoupper($mypaymode[1]);
// echo $paymode;
echo "<option value=''>Select Phone Number</option>";
$stmt=$sql->Execute($sql->Prepare("SELECT SET_ACC_NO FROM `hms_settlement_account` WHERE SET_ACC_NAME=".$sql->Param('a')." AND SET_FAC_CODE=".$sql->Param('a')." "),array($paymode,$actor_facilitycode));
if ($stmt->RecordCount() > 0) {
	# code...
	while ($myobj=$stmt->FetchNextObject()) {
		# code...
	
?>
<option value="<?php echo $myobj->SET_ACC_NO ?>"><?php echo $myobj->SET_ACC_NO; ?></option>
<?php 
}
}else{
	echo "<option  value=''>no numbers found</option>";
}
?>