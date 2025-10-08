<?php

include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";

$engine = new engineClass();
$day = Date("Y-m-d");
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();
$actor = $engine->getActorDetails();
$activeinstitution = $actor->USR_FACICODE;

if (!empty($keys)){
    
	
	$stmt = $sql->Execute($sql->Prepare("UPDATE hms_emergency_reports SET PM_STATUS = '0' WHERE REP_ID=".$sql->Param('1')),array($keys));
	
    print $sql->ErrorMsg();
    if ($stmt){
        
		$fetchstmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_emergency_reports WHERE REP_PATIENTCODE = ".$sql->Param('1')." AND REP_VISITCODE = ".$sql->Param('2')." AND REP_STATUS = ".$sql->Param('3').""),array($patientcode,$visitcode,'1'));
        print $sql->ErrorMsg();
        $result = array();
        $num = 1;
        if ($fetchstmt->RecordCount()>0){
            while ($obj = $fetchstmt->FetchNextObject()){
                
				$result.='<tr>
				<td>'.$num++.'</td>
				<td>'.$obj->REP_DETAILS.'</td>
				<td>'.$obj->REP_ACTOR.'</td>
				<td>'.$obj->REP_DATE.'</td>
				<td class="text-center valign-middle" width="100">
                <button class="btn btn-xs btn-danger square" type="button" onclick="deleteReport(\''.$obj->REP_ID.'\')"><i class="fa fa-close"></i>
				</button>
                </td>
				<tr>';
            }
           }else{
				$result.='<tr>
					<td colspan="4">No record found.</td>
				<tr>';
			}
		echo $result;
    }
}