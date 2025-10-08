<?php

/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 8/25/2017
 * Time: 11:59 AM
 */
include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
include SPATH_LIBRARIES.DS."doctors.Class.php";
$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);

$engine = new engineClass();
$doc = new doctorClass();
$day = Date("Y-m-d");
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();
$actor = $engine->getActorDetails();
$activeinstitution = $actor->USR_FACICODE;
$actor_id = $engine->getActorCode();
$facility_code = $actor->USR_FACICODE;
 //echo $actor_id;

//if (!empty($txtarea)){
$from = date("Y-m-d",strtotime($datefrom));
$to = date("Y-m-d",strtotime($dateto));

$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_wallet_transaction WHERE HRMSTRANS_RECEIVER = ".$sql->Param('a')." AND HRMSTRANS_DATE >={$sql->Param('a')} AND  HRMSTRANS_DATE <={$sql->Param('a')} ORDER BY  HRMSTRANS_INPUTDATE"),array($actor_id,$from,$to));
print $sql->ErrorMsg();
//$result = array();

$num = 1;
$result.='<table class="table table-hover">
                    <thead>
                        <tr>
                           <th>#</th>
                   
                    <th>Patient Name</th>
                    <th>Amount</th>
                    <th>Phone No.</th>
                    <th>Date</th>                            
                        </tr>
                    </thead>
                    <tbody>';


if($stmt->RecordCount() > 0){
    $num = 1;
    while($obj  = $stmt->FetchNextObject()){
        $pcode = $obj->HRMSTRANS_USERCODE;
        //$actorcode = $obj->FIR_PATIENTID;
        $stmtp = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient WHERE PATIENT_PATIENTCODE =".$sql->Param('a').""),array($pcode));
        $objp  = $stmtp->FetchNextObject();

        //$stmta = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient WHERE PATIENT_PATIENTCODE =".$sql->Param('a').""),array($activeinstitution));
        //$obja  = $stmta->FetchNextObject();

        $result.='<td>'.$num++.'</td>
                     
                        <td>'.$objp->PATIENT_FNAME.' '.$objp->PATIENT_MNAME.' '.$objp->PATIENT_LNAME.'</td>
                        <td>'.$obj->HRMSTRANS_AMOUNT.'</td>                      
                        <td>'.$objp->PATIENT_PHONENUM.'</td>
						
						<td>'.date("d-m-Y",strtotime($obj->HRMSTRANS_DATE)).'</td>
						
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
//}
//}
?>

