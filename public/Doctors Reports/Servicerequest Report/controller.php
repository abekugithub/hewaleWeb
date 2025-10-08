<?php
$actor = $engine->getActorDetails();
$activeinstitution = $actor->USR_FACICODE;
//print_r ($_POST);
//echo $activeinstitution;


switch($viewpage){

    case "report":
        if (!empty($datefrom)&&!empty($dateto)){
            if (strtotime($datefrom)<=strtotime($dateto)){
                $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hmsb_allfacilities WHERE FACI_CODE =".$sql->Param('a').""),array($activeinstitution));
                $obj = $stmt->FetchNextObject();

                $report_comp_logo = "media/img/".$obj->FACI_LOGO_UNINAME;
                $report_comp_name = $obj->FACI_NAME;
                $report_title = "My Service Request Report";
                $report_comp_location = $obj->FACI_LOCATION;
                $report_phone_number = $obj->FACI_PHONENUM;
                //echo "loly pop";
                //$report_content = '';
                include("model/js.php");
            }
            else{
                //compare date
                $view ="";
            }
        }else{
            $view ="";
        }
        break;


}


?>