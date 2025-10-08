<?php
/*
 * Log out all doctors from the system 
 * at 12 midnight
 */
ob_start();
include "../config.php";
include SPATH_LIBRARIES.DS."engine.Class.php";
include SPATH_LIBRARIES.DS."doctors.Class.php";

$engine = new engineClass();
$doctors = new doctorClass();

$actordetails = $engine->getActorDetails();

$currenttime = date('G:i:sa');

if($currenttime >= '23:10:00'){

    $query = "UPDATE hms_users SET USR_ONLINE_STATUS = '0',USR_CONSULTING_STATUS = '0',USR_CHATSTATE = '' ";
    $stmt = $sql->Execute($query,array());
    
    $sql->Execute($sql->Prepare("UPDATE hms_consultation SET CONS_INCONSULTATION = '0' "),array());
   
    /* $sessiononlinestate = $session->get('sessiononlinestate'); */

    /*$stmtp = $sql->Execute($sql->Prepare("SELECT * FROM hmsb_doctorsmonitor WHERE DM_SESSIONLOGIN = ".$sql->Param('a')." AND  DM_DOCTORCODE = ".$sql->Param('b')." AND DM_ENDTIME IS NULL "),array($sessiononlinestate,$usercode)); */

    $stmtp = $sql->Execute($sql->Prepare("SELECT * FROM hmsb_doctorsmonitor WHERE DM_ENDTIME IS NULL"),array());
    
    
    if($stmtp->RecordCount() > 0){
    while( $objmon =  $stmtp->FetchNextObject()){	
    $starttime = $objmon->DM_STARTTIME;
    $usercode = $objmon->DM_DOCTORCODE;
    $currenttime = date('Y-m-d H:i:s');
          
    //$timediff = date( "i", abs(strtotime($currenttime) - strtotime($starttime)));	
      
        
        $sql->Execute("UPDATE hmsb_doctorsmonitor SET DM_ENDTIME = ".$sql->Param('a')." ,DM_TIMEDIFF = CONCAT(
            MOD (
                HOUR (
                    TIMEDIFF(
                        ".$sql->Param('b').",
                        ".$sql->Param('c')."
                    )
                ),
                24
            ),
            'H : ',
            MINUTE (
                TIMEDIFF(
                    ".$sql->Param('d').",
                    ".$sql->Param('e')."
                )
            ),
            'min'
        ),DM_SOURCE = '2'  WHERE  DM_DOCTORCODE = ".$sql->Param('c')." AND  DM_ENDTIME IS NULL ",array($currenttime,$starttime,$currenttime,$starttime,$currenttime,$usercode));
     }
    }
    $session->del('sessiononlinestate');
    $session->del('userid');
    $session->del('loginuserfulname');
    $session->del('h1');
    $session->del('activeinstitution');
    $session->del('random_seed');
    $session->del('hash_key');
    $session->del('usercode');
}
ob_flush();
?>