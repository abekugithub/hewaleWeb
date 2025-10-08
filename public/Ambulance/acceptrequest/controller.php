<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 5/29/2018
 * Time: 2:39 PM
 */

if(!empty($fdsearch)){
    $query = "SELECT * FROM hms_consultation WHERE CONS_FACICODE = ".$sql->Param('a')." AND CONS_DOCTORCODE = ".$sql->Param('b')." AND CONS_STATUS IN ('1','2') AND (CONS_PATIENTNUM = ".$sql->Param('c')." OR CONS_PATIENTNAME LIKE ".$sql->Param('d').") ORDER BY CONS_INPUTDATE DESC";
    $input = array($activeinstitution,$usrcode,$fdsearch,'%'.$fdsearch.'%');
}else {
    $query = "SELECT * FROM hms_consultation WHERE CONS_FACICODE = ".$sql->Param('a')." AND CONS_DOCTORCODE = ".$sql->Param('b')." AND CONS_STATUS IN ('1','2') ORDER BY CONS_INPUTDATE DESC";
    $input = array($activeinstitution,$usrcode);


}
if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=f77ccbdb203c19d3d52b12a85f33faf5&option=6bf17fe4762ece7a82410014d090d322&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);
