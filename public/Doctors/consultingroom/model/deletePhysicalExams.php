<?php
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
//    $visitcode = $new_visitcode;
    
	//$stmt = $sql->Execute($sql->Prepare("DELETE FROM hms_patient_management WHERE PM_ID = ".$sql->Param('a').""), array($keys));
	$stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_physicalexams SET PPEX_STATUS = '0' WHERE PPEX_ID=".$sql->Param('d')),array($keys));
	
    print $sql->ErrorMsg();
    if ($stmt){
        
		$fetchstmt = $sql->Execute($sql->Prepare("SELECT PPEX_PHYSICALEXAMSTYPE,PPEX_PHYSICALEXAMSDETAILS,PPEX_CODE,PPEX_ID FROM hms_patient_physicalexams WHERE PPEX_PATIENTNUM = ".$sql->Param('1')." AND PPEX_VISITCODE = ".$sql->Param('2')." AND PPEX_STATUS = ".$sql->Param('3').""),array($patientnum,$visitcode,'1'));
        print $sql->ErrorMsg();
        $result = array();
        $num = 1;
        if ($fetchstmt->RecordCount()>0){
            while ($obj = $fetchstmt->FetchNextObject()){
                $physicalexamstype = $encaes->decrypt($obj->PPEX_PHYSICALEXAMSTYPE);
                $physicalexamsdetails = $encaes->decrypt($obj->PPEX_PHYSICALEXAMSDETAILS);

				$result.='<tr>
				<td>'.$num++.'</td>
				<td>'.$physicalexamstype.'</td>
				<td>'.$physicalexamsdetails.'</td>
				<td class="text-center valign-middle" width="100">
                <button class="btn btn-xs btn-danger square" type="button" onclick="deletePhysicalExams(\''.$obj->PPEX_ID.'\')"><i class="fa fa-close"></i>
				</button>
                </td>
				<tr>';
            }
           }else{
				$result.='<tr>
					<td colspan="3">No record found.'.$patientnum.' '.$new_visitcode.'</td>
				<tr>';
			}
		echo $result;
    }
}