<?php
    include '../../../../config.php';
    include SPATH_LIBRARIES.DS."engine.Class.php";
    include SPATH_LIBRARIES.DS."doctors.Class.php";
    $doctors = new doctorClass();
    //---> Get Comments ---//
    $doctor_code = $session->get('usercode');
    $info = $doctors->getDoctorProfile($doctor_code);
    $country_code = $info->MP_COUNTRYCODE;
    $postdata = file_get_contents('php://input');
    $obj = json_decode($postdata,true);
    $article_id = $obj['article_id'];
    $commenttext = $obj['commenttext'];
    $comments = '';
    
    ## Query Tables
    if (!empty($article_id) && !empty($commenttext) && !empty($doctor_code)){
        $commentdate = date('Y-m-d H:i:s');
        $stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_article_comments (ATCOM_ARTICLEID,ATCOM_PATIENTCODE,ATCOM_COMMENT,ATCOM_DATEADDED) VALUES (".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').")"),array($article_id,$doctor_code,$commenttext,$commentdate));
        print($sql->ErrorMsg());
        $stmta = $sql->Execute($sql->Prepare("UPDATE hms_articles SET ART_COMMENT_COUNT = ART_COMMENT_COUNT + 1 WHERE ART_ID=".$sql->Param('a')." "),array($article_id));
        print($sql->ErrorMsg());
        if($stmt && $stmta){
            $comments = 'done';
        }else{
            $comments = $sql->ErrorMsg();
        }
    }else{
        $comments = 'error getting data';
    }

    

    echo json_encode($comments);

?>