<?php
ob_start();
include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
$engine = new engineClass();

if (!empty($val)){
    $stmtsubgroup = $sql->Execute($sql->Prepare("SELECT PPR_METHOD,PPR_METHODCODE FROM hms_pharmacyprice where PPR_DRUGCODE=".$sql->Param('a')." "),array($val));
    print $sql->ErrorMsg();

    $result = "<option value='' selected disabled='disabled'>-- Select Payment Method --</option>";
    if ($stmtsubgroup->RecordCount()>0){
        while ($obj = $stmtsubgroup->FetchNextObject()){
        	if ($obj->PPR_METHODCODE !=''){
            $result .= "<option value='".$obj->PPR_METHODCODE.'|'.$obj->PPR_METHOD."'>".$obj->PPR_METHOD."</option>";
        	}else{
        		$result .= "<option value='PC0001|CASH'>CASH</option>";
        	}
        }
    }else{
         $result .= "<option value='PC0001|CASH'>CASH</option>";
    }
     echo json_encode($result);
}