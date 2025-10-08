<?php
include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
$engine = new engineClass();

$actor_id = $engine->getActorCode();
$actor = $engine->getActorDetails();
$facility_code = $actor->USR_FACICODE;
$from = date("Y-m-d",strtotime($datefrom));
$to = date("Y-m-d",strtotime($dateto));

$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_service_request WHERE REQU_FACI_CODE = ".$sql->Param('a')." AND REQU_DOCTORCODE = ".$sql->Param('a')." AND REQU_STATUS = '1'  AND REQU_DATE >={$sql->Param('a')} AND  REQU_DATE <={$sql->Param('a')} ORDER BY REQU_INPUTEDDATE")
    ,array($facility_code,$actor_id,$from,$to));
print $sql->ErrorMsg();

$num = 1;
$result.='<table class="table table-hover">
                    <thead>
                        <tr>
                           <th>#</th>
                    <th>Patient No.</th>
                    <th>Patient Name</th>
                    <th>Gender</th>                 
                    <th>Phone No.</th>
                    <th>Date</th>           
                        </tr>
                    </thead>
                    <tbody>';

if($stmt->RecordCount() > 0){
    $num = 1;
while( $obj=$stmt->FetchNextObject()){
     $pcode = $obj->REQU_PATIENTCODE;
    $stmtp = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient WHERE PATIENT_PATIENTCODE =".$sql->Param('a').""),array($pcode));
    $objp  = $stmtp->FetchNextObject();

    $result.='<td>'.$num++.'</td>
                       <td>'.$objp->PATIENT_PATIENTNUM.'</td>
                        <td>'.$objp->PATIENT_FNAME.' '.$objp->PATIENT_MNAME.' '.$objp->PATIENT_LNAME.'</td>
                        <td>'.$objp->PATIENT_GENDER.'</td>                
                        <td>'.$objp->PATIENT_PHONENUM.'</td>
						<td>'.date("d/m/Y",strtotime($obj->REQU_DATE)).'</td>						
                    </tr>';
}}
else{
           $result.='<tr>
                <td colspan="6">No record found.</td>
        <tr>';
}
           $result.='                    
                    </tbody>
                  </table>';
      echo $result;



?>