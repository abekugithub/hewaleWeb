<?php 
include("../../../../config.php");
$ward = explode('@@@', $data);
$wardcode=$ward[0];
$facidcode=$ward[1];

$stmt=$sql->Execute($sql->Prepare("SELECT BED_CODE,BED_NAME FROM hms_st_wardbed WHERE BED_WARDID=".$sql->Param('a')." AND BED_FACICODE=".$sql->Param('b')." ORDER BY BED_NAME ASC "),array($wardcode,$facidcode));
        if($stmt->RecordCount()>0){
			
		while($obj = $stmt->FetchNextObject()){
			$result.='<option value="'.$obj->BED_CODE.'">'.$obj->BED_NAME.'</option>';
			}
			
	}else{
		$result.='<option value="" selected="selected">No Bed</option>';
		}
	echo $result;
	
?>