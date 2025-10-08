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

		$stmt = $sql->Execute($sql->Prepare("SELECT PRESC_VISITCODE,PRESC_PATIENTNUM,PRESC_PATIENT,PRESC_ACTORNAME FROM hms_patient_prescription WHERE PRESC_INSTCODE =".$sql->Param('a')." AND PRESC_DATE >= ".$sql->Param('a')." AND PRESC_DATE   <= ".$sql->Param('a')." GROUP BY PRESC_VISITCODE,PRESC_PATIENTNUM,PRESC_PATIENT,PRESC_ACTORNAME"),array($activeinstitution,$from,$to));
        print $sql->ErrorMsg();
        //$result = array();
        $stmtdate=$sql->Execute($sql->Prepare("SELECT DISTINCT PRESC_VISITCODE,PRESC_DATE FROM hms_patient_prescription WHERE PRESC_INSTCODE=".$sql->Param('a')." AND PRESC_DATE >= ".$sql->Param('a')." AND PRESC_DATE   <= ".$sql->Param('a').""),array($activeinstitution,$from,$to));
        print $sql->ErrorMsg();
        if ($stmtdate->RecordCount()>0){
        	while ($objs=$stmtdate->FetchNextObject()){
        		$date_array[$objs->PRESC_VISITCODE]=$objs->PRESC_DATE;
        	}
        }
        $num = 1;
		
		$result.='<table class="table table-hover" >
                    <thead>
                        <tr>
                            <th>#</th>
                            <th width="500px">Patient Name</th>
                            <th width="300px">Hewale Number</th>
                            <th width="500px">Prescribed By</th>
                            <th width="300px">Date</th>
                            
                        </tr>
                    </thead>
                    <tbody>';
                       
                 
					if($stmt->RecordCount() > 0){
						$num = 1;
						while($obj  = $stmt->FetchNextObject()){
						  
                   $result.='<td>'.$num++.'</td>
                        <td>'.$obj->PRESC_PATIENT.'</td>
                        <td>'.$obj->PRESC_PATIENTNUM.'</td>
                        <td>'.$obj->PRESC_ACTORNAME.'</td>
						<td>'.date("d/m/Y",strtotime($date_array[$obj->PRESC_VISITCODE])).'</td>
					</tr>';
					}}
					else{
				$result.='<tr>
					<td colspan="5">No record found.</td>
				<tr>';
			}
					$result.='
                    
                    </tbody>
                </table>';
                
       
		echo $result;
    //}
//}
?>