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

			if (empty($hewale_number) && empty($prescriber_name)){
//if (!empty($txtarea)){
		$from = date("Y-m-d",strtotime($datefrom));
		$to = date("Y-m-d",strtotime($dateto));
	$stmt = $sql->Execute($sql->Prepare("SELECT PRESC_CODE,PRESC_VISITCODE,PRESC_PATIENTNUM,PRESC_PATIENT,PRESC_ACTORNAME,PRESC_DATE,PRESC_DRUGID,PRESC_DRUG,PRESC_QUANTITY,PRESC_DOSAGENAME,PRESC_FREQ,PRESC_DAYS,PRESC_TIMES,CASE PRESC_STATUS WHEN '0' THEN 'CANCELLED' WHEN '1' THEN 'PENDING' WHEN '2' THEN 'PENDING PAYMENT' WHEN '3' THEN 'PAID' WHEN '4' THEN 'COURIER' WHEN '5' THEN 'TRANSIT' WHEN '6' THEN 'DELIVERED' END PRESC_STATUS FROM hms_patient_prescription WHERE PRESC_INSTCODE =".$sql->Param('a')." AND PRESC_DATE >= ".$sql->Param('a')." AND PRESC_DATE   <= ".$sql->Param('a')." AND PRESC_STATUS IN ('3','4')"),array($activeinstitution,$from,$to));
		 if ($stmt->RecordCount()>0){
		 	while ($obj=$stmt->FetchNextObject()){
		 		$data_array[$obj->PRESC_VISITCODE][]=array('PRESC_CODE'=>$obj->PRESC_CODE,'PRESC_PATIENTNUM'=>$obj->PRESC_PATIENTNUM,'PRESC_PATIENT'=>$obj->PRESC_PATIENT,'PRESC_ACTORNAME'=>$obj->PRESC_ACTORNAME,'PRESC_DATE'=>$obj->PRESC_DATE,'PRESC_DRUGID'=>$obj->PRESC_DRUGID,'PRESC_DRUG'=>$obj->PRESC_DRUG,'PRESC_QUANTITY'=>$obj->PRESC_QUANTITY,'PRESC_DOSAGENAME'=>$obj->PRESC_DOSAGENAME,'PRESC_FREQ'=>$obj->PRESC_FREQ,'PRESC_DAYS'=>$obj->PRESC_DAYS,'PRESC_TIMES'=>$obj->PRESC_TIMES,'PRESC_STATUS'=>$obj->PRESC_STATUS);
		 	}
		 }
	    print $sql->ErrorMsg();
	      //$result = array();
        $stmtdate=$sql->Execute($sql->Prepare("SELECT DISTINCT PRESC_VISITCODE,PRESC_PATIENT,PRESC_PATIENTNUM,PRESC_DATE,PRESC_ACTORNAME FROM hms_patient_prescription WHERE PRESC_INSTCODE=".$sql->Param('a')." AND PRESC_DATE >= ".$sql->Param('a')." AND PRESC_DATE   <= ".$sql->Param('a').""),array($activeinstitution,$from,$to));
       print $sql->ErrorMsg();
        if ($stmtdate->RecordCount()>0){
        	while ($objs=$stmtdate->FetchNextObject()){
        		$details_array[$objs->PRESC_VISITCODE]=array($objs->PRESC_PATIENT,$objs->PRESC_PATIENTNUM,$objs->PRESC_ACTORNAME,$objs->PRESC_DATE);
        	}
        }
        
        if(is_array($data_array) && count($data_array)>0){
        	$number=1;
        	foreach ($data_array as $key=>$val){
		$result.= '<br><table class="table table-hover" >
                    <thead>
                    	<th colspan="3">No.'.$number.'   Patient : '. $details_array[$key][0].'('.$details_array[$key][1].')'.  '</th>
                    	<th colspan="3">Prescribed By : '. $details_array[$key][2].'</th>
                    	<th colspan="3">Date : '. date("d/m/Y",strtotime($details_array[$key][3])).'</th>
                    	
                        <tr>
                            <th>#</th>
                            <th width="200px">Code</th>
                            <th width="400px">Drug</th>
                            <th width="200px">Quantity</th>
                            <th width="200px">Frequency</th>
                            <th width="200px">Time</th>
                            <th width="200px">Dosage</th>
                            <th width="200px">Status</th>
                            
                            
                        </tr>
                        </thead>
                    <tbody>';
					$num = 1;
                   foreach ($val as $value){  
					
                   $result.='<tr><td>'.$num++.'</td>
                        <td>'.$value['PRESC_CODE'].'</td>
                        <td>'.$encaes->decrypt($value['PRESC_DRUG']).'</td>
                        <td>'.$value['PRESC_QUANTITY'].'</td>
                        <td>'.$value['PRESC_FREQ'].'</td>
                        <td>'.$value['PRESC_TIMES'].'</td>
                        <td>'.$value['PRESC_DOSAGENAME'].'</td>
                        <td>'.$value['PRESC_STATUS'].'</td>
                        </tr>';
                   }
					$result.='
                    </tbody>
                </table>
                </br>
                </br>
                ';$number++;}}else{
                $result.='<table class="table table-hover" >
                <tbody>
                <tr>
                <td colspan="6">No record found.</td>
				</tr>
				</tbody>
				</table>
				';
                };
                
       
		echo $result;
    //}
//}
}
//if a hewale number is entered
elseif (!empty($hewale_number) && empty($prescriber_name)){
	
//if (!empty($txtarea)){
		$from = date("Y-m-d",strtotime($datefrom));
		$to = date("Y-m-d",strtotime($dateto));
	$stmt = $sql->Execute($sql->Prepare("SELECT PRESC_CODE,PRESC_VISITCODE,PRESC_PATIENTNUM,PRESC_PATIENT,PRESC_ACTORNAME,PRESC_DATE,PRESC_DRUGID,PRESC_DRUG,PRESC_QUANTITY,PRESC_DOSAGENAME,PRESC_FREQ,PRESC_DAYS,PRESC_TIMES,CASE PRESC_STATUS WHEN '0' THEN 'CANCELLED' WHEN '1' THEN 'PENDING' WHEN '2' THEN 'PENDING PAYMENT' WHEN '3' THEN 'PAID' WHEN '4' THEN 'COURIER' WHEN '5' THEN 'TRANSIT' WHEN '6' THEN 'DELIVERED' END PRESC_STATUS FROM hms_patient_prescription WHERE PRESC_INSTCODE =".$sql->Param('a')." AND PRESC_DATE >= ".$sql->Param('a')." AND PRESC_DATE   <= ".$sql->Param('a')." AND PRESC_PATIENTNUM=".$sql->Param('d')." AND PRESC_STATUS IN ('3','4') "),array($activeinstitution,$from,$to,$hewale_number));
		 if ($stmt->RecordCount()>0){
		 	while ($obj=$stmt->FetchNextObject()){
		 		$data_array[$obj->PRESC_VISITCODE][]=array('PRESC_CODE'=>$obj->PRESC_CODE,'PRESC_PATIENTNUM'=>$obj->PRESC_PATIENTNUM,'PRESC_PATIENT'=>$obj->PRESC_PATIENT,'PRESC_ACTORNAME'=>$obj->PRESC_ACTORNAME,'PRESC_DATE'=>$obj->PRESC_DATE,'PRESC_DRUGID'=>$obj->PRESC_DRUGID,'PRESC_DRUG'=>$obj->PRESC_DRUG,'PRESC_QUANTITY'=>$obj->PRESC_QUANTITY,'PRESC_DOSAGENAME'=>$obj->PRESC_DOSAGENAME,'PRESC_FREQ'=>$obj->PRESC_FREQ,'PRESC_DAYS'=>$obj->PRESC_DAYS,'PRESC_TIMES'=>$obj->PRESC_TIMES,'PRESC_STATUS'=>$obj->PRESC_STATUS);
		 	}
		 }
	    print $sql->ErrorMsg();
	      //$result = array();
        $stmtdate=$sql->Execute($sql->Prepare("SELECT DISTINCT PRESC_VISITCODE,PRESC_PATIENT,PRESC_PATIENTNUM,PRESC_DATE,PRESC_ACTORNAME FROM hms_patient_prescription WHERE PRESC_INSTCODE=".$sql->Param('a')." AND PRESC_DATE >= ".$sql->Param('a')." AND PRESC_DATE   <= ".$sql->Param('a').""),array($activeinstitution,$from,$to));
       print $sql->ErrorMsg();
        if ($stmtdate->RecordCount()>0){
        	while ($objs=$stmtdate->FetchNextObject()){
        		$details_array[$objs->PRESC_VISITCODE]=array($objs->PRESC_PATIENT,$objs->PRESC_PATIENTNUM,$objs->PRESC_ACTORNAME,$objs->PRESC_DATE);
        	}
        }
        
        if(is_array($data_array) && count($data_array)>0){
        	$number=1;
        	foreach ($data_array as $key=>$val){
		$result.= '<br><table class="table table-hover" >
                    <thead>
                    	<th colspan="3">No.'.$number.'   Patient : '. $details_array[$key][0].'('.$details_array[$key][1].')'.  '</th>
                    	<th colspan="3">Prescribed By : '. $details_array[$key][2].'</th>
                    	<th colspan="3">Date : '. date("d/m/Y",strtotime($details_array[$key][3])).'</th>
                    	
                        <tr>
                            <th>#</th>
                            <th width="200px">Code</th>
                            <th width="400px">Drug</th>
                            <th width="200px">Quantity</th>
                            <th width="200px">Frequency</th>
                            <th width="200px">Time</th>
                            <th width="200px">Dosage</th>
                            <th width="200px">Status</th>
                            
                            
                        </tr>
                        </thead>
                    <tbody>';
					$num = 1;
                   foreach ($val as $value){  
					
                   $result.='<tr><td>'.$num++.'</td>
                        <td>'.$value['PRESC_CODE'].'</td>
                        <td>'.$encaes->decrypt($value['PRESC_DRUG']).'</td>
                        <td>'.$value['PRESC_QUANTITY'].'</td>
                        <td>'.$value['PRESC_FREQ'].'</td>
                        <td>'.$value['PRESC_TIMES'].'</td>
                        <td>'.$value['PRESC_DOSAGENAME'].'</td>
                        <td>'.$value['PRESC_STATUS'].'</td>
                        </tr>';
                   }
					$result.='
                    </tbody>
                </table>
                </br>
                </br>
                ';$number++;}}else{
                $result.='<table class="table table-hover" >
                <tbody>
                <tr>
                <td colspan="6">No record found.</td>
				</tr>
				</tbody>
				</table>
				';
                };
                
       
		echo $result;
    //}
//}
	
	
}elseif (!empty($prescriber_name) && empty($hewale_number)){
	$from = date("Y-m-d",strtotime($datefrom));
		$to = date("Y-m-d",strtotime($dateto));
	$stmt = $sql->Execute($sql->Prepare("SELECT PRESC_CODE,PRESC_VISITCODE,PRESC_PATIENTNUM,PRESC_PATIENT,PRESC_ACTORNAME,PRESC_DATE,PRESC_DRUGID,PRESC_DRUG,PRESC_QUANTITY,PRESC_DOSAGENAME,PRESC_FREQ,PRESC_DAYS,PRESC_TIMES,CASE PRESC_STATUS WHEN '0' THEN 'CANCELLED' WHEN '1' THEN 'PENDING' WHEN '2' THEN 'PENDING PAYMENT' WHEN '3' THEN 'PAID' WHEN '4' THEN 'COURIER' WHEN '5' THEN 'TRANSIT' WHEN '6' THEN 'DELIVERED' END PRESC_STATUS FROM hms_patient_prescription WHERE PRESC_INSTCODE =".$sql->Param('a')." AND PRESC_DATE >= ".$sql->Param('a')." AND PRESC_DATE   <= ".$sql->Param('a')." AND PRESC_ACTORNAME=".$sql->Param('d')." AND PRESC_STATUS IN ('3','4')"),array($activeinstitution,$from,$to,$prescriber_name));
		 if ($stmt->RecordCount()>0){
		 	while ($obj=$stmt->FetchNextObject()){
		 		$data_array[$obj->PRESC_VISITCODE][]=array('PRESC_CODE'=>$obj->PRESC_CODE,'PRESC_PATIENTNUM'=>$obj->PRESC_PATIENTNUM,'PRESC_PATIENT'=>$obj->PRESC_PATIENT,'PRESC_ACTORNAME'=>$obj->PRESC_ACTORNAME,'PRESC_DATE'=>$obj->PRESC_DATE,'PRESC_DRUGID'=>$obj->PRESC_DRUGID,'PRESC_DRUG'=>$obj->PRESC_DRUG,'PRESC_QUANTITY'=>$obj->PRESC_QUANTITY,'PRESC_DOSAGENAME'=>$obj->PRESC_DOSAGENAME,'PRESC_FREQ'=>$obj->PRESC_FREQ,'PRESC_DAYS'=>$obj->PRESC_DAYS,'PRESC_TIMES'=>$obj->PRESC_TIMES,'PRESC_STATUS'=>$obj->PRESC_STATUS);
		 	}
		 }
	    print $sql->ErrorMsg();
	      //$result = array();
        $stmtdate=$sql->Execute($sql->Prepare("SELECT DISTINCT PRESC_VISITCODE,PRESC_PATIENT,PRESC_PATIENTNUM,PRESC_DATE,PRESC_ACTORNAME FROM hms_patient_prescription WHERE PRESC_INSTCODE=".$sql->Param('a')." AND PRESC_DATE >= ".$sql->Param('a')." AND PRESC_DATE   <= ".$sql->Param('a').""),array($activeinstitution,$from,$to));
       print $sql->ErrorMsg();
        if ($stmtdate->RecordCount()>0){
        	while ($objs=$stmtdate->FetchNextObject()){
        		$details_array[$objs->PRESC_VISITCODE]=array($objs->PRESC_PATIENT,$objs->PRESC_PATIENTNUM,$objs->PRESC_ACTORNAME,$objs->PRESC_DATE);
        	}
        }
        
        if(is_array($data_array) && count($data_array)>0){
        	$number=1;
        	foreach ($data_array as $key=>$val){
		$result.= '<br><table class="table table-hover" >
                    <thead>
                    	<th colspan="3">No.'.$number.'   Patient : '. $details_array[$key][0].'('.$details_array[$key][1].')'.  '</th>
                    	<th colspan="3">Prescribed By : '. $details_array[$key][2].'</th>
                    	<th colspan="3">Date : '. date("d/m/Y",strtotime($details_array[$key][3])).'</th>
                    	
                        <tr>
                            <th>#</th>
                            <th width="200px">Code</th>
                            <th width="400px">Drug</th>
                            <th width="200px">Quantity</th>
                            <th width="200px">Frequency</th>
                            <th width="200px">Time</th>
                            <th width="200px">Dosage</th>
                            <th width="200px">Status</th>
                            
                            
                        </tr>
                        </thead>
                    <tbody>';
					$num = 1;
                   foreach ($val as $value){  
					
                   $result.='<tr><td>'.$num++.'</td>
                        <td>'.$value['PRESC_CODE'].'</td>
                        <td>'.$encaes->decrypt($value['PRESC_DRUG']).'</td>
                        <td>'.$value['PRESC_QUANTITY'].'</td>
                        <td>'.$value['PRESC_FREQ'].'</td>
                        <td>'.$value['PRESC_TIMES'].'</td>
                        <td>'.$value['PRESC_DOSAGENAME'].'</td>
                        <td>'.$value['PRESC_STATUS'].'</td>
                        </tr>';
                   }
					$result.='
                    </tbody>
                </table>
                </br>
                </br>
                ';$number++;}}else{
                $result.='<table class="table table-hover" >
                <tbody>
                <tr>
                <td colspan="6">No record found.</td>
				</tr>
				</tbody>
				</table>
				';
                };
                
       
		echo $result;
    //}
//}
	
	
	
	
	
	
}elseif (!empty($hewale_number) && !empty($prescriber_name)){
	
	$from = date("Y-m-d",strtotime($datefrom));
		$to = date("Y-m-d",strtotime($dateto));
	$stmt = $sql->Execute($sql->Prepare("SELECT PRESC_CODE,PRESC_VISITCODE,PRESC_PATIENTNUM,PRESC_PATIENT,PRESC_ACTORNAME,PRESC_DATE,PRESC_DRUGID,PRESC_DRUG,PRESC_QUANTITY,PRESC_DOSAGENAME,PRESC_FREQ,PRESC_DAYS,PRESC_TIMES,CASE PRESC_STATUS WHEN '0' THEN 'CANCELLED' WHEN '1' THEN 'PENDING' WHEN '2' THEN 'PENDING PAYMENT' WHEN '3' THEN 'PAID' WHEN '4' THEN 'COURIER' WHEN '5' THEN 'TRANSIT' WHEN '6' THEN 'DELIVERED' END PRESC_STATUS FROM hms_patient_prescription WHERE PRESC_INSTCODE =".$sql->Param('a')." AND PRESC_DATE >= ".$sql->Param('a')." AND PRESC_DATE   <= ".$sql->Param('a')." AND PRESC_ACTORNAME=".$sql->Param('d')."  AND PRESC_PATIENTNUM=".$sql->Param('d')." AND PRESC_STATUS IN ('3','4')"),array($activeinstitution,$from,$to,$prescriber_name,$hewale_number));
		 if ($stmt->RecordCount()>0){
		 	while ($obj=$stmt->FetchNextObject()){
		 		$data_array[$obj->PRESC_VISITCODE][]=array('PRESC_CODE'=>$obj->PRESC_CODE,'PRESC_PATIENTNUM'=>$obj->PRESC_PATIENTNUM,'PRESC_PATIENT'=>$obj->PRESC_PATIENT,'PRESC_ACTORNAME'=>$obj->PRESC_ACTORNAME,'PRESC_DATE'=>$obj->PRESC_DATE,'PRESC_DRUGID'=>$obj->PRESC_DRUGID,'PRESC_DRUG'=>$obj->PRESC_DRUG,'PRESC_QUANTITY'=>$obj->PRESC_QUANTITY,'PRESC_DOSAGENAME'=>$obj->PRESC_DOSAGENAME,'PRESC_FREQ'=>$obj->PRESC_FREQ,'PRESC_DAYS'=>$obj->PRESC_DAYS,'PRESC_TIMES'=>$obj->PRESC_TIMES,'PRESC_STATUS'=>$obj->PRESC_STATUS);
		 	}
		 }
	    print $sql->ErrorMsg();
	      //$result = array();
        $stmtdate=$sql->Execute($sql->Prepare("SELECT DISTINCT PRESC_VISITCODE,PRESC_PATIENT,PRESC_PATIENTNUM,PRESC_DATE,PRESC_ACTORNAME FROM hms_patient_prescription WHERE PRESC_INSTCODE=".$sql->Param('a')." AND PRESC_DATE >= ".$sql->Param('a')." AND PRESC_DATE   <= ".$sql->Param('a').""),array($activeinstitution,$from,$to));
       print $sql->ErrorMsg();
        if ($stmtdate->RecordCount()>0){
        	while ($objs=$stmtdate->FetchNextObject()){
        		$details_array[$objs->PRESC_VISITCODE]=array($objs->PRESC_PATIENT,$objs->PRESC_PATIENTNUM,$objs->PRESC_ACTORNAME,$objs->PRESC_DATE);
        	}
        }
        
        if(is_array($data_array) && count($data_array)>0){
        	$number=1;
        	foreach ($data_array as $key=>$val){
		$result.= '<br><table class="table table-hover" >
                    <thead>
                    	<th colspan="3">No.'.$number.'   Patient : '. $details_array[$key][0].'('.$details_array[$key][1].')'.  '</th>
                    	<th colspan="3">Prescribed By : '. $details_array[$key][2].'</th>
                    	<th colspan="3">Date : '. date("d/m/Y",strtotime($details_array[$key][3])).'</th>
                    	
                        <tr>
                            <th>#</th>
                            <th width="200px">Code</th>
                            <th width="400px">Drug</th>
                            <th width="200px">Quantity</th>
                            <th width="200px">Frequency</th>
                            <th width="200px">Time</th>
                            <th width="200px">Dosage</th>
                            <th width="200px">Status</th>
                            
                            
                        </tr>
                        </thead>
                    <tbody>';
					$num = 1;
                   foreach ($val as $value){  
					
                   $result.='<tr><td>'.$num++.'</td>
                        <td>'.$value['PRESC_CODE'].'</td>
                        <td>'.$encaes->decrypt($value['PRESC_DRUG']).'</td>
                        <td>'.$value['PRESC_QUANTITY'].'</td>
                        <td>'.$value['PRESC_FREQ'].'</td>
                        <td>'.$value['PRESC_TIMES'].'</td>
                        <td>'.$value['PRESC_DOSAGENAME'].'</td>
                        <td>'.$value['PRESC_STATUS'].'</td>
                        </tr>';
                   }
					$result.='
                    </tbody>
                </table>
                </br>
                </br>
                ';$number++;}}else{
                $result.='<table class="table table-hover" >
                <tbody>
                <tr>
                <td colspan="6">No record found.</td>
				</tr>
				</tbody>
				</table>
				';
                };
                
       
		echo $result;
    //}
//}
	
	
	
	
	
	
	
}
?>