<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 5/1/2018
 * Time: 5:32 PM
 */
// Get Doctor Code
$actor_id = $engine->getActorCode();
// Get Doctor Facility Code
$actor = $engine->getActorDetails();
$actorname = $engine->getActorName();
$facility_code = $actor->USR_FACICODE;
$actudate = date("Y-m-d");

switch ($viewpage){

}

if(!empty($fdsearch)){
    $query = "SELECT * FROM hms_nurse_request JOIN hmsb_med_prac ON NRQ_DOCTOR_CODE=MP_USRCODE WHERE NRQ_NURSE_CODE = ".$sql->Param('a')." AND NRQ_STATUS = '1' AND (NRQ_DOCTOR_CODE = ".$sql->Param('b')." OR NRQ_DOCTOR_NAM LIKE ".$sql->Param('c').") AND MP_STATUS = '1' ORDER BY NRQ_INPUTEDDATE DESC";
    $input = array($actor_id,$fdsearch,'%'.$fdsearch.'%');
}else {
    $query = "SELECT * FROM hms_nurse_request JOIN hmsb_med_prac ON NRQ_DOCTOR_CODE=MP_USRCODE WHERE NRQ_NURSE_CODE = ".$sql->Param('a')." AND NRQ_STATUS = '2' AND MP_STATUS = '1' ORDER BY NRQ_INPUTEDDATE DESC";
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