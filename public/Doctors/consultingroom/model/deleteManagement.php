<?php
ob_start();
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 8/25/2017
 * Time: 11:59 AM
 */
include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);

$engine = new engineClass();
$day = Date("Y-m-d");
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();
$actor = $engine->getActorDetails();
$activeinstitution = $actor->USR_FACICODE;

if (!empty($keys)){
    
	//$stmt = $sql->Execute($sql->Prepare("DELETE FROM hms_patient_management WHERE PM_ID = ".$sql->Param('a').""), array($keys));
	$stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_management SET PM_STATUS = '0' WHERE PM_ID=".$sql->Param('d')),array($keys));
	
    print $sql->ErrorMsg();
    if ($stmt){
        
		$fetchstmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_management WHERE PM_PATIENTNUM = ".$sql->Param('1')." AND PM_VISITCODE = ".$sql->Param('2')." AND PM_STATUS = ".$sql->Param('3').""),array($patientnum,$visitcode,'1'));
        print $sql->ErrorMsg();
        $result = array();
        $num = 1;
        if ($fetchstmt->RecordCount()>0){
            while ($obj = $fetchstmt->FetchNextObject()){

				$decrypid = $obj->PM_ENCRYPKEY;
				if($decrypid != $activekey){
				$saltencrypt = $encryptkeys[$decrypid]['salt'];
                $pepperdecrypt =  $encryptkeys[$decrypid]['pepper'];
				$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
				}

				$txtarea = $encaes->decrypt($obj->PM_MANAGEMENT);
				
				$result.='<tr>
				<td>'.$num++.'</td>
				<td>'.$txtarea.'</td>
				<td class="text-center valign-middle" width="100">
                <button class="btn btn-xs btn-danger square" type="button" onclick="deleteManagement(\''.$obj->PM_ID.'\')"><i class="fa fa-close"></i>
				</button>
                </td>
				<tr>';
            }
           }else{
				$result.='<tr>
					<td colspan="3">No record found.</td>
				<tr>';
			}
		echo $result;
    }
}