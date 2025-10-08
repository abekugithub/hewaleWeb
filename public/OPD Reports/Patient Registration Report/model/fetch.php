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

		$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient WHERE PATIENT_FACILITYCODE =".$sql->Param('a')." AND PATIENT_DATE >= ".$sql->Param('a')." AND PATIENT_DATE   <= ".$sql->Param('a').""),array($activeinstitution,$from,$to));
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
                            <th>Actor</th>
                        </tr>
                    </thead>
                    <tbody>';
                       
                 
					if($stmt->RecordCount() > 0){
						$num = 1;
						while($obj  = $stmt->FetchNextObject()){
						  
                   $result.='<td>'.$num++.'</td>
                        <td>'.$obj->PATIENT_FNAME.' '.$obj->PATIENT_MNAME.' '.$obj->PATIENT_LNAME.'</td>
                        <td>'.$obj->PATIENT_PATIENTNUM.'</td>
                        <td>'.$obj->PATIENT_PHONENUM.'</td>
						<td>'.$obj->PATIENT_ADDRESS.'</td>
                        <td>'.$obj->PATIENT_EMAIL.'</td>
						<td>'.date("d/m/Y",strtotime($obj->PATIENT_DATE)).'</td>
						<td>'.$obj->PATIENT_USERCODE.'</td>
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