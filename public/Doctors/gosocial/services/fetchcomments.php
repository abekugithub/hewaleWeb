<?php
    include '../../../../config.php';
    include SPATH_LIBRARIES.DS."engine.Class.php";
    include SPATH_LIBRARIES.DS."doctors.Class.php";
    $doctors = new doctorClass();
    //---> Get Comments ---//
    $postdata = file_get_contents('php://input');
    $obj = json_decode($postdata,true);
    $article_id = $obj['article_id'];
    
    ## Query Tables
    $stmt = $sql->Execute($sql->Prepare("SELECT hms_article_comments.ATCOM_ID, hms_article_comments.ATCOM_ARTICLEID, hms_article_comments.ATCOM_PATIENTCODE, hms_article_comments.ATCOM_COMMENT, hms_article_comments.ATCOM_DATEADDED FROM hms_article_comments WHERE hms_article_comments.ATCOM_STATUS = '1' AND hms_article_comments.ATCOM_ARTICLEID = ".$sql->Param('a')." ORDER BY hms_article_comments.ATCOM_DATEADDED"),array($article_id));

    if($stmt && $stmt->RecordCount() > 0){
        $comments = $stmt->GetAll();
        foreach ($comments as $key => $val) {
            $code = $val['ATCOM_PATIENTCODE'];
            $doctor_info = $doctors->getDoctorProfile($code);
            $patient_info = getPatientInfo($code);
            if(isset($doctor_info)){
                $comments[$key]['ATCOM_PATIENTNAME'] = $doctor_info->MP_SURNAME.' '.$doctor_info->MP_OTHERNAME;
                $comments[$key]['ATCOM_PATIENTPHOTO'] = $doctor_info->MP_PHOTO;
            }elseif(isset($patient_info)){
                $comments[$key]['ATCOM_PATIENTNAME'] = $patient_info['PATCON_FULLNAME'];
                $comments[$key]['ATCOM_PATIENTPHOTO'] = $patient_info['PATCON_PHOTO'];
            }
        }
    }else{
        $comments = [];
    }

    function getPatientInfo($code){
        global $sql;
        $stmt = $sql->Execute($sql->Prepare("SELECT PATCON_PHOTO,PATCON_FULLNAME FROM hms_patient_connect WHERE PATCON_PATIENTCODE = ".$sql->Param('a')." "),array($code));
        print $sql->ErrorMsg();
        if($stmt && $stmt->RecordCount() > 0){
            return $stmt->FetchRow(); 
        }else{
            return false;
        }  
    }

    echo json_encode($comments);

?>