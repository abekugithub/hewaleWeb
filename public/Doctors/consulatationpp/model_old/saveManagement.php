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
include SPATH_LIBRARIES.DS."doctors.Class.php";
$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);

$engine = new engineClass();
$doc = new doctorClass();
$day = Date("Y-m-d");
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();
$actor = $engine->getActorDetails();
$activeinstitution = $actor->USR_FACICODE;
//$managementcode = '000';

if (!empty($txtarea)){
	$managementcode = $doc->getManagementCode();
	
	$txtarea = $encaes->encrypt($txtarea);

	$stmtman = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_management (PM_MANAGEMENT,PM_CODE,PM_DATE,PM_PATIENTNUM,PM_VISITCODE,PM_INSTCODE,PM_ACTORNAME,PM_ACTORCODE,PM_ENCRYPKEY,PM_PATIENTCODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').")"),array($txtarea,$managementcode,$day,$patientnum,$visitcode,$activeinstitution,$usrname,$usrcode,$encryptkey,$patientcode));
	print $sql->ErrorMsg();
	
    if ($stmtman){
        //$msg = "Consultation has been saved successfully";
        //$status = "success";

		$fetchstmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_management WHERE PM_PATIENTNUM = ".$sql->Param('1')." AND PM_VISITCODE = ".$sql->Param('2')." AND PM_STATUS = ".$sql->Param('3').""),array($patientnum,$visitcode,'1'));
        print $sql->ErrorMsg();
        $result = array();
        $num = 1;
        if ($fetchstmt->RecordCount()>0){
            while ($obj = $fetchstmt->FetchNextObject()){
				// Decrypt text with another key if necessary
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