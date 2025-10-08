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


//if (!empty($txtarea)){
		$from = date("Y-m-d",strtotime($datefrom));
		$to = date("Y-m-d",strtotime($dateto));

		$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_vitals WHERE VITALS_FACILITYCODE =".$sql->Param('a')." AND VITALS_INPUTEDDATE >= ".$sql->Param('a')." AND VITALS_INPUTEDDATE   <= ".$sql->Param('a').""),array($activeinstitution,$from,$to));
        print $sql->ErrorMsg();
        //$result = array();
        $num = 1;
		
		$result.='<table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Hewale Number</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Date</th>
                       
                        </tr>
                    </thead>
                    <tbody>';
                       
                 
					if($stmt->RecordCount() > 0){
						$num = 1;
						while($obj  = $stmt->FetchNextObject()){
							
							$pcode = $obj->VITALS_PATIENTID;
							//$actorcode = $obj->VITALS_ACTOR;
							$stmtp = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient WHERE PATIENT_PATIENTCODE =".$sql->Param('a').""),array($pcode));
							$objp  = $stmtp->FetchNextObject();
							
							//$stmta = $sql->Execute($sql->Prepare("SELECT * FROM hms_users WHERE PATIENT_PATIENTCODE =".$sql->Param('a').""),array($actorcode));
							//$obja  = $stmta->FetchNextObject();
						  
                   $result.='<td>'.$num++.'</td>
                        <td>'.$objp->PATIENT_FNAME.' '.$objp->PATIENT_MNAME.' '.$objp->PATIENT_LNAME.'</td>
                        <td>'.$obj->VITALS_PATIENTNO.'</td>
                        <td>'.$objp->PATIENT_PHONENUM.'</td>
						<td>'.$objp->PATIENT_ADDRESS.'</td>
                        <td>'.$objp->PATIENT_EMAIL.'</td>
						<td>'.date("d/m/Y",strtotime($obj->VITALS_INPUTEDDATE)).'</td>
						
                    </tr>';
					}}
					else{
				$result.='<tr>
					<td colspan="3">No record found.</td>
				<tr>';
			}
					$result.='
                    
                    </tbody>
                </table>';
                
       
		echo $result;
    //}
//}
?>