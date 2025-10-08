<?php
ob_start();
include('../../../../config.php');
include SPATH_LIBRARIES.DS.'engine.Class.php';
//include SPATH_LIBRARIES.DS.'patient.Class.php';
$engine = new engineClass();
$patientCls = new patientClass();
$usrcode = $engine->getActorCode();
$username = $engine->getActorName();

echo 'HHH '.$cancelreason.' @@@ '.$visitcode; exit;
//Update consultation
$stmt = $sql->Execute($sql->Prepare("SELECT CONS_PATIENTNAME,CONS_PATIENTNUM FROM hms_consultation WHERE CONS_VISITCODE = ".$sql->Param('a')." "),array($visitcode));
$cons = $stmt->FetchNextObject();
		
	$sql->Execute($sql->Prepare("UPDATE hms_service_request SET REQU_STATUS ='13', REQU_CANCEL_REASON=".$sql->Param('a')." WHERE REQU_VISITCODE=".$sql->Param('d').""),array($cancelreason,$visitcode));
	print $sql->ErrorMsg();
	
	$sql->Execute($sql->Prepare("UPDATE hms_consultation SET CONS_STATUS ='0', CONS_CANCEL_REASON=".$sql->Param('a')." WHERE CONS_VISITCODE=".$sql->Param('d').""),array($cancelreason,$visitcode));
	print $sql->ErrorMsg();

        $activity = "Patient ".$cons->CONS_PATIENTNAME." with Hewale Number ".$cons->CONS_PATIENTNUM." Consultation's request cancelled by Dr. ".$username." with user code ".$usrcode;
        $engine->setEventLog("103",$activity);
        
//End cancelling consultation

$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_consultation WHERE CONS_FACICODE = ".$sql->Param('a')."  AND  CONS_STATUS IN ('1','2') ORDER BY CONS_INPUTDATE DESC"),array($activeinstitution));
//print $sql->ErrorMsg();

$consult = array();


    if($stmt) {                 
    if ($stmt->RecordCount() > 0) {
        $num = 1;
        while ($obj = $stmt->FetchNextObject()) {
            array_push($consult, '<tr >
                        <td>'.$num++.'</td>
                        <td>'.date("d/m/Y",strtotime($obj->CONS_DATE)).'</td>
                        <td>'.$obj->CONS_PATIENTNAME.'</td>
                        <td>'.$obj->CONS_PATIENTNUM.'</td>
						<td>'.(($obj->CONS_STATUS == 1)?(($obj->CONS_SERVCODE == 'SER0004')?'Awaiting Vitals':'Pending'):(($obj->CONS_STATUS == 2)?'Incomplete':'')).'</td>
                        <td><div class="btn-group">
                                <button type="button" class="btn btn-info btn-square" dropdown-toggle" data-toggle="dropdown">Options <span class="caret"></span></button>
                                
								 <ul class="dropdown-menu" role="menu">
								
									<li>
									
									<a href="consultingdetails.php?keys='.$obj->CONS_CODE.'&patientcode='.$obj->CONS_PATIENTNUM.'&new_visitcode='.$obj->CONS_VISITCODE.'&viewpage=consult" ><button type="submit" class="startchat" onclick="document.getElementById(\'keys\').value=\''.$obj->CONS_CODE.'\';document.getElementById(\'patientcode\').value=\''.$obj->CONS_PATIENTNUM.'\';document.getElementById(\'new_visitcode\').value=\''.$obj->CONS_VISITCODE.'\';document.getElementById(\'viewpage\').value=\'consult\';document.getElementById(\'view\').value=\'consulting\';document.myform.submit;">Consulting Room</button></a>
									
									</li>
									
                                    <li>
                                    <a href="consultingdetails.php?keys='.$obj->CONS_CODE.'&patientcode='.$obj->CONS_PATIENTNUM.'&new_visitcode='.$obj->CONS_VISITCODE.'&viewpage=consult"><button type="submit" onclick="CallSmallerWindow(\''.$linkview.'\')"> Medical History</button></a></li>
									<button type="button" class="" data-toggle="modal" data-target="#addDesp" onclick="document.getElementById(\'keys\').value=\''.$obj->CONS_CODE.'@@@'.$obj->CONS_VISITCODE.'\';document.myform.submit;">Cancel</button>
                                </ul>
								
                            </div>
                        </td>
                    </tr>');
        }
        echo json_encode($consult);
    } else {

    }
}