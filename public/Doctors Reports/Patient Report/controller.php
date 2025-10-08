<?php
$actor = $engine->getActorDetails();
$activeinstitution = $actor->USR_FACICODE;
$usrcode = $engine->getActorCode();
//$actor_id = $engine->getActorCode();
// print_r ($_POST);
//echo $activeinstitution;


switch($viewpage){

     case "report":
        if (!empty($datefrom)&&!empty($dateto)){
            if (strtotime($datefrom)<=strtotime($dateto)){
                $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hmsb_allfacilities WHERE FACI_CODE =".$sql->Param('a').""),array($activeinstitution));
                $obj = $stmt->FetchNextObject();

                $report_comp_logo = "media/img/".$obj->FACI_LOGO_UNINAME;
                $report_comp_name = $obj->FACI_NAME;
                $report_title = "My Patients Report";
                $report_comp_location = $obj->FACI_LOCATION;
                $report_phone_number = $obj->FACI_PHONENUM;
                //echo "loly pop";
                $report_content = '';
               // include("model/js.php");


               $from = date("Y-m-d",strtotime($datefrom));
               $to = date("Y-m-d",strtotime($dateto));
              // $sql->debug = true;
               $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_consultation WHERE CONS_DOCTORCODE = ".$sql->Param('a')." AND CONS_DATE >={$sql->Param('a')} AND  CONS_DATE <={$sql->Param('a')} AND CONS_STATUS IN ('0','8','7','6','5','4','3','2','1')  ORDER BY CONS_INPUTDATE"),array($usrcode,$from,$to));
               print $sql->ErrorMsg();
               $num = 1;
               $result.='<table class="table table-hover">
                                   <thead>
                                       <tr>
                                          <th>#</th>
                                   <th>Patient No.</th>
                                   <th>Patient Name</th>
                                   <th>Gender</th>
                                   <th>Email</th>
                                   <th>Phone No.</th>
                                   <th>Date</th>                           
                                       </tr>
                                   </thead>
                                   <tbody>';
               
               
               if($stmt->RecordCount() > 0){
                   $num = 1;
                   while($obj  = $stmt->FetchNextObject()){
                       $pcode = $obj->CONS_PATIENTCODE;
                       //$actorcode = $obj->FIR_PATIENTID;
                       $stmtp = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient WHERE PATIENT_PATIENTCODE =".$sql->Param('a').""),array($pcode));
                       $objp  = $stmtp->FetchNextObject();
               
                       //$stmta = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient WHERE PATIENT_PATIENTCODE =".$sql->Param('a').""),array($activeinstitution));
                       //$obja  = $stmta->FetchNextObject();
               
                       $result.='<td>'.$num++.'</td>
                                      <td>'.$objp->PATIENT_PATIENTNUM.'</td>
                                       <td>'.$objp->PATIENT_FNAME.' '.$objp->PATIENT_MNAME.' '.$objp->PATIENT_LNAME.'</td>
                                       <td>'.$objp->PATIENT_GENDER.'</td>
                                       <td>'.$objp->PATIENT_EMAIL.'</td>
                                       <td>'.$objp->PATIENT_PHONENUM.'</td>
                                       
                                       <td>'.date("d/m/Y",strtotime($obj->CONS_DATE)).'</td>
                                       
                                   </tr>';
                   }}
               else{
                   $result.='<tr>
                                   <td colspan="4">No record found.</td>
                               <tr>';
               }
               $result.='
                                   
                                   </tbody>
                               </table>';
               
               
                $report_content = $result;

















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