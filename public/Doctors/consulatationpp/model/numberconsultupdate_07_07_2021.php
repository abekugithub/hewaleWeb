<?php
ob_start();
include('../../../../config.php');
include SPATH_LIBRARIES.DS.'engine.Class.php';
$engine = new engineClass();
$actordetails = $engine->getActorDetails();
$activecc = $actordetails->USR_ACTIVECC ;
$countrycode = $actordetails->USR_COUNTRYCODE;

if($actordetails->USR_TYPE == '2'){
//get pending patient in queue
$stmtqueue = $sql->Execute($sql->Prepare("SELECT COUNT(*) AS TOTALPATIENT FROM hms_consultation_queue WHERE CONS_DOCTORCODE IS NULL AND CONS_COUNTRYCODE = ".$sql->Param('a')."  AND CONS_STATUS = '1' "),array($countrycode));
if($stmtqueue->RecordCount() > 0){
$objqueue = $stmtqueue->FetchNextObject();
$totalpatient = $objqueue->TOTALPATIENT;

//$consult = array();

$result = '
<button type="button" title="Attend to next patient in queue" id="" onclick="document.getElementById(\'viewpage\').value=\'loadqueuedpatient\';document.getElementById(\'view\').value=\'consulting\';document.myform.submit();" class="btn btn-info"><i class="fa fa-medkit"></i> Next patient in queue <span><font color="#fff" size="-10">'.(($totalpatient > 0)?'<span class="badgepd">'.$totalpatient.'</span>':'<span class="badgepd">0</span>').'</font></span> </button>
';
}
}elseif($actordetails->USR_TYPE == '7'){
//get pending patient in queue
$stmtqueue = $sql->Execute($sql->Prepare("SELECT COUNT(*) AS TOTALPATIENT FROM hms_waiting_room WHERE CONS_DOCTORCODE IS NULL AND CONS_FACICODE = ".$sql->Param('a')." "),array($activecc));
if($stmtqueue->RecordCount() > 0){
$objqueue = $stmtqueue->FetchNextObject();
$totalchpspatients = $objqueue->TOTALPATIENT;


//$consult = array();

$result = '
<button type="button" title="Attend to next patient in queue" id="" onclick="document.getElementById(\'viewpage\').value=\'loadwaitingroompatient\';document.getElementById(\'view\').value=\'consulting\';document.myform.submit();" class="btn btn-info"><i class="fa fa-medkit"></i> Next patient in queue <span><font color="#fff" size="-10">'.(($totalchpspatients > 0)?'<span class="badgepd">'.$totalchpspatients.'</span>':'<span class="badgepd">0</span>').'</font></span> </button>
';

}
}

/*
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
						<td>'.(!empty($obj->CONS_SCHEDULEDATE)?date("d/m/Y",strtotime($obj->CONS_SCHEDULEDATE)):'-').'</td>
                        <td>'.(!empty($obj->CONS_SCHEDULETIME)?$obj->CONS_SCHEDULETIME:'-').'</td>
						<td>'.(($obj->CONS_STATUS == 1)?(($obj->CONS_SERVCODE == 'SER0004')?'Awaiting Vitals':'Pending'):(($obj->CONS_STATUS == 2)?'Incomplete':'')).'</td>
                        <td>'.$medium.'</td>
                        <td align="center"> <span><font color="#fff">'.(($unread > 0)?'<span class="badge">'.$unread.'</span>':'').'</font></span></td>
                        <td><div class="btn-group">
                                <button type="button" class="btn btn-info btn-square" dropdown-toggle" data-toggle="dropdown">Options <span class="caret"></span></button>
                                
								 <ul class="dropdown-menu" role="menu">
								
									'.(($obj->CONS_PAYSTATE == 2)?'
                                    <li>
									
									<button type="submit" class="startchat" onclick="document.getElementById(\'keys\').value=\''.$obj->CONS_CODE.'\';document.getElementById(\'patientcode\').value=\''.$obj->CONS_PATIENTNUM.'\';document.getElementById(\'new_visitcode\').value=\''.$obj->CONS_VISITCODE.'\';document.getElementById(\'viewpage\').value=\'consult\';document.getElementById(\'view\').value=\'consulting\';document.myform.submit;">Consulting Room</button>
									
                                    </li>
                                    
                                    <li>
									
									<button type="submit" class="startchat" onclick="CallSmallerWindow(\''.$linkviewrequst.'\')">Request Reason</button>
									
                                    </li> 
                                    
									':'<li>
									
									<button type="submit" class="startchat" onclick="document.getElementById(\'keys\').value=\''.$obj->CONS_CODE.'\';document.getElementById(\'patientcode\').value=\''.$obj->CONS_PATIENTNUM.'\';document.getElementById(\'new_visitcode\').value=\''.$obj->CONS_VISITCODE.'\';document.getElementById(\'viewpage\').value=\'consult\';document.getElementById(\'view\').value=\'consulting\';document.myform.submit;">Consulting Room</button>
									
									</li>' ).'
									
									<li><button type="submit" onclick="CallSmallerWindow(\''.$linkview.'\')"> Medical History</button></li>
									<button type="button" class="" data-toggle="modal" data-target="#addDesp" onclick="document.getElementById(\'keys\').value=\''.$obj->CONS_CODE.'@@@'.$obj->CONS_VISITCODE.'\';document.myform.submit;">Cancel</button>
                                </ul>
								
                            </div>
                        </td>
                    </tr>');
        }
        echo json_encode($consult);
    } else {

    }
    }*/

echo json_encode($result); 
