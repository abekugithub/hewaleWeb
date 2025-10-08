<?php
ob_start();
include ("../../../../config.php");
$searchobj = $_GET['term'];
$stmtn = $sql->Execute($sql->Prepare("SELECT SY_CODE,SY_NAME FROM hmsb_st_symtoms WHERE SY_NAME LIKE '%".$searchobj."%' "));
//die($sql->errorMsg());
if($stmtn->RecordCount() > 0){
	$data=array();
	while($row=$stmtn->FetchNextObject()){
		$data[] = array('value'=>$row->SY_CODE,'label'=>$row->SY_NAME);	
	}
	echo json_encode($data);
}
?>