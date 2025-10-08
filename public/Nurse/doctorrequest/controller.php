<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 5/1/2018
 * Time: 5:32 PM
 */
$patientCls = new patientClass();
// Get Doctor Code
$actor_id = $engine->getActorCode();
// Get Doctor Facility Code
$actor = $engine->getActorDetails();
$actorname = $engine->getActorName();
$facility_code = $actor->USR_FACICODE;
$actudate = date("Y-m-d");

switch ($viewpage){
    case 'acceptrequest':
        // Accept Doctor's Request to work with nurse
        if (isset($keys) && !empty($keys)){
            $stmt = $sql->Execute($sql->Prepare("UPDATE hms_nurse_request SET NRQ_STATUS = ".$sql->Param('1')." WHERE NRQ_ID = ".$sql->Param('2')),array('2',$keys));
            print $sql->ErrorMsg();
            if ($stmt){
                // Event Log
                $activity = "You have accepted Dr. {$actorname}'s request to be His/Her Nurse for Premium Service.";
                $engine->setEventLog('118',$activity);

                //Notification
                $desc = "Nurse {$nursename} with ID {$nurseid} has accepted Dr. {$actorname}'s request to be His/Her Nurse for Premium Service.";
                $tablerowid = $sql->insert_Id();
                //menudetailscode for My Nurses 0160
                $engine->setNotification('042',$desc,'0153',$tablerowid,$doctorcode,$facility_code);
                $engine->ClearNotification('0146',$keys);
echo $keys;
                $msg = "You have accepted to be one of Dr. {$doctorname}'s Nurses";
                $status = "success";
            }else{
                $msg = "You were unable to accept Dr. {$doctorname}'s request to become His/Her Nurse. An error might be encountered.";
                $status = "error";
            }
        }
    break;

    case 'rejectrequest':
        // Reject Doctor's Request to work with nurse
        if (isset($keys) && !empty($keys)){
            $stmt = $sql->Execute($sql->Prepare("UPDATE hms_nurse_request SET NRQ_STATUS = ".$sql->Param('1')." WHERE NRQ_ID = ".$sql->Param('2')),array('3',$keys));
            print $sql->ErrorMsg();
            if ($stmt){
                // Event Log
                $activity = "You have rejected Dr. {$actorname}'s request to be His/Her Nurse for Premium Service.";
                $engine->setEventLog('118',$activity);

                //Notification
                $desc = "Nurse {$nursename} with ID {$nurseid} has accepted Dr. {$actorname}'s request to be His/Her Nurse for Premium Service.";
                $tablerowid = $sql->insert_Id();
                $engine->setNotification('042',$desc,'0153',$tablerowid,$doctorcode,$facility_code);
//                $stmt_id = $sql->Execute($sql->Prepare("SELECT NRQ_ID FROM hms_nurse_request WHERE NRQ_NURSE_CODE=".$sql->Param('a')." AND NRQ_DOCTOR_CODE=".$sql->Param('b')),array($nurseid,$doctorcode));
                $engine->ClearNotification('0146',$keys);

                $msg = "You have rejected to be one of Dr. {$doctorname}'s Nurses";
                $status = "success";
            }else{
                $msg = "You were unable to reject Dr. {$doctorname}'s request to become His/Her Nurse. An error might be encountered.";
                $status = "error";
            }
        }
        break;

    case 'viewdoctorprofile':
        //View Doctor Profile
        if (isset($keys) && !empty($keys)){
            $stmt = $sql->Execute($sql->Prepare("SELECT NRQ_DOCTOR_CODE,NRQ_DOCTOR_MEDLICENSE,NRQ_DOCTOR_NAM,NRQ_DOCTOR_SPECIALTY,NRQ_SUMMARY FROM hms_nurse_request WHERE NRQ_ID = ".$sql->Param('2')),array($keys));
            print $sql->ErrorMsg();
            if ($stmt){
                $obj = $stmt->FetchNextObject();
                $doctorname = $obj->NRQ_DOCTOR_NAM;
                $doctorcode = $obj->NRQ_DOCTOR_CODE;
                $specialty = $obj->NRQ_DOCTOR_SPECIALTY;
                $license = $obj->NRQ_DOCTOR_MEDLICENSE;
                // Event Log
//                $activity = "You have rejected Dr. {$actorname}'s request to be His/Her Nurse for Premium Service.";
//                $engine->setEventLog('118',$activity);

                //Notification
//                $desc = "Nurse {$nursename} with ID {$nurseid} has accepted Dr. {$actorname}'s request to be His/Her Nurse for Premium Service.";
//                $tablerowid = $sql->insert_Id();
//                $engine->setNotification('042',$desc,'0153',$tablerowid,$doctorcode,$facility_code);

//                $msg = "You have rejected to be one of Dr. {$doctorname}'s Nurses";
//                $status = "success";
            }else{
                $msg = "You were unable to reject Dr. {$doctorname}'s request to become His/Her Nurse. An error might be encountered.";
                $status = "error";
            }
        }
        break;
}
$status_arr = ['1'=>'Requested','2'=>'Approved','-1'=>'Disengaged'];

if(!empty($fdsearch)){
    $query = "SELECT * FROM hms_nurse_request WHERE NRQ_NURSE_CODE = ".$sql->Param('a')." AND NRQ_STATUS = '1' AND (NRQ_DOCTOR_CODE = ".$sql->Param('b')." OR NRQ_DOCTOR_NAM LIKE ".$sql->Param('c').") ORDER BY NRQ_INPUTEDDATE DESC";
    $input = array($actor_id,$fdsearch,'%'.$fdsearch.'%');
}else {
    $query = "SELECT * FROM hms_nurse_request WHERE NRQ_NURSE_CODE = ".$sql->Param('a')." AND NRQ_STATUS = '1' ORDER BY NRQ_ID DESC";
    $input = array($actor_id);
}

if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=f77ccbdb203c19d3d52b12a85f33faf5&option=6bf17fe4762ece7a82410014d090d322&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);