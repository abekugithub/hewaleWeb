<?php
ob_start();
include('../../../../config.php');
include SPATH_LIBRARIES.DS.'engine.Class.php';
$engine = new engineClass();
//$usrcode = $engine->getActorCode();

$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_consultation WHERE CONS_FACICODE = ".$sql->Param('a')."  AND  CONS_DOCTORCODE = ".$sql->Param('b')." AND CONS_STATUS IN ('1','2') ORDER BY CONS_INPUTDATE DESC"),array($activeinstitution,$usrcode));
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
						<td>'.date("d/m/Y",strtotime($obj->CONS_SCHEDULEDATE)).'</td>
                        <td>'.$obj->CONS_SCHEDULETIME.'</td>
						<td>'.(($obj->CONS_STATUS == 1)?(($obj->CONS_SERVCODE == 'SER0004')?'Awaiting Vitals':'Pending'):(($obj->CONS_STATUS == 2)?'Incomplete':'')).'</td>
						<td><div class="btn-group">
                                <button type="button" class="btn btn-info btn-square" dropdown-toggle" data-toggle="dropdown">Options <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><button type="submit" class="startchat" onclick="fetchComplains(\''.$obj->CONS_PATIENTNUM.'\',\''.$obj->CONS_VISITCODE.'\');document.getElementById(\'keys\').value=\''.$obj->CONS_CODE.'\';document.getElementById(\'viewpage\').value=\'consult\';document.getElementById(\'view\').value=\'consulting\';document.myform.submit;">Consulting Room</button></li>
									
									'.(($usrtype == 2) ?'<li><button>Reschedule</button></li>':'').'
                                    <li><button type="submit" onclick="document.getElementById(\'keys\').value=\''.$obj->CONS_PATIENTNUM.'\';document.getElementById(\'viewpage\').value=\'history\';document.getElementById(\'view\').value=\'history\';document.myform.submit;">Medical History</button></li>
                                </ul>
                            </div>
                        </td>
                    </tr>');
        }
        echo json_encode($consult);
    } else {

    }
}