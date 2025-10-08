<?php

include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
//include SPATH_LIBRARIES.DS."doctors.Class.php";
//$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);

$engine = new engineClass();
//$doc = new doctorClass();
$date = Date("Y-m-d H:i:s");
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();
$actor = $engine->getActorDetails();
$activeinstitution = $actor->USR_FACICODE;

        
		$fetchstmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_emergency_reports WHERE REP_PATIENTCODE = ".$sql->Param('1')." AND REP_VISITCODE = ".$sql->Param('2')." AND REP_STATUS = ".$sql->Param('3').""),array($patientcode,$visitcode,'1'));
        print $sql->ErrorMsg();
        $result = array();
        $num = 1;
        if ($fetchstmt->RecordCount()>0){
            while ($obj = $fetchstmt->FetchNextObject()){
				// Decrypt text with another key if necessary
				//$decrypid = $obj->PM_ENCRYPKEY;
				//if($decrypid != $activekey){
				//$saltencrypt = $encryptkeys[$decrypid]['salt'];
                //$pepperdecrypt =  $encryptkeys[$decrypid]['pepper'];
				//$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
				//}
				
                //$txtarea = $encaes->decrypt($obj->PM_MANAGEMENT);
				
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
    
	?>
