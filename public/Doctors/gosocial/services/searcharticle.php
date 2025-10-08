<?php
    include '../../../../config.php';
    include SPATH_LIBRARIES.DS."engine.Class.php";
    include SPATH_LIBRARIES.DS."doctors.Class.php";
    $doctors = new doctorClass();
    //---> Get Articles ---//

    $doctor_code = $session->get('usercode');
    $info = $doctors->getDoctorProfile($doctor_code);
    $country_code = $info->MP_COUNTRYCODE;
    $postdata = file_get_contents('php://input');
    $obj = json_decode($postdata,true);
    $search_params = $obj['search_param'];
    
    ## Query Tables
    $stmt = $sql->Execute($sql->Prepare("SELECT c.ART_ID,c.ART_TITLE,c.ART_SUBTITLE,c.ART_CATEGORY,c.ART_ARTICLETEXT,c.ART_ARTICLE_PHOTO,c.ART_ARTICLE_PHOTO2,c.ART_AUTHOR_PHOTO,c.ART_AUTHOR_NAME,c.ART_AUTHOR_CODE,c.ART_LIKE_COUNT,c.ART_COMMENT_COUNT,c.ART_COUNTRY,c.ART_STATUS,c.ART_DATE_ADDED,c.ART_DATE_UPDATED ,IF(( SELECT DISTINCT LKE_ARTICLEID FROM hms_article_likes WHERE LKE_PATIENTCODE=".$sql->Param('a')." AND LKE_ARTICLEID = c.ART_ID )IS NULL ,0,1) AS  articlelike FROM hms_articles c WHERE c.ART_COUNTRYCODE=".$sql->Param('a')." AND c.ART_STATUS = '1' AND (c.ART_TITLE LIKE ".$sql->Param('b')." OR c.ART_ARTICLETEXT LIKE ".$sql->Param('c')." OR c.ART_SUBTITLE LIKE ".$sql->Param('d').") "),array($doctor_code,$country_code,'%'.$search_params.'%','%'.$search_params.'%','%'.$search_params.'%'));

    if($stmt && $stmt->RecordCount() > 0){
        $articles = $stmt->GetAll();
    }else{
        $articles = [];
    }

    echo json_encode($articles);

?>