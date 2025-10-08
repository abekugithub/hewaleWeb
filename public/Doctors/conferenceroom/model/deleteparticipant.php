<?php
ob_start();
include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";

$engine = new engineClass();
$actualdate = date('Y-m-d');
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();
$actor = $engine->getActorDetails();
$actorcode = $actor->USR_CODE;
$activeinstitution = $actor->USR_FACICODE;

$result = array();
$num = 1;
if (!empty($participantid)){ 
          //  $sql->debug = true;
        $sql->Execute("DELETE FROM hms_conference_panels WHERE CONFER_ID = ".$sql->Param('1')." ",
            array($participantid));
        print $sql->ErrorMsg();

        $stmtpart = $sql->Execute($sql->Prepare("SELECT * FROM hms_conference_panels WHERE CONFER_CONFCODE=".$sql->Param('a')." "),array($confcode));

        if ($stmtpart->RecordCount()>0){
            while ($obj = $stmtpart->FetchNextObject()){
                $participantname = $engine->getUSerDetils($obj->CONFER_INVITED_USERID);

                $result = '<tr ><td>'.$num++.'</td>
                <td>'.$participantname.'</td>
                <td><button type="button" id="" onclick="deleteparticipant('.$obj->CONFER_ID.')" class="btn-danger">&times;</button></td></tr>';
            }
        }else{
            $result = '<tr><td colspan="3"></td></tr>';
        }
    
}
echo $result ;