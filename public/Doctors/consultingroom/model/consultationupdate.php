<?php
ob_start();
include('../../../../config.php');
include SPATH_LIBRARIES.DS.'engine.Class.php';
//include SPATH_LIBRARIES.DS.'patient.Class.php';
$engine = new engineClass();
$patientCls = new patientClass();
//$usrcode = $engine->getActorCode();
echo $activeinstitution;
$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_consultation WHERE CONS_FACICODE = ".$sql->Param('a')."  AND  CONS_STATUS = '1' ORDER BY CONS_INPUTDATE DESC"),array($activeinstitution));
//print $sql->ErrorMsg();

$consult = array();

    if($stmt) {                 
    if ($stmt->RecordCount() > 0) {
        $num = 1;
        while ($obj = $stmt->FetchNextObject()) {
            $unread = $engine->getUnreadConsChat($usrcode,$obj->CONS_PATIENTCODE); 
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
									
									<a href="consultingdetails.php?keys='.$obj->CONS_CODE.'&patientcode='.$obj->CONS_PATIENTNUM.'&new_visitcode='.$obj->CONS_VISITCODE.'&viewpage=consult" ><button type="submit" class="startchat" onclick="document.getElementById(\'keys\').value=\''.$obj->CONS_CODE.'\';document.getElementById(\'patientcode\').value=\''.md5($obj->CONS_PATIENTNUM).'\';document.getElementById(\'new_visitcode\').value=\''.$obj->CONS_VISITCODE.'\';document.getElementById(\'viewpage\').value=\'consult\';document.getElementById(\'view\').value=\'consulting\';document.myform.submit;">Consulting Room</button></a>
									
									</li>
									
                                    <li>
                                    <a href="consultingdetails.php?keys='.$obj->CONS_CODE.'&patientcode='.md5($obj->CONS_PATIENTNUM).'&new_visitcode='.$obj->CONS_VISITCODE.'&viewpage=consult"><button type="submit" onclick="CallSmallerWindow(\''.$linkview.'\')"> Medical History</button></a></li>
									
                                </ul>
								
                            </div>
                        </td>
                    </tr>');
        }
        echo json_encode($consult);
    } else {

    }
}