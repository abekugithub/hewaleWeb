<?php 
//---------------Code by Reggie -------------------//
include ("/../../../config.php");

$searchobj = $_GET['term'];
$stmtn = $sql->Execute($sql->Prepare("SELECT MEM_ID,MEM_NAME,MEM_PHOTO FROM church_members WHERE MEM_NAME LIKE '%".$searchobj."%' "));
//die($sql->errorMsg());
if($stmtn->RecordCount() > 0){
	$data=array();
	while($row=$stmtn->FetchNextObject()){
		$data[] = array('value'=>$row->MEM_ID,'label'=>$row->MEM_NAME,'photo'=>$row->MEM_PHOTO);	
	}
	echo json_encode($data);
}
?>